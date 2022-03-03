<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
<!-- Brand Logo -->
<a href="#" class="brand-link center-text">     
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
		  <span class="mid">Jeremae G. Payot</span>
		  <span class="bot">Loan Clerk</span>
	  </div>
	</div>
	</div>
  
	<!-- Sidebar Menu -->
	<nav class="mt-2">
	  	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			<li class="nav-item">
				<a href="#" class="nav-link main-link">
				  <p>
					Client Information
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
						<a href="client_list.php" class="nav-link flex">
						  <p>Personal Information</p>
						</a>
					  </li>
					  <li class="nav-item pick">
						  <div class="flex navicon">
							<div class="top-line"></div>
							<div class="mid-circle"></div>
							<div class="bottom-line"></div>
						</div>
						<a href="statement_of_accounts_list.php" class="nav-link">

						  <p>Statement of Accounts</p>
						</a>
					  </li>
					  <li class="nav-item pick">
						  <div class="flex navicon">
							<div class="top-line"></div>
							<div class="mid-circle"></div>
							<div class="bottom-line invis"></div>
						</div>
						<a href="balance_inquiry_list.php" class="nav-link">

						  <p>Balance Inquiry</p>
						</a>
					  </li>
				</ul>
			</li>

			<li class="nav-item">
				<a href="#" class="nav-link main-link">
				  <p>
					Transaction
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
					<a href="release_entry_borrower_info.php" class="nav-link">
					  <p>Release Entry</p>
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
			<li class="nav-item {{isset($nav) && isActive($nav[0], 'maintenance')? 'active menu-open' : ''}}">
				<a href="#" class="nav-link main-link">
				  <p>
					Maintenance
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
					  <a href="cancel_payment.php" class="nav-link">
						<p>Cancel Payments</p>
					  </a>
					</li>
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
					<li class="nav-item pick">
						<div class="flex navicon">
							  <div class="top-line"></div>
							  <div class="mid-circle"></div>
							  <div class="bottom-line"></div>
						  </div>
					  <a href="center_group_setup.php" class="nav-link">
						<p>Center - Group Setup</p>
					  </a>
					</li>
					<li class="nav-item pick">
						<div class="flex navicon">
							  <div class="top-line"></div>
							  <div class="mid-circle"></div>
							  <div class="bottom-line"></div>
						  </div>
					  <a href="user_settings.php" class="nav-link">
						<p>User Settings</p>
					  </a>
					</li>
					<li class="nav-item pick">
						<div class="flex navicon">
							  <div class="top-line"></div>
							  <div class="mid-circle"></div>
							  <div class="bottom-line"></div>
						  </div>
					  <a href="gl_setup.php" class="nav-link">
						<p>GL Setup</p>
					  </a>
					</li>
					<li class="nav-item pick">
						<div class="flex navicon">
							  <div class="top-line"></div>
							  <div class="mid-circle"></div>
							  <div class="bottom-line invis"></div>
						  </div>
					  <a href="account_retagging.php" class="nav-link">
						<p>Account Re-Tagging</p>
					  </a>
					</li>
				</ul>
			</li>

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

			<li class="nav-item">
				<a href="reports_transaction_product.php" class="nav-link main-link">
				  <p>
					Reports
					<i class="right fas fa-caret-right"></i>
				  </p>
				</a>
			</li>

			<li class="nav-item">
				<a href="#" class="nav-link main-link">
				  <p>
					End of Day
					<i class="right fas fa-caret-right"></i>
				  </p>
				</a>
				
			</li>
		</ul>
	</nav>
	<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>