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
	<title>Books</title>

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
		<h3>Books</h3>
		<hr />
		<form id="statusForm">
			<div class="col-lg-6">
				<label for="MovieName">Book name:<span class="required">*</span></label>
				<input type="text" id="MovieName" class="col-6 col-lg-6" name="MovieName" required="true" />
			</div>

			<div class="col-lg-6 left">
				<label for="Year">Year:</label>
				<input type="text" id="Year" class="col-6 col-lg-6" name="Year" />
			</div>
		</form>
			<button id="findMovie" class="btn btn-primary" type="submit">Search</button>
			</div>
			
		<br/><br/>
			
		<br/>
			<div id="wrap_result">
		
			<p id="result"></table>		
	</main>
	<?php
		include "footer.php";
	?>

	<script>
		$(document).ready(function()
		{			
			$("#findMovie").click(function()
			{
				var movieName = $("#MovieName").val();
				var year = $("#Year").val();
				$.get("googleBooks.php",{"MovieName":movieName, "Year":year},
				function(data)
				{
					$('#wrap_result').show();
					$('#result').html("<h3>Found headings: </h3>"+data);
				});	
			});
		});		
		</script>
</body>
</html>