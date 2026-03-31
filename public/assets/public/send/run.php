<?php
### Settings ###################################################################

//error_reporting(0); // Errors output must be disabled by default

define('MailFrom', 'info@'.$_SERVER['HTTP_HOST']);
define('MailTo',   'shamsiddinovs102@gmail.com');
define('RemoveHTML', true);

################################################################################

function validateEmail($email) { // http://stackoverflow.com/a/46181/2252921
	return (preg_match('/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)'.
			'|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])'.
			'|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email) === 1) ? true : false;
}

function exitWithMessage($msg, $code = 0){
	die(json_encode(array('msg' => $msg, 'code' => $code)));
}

function secureClear($text) {
	return htmlspecialchars(strip_tags($text));
}

header('Content-Type: application/json');

// If empty POST - we will die
if(empty($_POST)) {
	header("HTTP/1.0 503 Service Unavailable");
	exitWithMessage('Direct access not allowed');
} elseif(isset($_POST['message']) and is_array($_POST['message'])
	and !empty($_POST['message'])) {

	$message = $_POST['message'];
	$mailTo = (string) '';
	$mailFrom = (string) '';

	// Check mail destination
	if(defined('MailTo') and validateEmail(MailTo))
		$mailTo = MailTo;
	elseif(!empty($message['to'][0]['email'])
		and validateEmail($message['to'][0]['email']))
		$mailTo = $message['to'][0]['email'];
	if(empty($mailTo))
		exitWithMessage('Empty or invalid email address for sending');

	// Check mail sender
	if(defined('MailFrom') and validateEmail(MailFrom))
		$mailFrom = MailFrom;
	elseif(!empty($message['from_email'])
		and validateEmail($message['from_email']))
		$mailFrom = $message['from_email'];
	if(empty($mailFrom))
		exitWithMessage('Empty or invalid email sender');

	// Remove html (if needed)
	if(defined('RemoveHTML') and RemoveHTML) {
		$message['subject'] = secureClear($message['subject']);
		$message['html'] = str_replace(
			array('<strong>', '</strong>', '<b>', '</b>'),
			'##', $message['html']);
		$message['html'] = secureClear($message['html']);
	}

	// Check subject
	if (empty($message['subject'])) exitWithMessage('Empty subject');

	// Check mail body
	if (empty($message['html'])) exitWithMessage('Empty or invalid mail body');

	// Prepare sendmail headers
	$headers = "MIME-Version: 1.0\r\n".
		"Content-Type: text/".((defined('RemoveHTML') and RemoveHTML) ?
			"plain" : "html")."; charset=\"utf-8\"\r\n";

	$headers .= "From: ".$mailFrom."\r\n".
		"Reply-To: ".$mailFrom."\r\n".
		"Return-Path: ".$mailFrom."\r\n";

	// And sending mail
	if(!mail($mailTo,
		'=?UTF-8?B?'.base64_encode($message['subject']).'?=',
		$message['html'],
		$headers)) {
		exitWithMessage('Sendmail server error :(');
	} exitWithMessage('Your message was sent successfully', 1);
}
