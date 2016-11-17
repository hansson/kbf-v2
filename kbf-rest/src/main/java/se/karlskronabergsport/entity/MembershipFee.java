package se.karlskronabergsport.entity;

import org.joda.time.DateTime;

public class MembershipFee {
	private DateTime paymentDate = new DateTime();
	private Type type = Type.ADULT;
	
	public enum Type {
		ADULT,
		YOUTH
	}

	public DateTime getPaymentDate() {
		return paymentDate;
	}

	public void setPaymentDate(DateTime paymentDate) {
		this.paymentDate = paymentDate;
	}

	public Type getType() {
		return type;
	}

	public void setType(Type type) {
		this.type = type;
	}

}
