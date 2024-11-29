<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php'; // Ensure PHPMailer is loaded with the correct path

function sendEmail($to, $username, $subject, $body, $altBody, $fromEmail, $fromName) {
    $mail = new PHPMailer(true);

    // Load SMTP configuration from file
    $smtpConfig = include 'smtp_config.php'; // Ensure this path is correct relative to the `conf` folder

    try {
        // Debugging - Toggle verbose output for development (2 for detailed debugging)
        $mail->SMTPDebug = 2; // Use 2 for detailed output during development; set to 0 for production
        $mail->Debugoutput = function ($str, $level) {
            // Create log file in the 'logs' directory within the project root
            file_put_contents(__DIR__ . '/../logs/email_debug.log', "SMTP Debug: [$level] $str\n", FILE_APPEND);
        };

        // SMTP Server Configuration
        $mail->isSMTP();
        $mail->Host = $smtpConfig['host'];              // SMTP server from config
        $mail->SMTPAuth = true;                        // Enable SMTP authentication
        $mail->Username = $smtpConfig['username'];     // SMTP username from config
        $mail->Password = $smtpConfig['password'];     // SMTP password from config
        $mail->SMTPSecure = $smtpConfig['encryption']; // Encryption method from config
        $mail->Port = $smtpConfig['port'];             // Port from config

        // Recipients
        $mail->setFrom($fromEmail, $fromName);         // Sender's email and name
        $mail->addAddress($to, $username);             // Recipient's email and name

        // Email Content
        $mail->isHTML(true);                           // Email format: HTML
        $mail->Subject = $subject;                     // Email subject
        $mail->Body    = $body;                        // Email body (HTML)
        $mail->AltBody = $altBody;                     // Email body (plain text)

        // Send the email
        $mail->send();
        return ['status' => 'success', 'message' => 'Email sent successfully!'];
    } catch (Exception $e) {
        // Log errors if email fails to send
        file_put_contents(__DIR__ . '/../logs/email_debug.log', "Mailer Error: {$mail->ErrorInfo}\n", FILE_APPEND);
        return ['status' => 'error', 'message' => "Mailer Error: {$mail->ErrorInfo}"];
    }
}


?>
