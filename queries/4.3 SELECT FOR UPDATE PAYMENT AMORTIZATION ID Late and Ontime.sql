
	SELECT
		payment.payment_id,
		payment.loan_account_id,
		payment.transaction_number,
		payment.transaction_date,
		max(amortization.id),
		amortization.loan_account_id,
		max(
			amortization.amortization_date
		),
		max(
			amortization.transaction_number
		)
	FROM
		payment
	INNER JOIN amortization ON payment.loan_account_id = amortization.loan_account_id
	AND payment.transaction_date >= amortization.amortization_date
	GROUP BY
		payment.payment_id;


	SELECT
		payment.payment_id,
		MAX(amortization.id) AS 'newID'
	FROM
		payment
	INNER JOIN amortization ON payment.loan_account_id = amortization.loan_account_id
	AND payment.transaction_date >= amortization.amortization_date
	GROUP BY
		payment.payment_id;


