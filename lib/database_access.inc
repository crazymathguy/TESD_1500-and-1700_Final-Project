<?php
	$dbname = "library_management";
	$hostname = "localhost";
	$username = "webuser";
	$password = "myL!brary73";

	$db = mysqli($hostname, $username, $password, $dbname);
	if (mysqli_connect_errno()) {
		throw new Exception("Couldn't connect to the database.");
	}
?>