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
	<title>New Status</title>

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
		<h3>New Status</h3>
		<hr />

		<form id="statusForm" method="POST" action="">
			<div class="col-lg-6">
				<label for="StatusName">Status name:<span class="required">*</span></label>
				<input type="text" id="StatusName" class="col-6 col-lg-6" name="StatusName" required="true" />
			</div>

			<div class="col-12 col-lg-3 right">
				<label for="IsActive">Active:</label>
				<select id="IsActive" name="IsActive">
					<option value="yes">Yes</option>
					<option value="no">No</option>
				</select>
			</div>

			<div class="createButton">
				<input type="submit" name="createNew" id="createNew" class="btn btn-primary createNew" value="Create" />
			</div>
			<?php
				include "dbMachine.php";
			?>
		</form>
		<?php
			$machine = new DBMachine();
			$list = array("StatusName", "IsActive");
			$machine->CreateNew($list, 'statuses', "'\$StatusName'", 'StatusName');
		?>
	</main>
	<?php
		include "footer.php";
	?>
</body>
</html>