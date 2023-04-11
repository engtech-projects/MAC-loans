SELECT
	CAST(
		loan_accounts.loan_account_id AS UNSIGNED
	) AS "loan_account_id",
	CAST(sched.DATESCHE AS DATE) AS 'amortization_date',
	CAST(sched.PRIN AS DECIMAL) AS 'principal',
	CAST(sched.INTE AS DECIMAL) AS 'interest',
	CAST(
		(sched.PRIN + sched.INTE) AS DECIMAL
	) AS 'total',
	CAST(
		ROUND(
			(
				sched.BALANCE / (sched.PRIN + sched.INTE)
			) * sched.PRIN,
			2
		) AS DECIMAL
	) AS 'principal_balance',
	CAST(
		FLOOR(
			(
				sched.BALANCE / (sched.PRIN + sched.INTE)
			) * sched.INTE
		) AS DECIMAL
	) AS 'interest_balance',
	CAST(sched.TRNO AS CHAR) AS 'transaction_number',
	CAST(

		IF (
			sched.DATEPAID >= sched.DATESCHE AND sched.DATEPAID is not NULL,
			'paid',
			'open'
		) AS CHAR
	) AS 'status',
	NOW() AS 'created_at',
	NOW() AS 'updated_at'
FROM
	sched
INNER JOIN loan_accounts ON sched.ACCNUM = loan_accounts.account_num
WHERE
	sched.DATESCHE IS NOT NULL