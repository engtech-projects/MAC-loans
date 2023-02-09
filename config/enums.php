<?php
return [
	'days' => [
		'monday',
		'tuesday',
		'wednesday',
		'thursday',
		'friday',
	],

	'status' => [
		'Single',
		'Married',
		'Widowed',
		'Divorced',
		'Separated',
	],

	'mode' => [
		'Monthly',
		'Bi-Monthly',
		'Weekly',
		'Lumpsum',
	],

	'type' => [
		'Add-On',
		'Prepaid',
	],

	'id_type' => [
		'GSIS  UMID',
		'SSS',
		'Postal ID',
		'Passport',
		'PNP',
		'4P’s ID',
		'Brgy ID',
		'Company ID',
		'Pag-Ibig',
		'Philhealth',
		'TIN',
		'NBI Clearance',
		'Voter’s ID / Certificate',
		'Police Clearance',
		'Drivers Licence',
		'Solo Parent ID',
		'PWD ID',
		'Others'
	],

	'release_type' => [
		'Cash',
		'Check',
		'Restructure',
	],

	'payment_type' => [
		'Cash Payment',
		'Check Payment',
		'Memo',
		'POS',
	],


	'loan_status' => [
		'Write-Off',
		'Case Filed',
		'Litigated',
		'Restructured',
		'Restructured w/o PDI',

	],
	
	'reports_nav' => [
		'branch' => [
			[
				'name' => 'Collection Report',
				'url' => 'reports/branch/collection_report'
			],
			[
				'name' => 'Maturity Report',
				'url' => 'reports/branch/maturity_report'
			],
			[
				'name' => 'Client Payment Status',
				'url' => 'reports/branch/client_payment_status'
			],
			[
				'name' => 'Account Officer',
				'url' => 'reports/branch/account_officer'
			],
			[
				'name' => 'Loan Listing',
				'url' => 'reports/branch/loan_listing'
			],
			[
				'name' => 'Loan Status Summary',
				'url' => 'reports/branch/loan_status_summary'
			],
			[
				'name' => 'Loan Aging Summary',
				'url' => 'reports/branch/loan_aging_summary'
			],
			[
				'name' => 'Revenue Report',
				'url' => 'reports/branch/revenue_report'
			]
		],
		'collection' => [
			[
				'name' => 'Group by Product Status',
				'url' => 'reports/collection/product'
			],
			[
				'name' => 'Group by Client Status',
				'url' => 'reports/collection/client'
			],
			[
				'name' => 'Group by Account Officer',
				'url' => 'reports/collection/ao'
			],
		],
		'repayment' => [
			[
				'name' => 'By Product',
				'url' => 'reports/repayment/product'
			],
			[
				'name' => 'By Client',
				'url' => 'reports/repayment/client'
			],
		],
		'release' => [
			[
				'name' => 'By Product',
				'url' => 'reports/release/product'
			],
			[
				'name' => 'By Client',
				'url' => 'reports/release/client'
			],
			[
				'name' => 'By Account Officer',
				'url' => 'reports/release/ao'
			],
		],
		'consolidated' => [
			[
				'name' => 'Loan Summary Report',
				'url' => 'reports/consolidated/loan_summary_report'
			],
			[
				'name' => 'Loan Aging Report',
				'url' => 'reports/consolidated/loan_aging_report'
			],
			[
				'name' => 'Generate DST',
				'url' => 'reports/consolidated/generate_dst'
			],
		]
	]
];
