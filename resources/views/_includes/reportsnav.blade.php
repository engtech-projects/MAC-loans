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
		@if(Auth::user()->hasAccess('view releases reports by product')||
			Auth::user()->hasAccess('view releases reports by client')||
			Auth::user()->hasAccess('view releases reports by AO'))
		<reports-nav name="Release" nav="{{$nav[0]}}" nav1="{{$nav[1]}}" nav2="{{$nav[2]}}" subnavs="{{json_encode(config('enums.reports_nav.release'))}}" access="{{json_encode(Auth::user()->accessibility)}}"></reports-nav>
		@endif
		@if(Auth::user()->hasAccess('view repayment reports by product')||
			Auth::user()->hasAccess('view repayment reports by client'))
		<reports-nav name="Repayment" nav="{{$nav[0]}}" nav1="{{$nav[1]}}" nav2="{{$nav[2]}}" subnavs="{{json_encode(config('enums.reports_nav.repayment'))}}" access="{{json_encode(Auth::user()->accessibility)}}"></reports-nav>
		@endif
		@if(Auth::user()->hasAccess('view collection reports by product')||
			Auth::user()->hasAccess('view collection reports by client')||
			Auth::user()->hasAccess('view collection reports by AO'))
		<reports-nav name="Collection" nav="{{$nav[0]}}" nav1="{{$nav[1]}}" nav2="{{$nav[2]}}" subnavs="{{json_encode(config('enums.reports_nav.collection'))}}" access="{{json_encode(Auth::user()->accessibility)}}"></reports-nav>
		@endif
		@if(Auth::user()->hasAccess('view collection branch reports')||
			Auth::user()->hasAccess('view maturity branch reports')||
			Auth::user()->hasAccess('view client payment status branch reports')||
			Auth::user()->hasAccess('view AO branch reports')||
			Auth::user()->hasAccess('view loan listing branch reports')||
			Auth::user()->hasAccess('view loan status summary branch reports')||
			Auth::user()->hasAccess('view loan aging summary branch reports')||
			Auth::user()->hasAccess('view revenue branch reports'))
		<reports-nav name="Branch" nav="{{$nav[0]}}" nav1="{{$nav[1]}}" nav2="{{$nav[2]}}" subnavs="{{json_encode(config('enums.reports_nav.branch'))}}" access="{{json_encode(Auth::user()->accessibility)}}"></reports-nav>
		@endif
		@if(Auth::user()->hasAccess('view loan summary consolidated reports')||
			Auth::user()->hasAccess('view loan aging consolidated reports')||
			Auth::user()->hasAccess('view revenue consolidated reports')||
			Auth::user()->hasAccess('generate DST')||
			Auth::user()->hasAccess('view AO consolidated reports'))
		<reports-nav name="Consolidated" nav="{{$nav[0]}}" nav1="{{$nav[1]}}" nav2="{{$nav[2]}}" subnavs="{{json_encode(config('enums.reports_nav.consolidated'))}}" access="{{json_encode(Auth::user()->accessibility)}}"></reports-nav>
		@endif
		@if(Auth::user()->hasAccess('view cancelled payments report'))
		<div class="report-item-nav <?php echo isActiveNav($nav[1], 'cancelled payments'); ?>">
			<div class="light-bb pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'cancelled payments'); ?>">
				<a href="{{route('reports.repayment.cancelled')}}" class="text-20 base-link">Cancelled Payments</a>
			</div>
		</div>
		@endif
		@if(Auth::user()->hasAccess('view micro monitoring report'))
		<div class="report-item-nav <?php echo isActiveNav($nav[1], 'micro monitoring'); ?>">
			<div class="light-bb pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'micro monitoring'); ?>">
				<a href="{{route('reports.micromonitoring')}}" class="text-20 base-link">Micro Monitoring</a>
			</div>
		</div>
		@endif
		@if(Auth::user()->hasAccess('view prepaid interest report'))
		<div class="report-item-nav <?php echo isActiveNav($nav[1], 'prepaid interest'); ?>">
			<div class="light-bb pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'prepaid interest'); ?>">
				<a href="{{route('reports.prepaidinterest')}}" class="text-20 base-link">Prepaid Interest</a>
			</div>
		</div>
		@endif
		@if(Auth::user()->hasAccess('view performance report'))
		<div class="report-item-nav <?php echo isActiveNav($nav[1], 'performance report'); ?>">
			<div class="light-bb pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'performance report'); ?>">
				<a href="{{route('reports.performancereport')}}" class="text-20 base-link">Performance Report</a>
			</div>
		</div>
		@endif
		@if(Auth::user()->hasAccess('view BIR report'))
		<div class="report-item-nav <?php echo isActiveNav($nav[1], 'bir'); ?>">
			<div class="pxy-25 d-flex justify-content-between align-items-center hover-light report-nav-item <?php echo isActiveNav($nav[1], 'bir'); ?>">
				<a href="{{route('reports.bir')}}" class="text-20 base-link">BIR</a>
			</div>
		</div>
		@endif
	</div>
