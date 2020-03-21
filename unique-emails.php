<?php 
/**
 * This script will check an array of emails and count only the unique emails according to Gmail account matching
 * 
 * Gmail will ignore the placement of "." in the username. And it will ignore any portion of the username after a "+".
 */

// Test Emails
// $emails = [
// 	'test.email@gmail.com',
// 	'test.email+spam@gmail.com',
// 	'testemail@gmail.com'
// ];

if(empty($_POST['emails'])){
	echo 0;
	exit;
}

// Track any errors
$errors = [];

// Store our unique emails
$unique_emails = [];

if(! empty($_POST['emails']) && is_array($_POST['emails'])){
	foreach($_POST['emails'] as $email){

		// validate that this is a valid email
		if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors[] = "Invalid email format: ".$email;
		}else{
			// Split our email into username and domain
			$split_emails = explode('@', $email);
			
			// Assuming the 0 and 1 key exist for now since it passed the filter. Production app should probably do more checks
			$username = $split_emails[0]?:'';
			$domain = $split_emails[1]?:'';

			// ignore the placement of "."
			$clean_username = str_replace('.', '', $username);
			// ignore any portion of the username after a "+"
			$clean_username = preg_replace('/\+.*/', '', $clean_username);

			// Recombine our username and domain into our unique email format
			$clean_email = $clean_username.'@'.$domain;

			// If this email does not already exist in our array of unique emails, add it
			if(! in_array($clean_email, $unique_emails)){
				$unique_emails[] = $clean_email;
			}
		}
	}
}

// Return our count
echo count($unique_emails);
exit;