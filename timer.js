var dis = document.getElementById("exceed");
var finishTime;
var timerLength = 60;
var timeoutID;
dis.innerHTML = "Time Left: " + timerLength;

if(localStorage.getItem('myTime')){
	Update();
}

function startTimer(){
	$('#exceed').attr('hidden', 'hidden');
	localStorage.setItem('myTime', ((new Date()).getTime() + timerLength * 1000));
	if (timeoutID != undefined) window.clearTimeout(timeoutID);
	Update();
}

function Update() {
	finishTime = localStorage.getItem('myTime');
	var timeLeft = (finishTime - new Date());
	if(timeLeft > 0){
		$('#exceed').removeAttr('hidden', 'hidden');
		$('#exceed1').removeAttr('hidden', 'hidden');
		$('#admin-email').attr('disabled', 'disabled');
		$('#admin-password').attr('disabled', 'disabled');
		$('#admin-login').attr('disabled', 'disabled');
		document.getElementById("admin-email").value = "";
		document.getElementById("admin-password").value = "";
		dis.innerHTML = "Login limit exceed, Wait " + + Math.floor(timeLeft/1000,0) + " seconds to login.";
	}else {
		$('#exceed').attr('hidden', 'hidden');
		$('#exceed1').attr('hidden', 'hidden');
		$('#admin-email').removeAttr('disabled', 'disabled');
		$('#admin-password').removeAttr('disabled', 'disabled');
		$('#admin-login').removeAttr('disabled', 'disabled');	
		$('#client-email').removeAttr('disabled', 'disabled');
		$('#client-password').removeAttr('disabled', 'disabled');
		$('#index-login').removeAttr('disabled', 'disabled');			
	}
	timeoutID = window.setTimeout(Update, 100);
}