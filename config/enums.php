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
				'url' => 'reports/branch/collection_report',
				'access' => 'view collection branch reports'
			],
			[
				'name' => 'Maturity Report',
				'url' => 'reports/branch/maturity_report',
				'access' => 'view maturity branch reports'
			],
			[
				'name' => 'Client Payment Status',
				'url' => 'reports/branch/client_payment_status',
				'access' => 'view client payment status branch reports'
			],
			[
				'name' => 'Account Officer',
				'url' => 'reports/branch/account_officer',
				'access' => 'view AO branch reports'
			],
			[
				'name' => 'Loan Listing',
				'url' => 'reports/branch/loan_listing',
				'access' => 'view loan listing branch reports'
			],
			[
				'name' => 'Loan Status Summary',
				'url' => 'reports/branch/loan_status_summary',
				'access' => 'view loan status summary branch reports'
			],
			[
				'name' => 'Loan Aging Summary',
				'url' => 'reports/branch/loan_aging_summary',
				'access' => 'view loan aging summary branch reports'
			],
			[
				'name' => 'Revenue Report',
				'url' => 'reports/branch/revenue_report',
				'access' => 'view revenue branch reports'
			]
		],
		'collection' => [
			[
				'name' => 'Group by Product Status',
				'url' => 'reports/collection/product',
				'access' => 'view collection reports by product'
			],
			[
				'name' => 'Group by Client Status',
				'url' => 'reports/collection/client',
				'access' => 'view collection reports by client'
			],
			[
				'name' => 'Group by Account Officer',
				'url' => 'reports/collection/ao',
				'access' => 'view collection reports by AO'
			],
		],
		'repayment' => [
			[
				'name' => 'By Product',
				'url' => 'reports/repayment/product',
				'access' => 'view repayment reports by product'
			],
			[
				'name' => 'By Client',
				'url' => 'reports/repayment/client',
				'access' => 'view repayment reports by client'
			],
		],
		'release' => [
			[
				'name' => 'By Product',
				'url' => 'reports/release/product',
				'access' => 'view releases reports by product'
			],
			[
				'name' => 'By Client',
				'url' => 'reports/release/client',
				'access' => 'view releases reports by client'
			],
			[
				'name' => 'By Account Officer',
				'url' => 'reports/release/ao',
				'access' => 'view releases reports by AO'
			],
		],
		'consolidated' => [
			[
				'name' => 'Loan Summary Report',
				'url' => 'reports/consolidated/loan_summary_report',
				'access' => 'view loan summary consolidated reports'
			],
			[
				'name' => 'Loan Aging Report',
				'url' => 'reports/consolidated/loan_aging_report',
				'access' => 'view loan aging consolidated reports'
			],
			[
				'name' => 'Revenue Report',
				'url' => 'reports/consolidated/revenue_report',
				'access' => 'view revenue consolidated reports'
			],
			[
				'name' => 'Generate DST',
				'url' => 'reports/consolidated/generate_dst',
				'access' => 'generate DST'
			],
			[
				'name' => 'Account Officer',
				'url' => 'reports/consolidated/account_officer',
				'access' => 'view AO consolidated reports'
			],
		]
	]
];
