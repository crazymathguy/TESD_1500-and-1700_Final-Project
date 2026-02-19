<?php
	session_start();
?>
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
		if (!isset($_POST['user']) && !isset($_POST['pass'])) {
			if (isset($_GET['new'])) {
				$heading = 'Create an Account';
				$switchPage = 'Already have an account? <a href="login.php">Log In</a>';
			}
			else {
				$heading = 'Please Log In';
				$switchPage = 'Don\'t have an account? <a href="login.php?new=true">Create an Account</a>';
			}
			echo '<h2>'.$heading.'</h2>';
			?>
			<form action="login.php" method="post">
				<label for="user">Username:</label>
				<input type="text" name="user" id="user" size="20" maxlength="30" required /><br />
				<label for="pass">Password:</label>
				<input type="password" name="pass" id="pass" size="20" required /><br />
				<?php
					echo '<input type="hidden" name="new" value="'.isset($_GET['new']).'" />';
				?>
				<input type="submit" value="Login" />
			</form>
			<?php
			echo '<p>'.$switchPage.'</p>';
		}
		else {
			try {
				require('lib/database_access.inc');

				echo '<p>Connected</p>';
				
				$user = trim($_POST['user']);
				$pass = password_hash(trim($_POST['pass']), PASSWORD_DEFAULT);
			}
			catch (Exception $e) {
				echo '<p>An error occurred.<br />Message: '.$e->message.'.</p>';
			}
			if ($_POST['new']) {
				$query = "SELECT username FROM login_info
				WHERE username = ?";
				$stmt = $db->prepare($query);
				$stmt->bind_param('s', $user);
				$stmt->execute();
				$stmt->store_result();

				if ($stmt->num_rows > 0) {
					echo '<p><strong>That username is already taken.</strong><br />
						Please return to the previous page and try again.</p>';
					exit;
				}

				$query = "INSERT INTO login_info VALUES (?, ?)";
				$stmt = $db->prepare($query);
				$stmt->bind_param('ss', $user, $pass);
				$stmt->execute();

				if ($stmt->affected_rows == 0) {
					echo '<p>An error occurred trying to create your account.<br />
						Please try again later.</p>';
					exit;
				}

				$_SESSION['username'] = $user;
				$db->close();

				echo '<p>Yay! New User!</p>';
			}
			else {
				$query = "SELECT `password` FROM login_info
				WHERE username = ?";
				$stmt = $db->prepare($query);
				$stmt->bind_param('s', $user);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($hash);

				if ($stmt->num_rows == 0 || !password_verify($pass, $hash)) {
					echo '<p>Your username or password is incorrect.<br />
						Please return to the previous page and try again.</p>';
					exit;
				}

				echo '<p>Yay! You\'re back!</p>';
			}
		}
	?>
</body>
</html>