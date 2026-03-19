<!--
	Library Management New Item Page
	Author: Sean Briggs
	Date Created: 2026-02-17

	Filename: newItem.php
-->

<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header("Location: ../login.php");
	}
	require('database_access.inc');

	$db = new mysqli($hostname, $username, $password, $dbname);
	if (mysqli_connect_errno()) {
		echo json_encode(["error" => "Couldn\'t connect to the database.
			Please try again later."]);
		exit;
	}

	$row = intval($_POST['row']);
	$isbn = htmlspecialchars(trim($_POST['isbn']));
	$author = htmlspecialchars(trim($_POST['author']));
	$title = htmlspecialchars(trim($_POST['title']));
	$shelf = htmlspecialchars(trim($_POST['shelf']));
	$item = intval($_POST['item']);

	if ($item < 0 || $item > 255) {
		echo json_encode(["error" => "Item Location must be between 0 and 255.
			Please try again."]);
		exit;
	}

	$table = preg_replace('/[^A-Za-z0-9_]/', '', $_SESSION['user']);
	if ($table === '') {
		echo json_encode(["error" => "Invalid user/table name"]);
		exit;
	}

	$query = "SELECT * FROM `".$table."`
		WHERE `Item ID` = ?";
	$stmt = $db->prepare($query);
	$stmt->bind_param('i', $row);
	if (!$stmt->execute()) {
		$errno = $stmt->errno;
		$err = $stmt->error;
		echo json_encode(["error" => "Database error (".$errno."): "
			.$err]);
		$stmt->close();
		exit;
	}
	$stmt->store_result();

	if ($stmt->num_rows == 0) {
		$stmt->close();
		if ($row !== 0) {
			echo json_encode(["error" => "Database not affected."]);
			exit;
		}
		$query = "INSERT INTO `".$table."`
			(ISBN, Author, Title, `Shelf Location`, `Item Location`)
			VALUES (?, ?, ?, ?, ?)";
		$stmt = $db->prepare($query);
		$stmt->bind_param('ssssi', $isbn, $author, $title, $shelf, $item);
		if (!$stmt->execute()) {
			$errno = $stmt->errno;
			$err = $stmt->error;
			echo json_encode(["error" => "Database error (".$errno."): "
				.$err]);
			$stmt->close();
			exit;
		}
		$stmt->close();
	}
	else {
		$stmt->close();
		$query = "UPDATE `".$table."`
			SET ISBN = ?, Author = ?, Title = ?, `Shelf Location` = ?, `Item Location` = ?
			WHERE `Item ID` = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param('ssssii', $isbn, $author, $title, $shelf, $item, $row);
		if (!$stmt->execute()) {
			$errno = $stmt->errno;
			$err = $stmt->error;
			echo json_encode(["error" => "Database error (".$errno."): "
				.$err]);
			$stmt->close();
			exit;
		}
		$stmt->close();
	}
	$db->close();
?>