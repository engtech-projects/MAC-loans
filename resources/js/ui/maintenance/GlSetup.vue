<template>
	<div>
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">General Ledger Setup</h1>
		</div><!-- /.col -->
		<div class="d-flex ml-16">
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

<script>
export default {
    props: ["token"],
    data() {
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            ledgerAccounts: [],
            newAccount: "",
            accounts: [],
            accountErr: "",
            inputs: {
                loans: "",
                code: "",
                accounting: "",
                type: "",
                gl_id: null,
            },
        };
    },
    methods: {
        fetchLedgerAccounts: function () {
            axios
                .get(this.baseURL() + "api/gl", {
                    headers: {
                        Authorization: "Bearer " + this.token,
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                })
                .then(
                    function (response) {
                        this.ledgerAccounts = response.data.data;
                        this.accounts = this.setAccounts();
                    }.bind(this)
                )
                .catch(
                    function (error) {
                        console.log(error);
                    }.bind(this)
                );
        },
    },
    mounted() {
        this.fetchLedgerAccounts();
    },
};
</script>
