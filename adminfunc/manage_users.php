<?php
require_once '../conf/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'This script only accepts POST requests.']);
    exit;
}

$action = $_POST['action'] ?? '';

try {
    if ($action === 'fetch') {
        // Fetch all users
        $stmt = $pdo->query("SELECT id, name AS username, webadmin FROM users ORDER BY id ASC");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 'success', 'data' => $users]);
    } elseif ($action === 'update_webadmin') {
        // Update webadmin status for a specific user
        $id = (int)$_POST['id'];
        $webadmin = (int)$_POST['webadmin'];

        if ($id <= 0 || !in_array($webadmin, [0, 1])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid user ID or webadmin value.']);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE users SET webadmin = ? WHERE id = ?");
        $stmt->execute([$webadmin, $id]);

        echo json_encode(['status' => 'success', 'message' => 'Webadmin status updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
    }
} catch (PDOException $e) {
    error_log('PDOException: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'A database error occurred.']);
} catch (Exception $e) {
    error_log('Exception: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred.']);
}
?>
