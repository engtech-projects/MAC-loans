TRUNCATE TABLE payment;

INSERT INTO payment (
	payment.loan_account_id,
	payment.branch_id,
	payment.payment_type,
	payment.or_no,
	payment.cheque_no,
	payment.bank_name,
	payment.reference_no,
	payment.memo_type,
	payment.amortization_id,
	payment.principal,
	payment.interest,
	payment.short_principal,
	payment.advance_principal,
	payment.short_interest,
	payment.advance_interest,
	payment.pdi,
	payment.pdi_approval_no,
	payment.short_pdi,
	payment.penalty,
	payment.penalty_approval_no,
	payment.short_penalty,
	payment.rebates,
	payment.rebates_approval_no,
	payment.total_payable,
	payment.amount_applied,
	payment.over_payment,
	payment.vat,
	payment.`status`,
	payment.created_at,
	payment.updated_at,
	payment.reference_id,
	payment.remarks,
	payment.transaction_number,
	payment.transaction_date
)(
	SELECT
	loan_accounts.loan_account_id,
	branch.branch_id,
	pay_type_ref.new_name AS 'payment_type',
	paymast.ORNUM AS 'or_no',
	paymast.CHK AS 'cheque_no',
	paymast.BNK_NAME AS 'bank_name',
	paymast.PAY_REF AS 'reference_no',
	memo_type_ref.newMemo AS 'memo_type',
	NULL AS 'amortization_id', -- TO UPDATE
	paymast.BALANCE AS 'principal',
	(paymast.INTBAL - paymast.REBATES) AS 'interest',
	NULL AS 'short_principal', -- TO UPDATE
	NULL AS 'advance_principal', -- TO UPDATE
	NULL AS 'short_interest', -- TO UPDATE
	NULL AS 'advance_interest', -- TO UPDATE
	paymast.PDI AS 'pdi',
	'03212023' AS 'pdi_approval_no',
	paymast.PDIBAL AS 'short_pdi',
	paymast.PENALTY AS 'penalty',
	'03212023' AS 'penalty_approval_no',
	paymast.PNLTYBAL AS 'short_penalty',
	paymast.REBATES AS 'rebates',
	'03212023' AS 'rebates_approval_no',
	0 AS 'total_payable', -- TO UPDATE
	(
		paymast.BALANCE + paymast.INTBAL + paymast.PDI + paymast.PENALTY + paymast.OTHPAY 
	) AS 'amount_applied',
	paymast.OTHPAY AS over_payment,
	ROUND((paymast.INTBAL + paymast.PDI + paymast.PENALTY - paymast.REBATES ) / 1.12 *.12, 2) AS vat,
	'paid' AS 'status',
	NOW() AS created_at,
	TIMESTAMP (paymast.DATEPAY) AS updated_at,
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
		SUM(sched.PRIN) AS totPrin,
		SUM(sched.INTE) AS totInt,
		sched.TRNO
	FROM
		sched
	GROUP BY
		TRNO
) AS amortDet ON amortDet.trno = paymast.TRNO
LEFT JOIN pay_type_ref ON pay_type_ref.old_name = paymast.PTYPE
LEFT JOIN memo_type_ref ON memo_type_ref.oldMemo = paymast.PTYPE
);