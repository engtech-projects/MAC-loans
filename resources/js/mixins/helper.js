import Vue from 'vue';

Vue.mixin({
	methods: {
		dateToYMD:function(date) {
			var d = date.getDate();
			var m = date.getMonth() + 1;
			var y = date.getFullYear();
			return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
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
			return parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
		}, 
		numToWords:function(numberInput){
			let oneToTwenty = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ',
			'eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
			let tenth = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];
		
			if(numberInput.toString().length > 7) return 'overlimit' ;
			console.log(numberInput);
			//let num = ('0000000000'+ numberInput).slice(-10).match(/^(\d{1})(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
		  let num = ('0000000'+ numberInput).slice(-7).match(/^(\d{1})(\d{1})(\d{2})(\d{1})(\d{2})$/);
			console.log(num);
			if(!num) return;
		
			let outputText = num[1] != 0 ? (oneToTwenty[Number(num[1])] || `${tenth[num[1][0]]} ${oneToTwenty[num[1][1]]}` )+' million ' : ''; 
		  
			outputText +=num[2] != 0 ? (oneToTwenty[Number(num[2])] || `${tenth[num[2][0]]} ${oneToTwenty[num[2][1]]}` )+'hundred ' : ''; 
			outputText +=num[3] != 0 ? (oneToTwenty[Number(num[3])] || `${tenth[num[3][0]]} ${oneToTwenty[num[3][1]]}`)+' thousand ' : ''; 
			outputText +=num[4] != 0 ? (oneToTwenty[Number(num[4])] || `${tenth[num[4][0]]} ${oneToTwenty[num[4][1]]}`) +'hundred ': ''; 
			outputText +=num[5] != 0 ? (oneToTwenty[Number(num[5])] || `${tenth[num[5][0]]} ${oneToTwenty[num[5][1]]} `) : ''; 
		
			return outputText;
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
		}
	}
})
