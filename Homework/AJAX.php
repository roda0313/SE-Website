<html>
<head>

<title>Ajax RSS News reader - BBC</title>
<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<script type="text/javascript">
function select(option)
{
	$("#JSONDiv").attr("hidden", true);
	$("#NewsFeedDiv").attr("hidden", true);
	$("#RandomTextDiv").attr("hidden", true);
	
	if (option.value == "JSONData")
	{
		$("#JSONDiv").removeAttr("hidden");
	}
	
	else if (option.value == "NewsFeed")
	{
		$("#NewsFeedDiv").removeAttr("hidden");
	}
	else if (option.value == "RandomString")
	{
		$("#RandomTextDiv").removeAttr("hidden");
	}
}

function randomString(length) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for(var i = 0; i < length; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
}

function loadJSON(type){
	//alert("hi");
	if (type == "good")
	{
		var data_file = "JSON/AJAXGoodData.JSON";
	}
	else
	{
		var data_file = "JSON/AJAXBadData.JSON";
	}
	
	var http_request = new XMLHttpRequest();
	try {
	   // Opera 8.0+, Firefox, Chrome, Safari
	   http_request = new XMLHttpRequest();
	} catch (e){
	   // Internet Explorer Browsers
	   try {
		  http_request = new ActiveXObject("Msxml2.XMLHTTP");

	   } catch (e) {

		  try{
			 http_request = new ActiveXObject("Microsoft.XMLHTTP");
		  }catch (e){
			 // Something went wrong
			 alert("Your browser broke!");
			 return false;
		  }

	   }
	}

	http_request.onreadystatechange = function(){

	   if (http_request.readyState == 4  ){
			// Javascript function JSON.parse to parse JSON data
			
			if (type == "good")
			{
				$("#JSONDiv").append("<h3>Good Data</h3>");
			}
			else 
			{
				$("#JSONDiv").append("<h3>Bad Data</h3>");
			}
			
			try 
			{
				var jsonObj = JSON.parse(http_request.responseText);
			}
			catch (e)
			{
				$("#JSONDiv").append("An error occurred in JSON.parse: " + e);
			}
			// jsonObj variable now contains the data structure and can
			// be accessed as jsonObj.name and jsonObj.country.
			
			if (type == "good")
			{
				$("#JSONDiv").append("Name: " + jsonObj.Name + "<br>");
				$("#JSONDiv").append("Age: " + jsonObj.Age + "<br>");
				$("#JSONDiv").append("Hometown: " + jsonObj.Hometown + "<br>");
			}
	   }
	}

	http_request.open("GET", data_file, true);
	http_request.send();
}
</script>

</head>
<body>

<div id="MainDiv"> 
	<h1>Select an option</h1>
	<select name="selector" onchange="select(this)">
		<option value="---">---</option>
		<option value="NewsFeed">News Feed</option>
		<option value="RandomString">Random Text</option>
		<option value="JSONData">JSON Data</option>
	</select>
</div>

<div id="JSONDiv" hidden>
	<h1>JSON Data</h1>
	<script type="text/javascript">
		loadJSON("good");
		loadJSON("bad");
	</script>
</div>

<div id="NewsFeedDiv" hidden>
	<h1>BBC News Feed</h1>
	<?php getFeed('https://feeds.bbci.co.uk/news/rss.xml?edition=us') ?>
</div>

<div id="RandomTextDiv" hidden>
	<h1>Random Text</h1>
	<h3>Scroll down for more text</h3>
	<script>
		var count = 0;
		while(count < 50)
		{
			var div = document.getElementById('RandomTextDiv');
			div.innerHTML = div.innerHTML + "<br>" + randomString(10);
			count++;
		}
	</script>
	<script>
		$(document).ready(function(){
			$(window).scroll(function(){
				var div = document.getElementById('RandomTextDiv');
				div.innerHTML = div.innerHTML + "<br>" + randomString(10);
			});
		});
	</script>
</div>

</body>
</html>

<?php
function getFeed($feed_url) 
{
     
    $content = file_get_contents($feed_url);
    $x = new SimpleXmlElement($content);
     
    foreach($x->channel->item as $entry) 
	{
        echo "<a href='$entry->link' title='$entry->title'>" . $entry->title . "</a><br>";
		echo "$entry->description <br><br>";
    }
}
?>