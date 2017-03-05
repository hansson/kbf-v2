package se.karlskronabergsport.test;
import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

import se.karlskronabergsport.util.TestFailureException;


public class BuyAndAddTenCardTest extends AttendeeTest {

	public BuyAndAddTenCardTest(ChromeDriver driver, String loginUrl) {
		super(driver, loginUrl, "tobias@tobiashansson.nu", "test");
	}

	@Override
	public void execute() throws TestFailureException {
		super.execute();
		validateThat(driver.getCurrentUrl().endsWith("index.php"), "Not on index.php");
		
		WebElement register = driver.findElementByLinkText("Registrera");
		register.click();
		validateThat(waitUntilPageChange("index.php"), "Could not click Registrera");
		
		WebElement tenCard = findCheckboxWithId("item_5");
		tenCard.click();
		WebElement total = driver.findElementById("total");
		total.click();
		validateThat(total.getText().contains("400"), "Wrong price on 10-card");
		WebElement pay = driver.findElementById("pay");
		pay.click();
		validateThat(waitUntilVisible("paySuccess"), "Payment failed");
		WebElement paySuccess = driver.findElementById("paySuccess");
		String cardNumber = paySuccess.getText();
		cardNumber = cardNumber.substring(cardNumber.length() - 8, cardNumber.length() - 1);
		
		WebElement open = driver.findElementByLinkText("Öppna");
		open.click();
		validateThat(waitUntilPageChange("register_fee.php"), "Could not click Öppna");
		
		WebElement openButton = driver.findElementById("open_btn");
		openButton.click();
		validateThat(waitUntilVisible("pay"), "Failed to open");
		
		WebElement prePaidNumber = driver.findElementById("prePaidNumber");
		prePaidNumber.sendKeys(cardNumber);
		WebElement addPrePaid = driver.findElementById("addPrePaid");
		addPrePaid.click();
		
		validateThat(waitUntilVisible("personInfoTenUntil"), "Failed to add card");
		WebElement cardLeft = driver.findElementById("personInfoTenUntil");
		validateThat(cardLeft.getText().equals("9"), "Wrong amount on card");
		
		prePaidNumber.sendKeys("1234567");
		validateThat(waitUntilVisible("tenNotFound"), "No error from add bad card");
		addPrePaid.click();
		
		WebElement table = driver.findElementById("openTable");
		List<WebElement> attendees = table.findElements(By.tagName("tr"));
		validateThat(attendees.size() == 1, "Wrong sized openTable");
		WebElement attendee = attendees.get(0);
		List<WebElement> attendeeColumns = attendee.findElements(By.tagName("td"));
		validateThat(attendeeColumns.get(0).getText().equals(cardNumber), String.format("%s not in first column", cardNumber));
		validateThat(attendeeColumns.get(1).getText().equals("0"), "0 not in second column");
	}

}
