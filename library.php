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
?>
<!DOCTYPE html>
<html>
<head>
	<script src="lib/javascript/buttonScripts.js" defer></script>
	<script src="lib/javascript/displayTable.js" defer></script>
	<link href="lib/styles/styles.css" rel="stylesheet" />
	<link href="lib/styles/tableAndForm.css" rel="stylesheet" />
	<title>Personal Library Manager</title>
</head>

<body>
	<header>
		<h1>Personal Library Management System</h1>
		<?php
			echo '<h2>Welcome '.$_SESSION['user'].'!</h2>';
		?>
	</header>
	<article>
		<h2>Your Library</h2>
		<button id="newItem" onclick="AddNew()">Add New Item</button>
		<table id="collectionTable">
			<thead>
			</thead>
			<tbody>
			</tbody>
		</table>
	</article>
</body>
</html>