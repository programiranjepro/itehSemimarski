$(document).ready(function () 
			{
				$(".display").DataTable(
				{
					deferRender:    true,
			        scrollY:        200,
			        scrollCollapse: true,
			        scroller:       true,
			 		"language": {
	                "url": "dataTables/DataTables-1.10.20/i18n/serbian.json"
			            }
				});



				$("#id").keyup(function()
				{
					var value = $("#id").val();
					if(value != "") 
					{
						$.get("suggest.php", 
						{ 
							id: value 
						},
				   		function(data)
				   		{
						    $("#livesearchId").show();
						    $("#livesearchId").html (data);
						});
					} else 
					{
						document.getElementById("livesearchId").innerHTML = "";
						document.getElementById("livesearchId").style.display = "none";
					}
				});

				$("#user").keyup(function()
				{
					var value = $("#user").val();
					if(value != "") 
					{
						$.get("suggest.php", 
						{ 
							user: value 
						},
				   		function(data)
				   		{
						    $("#livesearchUser").show();
						    $("#livesearchUser").html (data);
						});
					}
					else 
					{
						document.getElementById("livesearchUser").innerHTML = "";
						document.getElementById("livesearchUser").style.display = "none";
					}

				});

				$("#client").keyup(function()
				{
					var value = $("#client").val();
					if(value != "") 
					{
						$.get("suggest.php", 
						{ 
							client: value 
						},
				   		function(data)
				   		{
						    $("#livesearchClient").show();
						    $("#livesearchClient").html (data);
						});
					} else 
					{
						document.getElementById("livesearchClient").innerHTML = "";
						document.getElementById("livesearchClient").style.display = "none";
					}
				});

				$("#status").keyup(function()
				{
					var value = $("#status").val();
					if(value != "") 
					{
						$.get("suggest.php", 
						{ 
							status: value 
						},
				   		function(data)
				   		{
						    $("#livesearchStatus").show();
						    $("#livesearchStatus").html (data);
						});
					} else 
					{
						document.getElementById("livesearchStatus").innerHTML = "";
						document.getElementById("livesearchStatus").style.display = "none";
					}
				});

				$("#heading").keyup(function()
				{
					var value = $("#heading").val();
					if(value != "") 
					{
						$.get("suggest.php", 
						{ 
							heading: value 
						},
				   		function(data)
				   		{
						    $("#livesearchHeading").show();
						    $("#livesearchHeading").html (data);
						});
					} else 
					{
						document.getElementById("livesearchHeading").innerHTML = "";
						document.getElementById("livesearchHeading").style.display = "none";
					}
				});

				$("#dateFrom").keyup(function()
				{
					var value = $("#dateFrom").val();
					if(value != "") 
					{
						$.get("suggest.php", 
						{ 
							dateFrom: value 
						},
				   		function(data)
				   		{
						    $("#livesearchDateFrom").show();
						    $("#livesearchDateFrom").html (data);
						});
					} else 
					{
						document.getElementById("livesearchDateFrom").innerHTML = "";
						document.getElementById("livesearchDateFrom").style.display = "none";
					}
				});

				$("#dateTo").keyup(function()
				{
					var value = $("#dateTo").val();
					if(value != "") 
					{
						$.get("suggest.php", 
						{ 
							dateTo: value 
						},
				   		function(data)
				   		{
						    $("#livesearchDateTo").show();
						    $("#livesearchDateTo").html (data);
						});
					} else 
					{
						document.getElementById("livesearchDateTo").innerHTML = "";
						document.getElementById("livesearchDateTo").style.display = "none";
					}
				});

				$("#searchButton").click(function()
				{
					var li = document.getElementById('searchButton').className;

					if(li.split(' ')[0] == 'searchButtonIndex')
					{
						var id = $("#id").val();
						var user = $("#user").val();
						var client = $("#client").val();
						var status = $("#status").val();
						var heading = $("#heading").val();
						var dateFrom = $("#dateFrom").val();
						var dateTo = $("#dateTo").val();

						$.get("searchBy.php", 
						{ 
							id: id,
							user: user,
							client: client,
							status: status,
							heading: heading,
							dateFrom: dateFrom,
							dateTo: dateTo,
							page: 'Index'
						},
						function(data)
						{
							$("#tickets_table").html (data);
						});
					}
					else if(li.split(' ')[0] == 'searchButtonUsers')
					{
						var id = $("#id").val();
						var user = $("#user").val();

						$.get("searchBy.php", 
						{ 
							id: id,
							user: user,
							page: 'Users'
						},
						function(data)
						{
							$("#tickets_table").html (data);
						});
					}
					else if(li.split(' ')[0] == 'searchButtonStatuses')
					{
						var id = $("#id").val();
						var status = $("#status").val();

						$.get("searchBy.php", 
						{ 
							id: id,
							status: status,
							page: 'Statuses'
						},
						function(data)
						{
							$("#tickets_table").html (data);
						});
					}
					else if(li.split(' ')[0] == 'searchButtonClients')
					{
						document.getElementById("import").disabled = false;
						document.getElementById("importedJSON").style.display = 'none';
						document.getElementById("createNew").style.display = 'none';
						var id = $("#id").val();
						var client = $("#client").val();

						$.get("searchBy.php", 
						{ 
							id: id,
							client: client,
							page: 'Clients'
						},
						function(data)
						{
							$("#tickets_table").html (data);
						});
					}
				});
			});

			function place(ele, eleID)
			{
				if(eleID == 'id')
				{
					$("#id").val(ele.innerHTML);
					$("#livesearchId").hide();
				}
				else if(eleID == 'user')
				{
					$("#user").val(ele.innerHTML);
					$("#livesearchUser").hide();
				}
				else if(eleID == 'client')
				{
					$("#client").val(ele.innerHTML);
					$("#livesearchClient").hide();
				}
				else if(eleID == 'status')
				{
					$("#status").val(ele.innerHTML);
					$("#livesearchStatus").hide();
				}
				else if(eleID == 'heading')
				{
					$("#heading").val(ele.innerHTML);
					$("#livesearchHeading").hide();
				}
				else if(eleID == 'dateFrom')
				{
					$("#dateFrom").val(ele.innerHTML);
					$("#livesearchDateFrom").hide();
				}
				else if(eleID == 'dateTo')
				{
					$("#dateTo").val(ele.innerHTML);
					$("#livesearchDateTo").hide();
				}
			}