<?php 
// Activates the user's account.
require ('includes/config.inc.php'); 
$page_title = 'Activate Your Account';
include ('includes/header.html');

// If $x and $y don't exist or in wrong format, redirect the user:
if (isset($_GET['x'], $_GET['y']) 
	&& filter_var($_GET['x'], FILTER_VALIDATE_EMAIL)
	&& (strlen($_GET['y']) == 32 )
	) {

	// Update users table:
	require (MYSQL);
	$q = "UPDATE users SET active=NULL WHERE (email='" . mysqli_real_escape_string($dbc, $_GET['x']) . "' AND active='" . mysqli_real_escape_string($dbc, $_GET['y']) . "') LIMIT 1";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	
	// Print feedback message:
	if (mysqli_affected_rows($dbc) == 1) {
		echo "<h3>Your account has been activated. You may now continue to log in.</h3>";
	} else {
		echo '<p class="error">Your account could not be activated. Please re-check the link or contact us with any issues.</p>'; 
	}

	mysqli_close($dbc);

} else { // Redirect home.

	$url = BASE_URL . 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); 

}

include ('includes/footer.html');
?>