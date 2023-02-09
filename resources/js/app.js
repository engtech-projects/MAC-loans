/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 
require('./bootstrap');
import { template } from 'lodash';
import Notifications from 'vue-notification'
import Vue from 'vue';
import helper from './mixins/helper';

window.Vue = require('vue').default;
Vue.use(Notifications);

Vue.component('current-transactiondate', require('./components/TransactionDate.vue').default);
Vue.component('login', require('./components/Login.vue').default);
Vue.component('borrower-login', require('./components/BorrowerLogin.vue').default);
Vue.component('branch', require('./components/Branch.vue').default);
Vue.component('client-list-side', require('./components/ClientListSide.vue').default);
Vue.component('upload-file', require('./components/UploadFile.vue').default);
Vue.component('print-docs', require('./components/DocumentsComponent.vue').default);
Vue.component('borrower-container', require('./components/BorrowerContainer.vue').default);
Vue.component('overridepayment-view', require('./components/OverridePaymentView.vue').default);
Vue.component('warning-modal', require('./components/WarningModal.vue').default);
Vue.component('account-details', require('./components/AccountDetails.vue').default);
Vue.component('branch-nav', require('./components/BranchNav.vue').default);
Vue.component('reports-nav', require('./components/ReportsNav.vue').default);
Vue.component('day-ended', require('./components/DayEnded.vue').default);
Vue.component('mac-pagination', require('./components/Pagination.vue').default);
Vue.component('client-list', require('./ui/client_information/ClientList.vue').default);
Vue.component('personal-information', require('./ui/client_information/PersonalInformation.vue').default);
Vue.component('balance-inquiry', require('./ui/client_information/BalanceInquiry.vue').default);
Vue.component('cancel-payments', require('./ui/maintenance/CancelPayments.vue').default);
Vue.component('product-setup', require('./ui/maintenance/ProductSetup.vue').default);
Vue.component('deduction-rate', require('./ui/maintenance/DeductionRate.vue').default);
Vue.component('center-ao', require('./ui/maintenance/CenterAccount.vue').default);
Vue.component('user-settings', require('./ui/maintenance/UserSettings.vue').default);
Vue.component('gl-setup', require('./ui/maintenance/GlSetup.vue').default);
Vue.component('account-retagging', require('./ui/maintenance/AccountRetagging.vue').default);
Vue.component('release-entry', require('./ui/transaction/release_entry/ReleaseEntry.vue').default);
Vue.component('borrowers-info', require('./ui/transaction/release_entry/BorrowersInfo.vue').default);
Vue.component('rejected-borrowers-info', require('./ui/transaction/rejected_release/BorrowersInfo.vue').default);
Vue.component('co-borrower', require('./ui/transaction/release_entry/BorrowerCo.vue').default);
Vue.component('rejected-co-borrower', require('./ui/transaction/rejected_release/BorrowerCo.vue').default);
Vue.component('override-release', require('./ui/transaction/override_release/OverrideRelease.vue').default);
Vue.component('override-release-details', require('./ui/transaction/override_release/OverrideReleaseDetails.vue').default);
Vue.component('loan-details', require('./ui/transaction/release_entry/LoanDetails.vue').default);
Vue.component('rejected-loan-details', require('./ui/transaction/rejected_release/LoanDetails.vue').default);
Vue.component('rejected-release', require('./ui/transaction/rejected_release/RejectedRelease.vue').default);
Vue.component('rejected-release-edit', require('./ui/transaction/rejected_release/RejectedReleaseEdit.vue').default);
Vue.component('repayment-entry', require('./ui/transaction/repayment_entry/RepaymentEntry.vue').default);
Vue.component('statement-details', require('./ui/client_information/StatementDetails.vue').default);
Vue.component('borrower-statement-details', require('./ui/client_portal_information/StatementDetails.vue').default);

Vue.component('repayment-details', require('./ui/transaction/repayment_entry/RepaymentDetails.vue').default);
Vue.component('override-payment', require('./ui/transaction/override_payment/OverridePayment.vue').default);
Vue.component('overridepayment-details', require('./ui/transaction/override_payment/LoanDetails.vue').default);

Vue.component('reports-transaction', require('./ui/reports/Transaction.vue').default);
Vue.component('reports-release-summary', require('./ui/reports/release/Summary.vue').default);
Vue.component('reports-release-product', require('./ui/reports/release/Product.vue').default);
Vue.component('reports-release-client', require('./ui/reports/release/Client.vue').default);
Vue.component('reports-release-ao', require('./ui/reports/release/Ao.vue').default);
Vue.component('reports-release-insurance', require('./ui/reports/release/Insurance.vue').default);
Vue.component('reports-repayment-product', require('./ui/reports/repayment/Product.vue').default);
Vue.component('reports-repayment-client', require('./ui/reports/repayment/Client.vue').default);
Vue.component('reports-repayment-cancelled', require('./ui/reports/repayment/Cancelled.vue').default);
Vue.component('reports-collection-product', require('./ui/reports/collection/Product.vue').default);
Vue.component('reports-collection-client', require('./ui/reports/collection/Client.vue').default);
Vue.component('reports-collection-ao', require('./ui/reports/collection/Ao.vue').default);
Vue.component('reports-branch-collection', require('./ui/reports/branch/CollectionReport.vue').default);
Vue.component('reports-branch-maturity', require('./ui/reports/branch/MaturityReport.vue').default);
Vue.component('reports-branch-paymentstatus', require('./ui/reports/branch/ClientPaymentStatus.vue').default);
Vue.component('reports-branch-accountofficer', require('./ui/reports/branch/AccountOfficer.vue').default);
Vue.component('reports-branch-loanlisting', require('./ui/reports/branch/LoanListing.vue').default);
Vue.component('reports-branch-loanstatussummary', require('./ui/reports/branch/LoanStatusSummary.vue').default);
Vue.component('reports-branch-loanagingsummary', require('./ui/reports/branch/LoanAgingSummary.vue').default);
Vue.component('reports-branch-revenuereport', require('./ui/reports/branch/RevenueReport.vue').default);

Vue.component('reports-consolidated-loansummary', require('./ui/reports/consolidated/LoanSummaryReport.vue').default);
Vue.component('reports-consolidated-loanaging', require('./ui/reports/consolidated/LoanAgingReportConsolidated.vue').default);
Vue.component('reports-consolidated-loanperformance', require('./ui/reports/consolidated/LoanPerformanceReport.vue').default);
Vue.component('reports-consolidated-generatedst', require('./ui/reports/consolidated/GenerateDst.vue').default);

Vue.component('reports-micromonitoring', require('./ui/reports/MicroMonitoring.vue').default);
Vue.component('reports-prepaidinterest', require('./ui/reports/PrepaidInterest.vue').default);
Vue.component('reports-performancereport', require('./ui/reports/PerformanceReport.vue').default);
Vue.component('reports-bir', require('./ui/reports/BirReport.vue').default);

Vue.component('endof-day', require('./ui/endofday/Endofday.vue').default);

Vue.component('borrower-balance-inquiry', require('./ui/client_portal_information/BalanceInquiry.vue').default);
Vue.component('borrower-personal-information', require('./ui/client_portal_information/PersonalInformation.vue').default);

Vue.config.devtools = true;
const app = new Vue({
	el: '#app',
	mixin:[helper],
});

