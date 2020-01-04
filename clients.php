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
	<title>Clients</title>

	<script src="jquery/jquery-3.4.1.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css" />
  	<script src="js/bootstrap.min.js"></script>
	<script src="jquery/jquery-3.4.1.min.js"></script>
	<script src="js/hide.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  	<script src="dataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>	
  	<link rel="stylesheet" href="dataTables/DataTables-1.10.20/css/jquery.dataTables.min.css" />
  	<script src="dataTables/Editable/jquery.dataTables.editable.js"></script>
  	<script src="dataTables/Editable/jquery.jeditable.js"></script>
  	<link rel="stylesheet" href="css/style.css" />
  	<script src="js/search.js"></script>
</head>
<body>
	<?php
		include "header.php";
	?>	
	<main class="container" id="cli">	
		<input id="import" type="button" name="import" class="btn btn-primary" value="Import" onclick="importJSON('#importedJSON')" />	
		<?php
			include "search.php";
			include "dbMachine.php";	
			$table = new DBMachine();
			$columns = array("ID", "Address", "Email", "Name", "ClientID");
			$table->FillTable($columns, "clients", "Name");
		?>

		<table id="importedJSON" class="table table-striped"></table>

		<input type="submit" name="createNew" id="createNew" class="btn btn-primary createNew" value="Save" onclick="window.location.href='client.php?save'" />

		<script type="text/javascript">
			hide("clients");

			function importJSON(selector)
			{
				document.getElementById("createNew").style.display = 'inline-block';
				var isSet = document.getElementById("loadTable");
				if(isSet)
					document.getElementById("loadTable").style.display = 'none';
				isSet = document.getElementById("searchTable");
				if(isSet)
					document.getElementById("searchTable").style.display = 'none';
				document.getElementById("importedJSON").style.display = 'table';
				var Parent = document.getElementById('importedJSON');
				while(Parent.hasChildNodes())
				{
				   Parent.removeChild(Parent.firstChild);
				}

				$.getJSON('json/importJSON.json', function(list) 
				{
					
		            var cols = Headers(list.clients, selector);   
		            $('#importedJSON').append("<tbody>");
		            for (var i = 0; i < list.clients.length; i++) 
		            { 
		                var row = $('<tr/>');
		                for (var colIndex = 0; colIndex < cols.length; colIndex++) 
		                { 
		                    var val = list.clients[i][cols[colIndex]]; 
		                      
		                    if (val == null) val = "";   
		                        row.append($('<td/>').html(val)); 
		                } 
		                $(selector).append(row);

		            $('#importedJSON').append("</tbody>");
	            	}
				});

				document.getElementById("import").disabled = true;
			}

			function Headers(list, selector) { 
	            var columns = []; 
	            var header = $('<thead/>'); 

	            for (var i = 0; i < list.length; i++) 
	            { 
	                var row = list[i]; 
	                  
	                for (var k in row) { 
	                    if ($.inArray(k, columns) == -1) 
	                    { 
	                        columns.push(k); 	                          
	                        header.append($('<th/>').html(k)); 
	                    } 
	                } 
	            } 
	            $(selector).append(header);
	            return columns; 
	        }
		</script>

	</main>
	<?php
		include "footer.php";
	?>
</body>
</html>