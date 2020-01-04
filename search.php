<h3>Search:</h3>
<hr />
	
<form method="POST" id="search">
	<div class="col-6 col-lg-4" id="divID">	
		<label for="id">Id:</label>
		<input type="text" id="id" class="col-6 col-lg-8" name="id" />
	</div>
	<div id="livesearchId" class="searchIndex"></div>

	<div class="right col-6 col-lg-4" id="divUser">
		<label for="user">User:</label>
		<input type="text" id="user" class="col-6 col-lg-8" name="user" />
	</div>
	<div id="livesearchUser" class="searchIndex"></div>

	<div class="col-6 col-lg-4" id="divClient">
		<label for="client">Client:</label>
		<input type="text" id="client" class="col-6 col-lg-8" name="client" />
	</div>
	<div id="livesearchClient" class="searchIndex"></div>

	<div class="right col-6 col-lg-4" id="divStatus">				
		<label for="status">Status:</label>
		<input type="text" id="status" class="col-6 col-lg-8" name="status" />
	</div>
	<div id="livesearchStatus" class="searchIndex"></div>
				
	<div class="col-6 col-lg-4" id="divHeading">
		<label for="heading">Heading:</label>
		<input type="text" id="heading" class="col-6 col-lg-8" name="heading" />
	</div>
	<div id="livesearchHeading" class="searchIndex"></div>

	<div class="right col-6 col-lg-4" id="divDateFrom">
		<label for="dateFrom">Date from:</label>
		<input type="text" id="dateFrom" class="col-6 col-lg-8" name="dateFrom" />
	</div>
	<div id="livesearchDateFrom" class="searchIndex"></div>

	<div class="col-6 col-lg-4" id="divDateTo">
		<label for="dateTo">Date to:</label>
		<input type="text" id="dateTo" class="col-6 col-lg-8" name="dateTo" />
	</div>
	<div id="livesearchDateTo" class="searchIndex"></div>

	<input type="button" name="search" id="searchButton" class="searchButtonIndex btn btn-primary" value="Search" />
</form>

<hr />

<form id="searchNew" action="ticket.php" name="new">
	<input id="create" type="submit" name="create" class="btn btn-primary" value="New" />
</form>
<div id="tickets_table"></div>		