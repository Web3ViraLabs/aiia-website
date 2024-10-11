<?php

// Define some constants
define("RECIPIENT_NAME", "Aiia-Enquiry");
define("RECIPIENT_EMAIL", "web3viralabs@gmail.com"); // Replace with your actual email

// Read the form values
$success = false;
$userName = isset($_POST['name']) ? preg_replace("/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['name']) : "";
$senderEmail = isset($_POST['email']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email']) : "";
$userSubject = isset($_POST['subject']) ? preg_replace("/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['subject']) : "";
$message = isset($_POST['message']) ? preg_replace("/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message']) : "";

// If all values exist, send the email
if ($userName && $senderEmail && $userSubject && $message) {
    $recipient = RECIPIENT_NAME . " <" . RECIPIENT_EMAIL . ">";
    $headers = "From: " . $userName . " <" . $senderEmail . ">\r\n";
    $headers .= "Reply-To: " . $senderEmail . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    $msgBody = "
    <html>
    <body>
        <h2>New Contact Form Submission</h2>
        <p><strong>Name:</strong> {$userName}</p>
        <p><strong>Email:</strong> {$senderEmail}</p>
        <p><strong>Service:</strong> {$userSubject}</p>
        <p><strong>Message:</strong></p>
        <p>{$message}</p>
    </body>
    </html>
    ";
    
    $success = mail($recipient, "New Contact Form Submission: {$userSubject}", $msgBody, $headers);

    if ($success) {
        // Set Location After Successful Submission
        header('Location: index.html?message=Successful');
    } else {
        // Set Location After Unsuccessful Submission due to mail() failure
        header('Location: index.html?message=MailFailed');
    }
} else {
    // Set Location After Unsuccessful Submission due to missing fields
    header('Location: index.html?message=Failed');
}

exit();
?>