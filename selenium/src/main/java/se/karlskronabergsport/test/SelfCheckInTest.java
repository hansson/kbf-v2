package se.karlskronabergsport.test;
import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

import se.karlskronabergsport.util.TestFailureException;


public class SelfCheckInTest extends AttendeeTest {

	private String loginUrl;

	public SelfCheckInTest(ChromeDriver driver, String loginUrl) {
		super(driver, loginUrl, "tobias@tobiashansson.nu", "test");
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
		validateThat(waitUntilVisible("pay"), "Failed to open");
		
		WebElement admin = driver.findElementByLinkText("Admin");
		admin.click();
		validateThat(waitUntilPageChange("index.php"), "Could not click Admin");
		
		WebElement personTable = driver.findElementById("personTable");
		List<WebElement> persons = personTable.findElements(By.tagName("tr"));
		validateThat(persons.size() == 1, "Wrong sized person table");
		WebElement acceptUser = driver.findElementById("accept_901104");
		acceptUser.click();
		
		WebElement register = driver.findElementByLinkText("Registrera");
		register.click();
		validateThat(waitUntilPageChange("index.php"), "Could not click Registrera");
		
		WebElement pnr = driver.findElementById("item_pnr");
		WebElement fullPnr = driver.findElementById("item_tmp_pnr");
		WebElement membershipFee = findCheckboxWithId("item_1");
		WebElement climbYear = findCheckboxWithId("item_3");
		WebElement total = driver.findElementById("total");
		WebElement pay = driver.findElementById("pay");
		
		pnr.sendKeys("901104");
		fullPnr.sendKeys("9011041111");
		membershipFee.click();
		climbYear.click();
		total.click();
		validateThat(total.getText().contains("1050"), "Wrong price on 10-card");
		pay.click();
		validateThat(waitUntilVisible("paySuccess"), "Payment failed");
		
		login("901104@test.com", "test");
		validateThat(driver.getCurrentUrl().endsWith("my_info.php"), "Not on my_info.php");
		
		validateThat(waitUntilVisible("name"), "Name not visible");
		WebElement name = driver.findElementById("name");
		name.getText().equals("901104 901104");
		validateThat(waitUntilVisible("number"), "Number not visible");
		WebElement number = driver.findElementById("number");
		number.getText().equals("901104");
		validateThat(waitUntilVisible("personInfoMember"), "Person info member not visible");
		validateThat(waitUntilVisible("personInfoClimb"), "Person info climb not visible");
		
		WebElement checkin = driver.findElementById("checkin");
		checkin.click();
		validateThat(waitUntilVisible("checked_in"), "Failed to check in");
		
		login();
		WebElement openTable = driver.findElementById("openTable");
		List<WebElement> attendees = openTable.findElements(By.tagName("tr"));
		validateThat(attendees.size() == 1, "Wrong sized openTable");
		WebElement attendee = attendees.get(0);
		List<WebElement> attendeeColumns = attendee.findElements(By.tagName("td"));
		validateThat(attendeeColumns.get(0).getText().equals("901104(901104 901104)"), "901104 901104 not in first column");
		validateThat(attendeeColumns.get(1).getText().equals("0"), "0 not in second column");
		
	}

}
