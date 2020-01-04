<?php

function show()
{
	require "connection.php";
	header("Content-type: application/json");?>{"movies":<?php
	$sql="SELECT * FROM movies";
	if (!$q=$mysqli->query($sql))
	{
		echo '{"Error":"Bad request."}';
		exit();
	} else 
	{
		if ($q->num_rows>0)
		{
			$arr = array();
			while ($row=$q->fetch_object())
			{
				$arr[] = $row;
			}
			$arr_json = json_encode ($arr);
			print ($arr_json);
		} else {
			echo '{"Error":"No result available."}';
		}
	}?>}
	<?php
	$mysqli->close();
}

function comment()
{
	require "connection.php";
	$sql="UPDATE movies SET Details='".$_POST['details']."' WHERE ID=".$_POST['id'];

	if (!$q=$mysqli->query($sql))
	{
		echo "Bad request.";
	} else 
	{
		$sql = "SELECT Details FROM movies WHERE ID=".$_POST['id'];
		if (!$q=$mysqli->query($sql))
		{
			echo "Bad request.";
		} else {
			$row=$q->fetch_object();
			echo $row->Details;			
		}
	}
}

function newMovie()
{
	require "connection.php";
	$sql = "INSERT INTO movies (MovieName, Details, Year) VALUES ('".$_POST['MovieName']."','".$_POST['Details']."',".$_POST['Year'].")";
	echo $sql;
	if (!$q=$mysqli->query($sql))
	{
		echo "Bad request.";
	} else 
	{
		echo "Saved!";
	}		
}

?>