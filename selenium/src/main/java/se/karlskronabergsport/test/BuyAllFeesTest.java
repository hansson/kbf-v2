package se.karlskronabergsport.test;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

import se.karlskronabergsport.util.TestFailureException;


public class BuyAllFeesTest extends AttendeeTest {

	public BuyAllFeesTest(ChromeDriver driver, String loginUrl) {
		super(driver, loginUrl, "tobias@tobiashansson.nu", "test");
	}

	@Override
	public void execute() throws TestFailureException {
		registerUser("901104");
		registerUser("901105");
		registerUser("901106");
		registerUser("901107");
		registerUser("901108");
		super.execute();
		validateThat(driver.getCurrentUrl().endsWith("index.php"), "Not on index.php");
		
		WebElement register = driver.findElementByLinkText("Registrera");
		register.click();
		validateThat(waitUntilPageChange("index.php"), "Could not click Registrera");
		
		WebElement pnr = driver.findElementById("item_pnr");
		WebElement fullPnr = driver.findElementById("item_tmp_pnr");
		
		WebElement membershipFee = findCheckboxWithId("item_1");
		WebElement membershipFeeYouth = findCheckboxWithId("item_2");
		WebElement climbYear = findCheckboxWithId("item_3");
		WebElement climbSemester = findCheckboxWithId("item_4");
		WebElement climbYearYouth = findCheckboxWithId("item_9");
		WebElement climbSemesterYouth = findCheckboxWithId("item_10");
		
		WebElement total = driver.findElementById("total");
		WebElement pay = driver.findElementById("pay");
		
		//Make sure full pnr needed
		pnr.sendKeys("901104");
		membershipFee.click();
		climbYear.click();
		total.click();
		validateThat(total.getText().contains("1050"), "Wrong price on member + year");
		pay.click();
		validateThat(waitUntilVisible("pnrError"), "Payment should have failed");
		fullPnr.sendKeys("9011041111");
		total.click();
		validateThat(total.getText().contains("1050"), "Wrong price on member + year");
		pay.click();
		validateThat(waitUntilVisible("paySuccess"), "Payment failed");
		
		//Make sure full pnr needed
		pnr.sendKeys("901105");
		membershipFeeYouth.click();
		climbYearYouth.click();
		total.click();
		validateThat(total.getText().contains("750"), "Wrong price on youth member + year youth");
		pay.click();
		validateThat(waitUntilVisible("pnrError"), "Payment should have failed");
		fullPnr.sendKeys("9011051111");
		total.click();
		validateThat(total.getText().contains("750"), "Wrong price on youth member + year youth");
		pay.click();
		validateThat(waitUntilVisible("paySuccess"), "Payment failed");
		
		//Fail if not member
		pnr.sendKeys("901106");
		climbSemester.click();
		total.click();
		validateThat(total.getText().contains("500"), "Wrong price on semester");
		pay.click();
		validateThat(waitUntilVisible("memberError"), "Payment should have failed");
		membershipFee.click();
		fullPnr.sendKeys("9011061111");
		total.click();
		validateThat(total.getText().contains("750"), "Wrong price on member + semester");
		pay.click();
		validateThat(waitUntilVisible("paySuccess"), "Payment failed");
		
		//Fail if not member
		pnr.sendKeys("901107");
		climbSemesterYouth.click();
		total.click();
		validateThat(total.getText().contains("400"), "Wrong price on semester youth");
		pay.click();
		validateThat(waitUntilVisible("memberError"), "Payment should have failed");
		membershipFeeYouth.click();
		fullPnr.sendKeys("9011071111");
		total.click();
		validateThat(total.getText().contains("550"), "Wrong price on youth member + semester youth");
		pay.click();
		validateThat(waitUntilVisible("paySuccess"), "Payment failed");
		
		//Fail if not member
		pnr.sendKeys("901108");
		climbSemester.click();
		total.click();
		validateThat(total.getText().contains("500"), "Wrong price on semester");
		pay.click();
		validateThat(waitUntilVisible("memberError"), "Payment should have failed");
		membershipFee.click();
		climbSemester.click();
		fullPnr.sendKeys("9011081111");
		total.click();
		validateThat(total.getText().contains("250"), "Wrong price on member");
		pay.click();
		validateThat(waitUntilVisible("paySuccess"), "Payment failed");
		pnr.sendKeys("901108");
		climbSemester.click();
		total.click();
		pay.click();
		validateThat(total.getText().contains("500"), "Wrong price semester");
		validateThat(waitUntilVisible("paySuccess"), "Payment failed");
	}

}
