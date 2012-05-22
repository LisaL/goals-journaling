<?php #
/* 
 * Define constants and settings
 * Set error handling
 * Define useful functions
 */
 
// Member registration system

// ************ BEGIN SETTINGS ************ //

// Flag variable for site status:
define('LIVE', FALSE);

// Admin contact address:
define('EMAIL', 'doanew@doanew.com');

// Site URL (base for all redirections):
define ('BASE_URL', 'http://www.doanew.com/');

// Location of MySQL connection script:
define ('MYSQL', '/path/to/mysqli_connect.php');

// Adjust time zone for PHP 5.1 and greater:
date_default_timezone_set ('US/Pacific');

// ************ END SETTINGS ************ //


// ************ BEGIN ERROR MANAGEMENT ************ //

// Create error handler:
function my_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {

	// Build error message:
	$message = "An error occurred in script '$e_file' on line $e_line: $e_message\n";
	
	// Add date and time:
	$message .= "Date/Time: " . date('n-j-Y H:i:s') . "\n";
	
	if (!LIVE) { // Development (print the error).

		// Show the error message:
		echo '<div class="error">' . nl2br($message);
	
		// Add variables and backtrace:
		echo '<pre>' . print_r ($e_vars, 1) . "\n";
		debug_print_backtrace();
		echo '</pre></div>';
		
	} else { // Withold error:

		// Send email to admin:
		$body = $message . "\n" . print_r ($e_vars, 1);
		mail(EMAIL, 'Site Error!', $body, 'From: errmail@errmail.com');
	
		// Only print an error message if the error isn't a notice:
		if ($e_number != E_NOTICE) {
			echo '<div class="error">A system error occurred. We apologize for the inconvenience. <br />The error has been logged and we will look into it. Thank you.</div><br />';
		}
	} // End of !LIVE IF.

} // End my_error_handler() definition.

// Use my error handler:
set_error_handler ('my_error_handler');

// ************ END ERROR MANAGEMENT ************ //