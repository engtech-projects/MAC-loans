import Vue from 'vue';
Vue.mixin({
	methods: {
		toUpperFirst(str) {
			return str.charAt(0).toUpperCase() + str.slice(1);
		}    
	}
})
