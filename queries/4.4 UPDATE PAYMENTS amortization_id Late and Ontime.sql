UPDATE payment
INNER JOIN (
	SELECT
		payment.payment_id,
		MAX(amortization.id) AS 'newID'
	FROM
		payment
	INNER JOIN amortization ON payment.loan_account_id = amortization.loan_account_id
	AND payment.transaction_date >= amortization.amortization_date
	GROUP BY
		payment.payment_id
) AS amortization ON amortization.payment_id = payment.payment_id
SET payment.amortization_id = amortization.newID
