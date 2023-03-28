SELECT
payment.payment_id,
payment.loan_account_id,
payment.transaction_number,
payment.transaction_date,
amortization.id,
amortization.loan_account_id,
min(amortization.amortization_date),
min(amortization.transaction_number)
FROM
payment
INNER JOIN amortization ON payment.loan_account_id = amortization.loan_account_id AND payment.transaction_date < amortization.amortization_date
WHERE payment.amortization_id IS NULL
GROUP BY
payment.payment_id;
SELECT
		payment.payment_id,
		MIN(amortization.id) AS 'newID'
	FROM
		payment
	INNER JOIN amortization ON payment.loan_account_id = amortization.loan_account_id
	AND payment.transaction_date < amortization.amortization_date
WHERE payment.amortization_id IS NULL
	GROUP BY
		payment.payment_id
	ORDER BY amortization.id