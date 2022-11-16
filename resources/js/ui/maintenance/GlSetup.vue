<template>
	<div class="container-fluid" style="padding:0!important">
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">General Ledger Setup</h1>
		</div><!-- /.col -->
		<div class="d-flex flex-column flex-xl-row ml-16">
			<div style="flex:20">
				<section class="mb-24" style="flex:21;padding-left:16px;">
					<span class="section-title section-subtitle mb-12">List</span>
					<div class="p-16 light-border">
						<table class="table table-stripped th-nbt table-hover">
							<thead>
								<th>Loan's Portal</th>
								<th>Code</th>
								<th>Accounting Portal</th>
								<th>Account</th>
								<th></th>
							</thead>
							<tbody>
								<tr v-if="!ledgerAccounts.length">
									<td>No products found.</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr v-for="la in ledgerAccounts" :key="la.gl_id">
									<td>{{sentenceCase(la.loans)}}</td>
									<td>{{la.code}}</td>
									<td>{{sentenceCase(la.accounting)}}</td>
									<td>{{sentenceCase(la.type)}}</td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
				</section>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
		props:['token'],
		data(){
			return {
				csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
				ledgerAccounts:[],
			}
		},
		methods: {
			fetchLedgerAccounts: function(){
				axios.get(this.baseURL() + 'api/gl', {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.ledgerAccounts = response.data.data;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},
		},
        mounted() {
           	this.fetchLedgerAccounts();
        }
    }
</script>