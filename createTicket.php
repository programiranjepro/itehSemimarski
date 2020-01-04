<?php 
	session_start();

  	if (isset($_POST["Heading"]) && isset($_POST["IDClient"]) && isset($_POST["IDStatus"]) && isset($_POST["Description"]))
	{
		include "connection.php";
		
		$Heading = $_POST['Heading'];
		$ClientName = $_POST['IDClient'];
		$StatusName = $_POST['IDStatus'];
		$EmailForIDUser = $_SESSION['email'];
		$Description = $_POST['Description'];	

		$sqlIDClient = "SELECT ID FROM clients WHERE Name LIKE '$ClientName'";
		$sqlIDStatus = "SELECT ID FROM statuses WHERE StatusName LIKE '$StatusName'";
		$sqlIDUser = "SELECT ID FROM users WHERE Email LIKE '$EmailForIDUser'";

		$IDClient = ExecSelect($sqlIDClient);
		$IDStatus = ExecSelect($sqlIDStatus);
		$IDUser = ExecSelect($sqlIDUser);	

		$sql = "INSERT INTO tickets (Heading, IDClient, IDStatus, CreateDate, IDUser, Description) 
			VALUES ('".$Heading."', '".$IDClient."', '".$IDStatus."', '".date("Y").
			"".date("m")."".date("d")."', '".$IDUser."', '".$Description."')";		

		if ($mysqli->query($sql))
		{
			echo "Saved!";
		} else 
		{
			echo "Element already exists!";
		}

		$mysqli->close();
	}

	function ExecSelect($sql)
	{
		include "connection.php";
		$id = "";
		if (!$q=$mysqli->query($sql))
		{
			echo "<p class='info alert alert-danger'>Error!</p>";
			exit();
		}
		if ($q->num_rows==0)
		{
			echo "<p class='info alert alert-success'>Table is up to date!</p>";
		} else 
		{
			while ($row = $q->fetch_object())
			{
				$id = $row->ID;
			}
		}
		return $id;
	}
 ?>