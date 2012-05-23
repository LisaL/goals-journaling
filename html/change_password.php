<?php
// Password change form.
require ('includes/config.inc.php'); 
$page_title = 'Change Your Password';
include ('includes/header.html');

// If no user id session variable exists, redirect the user:
if (!isset($_SESSION['user_id'])) {
	
	$url = BASE_URL . 'index.php'; // Define the URL.
	ob_end_clean(); // Clear the output buffer.
	header("Location: $url");
	exit();
	
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require (MYSQL);
			
	// Check for a new password and match against the confirmed password:
	$p = FALSE;
	if (preg_match ('/^(\w){6,20}$/', $_POST['password1']) ) {
		if ($_POST['password1'] == $_POST['password2']) {
			$p = mysqli_real_escape_string ($dbc, $_POST['password1']);
		} else {
			echo '<p class="error">Your password did not match the confirmed password!</p>';
		}
	} else {
		echo '<p class="error">Please enter a valid password.</p>';
	}
	
	if ($p) { // If everything checks out.

		// Update user table:
		$q = "UPDATE users SET pass=SHA1('$p') WHERE user_id={$_SESSION['user_id']} LIMIT 1";	
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			// Send an email as needed.
			echo '<h3>Your password has been changed.</h3>';
			mysqli_close($dbc); // Close database connection.
			include ('includes/footer.html'); // Include HTML footer.
			exit();
			
		} else { // If password change not complete.
		
			echo '<p class="error">Your password was not changed. Please ensure your new password is different than the current password. Contact us if you are still having issues.</p>'; 

		}

	} else { // Failed validation test.
		echo '<p class="error">Please try again.</p>';		
	}
	
	mysqli_close($dbc); // Close database connection.

}







































?>

<h1>Change Password</h1>

<form action="change_password.php" method="post">
	<fieldset>
	<p><b>New Password:</b> <input type="password" name="password1" size="20" maxlength="20" /> <small>Use only letters, numbers, and the underscore. Must be between 4 and 20 characters long.</small></p>
	<p><b>Confirm New Password:</b> <input type="password" name="password2" size="20" maxlength="20" /></p>
	</fieldset>
	<div align="center"><input type="submit" name="submit" value="Change My Password" /></div>
</form>

<?php include ('includes/footer.html'); ?>