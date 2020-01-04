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
	<title>Movies</title>

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
	<script type="text/javascript">				
				function change (caller)
				{
				var id = caller.attr("id");
				var details=$("#Details2"+id).val();
				
				$.post("index.php/comment",{"details":details, "id":id}, 
				function(data){
					$('#Details'+id).html(data);
					
				});
			}			
		</script>
	<?php
		include "header.php";
	?>	
	<main class="container">
		<?php
			$url = 'http://localhost/iteh3b/index.php/show';
			$dataType = 'Accept: application/json';
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array($dataType));
			curl_setopt($curl, CURLOPT_POST, false);
			$curl_result = curl_exec($curl);
			curl_close($curl);
			$json_object=json_decode($curl_result);
		?>
		<h3>Movies</h3>
		<hr />

		<form id="searchNew" action="movie.php" name="new">
			<input id="create" type="submit" name="create" class="btn btn-primary" value="New" />
			<input id="findMovie" type="button" onclick="location.href='findMovie.php';" name="findMovie" class="btn btn-primary" value="Books" />	
		</form>
		<table class="table table-striped display">
			<thead>
				<tr>
					<td>ID</td>
					<td>Movie</td>
					<td>Year</td>
					<td>Details</td>
					<td></td>
				</tr>
			</thead>
			<tbody>		
			<?php
				foreach($json_object->movies as $value)
				{
				?>

					<tr>
						<td><?php echo $value->ID;?></td>
						<td><?php echo $value->MovieName;?></td>
						<td><?php echo $value->Year;?></td>
						<td id="Details<?php echo$value->ID?>"><?php echo $value->Details;?></td>
						<td><?php
							echo "<textarea rows='4' name='Details2' id='Details2".$value->ID."'>".$value->Details."</textarea>";
							echo "<input type='button' class='change' value='Change details' id='".$value->ID."' onclick='change($(this))'>"; 
							?>
						</td>
					</tr>
			<?php
				}
			?>
			</tbody>
		</table>
	</main>
	<?php
		include "footer.php";
	?>
</body>
</html>