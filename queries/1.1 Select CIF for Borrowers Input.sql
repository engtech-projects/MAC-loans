SELECT
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