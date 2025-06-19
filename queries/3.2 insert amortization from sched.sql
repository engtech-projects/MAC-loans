TRUNCATE TABLE amortization;
INSERT INTO amortization ( loan_account_id, amortization_date, principal, interest, total, principal_balance, interest_balance, transaction_number, STATUS, created_at, updated_at )(
	SELECT
		CAST( loan_accounts.loan_account_id AS UNSIGNED ) AS "loan_account_id",
		CAST( sched.DATESCHE AS DATE ) AS 'amortization_date',
		sched.PRIN AS 'principal',
		sched.INTE AS 'interest',
		( sched.PRIN + sched.INTE ) AS 'total',
		( sched.BALANCE + sched.INTE ) - (
			ROUND(( sched.BALANCE + sched.PRIN + sched.INTE ) / ( sched.PRIN + sched.INTE ), 2 ) * sched.INTE 
		) AS 'principal_balance',
		( sched.BALANCE + sched.PRIN ) - (
			ROUND(( sched.BALANCE + sched.PRIN + sched.INTE ) / ( sched.PRIN + sched.INTE ), 2 ) * sched.PRIN 
		) AS 'interest_balance',
		CAST( sched.TRNO AS CHAR ) AS 'transaction_number',
		CAST( IF ( sched.DATEPAID >= sched.DATESCHE AND sched.DATEPAID IS NOT NULL, 'paid', 'open' ) AS CHAR ) AS 'status',
		NOW() AS 'created_at',
		NOW() AS 'updated_at' 
	FROM
		sched
		INNER JOIN loan_accounts ON sched.ACCNUM = loan_accounts.account_num 
	WHERE
		sched.DATESCHE IS NOT NULL 
	);