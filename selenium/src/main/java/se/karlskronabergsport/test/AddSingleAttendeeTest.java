package se.karlskronabergsport.test;
import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

import se.karlskronabergsport.util.TestFailureException;


public class AddSingleAttendeeTest extends AttendeeTest {

	public AddSingleAttendeeTest(ChromeDriver driver, String loginUrl) {
		super(driver, loginUrl, "me@tobiashansson.nu", "test");
	}

	@Override
	public void execute() throws TestFailureException {
		super.execute();
		validateThat(driver.getCurrentUrl().endsWith("index.php"), "Not on index.php");
		WebElement openButton = driver.findElementById("open_btn");
		openButton.click();
		validateThat(waitUntilLoaded("pay"), "Failed to open");
		
		addAttendee("Tobias Hansson", "1", true, false, "70");

		WebElement table = driver.findElementById("openTable");
		List<WebElement> attendees = table.findElements(By.tagName("tr"));
		validateThat(attendees.size() == 1, "Wrong sized openTable");
		WebElement attendee = attendees.get(0);
		List<WebElement> attendeeColumns = attendee.findElements(By.tagName("td"));
		validateThat(attendeeColumns.get(0).getText().equals("Tobias Hansson"), "Tobias Hansson not in first column");
		validateThat(attendeeColumns.get(1).getText().equals("70"), "70 not in second column");
	}

}
