
function getTime() {
	var d = new Date();
    postMessage(d);
	setTimeout("getTime()", 900);
}

getTime();
