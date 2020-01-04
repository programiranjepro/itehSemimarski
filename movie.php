<!DOCTYPE html>
<?php
	session_start();

	if(!isset($_SESSION['logged']))
	{
		header('Location: login.php');
		exit();
	}	
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>New Movie</title>

	<script src="jquery/jquery-3.4.1.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css" />
  	<script src="js/bootstrap.min.js"></script>
	<script src="jquery/jquery-3.4.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  		<script src="dataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>	
  		<link rel="stylesheet" href="dataTables/DataTables-1.10.20/css/jquery.dataTables.min.css" />
  	<link rel="stylesheet" href="css/style.css" />
</head>
<body>
	<?php
		include "header.php";
	?>
	<main id="ticket">
		<h3>New Movie</h3>
		<hr />

		<form id="statusForm" method="POST" action="">
			<div class="col-lg-6">
				<label for="MovieName">Movie name:<span class="required">*</span></label>
				<input type="text" id="MovieName" class="col-6 col-lg-6" name="MovieName" required="true" />
			</div>

			<div class="col-lg-6">
				<label for="Details">Details:</label>
				<input type="text" id="Details" class="col-6 col-lg-6" name="Details" />
			</div>

			<div class="col-lg-6">
				<label for="Year">Year:</label>
				<input type="text" id="Year" class="col-6 col-lg-6" name="Year" />
			</div>

			<div class="createButton">
				<input type="submit" name="createNew" id="createNew" class="btn btn-primary createNew" value="Create" />
			</div>
		</form>
	</main>
	<?php
		include "footer.php";
	?>

	<script>
		$(document).ready(function()
		{			
			$("#createNew").click(function()
			{
				MovieName = $("#MovieName").val();
				Details = $("#Details").val();
				Year = $("#Year").val();
				$.post("index.php",{"MovieName":MovieName, "Details":Details,"Year":Year}, 
				function(data)
				{
					alert(data);
				});
			});	
		});		
		</script>
</body>
</html>