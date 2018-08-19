package se.karlskronabergsport.test;
import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

import se.karlskronabergsport.util.TestFailureException;


public class PermissionTest extends AttendeeTest {

	public PermissionTest(ChromeDriver driver, String loginUrl) {
		super(driver, loginUrl, "me@tobiashansson.nu", "test");
	}

	@Override
	public void execute() throws TestFailureException {
		registerUser("901104");	
		loginAndGoToAdmin();
		
		WebElement personTable = driver.findElementById("personTable");
		List<WebElement> persons = personTable.findElements(By.tagName("tr"));
		validateThat(persons.size() == 1, "Wrong sized person table");
		WebElement acceptUser = driver.findElementById("accept_901104");
		acceptUser.click();

		validatePermissions(2);
		
		loginAndGoToAdmin();
		setPermissions(true, false); //check responsible
		validatePermissions(5);
		
		loginAndGoToAdmin();
		setPermissions(false, true); //Both admin and responsible
		validatePermissions(7);
		
		loginAndGoToAdmin();
		setPermissions(true, false); //uncheck responsible
		validatePermissions(7);
	}

	private void validatePermissions(int expectedSize) throws TestFailureException {
		login("901104@test.com", "test");
		WebElement menu = driver.findElementByCssSelector("nav ul");
		int size = menu.findElements(By.tagName("li")).size();
		validateThat(size == expectedSize, "Wrong menu items");
	}

	private void setPermissions(boolean responsible, boolean admin) throws TestFailureException {
		WebElement permissions = driver.findElementByCssSelector(" a[href='permissions.php']");
		permissions.click();
		
		WebElement searchInput = driver.findElementById("searchNumber");
		searchInput.sendKeys("901104");
		WebElement searchBtn = driver.findElementById("search");
		searchBtn.click();
		validateThat(waitUntilVisible("search-901104"), "Search failed");
		WebElement result = driver.findElementById("search-901104");
		result.click();
		try {
			Thread.sleep(100);
		} catch (InterruptedException e) {
			//I will sleep!
		}
		
		if(responsible) {
			WebElement responsibleCheckbox = findCheckboxWithId("responsible");
			responsibleCheckbox.click();
		}
		
		if(admin) {
			WebElement adminCheckbox = findCheckboxWithId("admin");
			adminCheckbox.click();
		}
		
		WebElement save = driver.findElementById("save");
		save.click();
	}

	private void loginAndGoToAdmin() throws TestFailureException {
		login();
		validateThat(driver.getCurrentUrl().endsWith("index.php"), "Not on index.php");
		WebElement admin = driver.findElementByLinkText("Admin");
		admin.click();
		validateThat(waitUntilPageChange("index.php"), "Could not click Admin");
	}

}
