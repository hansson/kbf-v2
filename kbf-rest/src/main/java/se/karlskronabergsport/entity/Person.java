package se.karlskronabergsport.entity;

import java.util.LinkedList;
import java.util.List;

public class Person {
	
	private final String socialSecurityNumber;
	private final String firstName;
	private final String lastName;
	private final List<MembershipFee> membershipFees = new LinkedList<>();
	private final List<ClimbingFee> climbingFees = new LinkedList<>();
	private final List<TenCard> tenCards = new LinkedList<>();
	
	public Person(String social, String firstName, String lastName) {
		socialSecurityNumber = social;
		this.firstName = firstName;
		this.lastName = lastName;
			
		membershipFees.add(new MembershipFee());
		climbingFees.add(new ClimbingFee());
		tenCards.add(new TenCard());
	}

	public String getSocialSecurityNumber() {
		return socialSecurityNumber;
	}

	public String getFirstName() {
		return firstName;
	}

	public String getLastName() {
		return lastName;
	}

	public List<MembershipFee> getMembershipFees() {
		return membershipFees;
	}

	public List<ClimbingFee> getClimbingFees() {
		return climbingFees;
	}

	public List<TenCard> getTenCards() {
		return tenCards;
	}

}
