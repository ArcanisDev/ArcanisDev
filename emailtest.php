<?php
require_once 'conf/send_email.php';

$testResult = sendEmail(
    'arcanisonline@gmail.com', // Replace with a real email
    'Test User',        // Username
    'Welcome Test',     // Subject
    '<p>This is a test email body.</p>', // HTML body
    'This is a plain text body.',       // Plain text alternative
    'no.reply.awaken@gmail.com',       // From email
    'Awaken Support'                   // From name
);

if ($testResult['status'] === 'success') {
    echo "Email sent successfully!";
} else {
    echo "Error sending email: " . $testResult['message'];
}
