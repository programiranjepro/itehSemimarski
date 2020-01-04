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
	<title>New Ticket</title>

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
		<h3>New Ticket</h3>
		<hr />

		<form id="ticketForm" method="POST" name="ticketForm">
			<div class="col-6">
				<label for="Heading">Heading:</label>
				<input type="text" id="Heading" class="col-6" name="Heading" />
			</div>
			<?php
				include "dbMachine.php";
				$machine = new DBMachine();
				$ClientIDResult = $machine->FillDropList('clients', 'Name', 'ID', 'IDClient', 'Client: ');
				$StatusIDResult = $machine->FillDropList('statuses', 'StatusName', 'ID', 'IDStatus', 'Status: ');
				$listOfClientID = explode(',', $ClientIDResult);
				$listOfStatusID = explode(',', $StatusIDResult);
			?>
			<div class="textarea">
				<label for="Description">Description:</label>
				<textarea id="Description" name="Description" rows="10" cols="30"></textarea>
			</div>
			<div class="createButton">
				<input type="button" name="createNew" id="createNew" class="btn btn-primary createNew" value="Create" onclick="Ticket('create')" />
			</div>
			<script>
				var selectedStatus = "";
				var selectedClient = "";
			    $().ready(function(){
			        $('#IDClient').change(function(){
			            selectedClient = $('#IDClient').find(":selected").val();
			            if(selectedClient != "")
			            	document.getElementById("IDStatus").disabled = false;
			            else			            
			            	document.getElementById("IDStatus").disabled = true;
			        });

			        $('#IDStatus').change(function(){
			            selectedStatus = $('#IDStatus').find(":selected").val();			            
			            document.getElementById("IDClient").disabled = true; 	        
			        });
			    });

			    function CreateTicket()
			    {
			       	//var list = ["Heading", "IDClient", "IDStatus", "Description"];
			       	var heading = document.getElementById("Heading").value;
			       	var description = document.getElementById("Description").value;
			       	var validate = Validate();
			       	if(validate)
			       	{
			            $.ajax({
			                url: 'createTicket.php',
			                type: 'POST',
			                data:
			                {			                	
			                	'Heading': heading,
			                	'IDClient': selectedClient,
			                	'IDStatus': selectedStatus,
			                	'Description': description
			                },
			                success: function (data) 
			                {
			                	alert(data);
			                }
			            });
			        }
			        else
			        	alert("Fill the fields");
		        }

		        function Ticket($action) {
		        	var heading = document.getElementById("Heading").value;
			       	var description = document.getElementById("Description").value;
			       	var validate = Validate();
			       	var url = $action  == 'create' ? 'createTicket.php' : 'editTicket.php'
			       	var url2 = window.location.href;
			       	var idIndex = url2.indexOf('id=');
			       	var idAnd = url2.substring(idIndex + 3);
			       	var andIndex = idAnd.indexOf('&');
			       	var id = idAnd.substring(0, andIndex);
			       	if(validate)
			       	{
			        	$.ajax({
			        		url: url,
			                type: 'POST',
			                data:
			                {			                	
			                	'Heading': heading,
			                	'IDClient': selectedClient,
			                	'IDStatus': selectedStatus,
			                	'Description': description,
			                	'idEdit': id
			                },
			                success: function (data) 
			                {
			                	alert(data);
			                }
			            });
			        } else
			        	alert("Fill the fields");
		        }

		        function Validate()
		        {
		        	if(selectedClient == "" || selectedStatus == "") return false;
		        	else return true;
		        }
			</script>
			<?php			
				$list = array("Heading", "IDClient", "IDStatus", "Description");
				//$machine->CreateNew($list, 'tickets', '$ID', 'ID');
			?>
		</form>
		<hr />
	</main>
	<?php
		include "footer.php";		
	?>
</body>
</html>