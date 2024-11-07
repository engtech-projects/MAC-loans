SELECT
	loan_accounts.loan_account_id,
	branch.branch_id,
	pay_type_ref.new_name AS 'payment_type',
	paymast.ORNUM AS 'or_no',
	paymast.CHK AS 'cheque_no',
	paymast.BNK_NAME AS 'bank_name',
	paymast.PAY_REF AS 'reference_no',
	memo_type_ref.newMemo AS 'memo_type',
	NULL AS 'amortization_id',-- TO UPDATE / FIXED IN 4.3 - 4.6
	paymast.BALANCE AS 'principal',
	(
		paymast.INTBAL -
	IF
		(
			paymast.REBATES < paymast.INTBAL 
			AND paymast.REBATES != paymast.PDI 
			AND paymast.REBATES != paymast.PENALTY,
			paymast.REBATES,
			0 
		) 
	) AS 'interest',
	NULL AS 'short_principal',-- TO UPDATE / FIXED IN CODE
	NULL AS 'advance_principal',-- TO UPDATE / FIXED IN CODE
	NULL AS 'short_interest',-- TO UPDATE / FIXED IN CODE
	NULL AS 'advance_interest',-- TO UPDATE / FIXED IN CODE
	paymast.PDI AS 'pdi',
IF
	( paymast.PDI = paymast.REBATES, '03212023', NULL ) AS 'pdi_approval_no',-- NEEDS CONDITION
	paymast.PDIBAL AS 'short_pdi',
	paymast.PENALTY AS 'penalty',
IF
	( paymast.PENALTY = paymast.REBATES, '03212023', NULL ) AS 'penalty_approval_no',-- NEEDS CONDITION
	paymast.PNLTYBAL AS 'short_penalty',
IF
	(
		paymast.REBATES <= paymast.INTBAL 
		AND paymast.REBATES != paymast.PDI 
		AND paymast.REBATES != paymast.PENALTY,
		paymast.REBATES,
		0 
	) AS 'rebates',-- NEEDS CONDITION
IF
	(
		paymast.REBATES < paymast.INTBAL 
		AND paymast.REBATES != paymast.PDI 
		AND paymast.REBATES != paymast.PENALTY,
		'03212023',
	NULL 
	) AS 'rebates_approval_no',-- NEEDS CONDITION
	0 AS 'total_payable',-- TO UPDATE / LEFT AT 0
	( paymast.BALANCE + paymast.INTBAL + paymast.PDI + paymast.PENALTY + paymast.OTHPAY ) AS 'amount_applied',
	paymast.OTHPAY AS over_payment,
	ROUND((
			paymast.INTBAL + paymast.PDI + paymast.PENALTY -
		IF
			(
				paymast.REBATES <= paymast.INTBAL 
				AND paymast.REBATES != paymast.PDI 
				AND paymast.REBATES != paymast.PENALTY,
				paymast.REBATES,
				0 
			) 
			) / 1.12 *.12,
		2 
	) AS vat,
	'paid' AS 'status',
	NOW() AS created_at,
	TIMESTAMP ( paymast.DATEPAY ) AS updated_at,
	NULL AS reference_id,
	NULL AS remarks,
	paymast.TRNO AS transaction_number,
	paymast.TRNDATE AS transaction_date 
FROM
	paymast
	INNER JOIN loan_accounts ON paymast.ACCNUM = loan_accounts.account_num
	INNER JOIN branch ON branch.branch_code = loan_accounts.branch_code
	LEFT JOIN (
	SELECT
		SUM( sched.PRIN ) AS totPrin,
		SUM( sched.INTE ) AS totInt,
		sched.TRNO 
	FROM
		sched 
	GROUP BY
		TRNO 
	) AS amortDet ON amortDet.trno = paymast.TRNO
	LEFT JOIN pay_type_ref ON pay_type_ref.old_name = paymast.PTYPE
	LEFT JOIN memo_type_ref ON memo_type_ref.oldMemo = paymast.PTYPE