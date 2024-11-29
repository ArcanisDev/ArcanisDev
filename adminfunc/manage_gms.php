<?php
require_once '../conf/config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'This script expects POST requests.']);
    exit;
}

$action = $_POST['action'] ?? '';

try {
    if ($action === 'fetch') {
        $stmt = $pdo->query("SELECT id, name AS username, email, accounttype FROM users ORDER BY id ASC");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 'success', 'data' => $users]);
    } elseif ($action === 'update') {
        $id = $_POST['id'] ?? 0;
        $account_type = $_POST['account_type'] ?? -1;

        // Validate input
        if (empty($id) || !is_numeric($account_type) || !in_array($account_type, [0, 1, 2, 3, 4, 5, 6])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid user ID or account type.']);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE users SET accounttype = ? WHERE id = ?");
        if ($stmt->execute([$account_type, $id])) {
            echo json_encode(['status' => 'success', 'message' => 'Account type updated successfully.']);
        } else {
            error_log('SQL Error (Update): ' . print_r($stmt->errorInfo(), true));
            echo json_encode(['status' => 'error', 'message' => 'Failed to update account type.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
    }
} catch (PDOException $e) {
    error_log('PDOException: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database error occurred.']);
} catch (Exception $e) {
    error_log('Exception: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred.']);
}
?>