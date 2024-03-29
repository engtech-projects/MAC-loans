<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
<!-- Brand Logo -->
<a href="{{asset('')}}" id="baseUrl" class="brand-link center-text">     
  <span class="logo">Micro Access Loan Corporation</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
	<!-- Sidebar user panel (optional) -->
	<div class="user-panel mt-3 pb-3 mb-3 d-flex flex-center-y">
	<div class="image">
	  <img src="{{ asset('img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
	</div>
	<div class="info">
	  <div class="flex-col">
		  <span class="top">Welcome</span>
		  <span class="mid">{{Session::get('fullname')}}</span>
		  <span class="bot">Loan Clerk</span>
	  </div>
	</div>
	</div>
  
	<!-- Sidebar Menu -->
	<nav class="mt-2">
	  	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			@if(Auth::user()->hasAccess('view borrower') || 
				Auth::user()->hasAccess('view statement of accounts') || 
				Auth::user()->hasAccess('view balance inquiry'))
			<li class="nav-item {{isset($nav) && isActive($nav[0], 'client information')? 'active menu-open' : ''}}">
				<a href="#" class="nav-link main-link">
				  <p>
					Client Information
					<i class="right fas fa-caret-right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
					@if(Auth::user()->hasAccess('view borrower'))
					<li class="nav-item pick {{isset($nav) && isActive($nav[1], 'personal information list')? 'active menu-open' : ''}}">
						<div class="flex navicon">
							<div class="top-line invis"></div>
							<div class="mid-circle"></div>
							<div class="bottom-line"></div>
						</div>
						<a href="{{route('client_information.personal_information_list')}}" class="nav-link flex">
						  <p>Personal Information</p>
						</a>
					  </li>
					  @endif
					  @if(Auth::user()->hasAccess('view statement of accounts'))
					  <li class="nav-item pick {{isset($nav) && isActive($nav[1], 'statement of accounts list')? 'active menu-open' : ''}}">
						  <div class="flex navicon">
							<div class="top-line"></div>
							<div class="mid-circle"></div>
							<div class="bottom-line"></div>
						</div>
						<a href="{{route('client_information.statement_of_accounts_list')}}" class="nav-link">

						  <p>Statement of Accounts</p>
						</a>
					  </li>
					  @endif
					  @if(Auth::user()->hasAccess('view balance inquiry'))
					  <li class="nav-item pick {{isset($nav) && isActive($nav[1], 'balance inquiry')? 'active menu-open' : ''}}">
						  <div class="flex navicon">
							<div class="top-line"></div>
							<div class="mid-circle"></div>
							<div class="bottom-line invis"></div>
						</div>
						<a href="{{route('client_information.balance_inquiry_list')}}" class="nav-link">

						  <p>Balance Inquiry</p>
						</a>
					  </li>
					  @endif
				</ul>
			</li>
			@endif

			@if(Auth::user()->hasAccess('view release entry') || 
				Auth::user()->hasAccess('view override release') || 
				Auth::user()->hasAccess('view rejected release') ||
				Auth::user()->hasAccess('view repayment entry') || 
				Auth::user()->hasAccess('view override payment'))
			<li class="nav-item {{isset($nav) && isActive($nav[0], 'transaction')? 'active menu-open' : ''}}">
				<a href="#" class="nav-link main-link">
				  <p>
					Transaction
					<i class="right fas fa-caret-right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
					@if(Auth::user()->hasAccess('view release entry'))
					<li class="nav-item pick {{isset($nav) && isActive($nav[1], 'release entry')? 'active menu-open' : ''}}">
						<div class="flex navicon">
								<div class="top-line invis"></div>
								<div class="mid-circle"></div>
								<div class="bottom-line"></div>
							</div>
						<a href="{{route('transaction.release_entry')}}" class="nav-link">
						<p>Release Entry</p>
						</a>
					</li>
					@endif
					@if(Auth::user()->hasAccess('view override release'))
					<li class="nav-item pick {{isset($nav) && isActive($nav[1], 'override release')? 'active menu-open' : ''}}">
						<div class="flex navicon">
								<div class="top-line"></div>
								<div class="mid-circle"></div>
								<div class="bottom-line"></div>
							</div>
						<a href="{{route('transaction.override_release')}}" class="nav-link">
						<p>Override Release</p>
						</a>
					</li>
					@endif
					@if(Auth::user()->hasAccess('view rejected release'))
					<li class="nav-item pick {{isset($nav) && isActive($nav[1], 'rejected release')? 'active menu-open' : ''}}">
						<div class="flex navicon">
								<div class="top-line"></div>
								<div class="mid-circle"></div>
								<div class="bottom-line"></div>
							</div>
						<a href="{{route('transaction.rejected_release')}}" class="nav-link">
						<p>Rejected Release</p>
						</a>
					</li>
					@endif
					@if(Auth::user()->hasAccess('view repayment entry'))
					<li class="nav-item pick {{isset($nav) && isActive($nav[1], 'repayment entry')? 'active menu-open' : ''}}">
						<div class="flex navicon">
								<div class="top-line"></div>
								<div class="mid-circle"></div>
								<div class="bottom-line"></div>
							</div>
						<a href="{{route('transaction.repayment_entry')}}" class="nav-link">
						<p>Repayment Entry</p>
						</a>
					</li>
					@endif
					@if(Auth::user()->hasAccess('view override payment'))
					<li class="nav-item pick {{isset($nav) && isActive($nav[1], 'override payment')? 'active menu-open' : ''}}">
						<div class="flex navicon">
								<div class="top-line"></div>
								<div class="mid-circle"></div>
								<div class="bottom-line invis"></div>
							</div>
						<a href="{{route('transaction.override_payment')}}" class="nav-link">
						<p>Override Payment</p>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif

			@if(Auth::user()->hasAccess('view cancelled payments') || 
				Auth::user()->hasAccess('view product setup') || 
				Auth::user()->hasAccess('view center') ||
				Auth::user()->hasAccess('view gl_setup') || 
				Auth::user()->hasAccess('view users') ||
				Auth::user()->hasAccess('view account retagging'))
			<li class="nav-item {{isset($nav) && isActive($nav[0], 'maintenance')? 'active menu-open' : ''}}">
				<a href="#" class="nav-link main-link">
				  <p>
					Maintenance
					<i class="right fas fa-caret-right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
					@if(Auth::user()->hasAccess('view cancelled payments'))
					<li class="nav-item pick {{isset($nav) && isActive($nav[1], 'cancel payments')? 'active' : ''}}">
						<div class="flex navicon">
							  <div class="top-line invis"></div>
							  <div class="mid-circle"></div>
							  <div class="bottom-line"></div>
						  </div>
					  <a href="{{route('maintenance.cancel_payments')}}" class="nav-link">
						<p>Cancel Payments</p>
					  </a>
					</li>
					@endif
					@if(Auth::user()->hasAccess('view product setup'))
					<li class="nav-item pick {{isset($nav) && isActive($nav[1], 'product setup')? 'active' : ''}}">
						<div class="flex navicon">
							  <div class="top-line"></div>
							  <div class="mid-circle"></div>
							  <div class="bottom-line"></div>
						</div>
					  <a href="{{route('maintenance.product_setup')}}" class="nav-link">
						<p>Product Setup</p>
					  </a>
					</li>
					@endif
					@if(Auth::user()->hasAccess('view center'))
					<li class="nav-item pick {{isset($nav) && isActive($nav[1], 'center ao')? 'active' : ''}}">
						<div class="flex navicon">
							  <div class="top-line"></div>
							  <div class="mid-circle"></div>
							  <div class="bottom-line"></div>
						  </div>
					  <a href="{{route('maintenance.center_ao')}}" class="nav-link">
						<p>Center - AO Setup</p>
					  </a>
					</li>
					@endif
					@if(Auth::user()->hasAccess('view users'))
					<li class="nav-item pick {{isset($nav) && isActive($nav[1], 'user settings')? 'active' : ''}}">
						<div class="flex navicon">
							  <div class="top-line"></div>
							  <div class="mid-circle"></div>
							  <div class="bottom-line"></div>
						  </div>
					  <a href="{{route('maintenance.user_settings')}}" class="nav-link">
						<p>User Settings</p>
					  </a>
					</li>
					@endif
					@if(Auth::user()->hasAccess('view gl setup'))
					<li class="nav-item pick {{isset($nav) && isActive($nav[1], 'gl setup')? 'active' : ''}}">
						<div class="flex navicon">
							  <div class="top-line"></div>
							  <div class="mid-circle"></div>
							  <div class="bottom-line"></div>
						  </div>
					  <a href="{{route('maintenance.gl_setup')}}" class="nav-link">
						<p>GL Setup</p>
					  </a>
					</li>
					@endif
					@if(Auth::user()->hasAccess('view account retagging'))
					<li class="nav-item pick {{isset($nav) && isActive($nav[1], 'account retagging')? 'active' : ''}}">
						<div class="flex navicon">
							  <div class="top-line"></div>
							  <div class="mid-circle"></div>
							  <div class="bottom-line"></div>
						  </div>
					  <a href="{{route('maintenance.account_retagging')}}" class="nav-link">
						<p>Account Re-Tagging</p>
					  </a>
					</li>
					@endif
					@if(Auth::user()->hasAccess('view deduction rate'))
					<li class="nav-item pick {{isset($nav) && isActive($nav[1], 'deduction rates')? 'active' : ''}}">
						<div class="flex navicon">
							  <div class="top-line"></div>
							  <div class="mid-circle"></div>
							  <div class="bottom-line invis"></div>
						  </div>
					  <a href="{{route('maintenance.deductions')}}" class="nav-link">
						<p>Deduction Rate</p>
					  </a>
					</li>
					@endif
				</ul>
			</li>
			@endif

			@if(1==0)
			<li class="nav-item">
				<a href="#" class="nav-link main-link">
				  <p>
					Master Setup
					<i class="right fas fa-caret-right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
				  <li class="nav-item pick">
					  <div class="flex navicon">
							<div class="top-line invis"></div>
							<div class="mid-circle"></div>
							<div class="bottom-line"></div>
						</div>
					<a href="#" class="nav-link">
					  <p>Payment Lookup</p>
					</a>
				  </li>
				  <li class="nav-item pick">
					  <div class="flex navicon">
							<div class="top-line"></div>
							<div class="mid-circle"></div>
							<div class="bottom-line"></div>
						</div>
					<a href="override_release.php" class="nav-link">
					  <p>Override Release</p>
					</a>
				  </li>
				  <li class="nav-item pick">
					  <div class="flex navicon">
							<div class="top-line"></div>
							<div class="mid-circle"></div>
							<div class="bottom-line"></div>
						</div>
					<a href="rejected_release.php" class="nav-link">
					  <p>Rejected Release</p>
					</a>
				  </li>
				  <li class="nav-item pick">
					  <div class="flex navicon">
							<div class="top-line"></div>
							<div class="mid-circle"></div>
							<div class="bottom-line"></div>
						</div>
					<a href="repayment_entry.php" class="nav-link">
					  <p>Repayment Entry</p>
					</a>
				  </li>
				  <li class="nav-item pick">
					  <div class="flex navicon">
							<div class="top-line"></div>
							<div class="mid-circle"></div>
							<div class="bottom-line invis"></div>
						</div>
					<a href="override_payment.php" class="nav-link">
					  <p>Override Payment</p>
					</a>
				  </li>
				</ul>
			</li>
			@endif

			<li class="nav-item pick {{isset($nav) && isActive($nav[0], 'reports')? 'active menu-open' : ''}}">
				<a href="{{route('reports.transaction')}}" class="nav-link main-link">
				  <p>
					Reports
					<i class="right fas fa-caret-right"></i>
				  </p>
				</a>
			</li>
			@if(Auth::user()->hasAccess('set beginning/end of day'))
			<li class="nav-item pick {{isset($nav) && isActive($nav[0], 'end of day')? 'active menu-open' : ''}}">
				<a href="{{route('endofday')}}" class="nav-link main-link">
				  <p>
					End of Day
				  </p>
				</a>
			</li>
			@endif
		</ul>
		<div class="d-flex flex-column align-items-center justify-content-center mt-120">
			<img src="<?=url('/img/logo-side.png');?>" alt="">
		</div>
	</nav>
	<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>