package se.karlskronabergsport.entity;

import org.joda.time.DateTime;

public class ClimbingFee {
	private DateTime paymentDate = new DateTime();
	private Type type = Type.FULL_YEAR;
	
	public enum Type {
		FULL_YEAR,
		HALF_YEAR
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
