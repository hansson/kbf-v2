package se.karlskronabergsport.entity;

import org.joda.time.DateTime;

public class TenCard {
	private DateTime paymentDate = new DateTime();
	private int handledBy = 1;
	private int[] signedBy = { 1, 1, 1, 1, 1, 1, 1, 1, 1, 1 };

	public DateTime getPaymentDate() {
		return paymentDate;
	}

	public void setPaymentDate(DateTime paymentDate) {
		this.paymentDate = paymentDate;
	}

	public int[] getSignedBy() {
		return signedBy;
	}

	public void setSignedBy(int[] signedBy) {
		this.signedBy = signedBy;
	}

	public int getHandledBy() {
		return handledBy;
	}

	public void setHandledBy(int handledBy) {
		this.handledBy = handledBy;
	}
}
