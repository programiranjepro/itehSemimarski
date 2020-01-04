<!DOCTYPE html>
<?php
	session_start();

	if(isset($_SESSION['logged'])) 
	{
		header('Location: tickets.php');
		exit();
	}

	if(isset($_POST['login'])) 
	{
		if (isset($_POST['email']) && isset($_POST['password']))
		{
			require "connection.php";

			$email = $_POST['email'];
			$password = $_POST['password'];

			$sql="SELECT ID FROM users WHERE email = '$email' AND password = '$password'";
			$data = $mysqli->query($sql);

			if($data->num_rows > 0)
			{
				$_SESSION['logged'] = '1';
				$_SESSION['email'] = $email;
				exit('1');
			}  
			else exit('0');
		}
		else echo "Error!";
		
		$mysqli->close();
	}
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Log-in</title>

  		<link rel="stylesheet" href="css/bootstrap.min.css">
  		<script src="js/bootstrap.min.js"></script>
		<script src="jquery/jquery-3.4.1.min.js"></script> 
  		<script src="dataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>	
  		<link rel="stylesheet" href="dataTables/DataTables-1.10.20/css/jquery.dataTables.min.css" />	
  		<link rel="stylesheet" href="css/style.css">
	</head>
	<body id="loginElements">
		<main class="container col-sm-8">

			<form method="POST" action="login.php">	
				<label for="email">Email:<span class="required">*</span></label>
				<input type="text" id="email" name="email" required="true" />
				<br />

				<label for="password">Password:<span class="required">*</span></label>
				<input type="password" id="password" name="password" required="true">
				<br />

				<input type="submit" id="login" class="btn btn-primary" name="login" value="Log-in" />	
			</form>

			<div id="response" class="alert"></div>
			<img id="welcome" src="images/login.jpg" width="100%" height="auto" />			
		</main>
		
		<script type="text/javascript">
			$(document).ready(function()
			{
				$("#login").on('click', function() 
				{
					var email = $("#email").val();
					var password = $("#password").val();

					$.ajax(
					{
						url: 'login.php',
						method: 'POST',
						data: 
						{
							login: 1,
							email: email,
							password: password
						},
						success: function(response) 
						{		
							var element = document.getElementById("response");

							if(response.indexOf('1') >= 0) 
							{										
   								element.classList.add("alert-success");	
								$("#response").html('Succesful login!')
							} 
							else 
							{		
								alert("Wrong username or password!");			
								window.location = 'login.php';			
							}											
						},
						dataType: 'text'
					});
					
				});
			});
		</script>
	</body>
</html>