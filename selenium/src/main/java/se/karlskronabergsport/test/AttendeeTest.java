package se.karlskronabergsport.test;

import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

import se.karlskronabergsport.util.Attendee;
import se.karlskronabergsport.util.TestFailureException;

public class AttendeeTest extends BaseTest{

	public AttendeeTest(ChromeDriver driver, String loginUrl, String email, String password) {
		super(driver, loginUrl, email, password);
	}
	
	protected Attendee addAttendee(String name, String shoes, boolean climb, boolean chalk, String total) throws TestFailureException {
		WebElement nameField = driver.findElementById("item_pnr");
		nameField.sendKeys(name);
		WebElement shoesField = driver.findElementById("item_6");
		shoesField.clear();
		shoesField.sendKeys(shoes);
		if(climb) {
			WebElement climbField = findCheckboxWithId("item_7");
			climbField.click();
		}
		if(chalk) {
			WebElement chalkField = findCheckboxWithId("item_8");
			chalkField.click();
		}

		WebElement totalField = driver.findElementById("total");
		totalField.click();
		validateThat(totalField.getText().contains(total), "Failed to add attendee");

		WebElement pay = driver.findElementById("pay");
		pay.click();
		
		try {
			Thread.sleep(100);
		} catch (InterruptedException e) {
			//I will sleep!
		}
		return new Attendee(name, total);
	}


}
