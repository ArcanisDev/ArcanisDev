<?php
require_once 'conf/config.php'; // Include your secure database connection file
require_once 'conf/send_email.php'; // Include your email-sending function
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $hcaptcha_response = $_POST['h-captcha-response'] ?? '';

    // Validate hCaptcha response
    $hcaptcha_secret = 'ES_53a819b1cc734bc5b8e6b414f4906c09';
    $hcaptcha_verify_url = 'https://hcaptcha.com/siteverify';
    $response = file_get_contents($hcaptcha_verify_url . '?secret=' . $hcaptcha_secret . '&response=' . $hcaptcha_response);
    $hcaptcha_success = json_decode($response)->success ?? false;

    if (!$hcaptcha_success) {
        $_SESSION['error'] = 'hCaptcha verification failed. Please try again.';
        $_SESSION['form_data'] = $_POST;
        header('Location: register.php');
        exit;
    }

    // Basic validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = 'All fields are required.';
        header('Location: register.php');
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = 'Passwords do not match.';
        $_SESSION['form_data'] = $_POST; // Preserve user input
        header('Location: register.php');
        exit;
    }

    try {
        // Check if username or email already exists
        $query = $pdo->prepare("SELECT COUNT(*) FROM users WHERE name = :username OR email = :email");
        $query->execute(['username' => $username, 'email' => $email]);
        $count = $query->fetchColumn();

        if ($count > 0) {
            $_SESSION['error'] = 'Username or email is already in use.';
            $_SESSION['form_data'] = $_POST; // Preserve user input
            header('Location: register.php');
            exit;
        }

        // Insert the user into the database
        $query = $pdo->prepare("
            INSERT INTO users (name, password, email) 
            VALUES (:username, :password, :email)
        ");
        $query->execute([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT), // Secure password hashing
            'email' => $email
        ]);

        // Prepare welcome email content
        $subject = "Welcome to Awaken!";
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
                .login-btn {
                    display: inline-block;
                    text-decoration: none;
                    background-color: #28a745;
                    color: #ffffff;
                    padding: 10px 20px;
                    border-radius: 5px;
                    font-size: 16px;
                    margin-top: 20px;
                    text-align: center;
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
                    Welcome to Awaken!
                </div>
                <div class="email-content">
                    <p>Dear ' . htmlspecialchars($username) . ',</p>
                    <p>Thank you for registering with us. We are thrilled to have you on board!</p>
                    <p>Click the button below to log in and start exploring:</p>
                    <a href="https://awakenms.ca/login.php" class="login-btn">Log in</a>
                </div>
                <div class="email-footer">
                    © ' . date("Y") . ' Awaken. All rights reserved.
                </div>
            </div>
        </body>
        </html>';

        $altBody = "Welcome, $username! Thank you for registering. Visit https://awakenms.ca/login.php to log in.";

        // Send the welcome email
        $fromEmail = 'no.reply.awaken@gmail.com';
        $fromName = 'Awaken Support';
        $result = sendEmail($email, $username, $subject, $body, $altBody, $fromEmail, $fromName);

        if ($result['status'] !== 'success') {
            error_log("Welcome email failed: " . $result['message']);
        }

        // Success - Redirect to login page with success message
        $_SESSION['success'] = 'Registration successful! A welcome email has been sent to your inbox.';
        header('Location: login.php');
        exit;

    } catch (PDOException $e) {
        // Log and display error for debugging
        error_log("Registration error: " . $e->getMessage());
        $_SESSION['error'] = 'An error occurred during registration. Please try again later.';
        header('Location: register.php');
        exit;
    }
} else {
    // Redirect if accessed without POST
    header('Location: register.php');
    exit;
}
