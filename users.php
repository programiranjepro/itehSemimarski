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
	<title>Users</title>

	<script src="jquery/jquery-3.4.1.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css" />
  	<script src="js/bootstrap.min.js"></script>
	<script src="jquery/jquery-3.4.1.min.js"></script>
	<script src="js/hide.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  	<script src="js/search.js"></script>
  		<script src="dataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>	
  		<link rel="stylesheet" href="dataTables/DataTables-1.10.20/css/jquery.dataTables.min.css" />
  	<link rel="stylesheet" href="css/style.css" />
</head>
<body>
	<?php
		include "header.php";
	?>	
	<main class="container">
		<?php
			include "search.php";
			include "dbMachine.php";	
			$table = new DBMachine();
			$columns = array("ID", "FirstName", "LastName", "Email");
			$table->FillTable($columns, "users", "Email");
		?>
		<script type="text/javascript">
			hide("users");
		</script>
	</main>
	<?php
		include "footer.php";
	?>
</body>
</html>