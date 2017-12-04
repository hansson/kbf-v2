package se.karlskronabergsport;
import java.util.LinkedList;
import java.util.List;
import java.util.ListIterator;
import java.util.concurrent.TimeUnit;
import java.util.logging.Level;

import org.openqa.selenium.StaleElementReferenceException;
import org.openqa.selenium.WebDriverException;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.logging.LogEntries;
import org.openqa.selenium.logging.LogEntry;
import org.openqa.selenium.logging.LogType;
import org.openqa.selenium.logging.LoggingPreferences;
import org.openqa.selenium.remote.CapabilityType;
import org.openqa.selenium.remote.DesiredCapabilities;
import org.openqa.selenium.remote.RemoteWebDriver;

import se.karlskronabergsport.test.AddMemberAttendeeTest;
import se.karlskronabergsport.test.AddMultipleAttendeesTest;
import se.karlskronabergsport.test.AddSingleAttendeeTest;
import se.karlskronabergsport.test.BaseTest;
import se.karlskronabergsport.test.BuyAllFeesTest;
import se.karlskronabergsport.test.BuyAndAddTenCardTest;
import se.karlskronabergsport.test.BuyMultipleFeesTest;
import se.karlskronabergsport.test.BuyTenCardAsMemberTest;
import se.karlskronabergsport.test.SearchTest;
import se.karlskronabergsport.test.SelfCheckInNotMemberTest;
import se.karlskronabergsport.test.SelfCheckInTest;
import se.karlskronabergsport.test.UseTenCardAndCashback;
import se.karlskronabergsport.test.WrongResponsibleTest;
import se.karlskronabergsport.util.TestFailureException;

public class SeleniumLauncher {

	private static final String RESET_URL = "http://127.0.0.1:12345/kbf/kbf-web/api/private/testing/reset";
	private static final String LOGIN_URL = "http://127.0.0.1:12345/kbf/kbf-web/admin/login.php";

	public static void main(String[] args) {
		DesiredCapabilities caps = DesiredCapabilities.chrome();
        LoggingPreferences logPrefs = new LoggingPreferences();
        logPrefs.enable(LogType.BROWSER, Level.ALL);
        caps.setCapability(CapabilityType.LOGGING_PREFS, logPrefs);
		ChromeDriver driver = new ChromeDriver(caps);
		driver.manage().window().maximize();
		driver.manage().timeouts().implicitlyWait(100, TimeUnit.MILLISECONDS);
		List<BaseTest> testList = new LinkedList<BaseTest>();
		if(args.length == 0) {
			testList.add(new BuyMultipleFeesTest(driver, LOGIN_URL));
			testList.add(new AddSingleAttendeeTest(driver, LOGIN_URL));
			testList.add(new AddMultipleAttendeesTest(driver, LOGIN_URL));
			testList.add(new BuyAndAddTenCardTest(driver, LOGIN_URL));
			testList.add(new BuyTenCardAsMemberTest(driver, LOGIN_URL));
			testList.add(new AddMemberAttendeeTest(driver, LOGIN_URL));
			testList.add(new BuyAllFeesTest(driver, LOGIN_URL));
			testList.add(new SelfCheckInTest(driver, LOGIN_URL));
			testList.add(new SelfCheckInNotMemberTest(driver, LOGIN_URL));
			testList.add(new WrongResponsibleTest(driver, LOGIN_URL));
			testList.add(new SearchTest(driver, LOGIN_URL));
			testList.add(new UseTenCardAndCashback(driver, LOGIN_URL));
		}  else {
			//Currently under development
			testList.add(new BuyTenCardAsMemberTest(driver, LOGIN_URL));
		}
		
		int maxRetries = testList.size();
		int retries = 0;
		
		ListIterator<BaseTest> listIterator = testList.listIterator();
		while(listIterator.hasNext()) {
			BaseTest test = listIterator.next();
			//Reset data
			driver.get(RESET_URL);
			try {
				test.execute();
				System.out.println(test.getClass().getSimpleName() + " successful");
			} catch (Exception e) {
				if(retries > maxRetries) {
					exit(e, test, driver);
				}
				System.out.println(test.getClass().getSimpleName() + " retrying");
				listIterator.previous();
				retries++;
			}
		}
		System.out.println("All tests successfull");
		driver.quit();
	}
	
	private static void exit(Exception e, BaseTest test, ChromeDriver driver) {
		e.printStackTrace();
		System.err.println(test.getClass().getSimpleName() + " " + e.getMessage());
		analyzeLog(driver);
		driver.quit();
		System.exit(0);
	}

	public static void analyzeLog(RemoteWebDriver driver) {
        LogEntries logEntries = driver.manage().logs().get(LogType.BROWSER);
        for (LogEntry entry : logEntries) {
            System.out.println(entry.getMessage());
        }
    }

}
