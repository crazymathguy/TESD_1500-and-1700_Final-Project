<!DOCTYPE html>
<html>
<head>
	<!--
		Library Management Login Page
		Author: Sean Briggs
		Date Created: 2026-02-17

		Filename: login.php
	-->

	<title>Sean's Library Management</title>
</head>

<body>
	<header>
		<h1>Sean's Library Management</h1>
	</header>
	<?php
		if (!isset($_GET['new'])) {
			$title = 'Please Log In';
			$link = 'Don\'t have an account? <a href="login.php?new=true">Sign Up</a>';
		}
		else {
			$title = 'Create an Account';
			$link = 'Already have an account? <a href="login.php">Log In</a>';
		}
		echo '<h2>'.$title.'</h2>';
	?>
	<form action="login.php" method="post">
		<label for="user">Username:</label>
		<input type="text" name="user" id="user" size="20" maxlength="30" /><br />
		<label for="pass">Password:</label>
		<input type="password" name="pass" id="pass" size="20" /><br />
		<input type="submit" value="Login" />
	</form>
	<?php
		echo '<p>'.$link.'</p>';
	?>
</body>
</html>