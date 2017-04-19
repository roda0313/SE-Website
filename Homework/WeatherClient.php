<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">

		<title>Daniel Roberts Website</title>
		<meta name="description" content="Daniel Roberts Website">
		<meta name="author" content="Daniel Roberts">
		<meta name="viewport" content="width=device-width"/>
		
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
        <script type="text/javascript" src="weather.js"></script>
		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	</head>
	<body>
		<div class="container">
			<h1>Weather R Us</h1>
		 
			<h3>Select your zip:</h3>
			<div class="list-group" id="ziplist" ></div>
			
			<form class="form-inline">
				<label for="zip" >Enter your zip: <input type="number" name="zip" id="zip-input" class="form-control"/></label>
				<button id="submit-zip" class="btn btn-primary">Search</button>
			</form>
			
			<div id="forecast-section" style="display:none">
			<hr/>
				<h3>Your local forecast</h3>
				<p>
					<strong>Name:</strong>
					<span id="name"></span>
				</p>
				<p>
					<strong>Forecast:</strong>
					<span id="forecast"></span>
				</p>
				<img id="image" src=""/>
			</div>
		</div>
	</body>
</html>