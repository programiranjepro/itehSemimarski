<?php
	$searchValue = "";
	$columnName = "";
	$tableName = "";
	$eleID = "";
	if (!isset ($_GET["id"]) && !isset ($_GET["user"]) && !isset ($_GET["client"]) 
		&& !isset ($_GET["status"]) && !isset ($_GET["heading"]) && !isset ($_GET["dateFrom"]) 
		&& !isset ($_GET["dateTo"])){
		echo "Parameter not set!";
	} else
	{
		include "connection.php";
	} 

	if(isset ($_GET["id"]))
	{
		$searchValue=$_GET["id"];
		$columnName = "ID";
		$tableName = "tickets";
		$eleID = "id";
	} else if(isset ($_GET["user"]))
	{
		$searchValue=$_GET["user"];
		$columnName = "Email";
		$tableName = "users";	
		$eleID = "user";	
	} else if(isset ($_GET["client"]))
	{
		$searchValue=$_GET["client"];
		$columnName = "Name";
		$tableName = "clients";		
		$eleID = "client";	
	} else if(isset ($_GET["status"]))
	{
		$searchValue=$_GET["status"];
		$columnName = "StatusName";
		$tableName = "statuses";	
		$eleID = "status";				
	} else if(isset ($_GET["heading"]))
	{
		$searchValue=$_GET["heading"];
		$columnName = "Heading";
		$tableName = "tickets";	
		$eleID = "heading";				
	}
	
		$sql="SELECT $columnName FROM $tableName WHERE $columnName LIKE '$searchValue%'";
		$result = $mysqli->query($sql);
		if ($result->num_rows==0)
		{
			echo "Database does not contain: " . $searchValue;
		} else 
		{
			while($row = $result->fetch_object())
			{
				echo "
				<a href='#' onclick='place(this,\"". $eleID."\")'>".$row->$columnName."</a>
				<br/>
				";
			}
		}
		$mysqli->close();
	
	
?>
