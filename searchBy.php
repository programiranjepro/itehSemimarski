<?php
	include "connection.php";
	if($_GET["page"] == 'Index'){
		if (!isset($_GET["id"]) || !isset($_GET["user"]) || !isset($_GET["client"]) || !isset($_GET["status"])
	 		|| !isset($_GET["heading"]) || !isset($_GET["dateFrom"]) || !isset($_GET["dateTo"]))
		{
			echo "Missing parameter!";
		} else 
		{
			$select = "t.ID, u.Email, c.Name, s.StatusName, t.Heading, t.CreateDate, t.Description";
			$where = "";
			$columns = array('ID','Email','Name','StatusName','Heading','CreateDate', 'Description');
			if(isset($_GET["id"]))
			{
				$where .= "t.ID LIKE '" . $_GET["id"]."%' AND ";
			}
			if(isset($_GET["user"]))
			{
				$where .= "u.Email LIKE '" . $_GET["user"]."%' AND ";
			}
			if(isset($_GET["client"]))
			{
				$where .= "c.Name LIKE '" . $_GET["client"]."%' AND ";
			}
			if(isset($_GET["status"]))
			{
				$where .= "s.StatusName LIKE '" . $_GET["status"]."%' AND ";
			}
			if(isset($_GET["heading"]))
			{
				if($_GET["dateFrom"] == "" && $_GET["dateTo"] == "")
					$where .= "t.Heading LIKE '" . $_GET["heading"]."%'";
				else
					$where .= "t.Heading LIKE '" . $_GET["heading"]."%' AND ";
			}
			if(isset($_GET["dateFrom"]) && $_GET["dateFrom"] != "")
			{
				$where .= "t.CreateDate >= " . $_GET["dateFrom"] . " AND ";
			}
			if(isset($_GET["dateTo"]) && $_GET["dateTo"] != "")
			{
				$where .= "t.CreateDate <= " . $_GET["dateTo"];
			}
			$sql = "SELECT " . $select . " FROM tickets t LEFT JOIN users u ON u.ID = t.IDUser LEFT JOIN clients c ON c.ID = t.IDClient LEFT JOIN statuses s ON s.ID = t.IDStatus WHERE " . $where;
			$result = $mysqli->query($sql);
			echo "<table class='dataTable display table-striped' id='searchTable'>
			<tr>
			<th>ID</th>	
			<th>Email</th>	
			<th>Name</th>	
			<th>StatusName</th>	
			<th>Heading</th>	
			<th>CreateDate</th>	
			<th>Description</th>	
			<th colspan='2'>Action</th>
			</tr>";

			$pom = 0;
			while($row = $result->fetch_object())
			{
				echo "<tr>";
				foreach ($columns as $key => $value) 
				{		
					echo "<td>" . $row->$value . "</td>";
				}
				echo "<td><a href='ticket.php?action=edit_formT&id=" . $row->ID . "&heading=" . $row->Heading . "&client=" . $row->Name . "&status=" . $row->StatusName . "&description=" . $row->Description . "; ?>' name='Edit" . $pom . " id='Edit" . $pom . "'><input type='button' class='btn btn-primary' value='Edit' /></a></td>";
				echo "<td><a href='?action=deleteT&id=" . $row->ID . "' name='Delete" . $pom . "'><input type='button' class='btn btn-primary' value='Delete' /></a></td>";
				echo "</tr>";
				$pom++;
			}
			echo "</table>";

			echo "<style>#loadTable{display: none;}</style>";
		}
	}
	else if($_GET["page"] == 'Users')
	{
		if (!isset($_GET["id"]) || !isset($_GET["user"]))
		{
			echo "Missing parameter!";
		} else 
		{
			$select = "ID, FirstName, LastName, Email";
			$where = "";
			$columns = array('ID','FirstName','LastName', 'Email');
			if(isset($_GET["id"]))
			{
				$where .= "ID LIKE '" . $_GET["id"]."%' AND ";
			}
			if(isset($_GET["user"]))
			{
				$where .= "Email LIKE '" . $_GET["user"]."%'";
			}
			$sql = "SELECT " . $select . " FROM users WHERE " . $where;
			$result = $mysqli->query($sql);
			echo "<table class='dataTable display table-striped' id='searchTable'>
			<tr>
			<th>ID</th>		
			<th>FirstName</th>	
			<th>LastName</th>
			<th>Email</th>		
			<th colspan='2'>Action</th>
			</tr>";

			$pom = 0;
			while($row = $result->fetch_object())
			{
				echo "<tr>";
				foreach ($columns as $key => $value) 
				{		
					echo "<td>" . $row->$value . "</td>";
				}
				echo "<td><a href='user.php?action=edit_formU&id=" . $row->ID . "&last=" . $row->LastName . "&first=" . $row->FirstName . "&email=" . $row->Email . "; ?>' name='Edit" . $pom . " id='Edit" . $pom . "'><input type='button' class='btn btn-primary' value='Edit' /></a></td>";
				echo "<td><a href='?action=deleteU&id=" . $row->ID . "' name='Delete" . $pom . "'><input type='button' class='btn btn-primary' value='Delete' /></a></td>";
				$pom++;
			}
			echo "</table>";

			echo "<style>#loadTable{display: none;}</style>";
		}
	}
	else if($_GET["page"] == 'Statuses')
	{
		if (!isset($_GET["id"]) || !isset($_GET["status"]))
		{
			echo "Missing parameter!";
		} else 
		{
			$select = "ID, StatusName, IsActive";
			$where = "";
			$columns = array('ID','StatusName','IsActive');
			if(isset($_GET["id"]))
			{
				$where .= "ID LIKE '" . $_GET["id"]."%' AND ";
			}
			if(isset($_GET["status"]))
			{
				$where .= "StatusName LIKE '" . $_GET["status"]."%'";
			}
			$sql = "SELECT " . $select . " FROM statuses WHERE " . $where;
			$result = $mysqli->query($sql);
			echo "<table class='dataTable display table-striped' id='searchTable'>
			<tr>
			<th>ID</th>		
			<th>StatusName</th>	
			<th>IsActive</th>
			<th colspan='2'>Action</th>
			</tr>";

			$pom = 0;
			while($row = $result->fetch_object())
			{
				echo "<tr>";
				foreach ($columns as $key => $value) 
				{		
					echo "<td>" . $row->$value . "</td>";
				}
				echo "<td><a href='status.php?action=edit_form&id=" . $row->ID . "&elem=" . $row->StatusName . "; ?>' name='Edit" . $pom . " id='Edit" . $pom . "'><input type='button' class='btn btn-primary' value='Edit' /></a></td>";
				echo "<td><a href='?action=delete&id=" . $row->ID . "' name='Delete" . $pom . "'><input type='button' class='btn btn-primary' value='Delete' /></a></td>";
				$pom++;
			}
			echo "</table>";

			echo "<style>#loadTable{display: none;}</style>";
		}
	}
	else if($_GET["page"] == 'Clients')
	{		
		if (!isset($_GET["id"]) || !isset($_GET["client"]))
		{
			echo "Missing parameter!";
		} else 
		{
			$select = "ID, Address, Email, Name, ClientID";
			$where = "";
			$columns = array('ID','Address','Email','Name', 'ClientID');
			if(isset($_GET["id"]))
			{
				$where .= "ID LIKE '" . $_GET["id"]."%' AND ";
			}
			if(isset($_GET["client"]))
			{
				$where .= "Name LIKE '" . $_GET["client"]."%'";
			}
			$sql = "SELECT " . $select . " FROM clients WHERE " . $where;
			$result = $mysqli->query($sql);
			echo "<table class='dataTable display table-striped' id='searchTable'>
			<tr>
			<th>ID</th>		
			<th>Address</th>	
			<th>Email</th>
			<th>Name</th>
			<th>ClientID</th>
			<th colspan='2'>Action</th>
			</tr>";

			$pom = 0;
			while($row = $result->fetch_object())
			{
				echo "<tr>";
				foreach ($columns as $key => $value) 
				{		
					echo "<td>" . $row->$value . "</td>";
				}
				echo "<td><a href='client.php?action=edit_formC&id=" . $row->ID . "&name=" . $row->Name . "&address=" . $row->Address . "&clientid=" . $row->ClientID . "&email=" . $row->Email . "; ?>' name='Edit" . $pom . " id='Edit" . $pom . "'><input type='button' class='btn btn-primary' value='Edit' /></a></td>";
				echo "<td><a href='?action=deleteC&id=" . $row->ID . "' name='Delete" . $pom . "'><input type='button' class='btn btn-primary' value='Delete' /></a></td>";
				$pom++;
			}
			echo "</table>";

			echo "<style>#loadTable{display: none;}</style>";
		}
	}
	$mysqli->close();
?>
