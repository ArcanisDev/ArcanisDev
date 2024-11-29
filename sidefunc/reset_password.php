<?php
session_start();
require '../conf/config.php'; // Include your database connection script

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newPassword = trim($_POST['newPassword']);
    $confirmPassword = trim($_POST['confirmPassword']);

    if ($newPassword !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }

    if (!isset($_SESSION['reset_email'])) {
        echo json_encode(['success' => false, 'message' => 'Session expired. Please request a new reset code.']);
        exit;
    }

    $email = $_SESSION['reset_email'];

    try {
        // Directly store the password without hashing (not recommended for production)
        $query = "UPDATE users SET password = :password, reset_code = NULL WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':password', $newPassword, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Password reset successfully.']);
            unset($_SESSION['reset_code']);
            unset($_SESSION['reset_email']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to reset password. Please try again.']);
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
    }
    exit;
}
?>
