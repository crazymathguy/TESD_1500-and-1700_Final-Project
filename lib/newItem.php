<!--
	Library Management New Item Page
	Author: Sean Briggs
	Date Created: 2026-02-17

	Filename: newItem.php
-->

<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header("Location: login.php");
	}
	require('database_access.inc');

	$db = new mysqli($hostname, $username, $password, $dbname);
	if (mysqli_connect_errno()) {
		echo '<p>Couldn\'t connect to the database.<br />
			Please try again later</p>';
		exit;
	}

	$isbn = htmlspecialchars(trim($_POST['isbn']));
	$author = htmlspecialchars(trim($_POST['author']));
	$title = htmlspecialchars(trim($_POST['title']));
	$shelf = htmlspecialchars(trim($_POST['shelf']));
	$item = intval($_POST['item']);

	if ($item < 0 || $item > 255) {
		echo '<p>Item Location must be between 0 and 255.<br />
			Please close this page and try again.</p>';
		exit;
	}

	$table = preg_replace('/[^A-Za-z0-9_]/', '', $_SESSION['user']);
	if ($table === '') {
		echo json_encode(["error" => "Invalid user/table name"]);
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
		echo '<p>Database error ('.htmlspecialchars($errno).'): <br />'
			.htmlspecialchars($err).'</p>';
		$stmt->close();
		exit;
	}
	$stmt->close();
	$db->close();
?>