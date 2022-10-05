function loadDoc() {
	setInterval(function(){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var view = this.responseText.replaceAll('"', '');
				document.getElementById("notify").innerHTML = view;
			}
		};
		xhttp.open("GET", "data_response.php", true);
		xhttp.send();
	}, 1000);
	setInterval(function(){
		var xhttps = new XMLHttpRequest();
		xhttps.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("data_notify").innerHTML = this.responseText;
			}
		};
		xhttps.open("GET", "data_notify.php", true);
		xhttps.send();
	}, 1000);
}
document.onreadystatechange = function () {
	if (document.readyState === 'interactive' || document.readyState === 'loading') {
		document.getElementById("notify").innerHTML = '';
		document.getElementById("data_notify").innerHTML = '<div class="dropdown-divider"></div><img src="http://vawvetclinic.info/dist/img/loading-buffering.gif" class="mx-auto d-block h-25 w-25 p-4">';
	}else if (document.readyState === 'complete') {
		loadDoc();
	}
}
