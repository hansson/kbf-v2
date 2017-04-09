package se.karlskronabergsport.test;
import java.util.LinkedList;
import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

import se.karlskronabergsport.util.Attendee;
import se.karlskronabergsport.util.TestFailureException;


public class AddMultipleAttendeesTest extends AttendeeTest {

	public AddMultipleAttendeesTest(ChromeDriver driver, String loginUrl) {
		super(driver, loginUrl, "me@tobiashansson.nu", "test");
	}

	@Override
	public void execute() throws TestFailureException {
		super.execute();
		validateThat(driver.getCurrentUrl().endsWith("index.php"), "Not on index.php");
		WebElement openButton = driver.findElementById("open_btn");
		openButton.click();
		validateThat(waitUntilLoaded("pay"), "Failed to open");
		
		List<Attendee> attendeeList = new LinkedList<Attendee>();
		attendeeList.add(addAttendee("Tobias Hansson", "1", true, false, "70"));
		attendeeList.add(addAttendee("Sven Svensson", "2", true, false, "90"));
		attendeeList.add(addAttendee("901103", "0", true, false, "40"));
		attendeeList.add(addAttendee("Per Persson", "1", true, true, "120"));
		attendeeList.add(addAttendee("Johan Johansson", "1", false, false, "20"));

		WebElement table = driver.findElementById("openTable");
		List<WebElement> attendeesWebList = table.findElements(By.tagName("tr"));
		validateThat(attendeesWebList.size() == attendeeList.size(), "Wrong sized openTable");
		for(int i = 0 ; i < attendeeList.size() ; i++) {
			WebElement webAttendee = attendeesWebList.get(i);
			Attendee attendee = attendeeList.get(i);
			List<WebElement> attendeeColumns = webAttendee.findElements(By.tagName("td"));
			validateThat(attendeeColumns.get(0).getText().equals(attendee.getName()), String.format("%s not in first column", attendee.getName()));
			validateThat(attendeeColumns.get(1).getText().equals(attendee.getTotal()), String.format("%s not in second column", attendee.getTotal()));
		}
	}

}
