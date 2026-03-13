<?php
	session_start();

	header("Content-Type: application/json");
	// Prevent the browser from caching the database results
	header("Cache-Control: no-cache, no-store, must-revalidate");

	require('database_access.inc');
	$db = mysqli_connect($hostname, $username, $password, $dbname);
	if ($db->connect_error) {
		echo json_encode(["error" => "Connection failed: " . $db->connect_error]);
		exit;
	}

	if (empty($_SESSION['user'])) {
		echo json_encode(["error" => "No user in session"]);
		exit;
	}

	$table = preg_replace('/[^A-Za-z0-9_]/', '', $_SESSION['user']);
	if ($table === '') {
		echo json_encode(["error" => "Invalid user/table name"]);
		exit;
	}

	$query = "SELECT * FROM `" . $table . "` LIMIT 50";
	$result = $db->query($query);

	$data = [];

	if ($result) {
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		$result->free();
	}

	$db->close();

	echo json_encode($data);
?>