package se.karlskronabergsport.test;
import java.io.File;
import java.io.IOException;
import java.util.List;
import java.util.function.Function;

import org.apache.commons.io.FileUtils;
import org.openqa.selenium.By;
import org.openqa.selenium.OutputType;
import org.openqa.selenium.TakesScreenshot;
import org.openqa.selenium.TimeoutException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.support.ui.WebDriverWait;

import se.karlskronabergsport.util.TestFailureException;


public abstract class BaseTest {

	protected final ChromeDriver driver;
	private final String loginUrl;
	private final String email;
	private final String password;

	public BaseTest(ChromeDriver driver, String loginUrl, String email, String password) {
		this.driver = driver;
		this.loginUrl = loginUrl;
		this.email = email;
		this.password = password;
	}

	public void execute() throws TestFailureException {
		login();
	}

	protected void login() throws TestFailureException {
		login(email, password);
	}
	
	protected void login(String e, String p) throws TestFailureException {
		driver.get(loginUrl);
		WebElement email = driver.findElementById("inputEmail");
		email.sendKeys(e);
		WebElement password = driver.findElementById("inputPassword");
		password.sendKeys(p);
		password.submit();
		validateThat(waitUntilPageChange("login.php"), "Login failed");
	}
	
	protected void registerUser(String user) throws TestFailureException {
		driver.get(loginUrl);
		WebElement register = driver.findElementById("registerBtn");
		register.click();
		validateThat(waitUntilPageChange("login.php"), "Failed to go to register page");
		
		WebElement firstName = driver.findElementById("inputFirstName");
		firstName.sendKeys(user);
		WebElement lastName = driver.findElementById("inputLastName");
		lastName.sendKeys(user);
		WebElement pnr = driver.findElementById("inputPnr");
		pnr.sendKeys(user);
		WebElement email = driver.findElementById("inputEmail");
		email.sendKeys(user + "@test.com");
		WebElement password = driver.findElementById("inputPassword");
		password.sendKeys("test");
		
		register = driver.findElementById("registerBtn");
		register.click();
		validateThat(waitUntilPageChange("register.php"), "Failed to register");
		validateThat(waitUntilLoaded("registered"), "Register not successful");
	}

	protected boolean waitUntilPageChange(final String currentPage) {
		try {
			new WebDriverWait(driver, 3).until(new Function<WebDriver, Boolean>() {

				public Boolean apply(WebDriver d) {
					return !d.getCurrentUrl().contains(currentPage);
				}

			});
			return true;
		} catch (TimeoutException e) {
			return false;
		}
	}
	
	protected boolean waitUntilLoaded(final String id) {
		try {
			new WebDriverWait(driver, 3).until(new Function<WebDriver, Boolean>() {
				public Boolean apply(WebDriver d) {
					return d.findElements(By.id(id)).size() > 0;
				}
			});
			return true;
		} catch (TimeoutException e) {
			return false;
		}
	}
	
	protected boolean waitUntilVisible(final String id) {
		try {
			new WebDriverWait(driver, 3).until(new Function<WebDriver, Boolean>() {

				public Boolean apply(WebDriver d) {
					List<WebElement> foundElements = d.findElements(By.id(id));
					if (foundElements.size() > 0) {
						return foundElements.get(0).isDisplayed();
					}
					return false;
				}

			});
			return true;
		} catch (TimeoutException e) {
			return false;
		}
	}
	
	
	protected void validateThat(boolean expr, String error) throws TestFailureException {
		if(!expr) {
			File scrFile = ((TakesScreenshot)driver).getScreenshotAs(OutputType.FILE);
			try {
				FileUtils.copyFile(scrFile, new File("c:\\tmp\\screenshot.png"));
				System.err.println("Screnshot at c:\\tmp\\screenshot.png");
			} catch (IOException e) {
				System.err.println("Failed to write screenshot");
			}
			throw new TestFailureException(error);
		}
	}
	
	protected WebElement findCheckboxWithId(String id) {
		List<WebElement> checkboxes = driver.findElementsByClassName("custom-checkbox");
		for(WebElement element : checkboxes) {
			List<WebElement> checkbox = element.findElements(By.id(id));
			if(checkbox.size() == 1) {
				return element;
			}
		}
		return null;
	}
}
