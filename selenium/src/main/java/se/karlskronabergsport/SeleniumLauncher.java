package se.karlskronabergsport;
import java.util.LinkedList;
import java.util.List;
import java.util.concurrent.TimeUnit;

import org.openqa.selenium.chrome.ChromeDriver;

import se.karlskronabergsport.test.AddMemberAttendeeTest;
import se.karlskronabergsport.test.AddMultipleAttendeesTest;
import se.karlskronabergsport.test.AddSingleAttendeeTest;
import se.karlskronabergsport.test.BaseTest;
import se.karlskronabergsport.test.BuyAllFeesTest;
import se.karlskronabergsport.test.BuyAndAddTenCardTest;
import se.karlskronabergsport.test.BuyMultipleFeesTest;
import se.karlskronabergsport.test.BuyTenCardAsMemberTest;
import se.karlskronabergsport.test.SelfCheckInNotMemberTest;
import se.karlskronabergsport.test.SelfCheckInTest;
import se.karlskronabergsport.test.WrongResponsibleTest;
import se.karlskronabergsport.util.TestFailureException;

public class SeleniumLauncher {

	private static final String RESET_URL = "http://127.0.0.1:12345/kbf/kbf-web/api/private/testing/reset";
	private static final String LOGIN_URL = "http://127.0.0.1:12345/kbf/kbf-web/admin/login.php";

	public static void main(String[] args) {
		ChromeDriver driver = new ChromeDriver();
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
		}  else {
			//Currently under development
			testList.add(new BuyAllFeesTest(driver, LOGIN_URL));
		}
		
		for(BaseTest test : testList) {
			//Reset data
			driver.get(RESET_URL);
			try {
				test.execute();
				System.out.println(test.getClass().getSimpleName() + " successful");
			} catch (TestFailureException e) {
				e.printStackTrace();
				System.err.println(test.getClass().getSimpleName() + " " + e.getMessage());
				driver.quit();
				System.exit(0);
			}
		}
		System.out.println("All tests successfull");
		driver.quit();
	}

}
