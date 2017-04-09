package se.karlskronabergsport.test;
import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

import se.karlskronabergsport.util.TestFailureException;


public class SelfCheckInNotMemberTest extends AttendeeTest {

	private String loginUrl;

	public SelfCheckInNotMemberTest(ChromeDriver driver, String loginUrl) {
		super(driver, loginUrl, "me@tobiashansson.nu", "test");
		this.loginUrl = loginUrl;
	}
	

	@Override
	public void execute() throws TestFailureException {
		registerUser("901104");
		
		driver.get(loginUrl);
		WebElement email = driver.findElementById("inputEmail");
		email.sendKeys("901104@test.com");
		WebElement password = driver.findElementById("inputPassword");
		password.sendKeys("test");
		password.submit();
		validateThat(waitUntilVisible("notActive"), "Should not be active");
		
		super.execute();
		validateThat(driver.getCurrentUrl().endsWith("index.php"), "Not on index.php");
		WebElement openButton = driver.findElementById("open_btn");
		openButton.click();
		validateThat(waitUntilLoaded("pay"), "Failed to open");
		
		WebElement admin = driver.findElementByLinkText("Admin");
		admin.click();
		validateThat(waitUntilPageChange("index.php"), "Could not click Admin");
		
		WebElement personTable = driver.findElementById("personTable");
		List<WebElement> persons = personTable.findElements(By.tagName("tr"));
		validateThat(persons.size() == 1, "Wrong sized person table");
		WebElement acceptUser = driver.findElementById("accept_901104");
		acceptUser.click();
		
		try {
			Thread.sleep(100);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		login("901104@test.com", "test");
		validateThat(driver.getCurrentUrl().endsWith("my_info.php"), "Not on my_info.php");
		
		validateThat(waitUntilLoaded("name"), "Name not visible");
		WebElement name = driver.findElementById("name");
		name.getText().equals("901104 901104");
		validateThat(waitUntilLoaded("number"), "Number not visible");
		WebElement number = driver.findElementById("number");
		number.getText().equals("901104");
		validateThat(waitUntilLoaded("personInfoMember"), "Person info member not visible");
		validateThat(waitUntilLoaded("personInfoClimb"), "Person info climb not visible");
		
		WebElement checkin = driver.findElementById("checkin");
		checkin.click();
		validateThat(waitUntilLoaded("checkin_error"), "Check in should fail");
		
		login();
		WebElement openTable = driver.findElementById("openTable");
		List<WebElement> attendees = openTable.findElements(By.tagName("tr"));
		validateThat(attendees.isEmpty(), "Wrong sized openTable");
		
	}

}
