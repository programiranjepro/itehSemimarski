function hide(param)
{
	if(param == "users")
	{
		document.getElementById("divClient").style.display = "none";
		document.getElementById("divStatus").style.display = "none";
		document.getElementById("divHeading").style.display = "none";
		document.getElementById("divDateFrom").style.display = "none";
		document.getElementById("divDateTo").style.display = "none";

		document.getElementById("searchButton").className = "searchButtonUsers";
		document.getElementById("searchButton").className += " btn btn-primary";
		document.new.action = "user.php";
	} else if(param == "statuses")
	{
		document.getElementById("divClient").style.display = "none";
		document.getElementById("divUser").style.display = "none";
		document.getElementById("divHeading").style.display = "none";
		document.getElementById("divDateFrom").style.display = "none";
		document.getElementById("divDateTo").style.display = "none";

		document.getElementById("searchButton").className = "searchButtonStatuses";
		document.getElementById("searchButton").className += " btn btn-primary";
		document.new.action = "status.php";
	} else if(param == "clients")
	{		
		document.getElementById("divStatus").style.display = "none";
		document.getElementById("divUser").style.display = "none";
		document.getElementById("divHeading").style.display = "none";
		document.getElementById("divDateFrom").style.display = "none";
		document.getElementById("divDateTo").style.display = "none";

		document.getElementById("searchButton").className = "searchButtonClients";
		document.getElementById("searchButton").className += " btn btn-primary";
		document.new.action = "client.php";
	}
}