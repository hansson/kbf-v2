package se.karlskronabergsport.test;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

import se.karlskronabergsport.util.TestFailureException;


public class BuyTenCardAsMemberTest extends AttendeeTest {

	public BuyTenCardAsMemberTest(ChromeDriver driver, String loginUrl) {
		super(driver, loginUrl, "me@tobiashansson.nu", "test");
	}

	@Override
	public void execute() throws TestFailureException {
		super.execute();
		validateThat(driver.getCurrentUrl().endsWith("index.php"), "Not on index.php");
		
		WebElement register = driver.findElementByLinkText("Registrera");
		register.click();
		validateThat(waitUntilPageChange("index.php"), "Could not click Registrera");
		
		WebElement memberNumber = driver.findElementById("item_pnr");
		memberNumber.sendKeys("901103");
		WebElement tenCard = findCheckboxWithId("item_5");
		tenCard.click();
		WebElement total = driver.findElementById("total");
		total.click();
		validateThat(total.getText().contains("300"), "Wrong price on 10-card");
		
		WebElement pay = driver.findElementById("pay");
		pay.click();
		validateThat(waitUntilVisible("paySuccess"), "Payment failed");
	}

}
