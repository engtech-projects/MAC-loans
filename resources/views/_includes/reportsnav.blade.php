<div class="flex-2 light-border d-flex flex-column report-nav mr-24">
		<div class="pxy-25 light-bb d-flex justify-content-between text-bold align-items-center">
			<span class="text-20">Select Report</span>
		</div>
		<div class="pxy-25 light-bb d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'transaction'); ?>">
			<a href="{{route('reports.transaction')}}" class="text-20 base-link">Transaction</a>
			<i class="fa fa-caret-right"></i>
		</div>
		<div class="pxy-25 light-bb d-flex justify-content-between align-items-center relative hover-light report-nav-item <?php echo isActiveNav($nav[1], 'release'); ?>">
			<a href="reports_release.php" class="text-20 base-link">Release</a>
			<i class="fa fa-caret-right"></i>
			<div class="ssub-menu light-border">
				<div class="pxy-25 light-bb d-flex justify-content-between align-items-center hover-primary-dark">
					<a href="{{route('reports.release.product')}}" class="text-20 base-link">By Product</a>
				</div>
				<div class="pxy-25 light-bb d-flex justify-content-between align-items-center hover-primary-dark">
					<a href="{{route('reports.release.client')}}" class="text-20 base-link">By Client</a>
				</div>
				<div class="pxy-25 light-bb d-flex justify-content-between align-items-center hover-primary-dark">
					<a href="{{route('reports.release.ao')}}" class="text-20 base-link">By Account Officer</a>
				</div>
			</div>
		</div>
		<div class="pxy-25 light-bb d-flex justify-content-between align-items-center hover-light report-nav-item relative <?php echo isActiveNav($nav[1], 'repayment'); ?>">
			<a href="reports_repayment.php" class="text-20 base-link">Repayment</a>
			<i class="fa fa-caret-right"></i>
			<div class="ssub-menu light-border">
				<div class="pxy-25 light-bb d-flex justify-content-between align-items-center hover-primary-dark">
					<a href="{{route('reports.repayment.product')}}" class="text-20 base-link">By Product</a>
				</div>
				<div class="pxy-25 light-bb d-flex justify-content-between align-items-center hover-primary-dark">
					<a href="{{route('reports.repayment.client')}}" class="text-20 base-link">By Client</a>
				</div>
			</div>
		</div>
		<div class="pxy-25 light-bb d-flex justify-content-between align-items-center hover-light report-nav-item relative <?php echo isActiveNav($nav[1], 'collection'); ?>">
			<a href="reports_collection_rate.php" class="text-20 base-link">Collection</a>
			<i class="fa fa-caret-right"></i>
			<div class="ssub-menu light-border">
				<div class="pxy-25 light-bb d-flex justify-content-between align-items-center hover-primary-dark">
					<a href="{{route('reports.collection.product')}}" class="text-20">Group by Product Status</a>
				</div>
				<div class="pxy-25 light-bb d-flex justify-content-between align-items-center hover-primary-dark">
					<a href="{{route('reports.collection.client')}}" class="text-20">Group by Client Status</a>
				</div>
				<div class="pxy-25 light-bb d-flex justify-content-between align-items-center hover-primary-dark">
					<a href="{{route('reports.collection.ao')}}" class="text-20">Group by Account Officer</a>
				</div>
			</div>
		</div>
		<div class="report-main-item pxy-25 light-bb d-flex flex-column relative <?php echo isActiveNav($nav[1], 'branch'); ?> hover-light report-nav-item">
			<div class="nav-item-body d-flex justify-content-between align-items-center">
				<a href="" class="text-20 base-link">Branch</a>
				<i class="fa fa-caret-right" style="display:block"></i>
			</div>
			<div class="sub-item-container mt-10">
				<div class="pxy-15 light-bt light-bb d-flex justify-content-between align-items-center hover-primary-dark <?php echo isActiveNav($nav[2], 'collection report'); ?>">
					<a href="reports_branch_collection.php" class="text-md base-link">Collection Report</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark <?php echo isActiveNav($nav[2], 'maturity report'); ?>">
					<a href="reports_branch_maturity.php" class="text-md base-link">Maturity Report</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark <?php echo isActiveNav($nav[2], 'client payment status'); ?>">
					<a href="reports_branch_client_payment_status.php" class="text-md base-link">Client Payment Status</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark <?php echo isActiveNav($nav[2], 'account officer'); ?>">
					<a href="reports_branch_account_officer.php" class="text-md base-link">Account Officer</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark <?php echo isActiveNav($nav[2], 'loan listing'); ?>">
					<a href="reports_branch_loan_listing.php" class="text-md base-link">Loan Listing</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark <?php echo isActiveNav($nav[2], 'loan status summary'); ?>">
					<a href="reports_branch_loan_status_summary.php" class="text-md base-link">Loan Status Summary</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark <?php echo isActiveNav($nav[2], 'loan aging summary'); ?>">
					<a href="reports_branch_loan_aging_summary.php" class="text-md base-link">Loan Aging Summary</a>
				</div>
				<div class="pxy-15 d-flex justify-content-between align-items-center hover-primary-dark <?php echo isActiveNav($nav[2], 'revenue report'); ?>">
					<a href="reports_branch_revenue_report.php" class="text-md base-link">Revenue Report</a>
				</div>
			</div>
		</div>
		<div class="report-main-item pxy-25 light-bb d-flex flex-column relative <?php echo isActiveNav($nav[1], 'consolidated'); ?> hover-light report-nav-item">
			<div class="nav-item2-body d-flex justify-content-between align-items-center">
				<a href="" class="text-20 base-link">Consolidated</a>
				<i class="fa fa-caret-right" style="display:block"></i>
			</div>
			<div class="sub-item-container mt-10">
				<div class="pxy-15 light-bt light-bb d-flex justify-content-between align-items-center hover-primary-dark <?php echo isActiveNav($nav[2], 'loan summary report'); ?>">
					<a href="reports_consolidated_loan_summary_report.php" class="text-md base-link">Loan Summary Report</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark <?php echo isActiveNav($nav[2], 'consolidated aging report'); ?>">
					<a href="reports_consolidated_loan_aging_report.php" class="text-md base-link">Loan Aging Report</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark <?php echo isActiveNav($nav[2], 'performance report'); ?>">
					<a href="#" class="text-md base-link">Performance Report</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark <?php echo isActiveNav($nav[2], 'write-off report'); ?>">
					<a href="#" class="text-md base-link">Write-Off Report</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark <?php echo isActiveNav($nav[2], 'delinquent report'); ?>">
					<a href="#" class="text-md base-link">Delinquent Report</a>
				</div>
				<div class="pxy-15 d-flex justify-content-between align-items-center hover-primary-dark <?php echo isActiveNav($nav[2], 'consolidated revenue report'); ?>">
					<a href="#" class="text-md base-link">Revenue Report</a>
				</div>
			</div>
		</div>
		<div class="light-bb pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'cancelled payments'); ?>">
			<a href="reports_cancelled_payments.php" class="text-20 base-link">Cancelled Payments</a>
			<i class="fa fa-caret-right"></i>
		</div>
		<div class="light-bb pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'micro monitoring'); ?>">
			<a href="reports_micro_monitoring.php" class="text-20 base-link">Micro Monitoring</a>
			<i class="fa fa-caret-right"></i>
		</div>
		<div class="light-bb pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'prepaid interest'); ?>">
			<a href="reports_prepaid_interest.php" class="text-20 base-link">Prepaid Interest</a>
			<i class="fa fa-caret-right"></i>
		</div>
		<div class="pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'performance report'); ?>">
			<a href="reports_performance_report.php" class="text-20 base-link">Performance Report</a>
			<i class="fa fa-caret-right"></i>
		</div>
	</div>
