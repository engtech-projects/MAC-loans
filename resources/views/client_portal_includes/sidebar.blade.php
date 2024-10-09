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
		  <span class="bot">Client</span>
	  </div>
	</div>
	</div>
  
	<!-- Sidebar Menu -->
	<nav class="mt-2">
	  	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			<li class="nav-item {{isset($nav) && isActive($nav[0], 'client information')? 'active menu-open' : ''}}">
				<a href="#" class="nav-link main-link">
				  <p>
					Client Information
					<i class="right fas fa-caret-right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item pick {{isset($nav) && isActive($nav[1], 'personal information list')? 'active menu-open' : ''}}">
						<div class="flex navicon">
							<div class="top-line invis"></div>
							<div class="mid-circle"></div>
							<div class="bottom-line"></div>
						</div>
						<a href="{{route('borrower.personal_information')}}" class="nav-link flex">
						  <p>Personal Information</p>
						</a>
					  </li>
					  <li class="nav-item pick {{isset($nav) && isActive($nav[1], 'statement of accounts list')? 'active menu-open' : ''}}">
						  <div class="flex navicon">
							<div class="top-line"></div>
							<div class="mid-circle"></div>
							<div class="bottom-line"></div>
						</div>
						<a href="{{route('borrower.account_statement')}}" class="nav-link">

						  <p>Statement of Accounts</p>
						</a>
					  </li>
					  <li class="nav-item pick {{isset($nav) && isActive($nav[1], 'balance inquiry')? 'active menu-open' : ''}}">
						  <div class="flex navicon">
							<div class="top-line"></div>
							<div class="mid-circle"></div>
							<div class="bottom-line invis"></div>
						</div>
						<a href="{{route('borrower.balance_inquiry')}}" class="nav-link">

						  <p>Balance Inquiry</p>
						</a>
					  </li>
				</ul>
			</li>
		</ul>
		<div class="d-flex flex-column align-items-center justify-content-center mt-120">
			<img src="<?=url('/img/logo-side.png');?>" alt="">
		</div>
	</nav>
	<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>