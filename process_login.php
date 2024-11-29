<?php
require_once 'conf/config.php'; // Include your secure database connection file

// Start session to store user information
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect user input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Basic validation
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Username and password are required.';
        header('Location: /login.php');
        exit;
    }

    try {
        // Fetch user from the database
        $query = $pdo->prepare("SELECT * FROM users WHERE name = :username");
        $query->execute(['username' => $username]);
        $user = $query->fetch();

        if ($user) {
            // Verify the password (if using hashing, replace this comparison)
            if ($user['password'] === $password) { // WARNING: Plaintext comparison
                // Successful login - Set user session
                $_SESSION['username'] = $user['name']; // Create session for username
                if ($user['webadmin'] > 0) {
                    $_SESSION['webadmin'] = true; // Create session for webadmin
                }

                // Redirect to index.php
                header('Location: index.php');
                exit;
            } else {
                $_SESSION['error'] = 'Invalid password.';
                header('Location: login.php');
                exit;
            }
        } else {
            $_SESSION['error'] = 'User not found.';
            header('Location: login.php');
            exit;
        }
    } catch (PDOException $e) {
        // Log and display error
        error_log("Login error: " . $e->getMessage());
        $_SESSION['error'] = 'An error occurred. Please try again later.';
        header('Location: login.php');
        exit;
    }
} else {
    // Redirect if accessed without POST
    header('Location: login.php');
    exit;
}
