<!--
	Library Management New Item Page
	Author: Sean Briggs
	Date Created: 2026-02-17

	Filename: removeItem.php
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

	$id = intval($_POST['row']);

	$query = "DELETE FROM `".$_SESSION['user']."`
		WHERE `Item ID` = ?";
	$stmt = $db->prepare($query);
	$stmt->bind_param('i', $id);
	if (!$stmt->execute()) {
		$errno = $stmt->errno;
		$err = $stmt->error;
		echo '<p>Database error ('.htmlspecialchars($errno).'): <br />'
			.htmlspecialchars($err).'</p>';
		$stmt->close();
		exit;
	}
	if ($db->affected_rows === 0) {
		echo '<p>No row selected. Please try again.</p>';
		$stmt->close();
		exit;
	}
	$stmt->close();
	$db->close();
?>

<script>
	window.close();
</script>