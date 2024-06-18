const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

function showTime(){
    var date = new Date(document.getElementById("currentTransactionDate").value);
	var timeDate = new Date;
    var h = timeDate.getHours(); // 0 - 23
    var m = timeDate.getMinutes(); // 0 - 59
    var s = timeDate.getSeconds(); // 0 - 59
	var M = months[date.getMonth()];
	var D = days[date.getDay()]; 
	var d = date.getDate();
	var y = date.getFullYear();
    var session = "AM";
    
    if(h == 0){
        h = 12;
    }
    
    if(h > 12){
        h = h - 12;
        session = "PM";
    }
    
    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;
    
    var time = h + ":" + m + ":" + s + " " + session;
	var calendar = D + ', ' + M + ' ' + d + ', ' + y;
    document.getElementById("MyClockDisplay").innerText = time;
    document.getElementById("MyClockDisplay").textContent = time;
	document.getElementById("MyDateDisplay").innerText = calendar;
    document.getElementById("MyDateDisplay").textContent = calendar;
    
    setTimeout(showTime, 1000);
    
}

showTime();