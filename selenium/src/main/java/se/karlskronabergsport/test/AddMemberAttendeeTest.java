package se.karlskronabergsport.test;
import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

import se.karlskronabergsport.util.TestFailureException;


public class AddMemberAttendeeTest extends AttendeeTest {

	public AddMemberAttendeeTest(ChromeDriver driver, String loginUrl) {
		super(driver, loginUrl, "tobias@tobiashansson.nu", "test");
	}

	@Override
	public void execute() throws TestFailureException {
		super.execute();
		validateThat(driver.getCurrentUrl().endsWith("index.php"), "Not on index.php");
		WebElement openButton = driver.findElementById("open_btn");
		openButton.click();
		validateThat(waitUntilLoaded("pay"), "Failed to open");
		
		WebElement prePaidNumber = driver.findElementById("prePaidNumber");
		prePaidNumber.sendKeys("901103");
		WebElement addPrePaid = driver.findElementById("addPrePaid");
		addPrePaid.click();
		
		validateThat(waitUntilVisible("personInfoClimb"), "Failed to add card");
		validateThat(waitUntilVisible("personInfoMember"), "Failed to add card");
		
		WebElement table = driver.findElementById("openTable");
		List<WebElement> attendees = table.findElements(By.tagName("tr"));
		validateThat(attendees.size() == 1, "Wrong sized openTable");
		WebElement attendee = attendees.get(0);
		List<WebElement> attendeeColumns = attendee.findElements(By.tagName("td"));
		validateThat(attendeeColumns.get(0).getText().equals("901103"), "901103 not in first column");
		validateThat(attendeeColumns.get(1).getText().equals("0"), "0 not in second column");
		
		driver.navigate().refresh();
		
		table = driver.findElementById("openTable");
		attendees = table.findElements(By.tagName("tr"));
		validateThat(attendees.size() == 1, "Wrong sized openTable");
		attendee = attendees.get(0);
		attendeeColumns = attendee.findElements(By.tagName("td"));
		validateThat(attendeeColumns.get(0).getText().equals("901103(Tobias Hansson)"), "901103 not in first column");
		validateThat(attendeeColumns.get(1).getText().equals("0"), "0 not in second column");
	}

}
