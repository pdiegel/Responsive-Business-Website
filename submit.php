<?php

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$emailUsername = filter_var($_ENV['EMAIL_ADDRESS'], FILTER_SANITIZE_EMAIL);
$emailPassword = $_ENV['EMAIL_PASSWORD'];

error_log("Email: $emailUsername");
error_log("Password: $emailPassword");

if (!file_exists(__DIR__ . '/.env')) {
    error_log('No .env file found at ' . __DIR__);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $from = $_POST['email']; // Sender's email, from the form
    $name = $_POST['name']; // Sender's name
    $subject = "Website Inquiry from $name <$from>"; // Email subject
    $businessName = $_POST['business_name'];
    $website = $_POST['business_website'] ?? 'Not provided'; // Optional field 
    $niche = $_POST['target_audience'];
    $challenges = $_POST['challenges'];

    if (!filter_var($from, FILTER_VALIDATE_EMAIL)) {
        echo "Error: Invalid email format";
        exit;
    }

    $message = "You have received a new inquiry:\n\n";
    $message .= "Name: $name\n";
    $message .= "Email: $from\n";
    $message .= "Business Name: $businessName\n";
    $message .= "Business Website: $website\n";
    $message .= "Niche/Industry: $niche\n";
    $message .= "Challenges: $challenges\n";

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'mail.privateemail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $emailUsername;
        $mail->Password = $emailPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom($emailUsername, 'Website Inquiry');
        $mail->addReplyTo($from, $name);
        $mail->addAddress($emailUsername);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = nl2br($message); // Convert newlines to <br> for HTML email
        $mail->AltBody = $message; // Plain-text version for non-HTML email clients

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request type.";
}
