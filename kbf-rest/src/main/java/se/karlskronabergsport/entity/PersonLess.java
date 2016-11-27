package se.karlskronabergsport.entity;

public class PersonLess {
	
	private final String climbUntil;
	private final String memberUntil;
	private final int tenCardLeft;
	
	public PersonLess(String climbUntil, String memberUntil, int tenCardLeft) {
		this.climbUntil = climbUntil;
		this.memberUntil = memberUntil;
		this.tenCardLeft = tenCardLeft;
	}
	
	public String getClimbUntil() {
		return climbUntil;
	}
	public String getMemberUntil() {
		return memberUntil;
	}
	public int getTenCardLeft() {
		return tenCardLeft;
	}
	
}
