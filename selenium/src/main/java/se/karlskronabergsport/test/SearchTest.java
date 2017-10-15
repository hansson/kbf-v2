package se.karlskronabergsport.test;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;

import se.karlskronabergsport.util.TestFailureException;


public class SearchTest extends AttendeeTest {

	public SearchTest(ChromeDriver driver, String loginUrl) {
		super(driver, loginUrl, "me@tobiashansson.nu", "test");
	}

	@Override
	public void execute() throws TestFailureException {
		registerUser("901104");
		super.execute();
		validateThat(driver.getCurrentUrl().endsWith("index.php"), "Not on index.php");
		
		WebElement register = driver.findElementByLinkText("Registrera");
		register.click();
		validateThat(waitUntilPageChange("index.php"), "Could not click Registrera");
		
		WebElement pnr = driver.findElementById("item_pnr");
		WebElement fullPnr = driver.findElementById("item_tmp_pnr");
		
		WebElement membershipFee = findCheckboxWithId("item_1");
		WebElement climbYear = findCheckboxWithId("item_3");
		
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
		
		WebElement search = driver.findElementByCssSelector(" a[href='search.php']");
		search.click();
		WebElement searchInput = driver.findElementById("searchNumber");
		searchInput.sendKeys("901104");
		WebElement searchBtn = driver.findElementById("search");
		searchBtn.click();
		validateThat(waitUntilVisible("search-901104"), "Search failed");
		WebElement result = driver.findElementById("search-901104");
		result.click();
		validateThat(waitUntilVisible("#paymentTable tr", TYPE_CSS), "Search failed");
	}

}
