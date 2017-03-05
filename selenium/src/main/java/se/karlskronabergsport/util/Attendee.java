package se.karlskronabergsport.util;

public class Attendee {
	private final String name;
	private final String total;
	
	public Attendee(String name, String total) {
		this.name = name;
		this.total = total;
	}

	public String getTotal() {
		return total;
	}

	public String getName() {
		return name;
	}
}
