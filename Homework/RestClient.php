<html>
<head>
	<meta charset="utf-8">

	<title>Daniel Roberts Website</title>
	<meta name="description" content="Daniel Roberts Website">
	<meta name="author" content="Daniel Roberts">
	<meta name="viewport" content="width=device-width"/>
	
	<!-- JQuery -->
	<script
		src="https://code.jquery.com/jquery-3.1.1.min.js"
		integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
		crossorigin="anonymous">
	</script>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>
	<div class="container">
		<div class="list-group">
			<?php
			// Author: Daniel Krutz
			// Description: Create a RESTful client to read the API from another site
			// Use GETs to read person info
			if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_person") 
			{
				$person_info = file_get_contents('https://www.se.rit.edu/~djr9478/Homework/RESTAPI.php?action=get_person&id=' . $_GET["id"]);
				$person_info = json_decode($person_info, true);
				?>


				<!-- Buld the table to display the data in
					  Notice how the person_info variables are being passed in.      
				-->
				<br>
				<table border ="1">
				  <tr>
					<td>Name: </td><td> <?php echo $person_info["person_name"] ?></td>
				  </tr>
				  <tr>
					<td>Age: </td><td> <?php echo $person_info["person_age"] ?></td>
				  </tr>
				  <tr>
					<td>Favorite Movie: </td><td> <?php echo $person_info["favorite_movie"] ?></td>
				  </tr>
				</table>
				<br />

				<!-- Create a basic link to return to the previous page -->
				<a class="list-group-item" href="https://www.se.rit.edu/~djr9478/Homework/RestClient.php?action=get_person_list" alt="person list">Return to the person list</a>
			<?php
			}
			else // else take the person list
			{
				// Create the person list
				$person_list = file_get_contents('https://www.se.rit.edu/~djr9478/Homework/RESTAPI.php?action=get_person_list');
				// Retrieve & decode the necessary JSON information
				$person_list = json_decode($person_list, true);
				?>
				<?php foreach ($person_list as $person): ?>
					<a class="list-group-item" href=<?php echo "https://www.se.rit.edu/~djr9478/Homework/RestClient.php?action=get_person&id=" . $person["id"]  ?> alt=<?php echo "person_" . $person_["id"] ?>><?php echo $person["name"] ?></a>
				<?php endforeach; ?>			
			  <?php
			} ?>
		
		</div>
		
		<?php
		if (!isset($_GET["action"]) || $_GET["action"] == "get_person_list") 
		{
		
		?>
			<form class="form-inline" method="get">
				<div class="form-group">
					<label for="action">Action</label>
					<select class="form-control" id="action" name="action">
					<option>add</option>
					<option>subtract</option>
					<option>multiply</option>
					<option>divide</option>
					</select>
				</div>
				<input type="number" class="form-control" id="num1" name="num1" placeholder="0" value=0 />
				<input type="number" class="form-control" id="num2" name="num2" placeholder="0" value=0 />
				<button class="btn btn-primary" type="submit">Submit</button>
			</form>
		<?php 
		} 
		?>
		
		<?php
		if (($_GET["action"] == "add" || $_GET["action"] == "subtract" || $_GET["action"] == "get_person_list" || $_GET["action"] == "multiply" || $_GET["action"] == "divide")&& isset($_GET["num1"]) && isset($_GET["num2"]))
		{	
		
		$string = ('https://www.se.rit.edu/~djr9478/Homework/RESTAPI.php?action=' . $_GET["action"] .'&num1=' . $_GET["num1"] . '&num2=' . $_GET["num2"]);
		$result = file_get_contents($string);
		$result = json_decode($result, true);
		?>
		
			<form class="form-inline" method="get">
				<div class="form-group">
					<label for="action">Action</label>
					<select class="form-control" id="action" name="action">
					<option <?php if ($_GET["action"] == "add") { ?> selected="selected" <?php } ?>>add</option>
					<option <?php if ($_GET["action"] == "subtract") { ?> selected="selected" <?php } ?>>subtract</option>
					<option <?php if ($_GET["action"] == "multiply") { ?> selected="selected" <?php } ?>>multiply</option>
					<option <?php if ($_GET["action"] == "divide") { ?> selected="selected" <?php } ?>>divide</option>
					</select>
				</div>
				<input type="number" class="form-control" id="num1" name="num1" value="<?php echo (string)$_GET["num1"] ?>"/>
				<input type="number" class="form-control" id="num2" name="num2" value="<?php echo (string)$_GET["num2"] ?>"/>
				<button class="btn btn-primary" type="submit">Submit</button>
				<label>Result: <?php echo $result ?> </label>
			</form>
		
		<?php
		}
		?>
		
	</div>
</body>
</html>