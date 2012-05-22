<?php

// Configuration include file:
require ('includes/config.inc.php'); 

// Header include file:
$page_title = '';
include ('includes/header.html');

// Welcome user with their name if they are logged in:
echo '<h1>Hi ';
if (isset($_SESSION['first_name'])) {
	echo ", {$_SESSION['first_name']}";
}
echo '.</h1>';

?>

<p>One thing</p>
<p>Or Another</p>

<?php include ('includes/footer.html'); ?>