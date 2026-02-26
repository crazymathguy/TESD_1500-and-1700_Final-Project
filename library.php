<!--
	Library Management Main Access Page
	Author: Sean Briggs
	Date Created: 2026-02-24

	Filename: library.php
-->

<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header("Location: login.php");
	}
	require('lib/database_access.inc');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Personal Library Manager</title>
</head>

<body>
	<header>
		<h1>Personal Library Management System</h1>
	</header>
	<h2>Your Library</h2>
	<table>
		<tr>
			<th>ISBN</th>
			<th>Author</th>
			<th>Title</th>
			<th>Shelf Location</th>
			<th>Item Location</th>
		</tr>
	</table>
</body>
</html>