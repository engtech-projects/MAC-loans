TRUNCATE TABLE loan_accounts;
INSERT INTO loan_accounts (
	account_num,
	date_release,
	transaction_date,
	cycle_no,
	ao_id,
	product_id,
	center_id,
	type,
	payment_mode,
	terms,
	loan_amount,
	interest_rate,
	interest_amount,
	no_of_installment,
	due_date,
	day_schedule,
	borrower_num,
	borrower_id,
	co_borrower_name,
	co_borrower_address,
	co_borrower_id_type,
	co_borrower_id_number,
	co_borrower_id_date_issued,
	co_maker_name,
	co_maker_address,
	co_maker_id_type,
	co_maker_id_number,
	co_maker_id_date_issued,
	document_stamp,
	filing_fee,
	insurance,
	affidavit_fee,
	prepaid_interest,
	notarial_fee,
	memo,
	total_deduction,
	net_proceeds,
	release_type,
	branch_code,
	STATUS,
	created_at,
	updated_at,
	loan_status,
    payment_status
)(SELECT
	CAST(tranmast.ACCNUM AS char) AS "account_num",
	CAST(tranmast.DATELN AS date) AS "date_release",
	CAST(tranmast.DATEPROCES AS date) AS "transaction_date",
	CAST(tranmast.CYCLE AS signed) AS "cycle_no",
	CAST(tranmast.TLR AS unsigned) AS "ao_id",
	CAST(product.product_id AS unsigned) AS "product_id",
	CAST(center.center_id AS unsigned) AS "center_id",
	CAST(tranmast.LTYPE AS char) AS "type",
	CAST(paymodes.mode_name AS char) AS "payment_mode",
	CAST(tranmast.TERM AS signed) AS "terms",
	CAST(tranmast.AMTLN AS DECIMAL) AS "loan_amount",
	CAST(tranmast.INRATE/12 AS DECIMAL) AS "interest_rate",
	CAST(tranmast.INTEREST AS DECIMAL) AS "interest_amount",
	CAST(tranmast.NO_INST AS signed) AS "no_of_installment",
	CAST(tranmast.DUEDATE AS date) AS "due_date",
	CAST(day_schedules.sched_day_name AS char) AS "day_schedule",
	CAST(borrower_info.borrower_num AS char) AS "borrower_num",
	CAST(borrower_info.borrower_id AS unsigned) AS "borrower_id",
	CAST(tranmast.COBORR1 AS char) AS "co_borrower_name",
	CAST(tranmast.COADRS1 AS char) AS "co_borrower_address",
	CAST(tranmast.COIDTYPE1 AS char) AS "co_borrower_id_type",
	CAST(tranmast.COIDNUM1 AS char) AS "co_borrower_id_number",
	CAST(tranmast.COIDDATE1 AS char) AS "co_borrower_id_date_issued",
	CAST(tranmast.COBORR2 AS char) AS "co_maker_name",
	CAST(tranmast.COADRS2 AS char) AS "co_maker_address",
	CAST(tranmast.COIDTYPE2 AS char) AS "co_maker_id_type",
	CAST(tranmast.COIDNUM2 AS char) AS "co_maker_id_number",
	CAST(tranmast.COIDDATE2 AS char) AS "co_maker_id_date_issued",
	CAST(tranmast.DOCSTAMPS AS decimal) AS "document_stamp",
	CAST(tranmast.FILLFEE AS decimal) AS "filing_fee",
	CAST(tranmast.INSURANCE AS decimal) AS "insurance",
	CAST(tranmast.OTHERS AS decimal) AS "affidavit_fee",
	CAST(tranmast.PREPAID AS decimal) AS "prepaid_interest",
	CAST(tranmast.NOTARIAL AS decimal) AS "notarial_fee",
	CAST(tranmast.MEMO AS decimal) AS "memo",
	CAST( (
		tranmast.DOCSTAMPS + tranmast.FILLFEE + tranmast.INSURANCE + tranmast.OTHERS + tranmast.PREPAID + tranmast.NOTARIAL + tranmast.MEMO
	) AS decimal) AS total_deduction,
	CAST( (
		tranmast.AMTLN - (
			tranmast.DOCSTAMPS + tranmast.FILLFEE + tranmast.INSURANCE + tranmast.OTHERS + tranmast.PREPAID + tranmast.NOTARIAL + tranmast.MEMO
		)
	) AS decimal) AS net_proceeds,
	CAST(release_type_ref.newReleaseType AS char) AS "release_type",
	CAST(branch.branch_code AS char) AS "branch_code",
	CAST('released' AS char) AS "STATUS",
	NOW() AS "created_at",
	NOW() AS "updated_at",
	CAST(IF(tranmast.`STATUS` != "", tranmast.`STATUS`, IF(tranmast.BALANCE+tranmast.INTBAL <= 0, 'Paid', 'Ongoing')) AS char) AS "loan_status",
    CAST(IF(tranmast.PDIBAL+tranmast.PNLTYBAL >0,'Delinquent','Current')AS char) AS "payment_status"
FROM
	tranmast
INNER JOIN product ON (
	CASE
	WHEN tranmast.PROD_CODE = 0 THEN
		SUBSTR(tranmast.ACCNUM, 7, 1)
	ELSE
		tranmast.PROD_CODE
	END
) = product.product_id
LEFT JOIN center ON tranmast.CNTNAME = center.center
INNER JOIN paymodes ON tranmast.PAYMODE = paymodes.mode_days
INNER JOIN day_schedules ON tranmast.DAYSCHED = day_schedules.sched_id
INNER JOIN borrower_info ON tranmast.CUSTNUM = borrower_info.borrower_num
INNER JOIN branch ON tranmast.BRANCHCODE = branch.branch_id
INNER JOIN release_type_ref ON release_type_ref.oldReleaseType = tranmast.RTYPE
)
