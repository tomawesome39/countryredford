<!DOCTYPE html>
<html lang="en-US">
<head>

	<meta charset="utf-8" />
	
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="author" content="Thomas Clark" />
	
	<link rel="stylesheet" href="css/crstyles.css" type="text/css" />
	<link rel="stylesheet" href="css/contactStyles.css" type="text/css" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>Country Reford - Contact Us</title>
	 
	<!--Name:		Thomas Clark
		Email:    tomclark@tomclark.info
		Date(s):  5/24/15
		Comments: Country Redford shows page
	-->

</head> 

<body id="body">
	<header>
		<!--<h1 class="title">Country Redford</h1>-->
		<p class="title"><img src="img/cr_logo.png" class="title_img" alt="Country Redford"/></p>
		<hr class="hr_top" />
		<nav class="nav">
			<ul class="menu">
				<li class="menu_item"><a class="nav_link" href="index.html">Home</a></li>
				<li class="menu_item"><a class="nav_link" href="shows.html">Shows</a></li>
				<li class="menu_item"><a class="nav_link" href="videos.html">Videos</a></li>
				<li class="menu_item"><a class="nav_link, nav_selected" href="contact.php">Contact</a></li>
				<li class="menu_item"><a class="nav_link" href="merch.html">Merch</a></li>
			</ul>
		</nav>
		<hr class="hr_btm" />
	</header>
	
	<div id="main_content_wrapper">
		<div class="main_content">
			<!-- CONTACT FORM GOES HERE -->
			
			
<?php
/*
 * Title: PHP Tutorial 1: Secure Contact Form
 * URL: http://www.matthewwatts.net/tutorials/php-tutorial-1-creating-a-secure-contact-form-for-your-website/
 * For: Processing form data and sending it to a specified E-mail address.
 * Site: matthewwatts.net
 * Author: Matthew Watts
 * Company: Rexibit Web Services - http://www.rexibit.com
 * Last Modified: 2010-09-05
 */

// Main Variables Used Throughout the Script
$domain = "http://www.countryredford.com" . $_SERVER["HTTP_HOST"]; // Root Domain - http://example.com
$siteName = "Country Redford";
$siteEmail = "countryredford@gmail.com";
$er = "";

// Check if the web form has been submitted
if (isset($_POST["contactEmail"])){
	
	/*
	 * Process the web form variables
	 * Strip out any malicious attempts at code injection, just to be safe.
	 * All that is stored is safe html entities of code that might be submitted.
	 */
	$contactName = htmlentities(substr($_POST["contactName"], 0, 100), ENT_QUOTES);
	$contactEmail = htmlentities(substr($_POST["contactEmail"], 0, 100), ENT_QUOTES);
	$messageSubject = htmlentities(substr($_POST["messageSubject"], 0, 100), ENT_QUOTES);
	$messageContent = htmlentities(substr($_POST["messageContent"], 0, 10000), ENT_QUOTES);
	
	/*
	 * Perform some logic on the form data
	 * If the form data has been entered incorrectly, return an Error Message
	 */
	 
	 // Check if the data entered for the E-mail is formatted like an E-mail should be
	if (!eregi('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$', $contactEmail)){
		$er .= 'Please enter a valid e-mail address.<br />';
	}
	
	// Check if all of the form fields contain data before we allow it to be submitted successfully
	if ($contactName == "" || $contactEmail == "" || $messageSubject == "" || $messageContent == ""){
		$er .= 'Your Name, E-mail, Message Subject, and Message Content cannot be left blank.<br />';
	}
	
	// IF NO ERROR - START
	if ($er == ''){
		
		// Prepare the E-mail elements to be sent
		$subject = $messageSubject;
		$message = 
		'<html>
			<head>
			<title>' . $siteName . ': A Contact Message</title>
			</head>
			<body>
			' . wordwrap($messageContent, 100) . '
			</body>
		</html>';
		
		/*
		 * We are sending the E-mail using PHP's mail function
		 * To make the E-mail appear more legit, we are adding several key headers
		 * You can add additional headers later to futher customize the E-mail
		 */
		
		$to = $siteName . ' Contact Form <' . $siteEmail . '>';
		
		// To send HTML mail, the Content-type header must be set
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional Headers
		$headers .= 'From: ' . $contactName . ' <' . $contactEmail . '>' . "\r\n";
		$headers .= 'Reply-To: ' . $contactName . ' <' . $contactEmail . '>' . "\r\n";
		$headers .= 'Return-Path: ' . $contactName . ' <' . $contactEmail . '>' . "\r\n";
		$headers .= 'Date: ' . date("r") . "\r\n";
		$headers .= 'X-Mailer: ' . $siteName . "\r\n";
		
		// And now, mail it
		if (mail($to, $subject, $message, $headers)){
			echo '<div>Thank you for contacting ' . $siteName . '. We will read your message and contact you if necessary.</div>';
		}
		else {
			$er .= 'We weren&#39;t able to send your message. Please contact ' . $siteEmail . '.<br />';
		}
	}
	// IF NO ERROR - END
}

// If web form has not been submitted, show a blank form
else {
	showContactForm();
}

/*
 * If there have been errors, we want to return notification
 * We also want to be nice, and send any data already filled in back so they don't re-enter it
 */

// If there are errors, and the contact E-mail is filled in
if ($er != '' && isset($_POST["contactEmail"])){
	showContactForm($contactName, $contactEmail, $messageSubject, $messageContent, $er);
}

// If there are errors, and the contact E-mail isn't filled in
else if ($er != '' && !isset($_POST["contactEmail"])){
	showContactForm('', '', '', '', $er);
}

// Setup a function to display a contact form
function showContactForm($contactName = "", $contactEmail = "", $messageSubject = "", $messageContent = "", $er = ''){
	echo '<div style="font-weight:bold; margin: 2%; color: red;">' . $er . '</div>
	<form action="' . $_SERVER["REQUEST_URI"] . '" method="post" name="contactForm" class="form">
		<fieldset class="fieldset">
			<ul>
				<li>
					<label for="contactName">Your Name</label><br/>
					<input name="contactName" type="text" size="20" maxlength="100" value="' . $contactName . '" />
				</li>
				<li>
					<label for="contactEmail">Your E-Mail</label><br/>
					<input name="contactEmail" type="text" size="20" maxlength="100" value="' . $contactEmail . '" />
				</li>
				<li>
					<label for="messageSubject">Message Subject</label><br/>
					<input name="messageSubject" type="text" size="20" maxlength="100" value="' . $messageSubject . '" />
				</li>
				<li>
					<label for="messageContent">Message</label><br/>
					<textarea name="messageContent" cols="35" rows="8">' . $messageContent . '</textarea>
				</li>
			</ul>
		</fieldset>
		<fieldset class="submit">
			<input name="submitButton" type="submit" value="Send Message" />
		</fieldset>
	</form>';
}
?>
			
			
		</div>
		<div class="clear"></div>
	</div>

	<div class="clear"></div>
	
	<footer id="footer">
		<p class="foot_text">Country Redford &copy; 2015&nbsp;&nbsp; | &nbsp;&nbsp;Web design by <a href="http://www.tomclark.info">Thomas Clark</a></p>
	</footer>
	
</body>
</html>
