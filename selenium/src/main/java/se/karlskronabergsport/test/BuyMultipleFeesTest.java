package se.karlskronabergsport.test;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

import se.karlskronabergsport.util.TestFailureException;


public class BuyMultipleFeesTest extends AttendeeTest {

	public BuyMultipleFeesTest(ChromeDriver driver, String loginUrl) {
		super(driver, loginUrl, "me@tobiashansson.nu", "test");
	}

	@Override
	public void execute() throws TestFailureException {
		registerUser("901104");
		registerUser("901105");
		super.execute();
		validateThat(driver.getCurrentUrl().endsWith("index.php"), "Not on index.php");
		
		WebElement register = driver.findElementByLinkText("Registrera");
		register.click();
		validateThat(waitUntilPageChange("index.php"), "Could not click Registrera");
		
		WebElement memberNumber = driver.findElementById("item_pnr");
		WebElement fullPnr = driver.findElementById("item_tmp_pnr");
		WebElement membership = findCheckboxWithId("item_1");
		WebElement climbSemester = findCheckboxWithId("item_4");
		WebElement total = driver.findElementById("total");
		WebElement pay = driver.findElementById("pay");
		
		memberNumber.sendKeys("901105");
		fullPnr.sendKeys("9011051111");
		membership.click();
		climbSemester.click();
		total.click();
		pay.click();
		validateThat(waitUntilVisible("paySuccess"), "Payment failed");
		
		memberNumber.sendKeys("901105");
		climbSemester.click();
		total.click();
		pay.click();
		validateThat(waitUntilVisible("duplicateFeeError"), "Payment should have failed");
	}

}
