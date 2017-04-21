<html>

<head>
<script>
function drawCanvas(){
	var c = document.getElementById("myCanvas");
	var ctx = c.getContext("2d");

	// Create gradient
	var grd = ctx.createRadialGradient(75,50,5,90,60,100);
	grd.addColorStop(0,"red");
	grd.addColorStop(1,"white");

	// Fill with gradient
	ctx.fillStyle = grd;
	ctx.fillRect(10,10,150,80);
}

//for the time of day web worker
var w = new Worker("time_worker.js");
w.onmessage = function(event) {
	document.getElementById("time").innerHTML = event.data;
};


</script>
</head>

<body>
<h1>HTML5 Demo Objects</h1><br/>

<h3>Embedded Video</h3>
<iframe width="560" height="315" src="https://www.youtube.com/embed/Tpq0n3Pk5ts" frameborder="0" allowfullscreen></iframe>

<h3>Embedded Audio</h3>
<audio controls>
  <source src="song.mp3" type="audio/mpeg">
Your browser does not support the audio element.
</audio>


<h3>A Canvas Item</h3>
<canvas id="myCanvas" width="200" height="100" style="border:1px solid #000000;">
</canvas>
<script>drawCanvas()</script>

<h3>A Required Field Item</h3>
<form action="">
  Required Field: <input type="text" required>
  <input type="submit">
</form>

<h3>Editable Content</h3>
<div id="example-one" contenteditable="true">
<style scoped>
  #example-one { margin-bottom: 10px; }
  [contenteditable="true"] { padding: 10px; outline: 2px dashed #CCC; }
  [contenteditable="true"]:hover { outline: 2px dashed #0090D2; }
</style>
<p>Everything contained within this div is editable in browsers that support <code>HTML5</code>. Go on, give it a try: click it and start typing.</p>
</div>

<h3>Live time of day</h3>
<div id="time">
</div>

<h3>Basic Form</h3>
<div id="basicForm">
	<form action="">
		First name:<br>
		<input type="text" name="firstname" id="FName" >
		<br>
		Last name:<br>
		<input type="text" name="lastname" id="LName">
		<br><br>
		<button onclick="store()" type="button">Submit</button>
	</form> 
</div>

<script  type="text/javascript">
	document.getElementById("FName").value = localStorage.getItem("firstname");
	document.getElementById("LName").value = localStorage.getItem("lastname");
	
	function store(){
		 var fname = document.getElementById("FName");
		 localStorage.setItem("firstname", fname.value);
		 
		 var lname = document.getElementById("LName");
		 localStorage.setItem("lastname", lname.value);
	}
</script>

</body>
</html>