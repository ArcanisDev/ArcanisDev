<?php
require_once '../conf/config.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get input from POST data
        $title = $_POST['title'] ?? null;
        $content = $_POST['content'] ?? null;

        // Validate inputs
        if (!$title || !$content) {
            echo json_encode(['success' => false, 'message' => 'Title and content are required.']);
            exit;
        }

        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO features (title, content) VALUES (:title, :content)");
        $stmt->execute(['title' => $title, 'content' => $content]);

        // Respond with success
        echo json_encode(['success' => true, 'message' => 'Feature added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    }
} catch (Exception $e) {
    // Handle any errors
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
