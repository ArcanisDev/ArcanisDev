<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require '../conf/config.php'; // Include your main config file
require '../conf/send_email.php'; // Include your PHPMailer function

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $resetCode = rand(100000, 999999); // Generate a 6-digit code

    try {
        // Store the reset code in the database
        $query = "UPDATE users SET reset_code = :reset_code WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':reset_code', $resetCode, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $updateSuccess = $stmt->execute();

        if (!$updateSuccess) {
            echo json_encode(['success' => false, 'message' => 'Failed to store the reset code in the database.']);
            exit;
        }

        // Prepare email content
        $subject = "Password Reset Code";
        $body = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f5f5f5;
                    margin: 0;
                    padding: 0;
                }
                .email-container {
                    max-width: 600px;
                    margin: 20px auto;
                    background-color: #ffffff;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                }
                .email-header {
                    background-color: #24292e;
                    padding: 20px;
                    color: #ffffff;
                    text-align: center;
                    font-size: 24px;
                }
                .email-content {
                    padding: 30px;
                    font-size: 16px;
                    color: #333;
                }
                .email-content p {
                    margin-bottom: 20px;
                }
                .reset-code {
                    display: block;
                    text-align: center;
                    background-color: #f0f0f0;
                    border-radius: 5px;
                    padding: 10px;
                    font-size: 22px;
                    color: #333;
                    margin: 20px 0;
                    font-weight: bold;
                }
                .email-footer {
                    text-align: center;
                    font-size: 12px;
                    color: #888;
                    padding: 20px;
                    border-top: 1px solid #ddd;
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="email-header">
                    Awaken Support
                </div>
                <div class="email-content">
                    <p>Dear User,</p>
                    <p>We received a request to reset your password. Use the code below to reset your password:</p>
                    <div class="reset-code">' . $resetCode . '</div>
                    <p>If you did not request a password reset, please ignore this email or contact support.</p>
                </div>
                <div class="email-footer">
                    © ' . date("Y") . ' Awaken. All rights reserved.
                </div>
            </div>
        </body>
        </html>';

        $altBody = "Your password reset code is: $resetCode";

        // Call the sendEmail function
        $fromEmail = 'no.reply.awaken@gmail.com'; // Replace with your actual 'from' email
        $fromName = 'Awaken Support'; // Replace with your actual 'from' name

        $result = sendEmail($email, '', $subject, $body, $altBody, $fromEmail, $fromName);

        if ($result['status'] === 'success') {
            echo json_encode(['success' => true, 'message' => 'A reset code has been sent to your email.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to send the email. ' . $result['message']]);
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
    }
    exit;
}
?>
