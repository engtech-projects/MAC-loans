TRUNCATE TABLE borrower_info;
INSERT INTO borrower_info (
	borrower_info.borrower_num,
	borrower_info.date_registered,
	borrower_info.firstname,
	borrower_info.middlename,
	borrower_info.lastname,
	borrower_info.address,
	borrower_info.birthdate,
	borrower_info.gender,
	borrower_info.`status`,
	borrower_info.contact_number,
	borrower_info.id_type,
	borrower_info.id_no,
	borrower_info.id_date_issued,
	borrower_info.spouse_firstname,
	borrower_info.spouse_middlename,
	borrower_info.spouse_lastname,
	borrower_info.spouse_birthdate,
	borrower_info.created_at,
	borrower_info.updated_at
)(SELECT
		CAST(cif.CUSTNUM AS char) AS "borrower_num",
		CAST(cif.DATEREGIS AS date) AS "date_registered",
		CAST(cif.FNAME AS char) AS "firstname",
		CAST(cif.MIDDLE AS char) AS "middlename",
		CAST(cif.LNAME AS char) AS "lastname",
		CAST(CONCAT(
			CIF.ADRS1,
			" ",
			CIF.ADRS2,
			" ",
			CIF.ADRS2
		) AS char) AS address,
		CAST(cif.DATEBIRTH as date) AS "birthdate",
		CAST(cif.GENDER as char) AS "gender",
		CAST(cif.STAT as char) AS "status",
		CAST(cif.TELNO as char) AS "contact_number",
		CAST(cif.IDTYPE as char) AS "id_type",
		CAST(cif.IDNUM as char) AS "id_no",
		CAST(cif.IDDATE as date) AS "id_date_issued",
		CAST(cif.SPFNAME as char) AS "spouse_firstname",
		CAST(cif.SPMIDDLE as char) AS "spouse_middlename",
		CAST(cif.SPLNAME as char) AS "spouse_lastname",
		CAST(cif.SPDBIRTH as char) AS "spouse_birthdate",
		NOW() AS "created_at",
		NOW() AS "updated_at" 
	FROM
		cif
)