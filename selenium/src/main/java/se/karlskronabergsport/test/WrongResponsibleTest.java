package se.karlskronabergsport.test;


import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

import se.karlskronabergsport.util.TestFailureException;

public class WrongResponsibleTest  extends AttendeeTest {
	
	public WrongResponsibleTest(ChromeDriver driver, String loginUrl) {
		super(driver, loginUrl, "me@tobiashansson.nu", "test");
	}

	@Override
	public void execute() throws TestFailureException {
		super.execute();
		validateThat(driver.getCurrentUrl().endsWith("index.php"), "Not on index.php");
		WebElement openButton = driver.findElementById("open_btn");
		openButton.click();
		validateThat(waitUntilLoaded("pay"), "Failed to open");
		
		login("901102", "test");
		validateThat(driver.getCurrentUrl().endsWith("index.php"), "Not on index.php");
		validateThat(waitUntilVisible("wrong_responsible"), "Should show Wrong responsible");
		WebElement wrongResponsible = driver.findElementById("wrong_responsible");
		validateThat(wrongResponsible.getText().contains("Det finns redan ett "), "Fel text");
	}

}
