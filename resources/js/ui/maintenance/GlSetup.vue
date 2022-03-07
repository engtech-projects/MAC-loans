<template>
	<div>
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">General Ledger Setup</h1>
		</div><!-- /.col -->
		<div class="d-flex ml-16">
			<div class="flex-1 mr-24">
				<span class="text-20 py-7 mid-light-bb text-block text-primary-dark text-bold mb-12">Inputs</span>
				<div class="light-border p-16">
					<div class="form-group mb-10">
						<label for="loansPortal" class="form-label">Loan's Portal</label>
						<input type="text" class="form-control form-input " id="loansPortal">
					</div>
					<div class="form-group mb-10">
						<label for="code" class="form-label">Code</label>
						<input type="text" class="form-control form-input " id="code">
					</div>
					<div class="form-group mb-10">
						<label for="accountingPortal" class="form-label">Accounting Portal</label>
						<input type="text" class="form-control form-input " id="accountingPortal">
					</div>
					<div class="form-group mb-16">
						<label for="account" class="form-label">Account</label>
						<div class="d-flex align-items-start">
							<div class="d-flex flex-column flex-1 mr-1">
								<select name="" id="" class="form-control form-input mb-12">
									<option value="Releasing">Releasing</option>
								</select>
							</div>
							<a href="#" class="btn btn-primary-dark" style="line-height:2;"><i class="fa fa-plus"></i></a>
						</div>
					</div>
					<div class="d-flex justify-content-end mb-36">
						<a href="#" class="btn btn-lg btn-success min-w-150">Save</a>
					</div>
				</div>
			</div>
			<div class="flex-2">
				<span class="text-20 py-7 mid-light-bb text-block text-primary-dark text-bold mb-12">Access</span>
				<div class="p-12 light-border">
					<table class="table table-stripped th-blue th-nbt">
						<thead>
							<th>Loan's Portal</th>
							<th>Code</th>
							<th>Accounting Portal</th>
							<th>Account</th>
						</thead>
						<tbody>
							<tr>
								<td>Loan Receivable</td>
								<td>1205</td>
								<td>Loan's Receivable - Current</td>
								<td>Releasing Account</td>
							</tr>
							<tr>
								<td>Loan Receivable</td>
								<td>1205</td>
								<td>Loan's Receivable - Current</td>
								<td>Releasing Account</td>
							</tr>
							<tr>
								<td>Loan Receivable</td>
								<td>1205</td>
								<td>Loan's Receivable - Current</td>
								<td>Releasing Account</td>
							</tr>
							<tr>
								<td>Loan Receivable</td>
								<td>1205</td>
								<td>Loan's Receivable - Current</td>
								<td>Releasing Account</td>
							</tr>
							<tr>
								<td>Loan Receivable</td>
								<td>1205</td>
								<td>Loan's Receivable - Current</td>
								<td>Releasing Account</td>
							</tr>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>
</template>