<?php
	session_start();
	require('lib/database_access.inc');
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
			$db = new mysqli($hostname, $username, $password, $dbname);
			if (mysqli_connect_errno()) {
				echo '<p>Couldn\'t connect to the database.<br />
					Please try again later</p>';
				exit;
			}

			$user = trim($_POST['user']);
			$user = preg_replace('/[[:cntrl:]]+/u', '', $user);
			$raw_pass = trim($_POST['pass']);
			$pass = password_hash($raw_pass, PASSWORD_DEFAULT);

			// enforce server-side length check
			$maxUsername = 30;
			if (mb_strlen($user, 'UTF-8') > $maxUsername) {
				echo '<p>Username must be at most '.$maxUsername.' characters.
					Please return to the previous page and try again.</p>';
				exit;
			}

			if (!empty($_POST['new'])) {
				$checkQ = "SELECT 1 FROM login_info WHERE username = ?";
				$checkSt = $db->prepare($checkQ);
				$checkSt->bind_param('s', $user);
				$checkSt->execute();
				$checkSt->store_result();

				if ($checkSt->num_rows > 0) {
					echo '<p><strong>That username is already taken.</strong><br />
						Please return to the previous page and try again.</p>';
					$checkSt->close();
					exit;
				}
				$checkSt->close();

				$query = "INSERT INTO login_info VALUES (?, ?)";
				$stmt = $db->prepare($query);
				$stmt->bind_param('ss', $user, $pass);
				if (!$stmt->execute()) {
					$errno = $stmt->errno;
					$err = $stmt->error;

					if ($errno === 1062) { // Duplicate entry (race condition)
						echo '<p><strong>That username is already taken.</strong><br />
							Please return to the previous page and try again.</p>';
					} else if ($errno === 1406) { // Username too long to fit in database
						echo '<p><strong>Username must be at most '.$maxUsername.' characters.</strong><br />
							Please return to the previous page and try again.</p>';
					}
					else {
						echo '<p>Database error ('.htmlspecialchars($errno).'): <br />'
							.htmlspecialchars($err).'</p>';
					}
					$stmt->close();
					exit;
				}
				$stmt->close();

				$_SESSION['username'] = $user;
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
				$stmt->fetch();

				if ($stmt->num_rows == 0 || !password_verify($raw_pass, $hash)) {
					echo '<p><strong>Your username or password is incorrect.</strong><br />
						Please return to the previous page and try again.</p>';
					$stmt->close();
					exit;
				}
				$stmt->close();

				echo '<p>Yay! You\'re back!</p>';
			}

			$db->close();
		}
	?>
</body>
</html>