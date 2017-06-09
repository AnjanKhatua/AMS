<?php
	// Authorisation details.
	$username = "shinningtech@gmail.com";
	$hash = "bc8562793de90f3fec38524837d172a5a68f3b06";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "0";

	// Data for text message. This is the text message data.
	$sender = "TXTLCL"; // This is who the message appears to be from.
	$numbers = "917551060147"; // A single number or a comma-seperated list of numbers
	$message = "Hi Royes, You are booked at J K Radclip Hospital on 21-07-2016 00:00 to 21-07-2016 14:00, %0aat Wasthills
 on 27-07-2016 07:00 to 27-07-2016 19:00.";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
	$message = urlencode($message);
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
	echo 'Hi';
?>
