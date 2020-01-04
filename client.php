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
	<title>New User</title>

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
		<h3>New Client</h3>
		<hr />

		<form id="statusForm" method="POST" action="">
			<div class="col-lg-6">
				<label for="Name">Name:<span class="required">*</span></label>
				<input type="text" id="Name" class="col-6 col-lg-6" name="Name" required="true" />
			</div>

			<div class="col-lg-6">
				<label for="Address">Address:<span class="required">*</span></label>
				<input type="text" id="Address" class="col-6 col-lg-6" name="Address" required="true" />
			</div>

			<div class="col-lg-6">
				<label for="Email">Email:<span class="required">*</span></label>
				<input type="text" id="Email" class="col-6 col-lg-6" name="Email" required="true" />
			</div>

			<div class="col-lg-6">
				<label for="ClientID">ClientID:<span class="required">*</span></label>
				<input type="text" id="ClientID" class="col-6 col-lg-6" name="ClientID" required="true" />
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
			if(strpos($_SERVER['REQUEST_URI'], 'save') !== false)
			{
				$json = file_get_contents("json/importJSON.json");
				$json_object=json_decode($json);
				foreach($json_object->clients as $value)
				{
					$_POST['Name'] = $value->Name;
				    $_POST['Address'] = $value->Address;
				    $_POST['Email'] = $value->Email;
				    $_POST['ClientID'] = $value->ClientID;
				    $_POST['createNew'] = "true";			
					$list = array("Name", "Address", "Email", "ClientID");
					$machine->CreateNew($list, 'clients', '$ClientID', 'ClientID');
				}
			}
			else
			{
				$list = array("Name", "Address", "Email", "ClientID");
				$machine->CreateNew($list, 'clients', '$ClientID', 'ClientID');
			}
		?>


	</main>
	<?php
		include "footer.php";
	?>
</body>
</html>