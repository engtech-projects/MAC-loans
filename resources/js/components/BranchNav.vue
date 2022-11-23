<template>
	<div>
		<div class="report-main-item pxy-25 light-bb d-flex flex-column relative hover-light report-nav-item" :class="branchNav?'active':''">
			<div @click="branchNav=!branchNav" class="nav-item-body d-flex justify-content-between align-items-center">
				<a href="" @click.prevent class="text-20 base-link">Branch</a>
				<i class="fa fa-caret-right" style="display:block"></i>
			</div>
			<div class="sub-item-container mt-10">
				<div class="pxy-15 light-bt light-bb d-flex justify-content-between align-items-center hover-primary-dark" :class="nav2=='collection report'?'active':''">
					<a :href="baseURL() + 'reports/branch/collection_report'" class="text-md base-link">Collection Report</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark" :class="nav2=='maturity report'?'active':''">
					<a :href="baseURL() + 'reports/branch/maturity_report'" class="text-md base-link">Maturity Report</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark" :class="nav2=='client payment status'?'active':''">
					<a :href="baseURL() + 'reports/branch/client_payment_status'" class="text-md base-link">Client Payment Status</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark" :class="nav2=='account officer'?'active':''">
					<a :href="baseURL() + 'reports/branch/account_officer'" class="text-md base-link">Account Officer</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark" :class="nav2=='loan listing'?'active':''">
					<a :href="baseURL() + 'reports/branch/loan_listing'" class="text-md base-link">Loan Listing</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark" :class="nav2=='loan status summary'?'active':''">
					<a :href="baseURL() + 'reports/branch/loan_status_summary'" class="text-md base-link">Loan Status Summary</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark" :class="nav2=='loan aging summary'?'active':''">
					<a :href="baseURL() + 'reports/branch/loan_aging_summary'" class="text-md base-link">Loan Aging Summary</a>
				</div>
				<div class="pxy-15 d-flex justify-content-between align-items-center hover-primary-dark" :class="nav2=='revenue report'?'active':''">
					<a :href="baseURL() + 'reports/branch/revenue_report'" class="text-md base-link">Revenue Report</a>
				</div>
			</div>
		</div>
		<div class="report-main-item pxy-25 light-bb d-flex flex-column relative hover-light report-nav-item" :class="consolidatedNav?'active':''">
			<div @click="consolidatedNav=!consolidatedNav" class="nav-item2-body d-flex justify-content-between align-items-center">
				<a @click.prevent href="" class="text-20 base-link">Consolidated</a>
				<i class="fa fa-caret-right" style="display:block"></i>
			</div>
			<div class="sub-item-container mt-10">
				<div class="pxy-15 light-bt light-bb d-flex justify-content-between align-items-center hover-primary-dark" :class="nav2=='loan summary report'?'active':''">
					<a href="reports_consolidated_loan_summary_report.php" class="text-md base-link">Loan Summary Report</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark" :class="nav2=='consolidated aging report'?'active':''">
					<a href="reports_consolidated_loan_aging_report.php" class="text-md base-link">Loan Aging Report</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark" :class="nav2=='performance report'?'active':''">
					<a href="#" class="text-md base-link">Performance Report</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark" :class="nav2=='write-off report'?'active':''">
					<a href="#" class="text-md base-link">Write-Off Report</a>
				</div>
				<div class="pxy-15 light-bb d-flex justify-content-between align-items-center hover-primary-dark" :class="nav2=='delinquent report'?'active':''">
					<a href="#" class="text-md base-link">Delinquent Report</a>
				</div>
				<div class="pxy-15 d-flex justify-content-between align-items-center hover-primary-dark" :class="nav2=='consolidated revenue report'?'active':''">
					<a href="#" class="text-md base-link">Revenue Report</a>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props:['nav1','nav2', 'mainnav'],
	data(){
		return {
			branchNav:false,
			consolidatedNav:false,
		}
	},
	mounted(){
		this.branchNav = this.nav1=='branch'?true:false
		this.consolidatedNav = this.nav1=='consolidated'?true:false
	}
}
</script>
