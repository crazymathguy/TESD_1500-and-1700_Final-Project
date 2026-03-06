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
	<script src="lib/javascript/newItem.js" defer></script>
	<link href="lib/styles/styles.css" rel="stylesheet" />
	<link href="lib/styles/tableAndForm.css" rel="stylesheet" />
	<title>Personal Library Manager</title>
</head>

<body>
	<header>
		<h1>Personal Library Management System</h1>
		<?php
			echo '<h2>Welcome '.$_SESSION['user'].'!</h2>';
			echo '</header>';

			$db = new mysqli($hostname, $username, $password, $dbname);
			if (mysqli_connect_errno()) {
				echo '<p>Couldn\'t connect to the database.<br />
					Please try again later</p>';
				exit;
			}
		?>
	<h2>Your Library</h2>
	<input type="button" id="new" value="Add New Item" onclick="AddNew()" />
	<table id="collectionTable">
		<tr>
			<th>ISBN</th>
			<th>Author</th>
			<th>Title</th>
			<th>Shelf Location</th>
			<th>Item Location</th>
		</tr>
		<?php
			$query = "SELECT ISBN, Author, Title, `Shelf Location`, `Item Location`
				FROM `".$_SESSION['user']."` LIMIT 25";
			$stmt = $db->prepare($query);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($isbn, $author, $title, $shelf, $item);

			while ($stmt->fetch()) {
				echo '<tr>';
				echo '<td>'.$isbn.'</td>';
				echo '<td>'.$author.'</td>';
				echo '<td>'.$title.'</td>';
				echo '<td>'.$shelf.'</td>';
				echo '<td>'.$item.'</td>';
				echo '</tr>';
			}
			$stmt->close();

			$db->close();
		?>
	</table>
</body>
</html>