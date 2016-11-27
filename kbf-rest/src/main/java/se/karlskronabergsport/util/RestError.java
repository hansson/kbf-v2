package se.karlskronabergsport.util;

public class RestError {

	private final String errorMessage;
	
	public RestError(String errorMessage) {
		this.errorMessage = errorMessage;
	}

	public String getErrorMessage() {
		return errorMessage;
	}

}
