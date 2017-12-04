package se.karlskronabergsport.test;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

import se.karlskronabergsport.util.TestFailureException;

public class UseTenCardAndCashback extends AttendeeTest {

	public UseTenCardAndCashback(ChromeDriver driver, String loginUrl) {
		super(driver, loginUrl, "me@tobiashansson.nu", "test");
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
		validateThat(waitUntilLoaded("pay"), "Failed to open");

		WebElement prePaidNumber = driver.findElementById("prePaidNumber");
		WebElement addPrePaid = driver.findElementById("addPrePaid");

		// Once
		prePaidNumber.sendKeys(cardNumber);
		addPrePaid.click();
		validateThat(waitUntilVisible("personInfoTenUntil"), "Failed to add card");
		WebElement cardLeft = driver.findElementById("personInfoTenUntil");
		validateThat(cardLeft.getText().equals("9"), "Wrong amount on card");

		// Twice
		prePaidNumber.sendKeys(cardNumber);
		addPrePaid.click();
		validateThat(waitUntilVisible("personInfoTenUntil"), "Failed to add card");
		cardLeft = driver.findElementById("personInfoTenUntil");
		validateThat(cardLeft.getText().equals("8"), "Wrong amount on card");

		WebElement removePrePaid = driver.findElementsByCssSelector("button[id^='remove-row-']").get(0);
		removePrePaid.click();
		validateThat(waitUntilVisible("delete"), "Failed to remove card");
		WebElement delete = driver.findElementById("delete");
//		throw new RuntimeException();
		delete.click();

		try {
			Thread.sleep(100);
		} catch (InterruptedException e) {
			//Silly wait
		}
		
		WebElement table = driver.findElementById("openTable");
		List<WebElement> attendees = table.findElements(By.tagName("tr"));
		validateThat(attendees.size() == 1, "Wrong sized openTable");

		// Once
		prePaidNumber.sendKeys(cardNumber);
		addPrePaid.click();
		validateThat(waitUntilVisible("personInfoTenUntil"), "Failed to add card");
		cardLeft = driver.findElementById("personInfoTenUntil");
		validateThat(cardLeft.getText().equals("8"), "Wrong amount on card");

		attendees = table.findElements(By.tagName("tr"));
		validateThat(attendees.size() == 2, "Wrong sized openTable");
		WebElement attendee = attendees.get(0);
		List<WebElement> attendeeColumns = attendee.findElements(By.tagName("td"));
		validateThat(attendeeColumns.get(0).getText().equals(cardNumber), String.format("%s not in first column", cardNumber));
		validateThat(attendeeColumns.get(1).getText().equals("0"), "0 not in second column");
	}

}
