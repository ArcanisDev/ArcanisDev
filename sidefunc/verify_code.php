<?php
session_start();
require '../conf/config.php'; // Include your database connection script

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userCode = trim($_POST['resetCode']);

    if (!isset($_SESSION['reset_email'])) {
        echo json_encode(['success' => false, 'message' => 'Session expired. Please request a new reset code.']);
        exit;
    }

    $email = $_SESSION['reset_email'];

    try {
        // Check if the code matches the one in the database
        $query = "SELECT reset_code FROM users WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $storedCode = $stmt->fetchColumn();

        if ($storedCode && $userCode === $storedCode) {
            echo json_encode(['success' => true, 'message' => 'Code verified. Proceed to reset password.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid code. Please try again.']);
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
    }
    exit;
}
?>
