<div class="flex-2 light-border d-flex flex-column report-nav mr-24">
		<div class="pxy-25 light-bb d-flex justify-content-between text-bold align-items-center">
			<span class="text-20">Select Report</span>
		</div>
		<div class="pxy-25 light-bb d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'transaction'); ?>">
			<a href="{{route('reports.transaction')}}" class="text-20 base-link">Transaction</a>
			<i class="fa fa-caret-right"></i>
		</div>
		<div class="pxy-25 light-bb d-flex justify-content-between align-items-center relative hover-light report-nav-item <?php echo isActiveNav($nav[1], 'release'); ?>">
			<a href="#" class="text-20 base-link">Release</a>
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
		
		<branch-nav mainNav="{{$nav[0]}}" nav1="{{$nav[1]}}" nav2="{{$nav[2]}}"></branch-nav>
		
		<div class="light-bb pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'cancelled payments'); ?>">
			<a href="{{route('reports.repayment.cancelled')}}" class="text-20 base-link">Cancelled Payments</a>
			<i class="fa fa-caret-right"></i>
		</div>
		<div class="light-bb pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'micro monitoring'); ?>">
			<a href="{{route('reports.micromonitoring')}}" class="text-20 base-link">Micro Monitoring</a>
			<i class="fa fa-caret-right"></i>
		</div>
		<div class="light-bb pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'prepaid interest'); ?>">
			<a href="{{route('reports.prepaidinterest')}}" class="text-20 base-link">Prepaid Interest</a>
			<i class="fa fa-caret-right"></i>
		</div>
		<div class="pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'performance report'); ?>">
			<a href="{{route('reports.performancereport')}}" class="text-20 base-link">Performance Report</a>
			<i class="fa fa-caret-right"></i>
		</div>
	</div>
