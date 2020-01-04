<?php
	Class DBMachine
	{
		public function FillDropList($table, $columnToShow, $columnToReturn, $elementID, $label)
		{
			include "connection.php";
			$orderedColumnToReturn = "";
			$sql="SELECT $columnToShow, $columnToReturn FROM $table ORDER BY $columnToShow";
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
				$numResults = $q->num_rows;
				$counter = 0;
				echo "<div class='col-6 right'>
					<label for='".$elementID."'>".$label."</label>";
					if($table == 'statuses')
					{
						echo "<select id='".$elementID."' class='col-6' name='".$elementID."'' disabled>";
					} else
					{
						echo "<select id='".$elementID."' class='col-6' name='".$elementID."''>";
					}
					echo "<option value=''></option>";
						while ($row = $q->fetch_object())
						{
							$orderedColumnToReturn = ++$counter == $numResults ? $orderedColumnToReturn."".$row->$columnToReturn : $orderedColumnToReturn."".$row->$columnToReturn.",";
							echo "<option value='".$row->$columnToShow."'>".$row->$columnToShow."</option>";
						}
				echo "
					</select>
				</div>";
			}
			$mysqli->close();
			return $orderedColumnToReturn;
		}

		public function CreateNew($columns, $table, $like, $reper)
		{
			if (isset($_POST["createNew"]))
			{
				include "connection.php";

				$passed = true;
				foreach ($columns as $key => $value) {
					$passed = $passed && isset($_POST[$value]);
				}
				if ($passed)
				{
					$checking = "";
					if($table == 'statuses')
					{
						$StatusName = $_POST['StatusName'];
						$IsActive = $_POST['IsActive'] == "yes" ? 1 : 0;
						$checking = "select $reper FROM $table WHERE $reper LIKE '$StatusName'";
					}
					else if($table == 'users')
					{
						$FirstName = $_POST['FirstName'];
						$LastName = $_POST['LastName'];
						$Email = $_POST['Email'];
						$Password = $_POST['Password'];
						$checking = "select $reper FROM $table WHERE $reper LIKE '$Email'";
					}
					else if($table == 'tickets')
					{
						$Heading = $_POST['Heading'];
						$IDClient = $_POST['IDClient'];
						$IDStatus = $_POST['IDStatus'];
						$EmailForIDUser = $_SESSION['email'];					
						$sqlIDUser = "SELECT ID FROM users WHERE Email LIKE '$EmailForIDUser'";
						$IDUser = "";	
						if (!$q=$mysqli->query($sqlIDUser))
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
								$IDUser = $row->ID;
							}
						}
						$Description = $_POST['Description'];
						$checking = true;
					}
					else if($table == 'clients')
					{
						$Name = $_POST['Name'];
						$Address = $_POST['Address'];
						$Email = $_POST['Email'];
						$ClientID = $_POST['ClientID'];
						$checking = "select $reper FROM $table WHERE $reper LIKE '$ClientID'";
					}

					if($checking)
					{
						$sql = "";
						if($table == 'statuses')
						{
							$sql = "INSERT INTO statuses (StatusName, IsActive) VALUES ('".$StatusName."', '".$IsActive."')";
						} 
						else if($table == 'users')
						{
							$sql = "INSERT INTO users (FirstName, LastName, Email, Password) 
							VALUES ('".$FirstName."', '".$LastName."', '".$Email."', '".$Password."')";						
						}
						else if($table == 'tickets')
						{
							$sql = "INSERT INTO tickets (Heading, IDClient, IDStatus, CreateDate, IDUser, Description) 
							VALUES ('".$Heading."', '".$IDClient."', '".$IDStatus."', '".date("Y").
							"".date("m")."".date("d")."', '".$IDUser."', '".$Description."')";			
						}
						else if($table == 'clients')
						{
							$sql = "INSERT INTO clients (Name, Address, Email, ClientID) 
							VALUES ('".$Name."', '".$Address."', '".$Email."', '".$ClientID."')";						
						}

						if ($mysqli->query($sql))
						{
							echo "<p class='info alert alert-success'>Saved!</p>";
						} else 
						{
							echo "<p class='info alert alert-danger'>Element already exists!</p>";
						}
					}
				} else 
				{
					echo "<p class='info alert alert-danger'>Missing parameters!</p>";
				}

				$mysqli->close();
			}
		}

		public function FillTable($columns, $databaseTable, $order, $join = "")
		{
			include "connection.php";
			$select = $databaseTable == 'tickets t' ? "Description, " : "ID, ";
			foreach ($columns as $key => $value) {
				$select = $key == 0 ? $select . '' . $value : $select . ', ' . $value;
			}

			$sql="SELECT $select FROM $databaseTable ".$join." ORDER BY $order";

			if (!$q=$mysqli->query($sql))
			{
				echo "<p class='info alert alert-danger'>Error!</p>";
				exit();
			}
			if ($q->num_rows==0)
			{
				echo "<p class='info alert alert-success'>Table is empty!</p>";
			} else 
			{
				?>
				<table class="display dataTable table-striped" id="loadTable">
					<thead>
						<tr>
							<?php
								foreach ($columns as $key => $value) 
								{			
									$p = $databaseTable == 'tickets t' ? substr($value, 2) : $value;	
									echo "<th>" . $p . "</th>";
								}
								echo "<th>Edit</th>";
								echo "<th>Delete</th>";
							?>
						</tr>
					</thead>
					<tbody>
					<?php
						$pom = 0;
						while ($row = $q->fetch_object())
						{
							echo "<tr>";
							$indexNo = $row->ID;
							foreach ($columns as $key => $value) 
							{							
								$p = $databaseTable == 'tickets t' ? substr($value, 2) : $value;
								echo "<td>" . $row->$p . "</td>";
							}
							if($databaseTable == 'statuses')
							{
								echo "<td><a href='status.php?action=edit_form&id=" . $indexNo . "&elem=" . $row->StatusName . "; ?>' name='Edit" . $pom . " id='Edit" . $pom . "'><input type='button' class='btn btn-primary' value='Edit' /></a></td>";
								echo "<td><a href='?action=delete&id=" . $indexNo . "' name='Delete" . $pom . "'><input type='button' class='btn btn-primary' value='Delete' /></a></td>";
							} 
							else if($databaseTable == 'users')
							{
								echo "<td><a href='user.php?action=edit_formU&id=" . $indexNo . "&last=" . $row->LastName . "&first=" . $row->FirstName . "&email=" . $row->Email . "; ?>' name='Edit" . $pom . " id='Edit" . $pom . "'><input type='button' class='btn btn-primary' value='Edit' /></a></td>";
								echo "<td><a href='?action=deleteU&id=" . $indexNo . "' name='Delete" . $pom . "'><input type='button' class='btn btn-primary' value='Delete' /></a></td>";
							} 
							else if($databaseTable == 'tickets t')
							{
								echo "<td><a href='ticket.php?action=edit_formT&id=" . $indexNo . "&heading=" . $row->Heading . "&client=" . $row->Name . "&status=" . $row->StatusName . "&description=" . $row->Description . "; ?>' name='Edit" . $pom . " id='Edit" . $pom . "'><input type='button' class='btn btn-primary' value='Edit' /></a></td>";
								echo "<td><a href='?action=deleteT&id=" . $indexNo . "' name='Delete" . $pom . "'><input type='button' class='btn btn-primary' value='Delete' /></a></td>";
							}
							else if($databaseTable == 'clients')
							{
								echo "<td><a href='client.php?action=edit_formC&id=" . $indexNo . "&name=" . $row->Name . "&address=" . $row->Address . "&clientid=" . $row->ClientID . "&email=" . $row->Email . "; ?>' name='Edit" . $pom . " id='Edit" . $pom . "'><input type='button' class='btn btn-primary' value='Edit' /></a></td>";
								echo "<td><a href='?action=deleteC&id=" . $indexNo . "' name='Delete" . $pom . "'><input type='button' class='btn btn-primary' value='Delete' /></a></td>";
							}
							
							$pom++;
							echo "</tr>";
						}
					?>
					</tbody>
				</table>
				<?php
			}
			$mysqli->close();
		}
	}

	include "connection.php";	

	if (isset ($_GET['action']) && isset ($_GET['id']))
	{
		$action = $_GET['action'];
		$id = $_GET['id'];
		switch ($action)
		{
			case "delete":
			$queryDelete = "DELETE FROM statuses WHERE ID = " . $id;
			if (!$q=$mysqli->query($queryDelete))
			{
				echo "<p class='info alert alert-danger'>Error!</p><br/>";
				die();
			} else 
			{
				echo "<p class='info alert alert-success'>Deleted!</p>";
			}
			break;
			case "deleteU":
			$queryDelete = "DELETE FROM users WHERE ID = " . $id;
			if (!$q=$mysqli->query($queryDelete))
			{
				echo "<p class='info alert alert-danger'>Error!</p><br/>";
				die();
			} else 
			{
				echo "<p class='info alert alert-success'>Deleted!</p>";
			}
			break;
			case "deleteT":
			$queryDelete = "DELETE FROM tickets WHERE ID = " . $id;
			if (!$q=$mysqli->query($queryDelete))
			{
				echo "<p class='info alert alert-danger'>Error!</p><br/>";
				die();
			} else 
			{
				echo "<p class='info alert alert-success'>Deleted!</p>";
			}
			break;
			case "deleteC":
			$queryDelete = "DELETE FROM clients WHERE ID = " . $id;
			if (!$q=$mysqli->query($queryDelete))
			{
				echo "<p class='info alert alert-danger'>Error!</p><br/>";
				die();
			} else 
			{
				echo "<p class='info alert alert-success'>Deleted!</p>";
			}
			break;
			case "edit_form":
				?>
				<input type="submit" id="editStatus" name="unos" class="btn btn-primary createNew" value="Edit" formmethod="POST" formaction="?action=edit&id=<?php echo $_GET['id'];?>"/>
				<style type="text/css"> #createNew{display: none;} #statusForm{text-align: center;}</style>

				<script type="text/javascript">
					const urlParams = new URLSearchParams(window.location.search);
					const elem = urlParams.get('elem');
					var splitElem = elem.split(";");
					document.getElementById("StatusName").value = splitElem[0];				
				</script>
				<?php
			break;
			case "edit_formU":
				?>
				<input type="submit" id="editStatus" name="unos" class="btn btn-primary createNew" value="Edit" formmethod="POST" formaction="?action=editU&id=<?php echo $_GET['id'];?>"/>
				<style type="text/css"> #createNew{display: none;} #statusForm{text-align: center;}</style>

				<script type="text/javascript">
					const urlParams = new URLSearchParams(window.location.search);
					const email = urlParams.get('email');
					const first = urlParams.get('first');
					const last = urlParams.get('last');
					var splitEmail = email.split(";");
					document.getElementById("FirstName").value = first;	
					document.getElementById("LastName").value = last;
					document.getElementById("Email").value = splitEmail[0];			
				</script>
				<?php
			break;
			case "edit_formT":
				?>
				<input type="submit" id="editStatus" name="unos" class="btn btn-primary createNew" value="Edit" onClick="Ticket('edit')" />
				<style type="text/css"> 
					#createNew{display: none;} 
					#statusForm{text-align: center;}
					#editStatus{position: absolute; top: 510px;}	
				</style>

				<script type="text/javascript">
					const urlParams = new URLSearchParams(window.location.search);
					const heading = urlParams.get('heading');
					const client = urlParams.get('client');
					const status = urlParams.get('status');
					const description = urlParams.get('description');
					var splitDescription = description.split(";");
					document.getElementById("Heading").value = heading;
					document.getElementById("Heading").disabled = true;
				</script>
				<?php
			break;
			case "edit_formC":
				?>
				<input type="submit" id="editStatus" name="unos" class="btn btn-primary createNew" value="Edit" formmethod="POST" formaction="?action=editC&id=<?php echo $_GET['id'];?>"/>
				<style type="text/css"> #createNew{display: none;} #statusForm{text-align: center;}</style>

				<script type="text/javascript">
					const urlParams = new URLSearchParams(window.location.search);
					const email = urlParams.get('email');
					const name = urlParams.get('name');
					const address = urlParams.get('address');
					const clientid = urlParams.get('clientid');
					var splitEmail = email.split(";");
					document.getElementById("Name").value = name;	
					document.getElementById("Address").value = address;
					document.getElementById("ClientID").value = clientid;
					document.getElementById("Email").value = splitEmail[0];			
				</script>
				<?php
			break;
			case "edit":
				if (isset ($_POST['StatusName']) && isset ($_POST['IsActive']))
				{	
					$StatusName = $_POST['StatusName'];
					$IsActive = $_POST['IsActive'];
					$idExplode = explode(";", $id);
					$queryEdit="UPDATE statuses SET StatusName='". $StatusName ."', IsActive='" . $IsActive . "' WHERE id=". $idExplode[0];
					if ($mysqli->query($queryEdit))
					{
						if ($mysqli->affected_rows > 0 )
						{
						echo "<p class='info alert alert-success'>Edited!</p>";
						} else {
						echo "<p class='info alert alert-danger'>Error!</p>";
						}
					} else {
					echo "<p class='info alert alert-danger'>Error!</p>" ;
					}
				} else {
				echo "<p class='info alert alert-danger'>Missing parameters!";
				}
				header('Location: ?');
				break;
				case "editU":
				if (isset ($_POST['FirstName']) && isset ($_POST['LastName'])
					&& isset ($_POST['Email']) && isset ($_POST['Password']))
				{	
					$FirstName = $_POST['FirstName'];
					$LastName = $_POST['LastName'];
					$Email = $_POST['Email'];
					$Password = $_POST['Password'];
					$idExplode = explode(";", $id);
					$queryEdit="UPDATE users SET FirstName='". $FirstName ."', LastName='" . $LastName .
						 "', Email='" . $Email . "', Password='" . $Password . "' WHERE id=". $idExplode[0];
					if ($mysqli->query($queryEdit))
					{
						if ($mysqli->affected_rows)
						{
						echo "<p class='info alert alert-success'>Edited!</p>";
						} else {
						echo "<p class='info alert alert-danger'>Error!</p>";
						}
					} else {
					echo "<p class='info alert alert-danger'>Error!</p>" ;
					}
				} else {
				echo "<p class='info alert alert-danger'>Missing parameters!";
				}
				header('Location: ?');
				break;	
				case "editC":
				if (isset ($_POST['Name']) && isset ($_POST['Address']) && isset ($_POST['Email']))
				{	
					$Name = $_POST['Name'];
					$Address = $_POST['Address'];
					$ClientID = $_POST['ClientID'];
					$Email = $_POST['Email'];
					$idExplode = explode(";", $id);
					$queryEdit="UPDATE clients SET Name='". $Name ."', Address='" . $Address .
						 "', ClientID='" . $ClientID . "', Email='" . $Email . "' WHERE id=". $idExplode[0];
					if ($mysqli->query($queryEdit))
					{
						if ($mysqli->affected_rows)
						{
						echo "<p class='info alert alert-success'>Edited!</p>";
						} else {
						echo "<p class='info alert alert-danger'>Error!</p>";
						}
					} else {
					echo "<p class='info alert alert-danger'>Error!</p>" ;
					}
				} else {
				echo "<p class='info alert alert-danger'>Missing parameters!";
				}
				break;			
			default:
				echo "<p class='info alert alert-danger'>Invalid action!</p>";
			break;		
		}
	}	
	$mysqli->close();
?>
