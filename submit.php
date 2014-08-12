<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
require_once 'utils.php';
require_once "class.phpmailer.php";

$to = "dncox54@gmail.com";
$to = "urubu715@gmail.com";

if (isset($_POST['txtCaptcha'])) {
	$addr = $_SERVER['REMOTE_ADDR'];
	$browser = $_SERVER['HTTP_USER_AGENT'];
	$host = '';
	if (!empty($_SERVER['REMOTE_HOST'])) {
		$host = $_SERVER['REMOTE_HOST'];
	}
	$timeStamp = date("d/M/Y:H:i:s O");

	if ( ($_POST["txtCaptcha"] == $_SESSION["security_code"]) && 
		(!empty($_POST["txtCaptcha"]) && !empty($_SESSION["security_code"])) ) {
			// correct code
	} else {
		$title = "Home";
		require_once 'head.php';
		echo '<div align="center">The letters/numbers you entered were not correct.  Please try again.<br><br>If you cannot see the characters in the image, try clicking the "Change Image" button.</div>';
		require_once 'foot.php';
		die();
	}
	
	$message =  "<b>".$_POST['contact_name']."</b> from <i>".$_POST['company_name']
				."</i>, (".$_POST['email'].") sent you the following through the SmallerSchools website:<br><br>";
	$message .= $_POST['comments'].'<br><br><hr>Time sent: '.$timeStamp.
									  '<br>IP addr: '.$addr.
									  '<br>Host: '.$host.
									  '<br>Browser: '.$browser.'<br><br><hr>';
	

	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
	$mail->IsSMTP(); // telling the class to use SMTP

	try {
		$mail->ClearAllRecipients(); // clears all addresses, ccs, and bccs
		$mail->ClearAttachments();
		$mail->ClearReplyTos();
		$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
		$mail->Username   = "coxwebdev@gmail.com";  // GMAIL username
		$mail->Password   = base64_decode("amRjMTQyMCs=");            // GMAIL password
		$mail->AddReplyTo(mysql_escape_string($_POST['email']), mysql_escape_string($_POST['email']));
		$mail->AddAddress($to, $to);
		$mail->SetFrom('coxwebdev@gmail.com', 'Smaller Schools Contact Page');
		$mail->Subject = "Comment from website";
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
		$mail->MsgHTML(mysql_escape_string($message));
		$mail->Send();
		echo "Message Sent OK</p>\n";
		echo'<script>alert("Your message was submitted successfully!  Thank you again for your time."); window.location=\'http://www.smallerschools.org\';</script></head></html>';
	} catch (phpmailerException $e) {
//		echo $e->errorMessage(); //Pretty error messages from PHPMailer
		echo '<script>alert("There was a problem with your submission.  Please try again."); window.history.go(-1);</script></head></html>';
	} catch (Exception $e) {
		//echo $e->getMessage(); //Boring error messages from anything else!
		echo '<script>alert("There was a problem with your submission.  Please try again."); window.history.go(-1);</script></head></html>';
	}

}
?>