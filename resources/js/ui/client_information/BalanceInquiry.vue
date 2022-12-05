<template>
    <div class="px-16">
        <div class="container-fluid">
            <div class="mb-16"></div>
            <div
                class="d-flex justify-content-between align-items-center mb-24 bb-primary-dark pb-7 text-block"
            >
                <h1 class="m-0 font-35">Statement of Account Details</h1>
                <a
                    :href="baseURL() + 'client_information/balance_inquiry_list'"
                    class="btn btn-primary-dark float-right"
                    style="padding: 7px 50px !important; font-size: 14px"
                    >Back</a
                >
            </div>
            <!-- /.col -->
            <section class="content">
                <div class="container-fluid" style="padding: 0 !important">
                    <div class="flex mb-24">
                        <div class="upload-photo">
                            <img
                                :src="borrowerPhoto"
                                style="
                                    border: 1px solid #ccc;
                                    margin-right: 16px;
									max-width:240px;
                                "
                                alt=""
                            />
                        </div>
                        <div class="flex-col">
                            <div class="customer-number mb-5">
                                <span>Customer Number</span>
                                <span>{{borrower.borrower_num}}</span>
                            </div>
                            <div class="info-display">
                                <span style="color: #2f4b67">Client Name</span>
                                <span>{{fullName(borrower.firstname, borrower.middlename, borrower.lastname)}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-display title mb-12">
                        <span>Accounts</span>
                    </div>
                    <account-details v-for="acc in unpaidLoanAccounts" :key="acc.loan_account_id" :loanDetails="acc" :showSchedule="true" class="card mb-12"></account-details>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
export default {
	props:['pborrower','token'],
	data(){
		return {
			borrower: {
				borrower_id: null,
				date_registered:'',
				borrower_num:'',
				firstname:'',
				lastname:'',
				middlename:'',
				suffix :'' ,
				address :'' ,
				birthdate :'',
				gender :'' ,
				status :'' ,
				photo: null,
				contact_number :'',
				id_type :'',
				id_no :'',
				id_date_issued :'',
				spouse_firstname:'',
				spouse_lastname:'',
				spouse_middlename:'',
				spouse_address :'',
				spouse_birthdate :'',
				spouse_id_type :'',
				spouse_id_no :'',
				spouse_id_date_issued :'',
				employmentInfo : [],
				businessInfo : [],
				householdMembers : [],
				outstandingObligations : [],
                loanAccounts:[],
                loan_accounts:[],
				created_at: '',
			}
		}
	},
	methods:{
		async fetchBorrower(){
			await axios.get(this.baseURL() + 'api/borrower/' + this.pborrower, {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'contentType': "multipart/form-data"
					}
				})
				.then(function (response) {
					this.borrower = response.data.data;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
		}
	},
	computed:{
		borrowerPhoto:function(){
			return this.borrower.photo? this.borrower.photo : this.baseURL()+'img/user.png';
		},
        unpaidLoanAccounts:function(){
            let data = [];
            this.borrower.loan_accounts.map(function(acc){
                if(acc.remainingBalance.memo.balance > 0){
                    data.push(acc);
                }
            }.bind(this));
            return data;
        }
	},
	mounted(){
		// this.borrower = JSON.parse(this.pborrower);
		this.fetchBorrower();
	}
}
</script>
