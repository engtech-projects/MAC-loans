/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 
require('./bootstrap');
import { template } from 'lodash';
 import Notifications from 'vue-notification'

 window.Vue = require('vue').default;
 Vue.use(Notifications)
 
 Vue.component('login', require('./components/Login.vue').default);
 Vue.component('client-list', require('./ui/client_information/ClientList.vue').default);
 Vue.component('personal-information', require('./ui/client_information/PersonalInformation.vue').default);
 Vue.component('branch', require('./components/Branch.vue').default);
 
 Vue.component('cancel-payments', require('./ui/maintenance/CancelPayments.vue').default);
 Vue.component('product-setup', require('./ui/maintenance/ProductSetup.vue').default);
 Vue.component('center-ao', require('./ui/maintenance/CenterAccount.vue').default);
 Vue.component('user-settings', require('./ui/maintenance/UserSettings.vue').default);
 Vue.component('gl-setup', require('./ui/maintenance/GlSetup.vue').default);
 Vue.component('account-retagging', require('./ui/maintenance/AccountRetagging.vue').default);
 
 const app = new Vue({
	 el: '#app',
 });
 