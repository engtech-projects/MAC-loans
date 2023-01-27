import Vue from 'vue';

Vue.mixin({
	methods: {
		concatW:function(str){
			if(str.length > 15){
				return str.substring(0,15) + '...';
			}
			return str;
		},
		dateToYMD:function(date) {
			var d = date.getDate();
			var m = date.getMonth() + 1;
			var y = date.getFullYear();
			return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
		},
		dateToYM:function(date) {
			var m = date.getMonth() + 1;
			var y = date.getFullYear();
			return '' + y + '-' + (m<=9 ? '0' + m : m);
		},
		dateToMDY2:function(date){
			var d = date.getDate();
			var m = date.getMonth() + 1;
			var y = date.getFullYear();
			return (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d) + '-' + y;
		},
		dateToMDY:function(date){
			var m = this.dateToFullMonth(date);
			var d = date.getDate();
			var y = date.getFullYear();
			return m + ' ' + d + ', ' + y;
		},
		dateToD:function(date){
			var d = date.getDate();
			return d;
		},
		dateToM:function(date){
			var m = date.getMonth() + 1;
		},
		dateToY:function(date){
			return date.getFullYear();
		},
		dateToFullMonth:function(date){
			const monthNames = ["January", "February", "March", "April", "May", "June",
								"July", "August", "September", "October", "November", "December"
								];
			return monthNames[date.getMonth()];
		},
		dateToHalfMonth:function(date){
			const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
								"Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
								];
			return monthNames[date.getMonth()];
		},
		todayTime:function(date){
			var hour = date.getHours() > 12? (date.getHours() - 12) : date.getHours();
			return hour + ':' + date.getMinutes();
		},
		amPm:function(date){
			return date.getHours() > 12? 'PM' : 'AM';
		},
		dateFullDay:function(date){
			const weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
			return weekday[date.getDay()];
		},
		dateDay:function(date){
			return date.getDay();
		},
		capitalizeFirstLetter(str) {
			return str.charAt(0).toUpperCase() + str.slice(1);
		},
		calculateAge:function(dateString) {
			var today = new Date();
			var birthDate = new Date(dateString);
			var age = today.getFullYear() - birthDate.getFullYear();
			var m = today.getMonth() - birthDate.getMonth();
			if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
				age--;
			}
			return age;
		},
		formatToCurrency:function(amount) {
			return amount? parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,"):'0.00';
		},
		formatToAmount:function(currency){
			return parseFloat(currency.toString().split(',').join(''));
		},
		sentenceCase(value){
			return value?value.replace(/(?:^|\s|-)\S/g, x => x.toUpperCase()):'';
		},
		numToWords:function(s){
			s = s + '';
			var th = ['','thousand','million', 'billion','trillion'];
			var dg = ['zero','one','two','three','four', 'five','six','seven','eight','nine'];
			var tn = ['ten','eleven','twelve','thirteen', 'fourteen','fifteen','sixteen', 'seventeen','eighteen','nineteen'];
			var tw = ['twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];
			s = s.toString();
			s = s.replace(/[\, ]/g,'');
			if (s != parseFloat(s)) return 'not a number';
			var x = s.indexOf('.');
			if (x == -1)
				x = s.length;
			if (x > 15)
				return 'too big';
			var n = s.split(''); 
			var str = '';
			var sk = 0;
			for (var i=0;   i < x;  i++) {
				if ((x-i)%3==2) { 
					if (n[i] == '1') {
						str += tn[Number(n[i+1])] + ' ';
						i++;
						sk=1;
					} else if (n[i]!=0) {
						str += tw[n[i]-2] + ' ';
						sk=1;
					}
				} else if (n[i]!=0) { // 0235
					str += dg[n[i]] +' ';
					if ((x-i)%3==0) str += 'hundred ';
					sk=1;
				}
				if ((x-i)%3==1) {
					if (sk)
						str += th[(x-i-1)/3] + ' ';
					sk=0;
				}
			}
			
			if (x != s.length) {
				var y = s.length;
				str += 'point ';
				for (var i=x+1; i<y; i++)
					str += dg[n[i]] +' ';
			}
			return this.upperFirst(str.replace(/\s+/g,' '))
		},
		upperFirst:function(string) {
			return string.charAt(0).toUpperCase() + string.slice(1);
		},
		nthDay:function(d){
			if (d > 3 && d < 21) return d + 'th';
			switch (d % 10) {
				case 1:  return d + "st";
				case 2:  return d + "nd";
				case 3:  return d + "rd";
				default: return d + "th";
			}
		},
		fullName:function(f,m,l){
			return m? f+' '+m.charAt(0)+'. '+l:f+' ' +l;
		},
		fullNameReverse:function(f,m,l){
			return m? l+', '+f+' '+m.charAt(0) + '.':f+' ' +l;
		},
		isActive:function(a,b){
			return a==b?'active':'';
		},
		replaceAll:function(str, find, replace) {
			return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
		},
		baseURL:function(){
			var href = document.getElementById('baseUrl').href;
			return href.slice(-1)=='/'?href:href+'/';
		},
		extractFileName:function(str){
			return str.split('\\').pop().split('/').pop();
		},
		hasAccess:function(list, access){
			var hasAccess = false;
			list.forEach(a => {
				if(a.access_id == access){
					hasAccess = true;
				}
			})
			return hasAccess;
		},
		checkVal:function(val){
			return val?val:0;
		},
		isEmptyObj(object) { 
			for(var i in object) { 
				return false; 
			} 
			return true; 
		},
		currentTransactionDate:function(){
			var date = 'no date';
			setTimeout(()=>{
				date = document.getElementById('currentTransactionDate');
				return date
			},10000);
			// return date;
		}
	}
})