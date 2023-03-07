<div class="flex-2 light-border d-flex flex-column report-nav mr-24">
		<div class="pxy-25 light-bb d-flex justify-content-between text-bold align-items-center">
			<span class="text-20">Select Report</span>
		</div>
		@if(Auth::user()->hasAccess('view transaction report'))
		<div class="report-item-nav <?php echo isActiveNav($nav[1], 'transaction'); ?>">
			<div class="pxy-25 light-bb d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'transaction'); ?>">
				<a href="{{route('reports.transaction')}}" class="text-20 base-link">Transaction</a>
			</div>
		</div>
		@endif
		
		@if(Auth::user()->hasAccess('view release report'))
		<reports-nav name="Release" nav="{{$nav[0]}}" nav1="{{$nav[1]}}" nav2="{{$nav[2]}}" subnavs="{{json_encode(config('enums.reports_nav.release'))}}"></reports-nav>
		@endif
		@if(Auth::user()->hasAccess('view repayment report'))
		<reports-nav name="Repayment" nav="{{$nav[0]}}" nav1="{{$nav[1]}}" nav2="{{$nav[2]}}" subnavs="{{json_encode(config('enums.reports_nav.repayment'))}}"></reports-nav>
		@endif
		@if(Auth::user()->hasAccess('view collection report'))
		<reports-nav name="Collection" nav="{{$nav[0]}}" nav1="{{$nav[1]}}" nav2="{{$nav[2]}}" subnavs="{{json_encode(config('enums.reports_nav.collection'))}}"></reports-nav>
		@endif
		<reports-nav name="Branch" nav="{{$nav[0]}}" nav1="{{$nav[1]}}" nav2="{{$nav[2]}}" subnavs="{{json_encode(config('enums.reports_nav.branch'))}}"></reports-nav>
		
		<reports-nav name="Consolidated" nav="{{$nav[0]}}" nav1="{{$nav[1]}}" nav2="{{$nav[2]}}" subnavs="{{json_encode(config('enums.reports_nav.consolidated'))}}"></reports-nav>
		
		<div class="report-item-nav <?php echo isActiveNav($nav[1], 'cancelled payments'); ?>">
			<div class="light-bb pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'cancelled payments'); ?>">
				<a href="{{route('reports.repayment.cancelled')}}" class="text-20 base-link">Cancelled Payments</a>
			</div>
		</div>

		<div class="report-item-nav <?php echo isActiveNav($nav[1], 'micro monitoring'); ?>">
			<div class="light-bb pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'micro monitoring'); ?>">
				<a href="{{route('reports.micromonitoring')}}" class="text-20 base-link">Micro Monitoring</a>
			</div>
		</div>

		<div class="report-item-nav <?php echo isActiveNav($nav[1], 'prepaid interest'); ?>">
			<div class="light-bb pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'prepaid interest'); ?>">
				<a href="{{route('reports.prepaidinterest')}}" class="text-20 base-link">Prepaid Interest</a>
			</div>
		</div>

		<div class="report-item-nav <?php echo isActiveNav($nav[1], 'performance report'); ?>">
			<div class="light-bb pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'performance report'); ?>">
				<a href="{{route('reports.performancereport')}}" class="text-20 base-link">Performance Report</a>
			</div>
		</div>

		<div class="report-item-nav <?php echo isActiveNav($nav[1], 'bir'); ?>">
			<div class="pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'bir'); ?>">
				<a href="{{route('reports.bir')}}" class="text-20 base-link">BIR</a>
			</div>
		</div>
	</div>
