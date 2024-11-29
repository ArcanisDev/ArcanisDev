<?php
require_once '../conf/config.php';

// Enable error reporting for debugging purposes (Remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture the action
    $action = $_POST['action'] ?? '';

    try {
        if ($action === 'add') {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $category_id = $_POST['category_id'] ?? 0;

            // Validate input
            if (empty($title) || empty($content) || !$category_id) {
                echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
                exit;
            }

            // Insert query
            $stmt = $pdo->prepare("INSERT INTO posts (category_id, title, content, created_at) VALUES (?, ?, ?, NOW())");
            if ($stmt->execute([$category_id, $title, $content])) {
                echo json_encode(['status' => 'success', 'message' => 'Post added successfully.']);
            } else {
                // Log SQL error details for debugging
                error_log('SQL Error (Add): ' . print_r($stmt->errorInfo(), true));
                echo json_encode(['status' => 'error', 'message' => 'Failed to add post.']);
            }
        } elseif ($action === 'edit') {
            $id = $_POST['id'] ?? 0;
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $category_id = $_POST['category_id'] ?? 0;

            // Validate input
            if (empty($id) || empty($title) || empty($content) || !$category_id) {
                echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
                exit;
            }

            // Update query
            $stmt = $pdo->prepare("UPDATE posts SET category_id = ?, title = ?, content = ? WHERE id = ?");
            if ($stmt->execute([$category_id, $title, $content, $id])) {
                echo json_encode(['status' => 'success', 'message' => 'Post updated successfully.']);
            } else {
                error_log('SQL Error (Edit): ' . print_r($stmt->errorInfo(), true));
                echo json_encode(['status' => 'error', 'message' => 'Failed to update post.']);
            }
        } elseif ($action === 'delete') {
            $id = $_POST['id'] ?? 0;

            // Validate input
            if (empty($id)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid post ID.']);
                exit;
            }

            // Delete query
            $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
            if ($stmt->execute([$id])) {
                echo json_encode(['status' => 'success', 'message' => 'Post deleted successfully.']);
            } else {
                error_log('SQL Error (Delete): ' . print_r($stmt->errorInfo(), true));
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete post.']);
            }
        } elseif ($action === 'fetch') {
            // Fetch posts and their categories
            $stmt = $pdo->query("SELECT posts.*, categories.name AS category_name 
                                 FROM posts 
                                 JOIN categories ON posts.category_id = categories.id 
                                 ORDER BY posts.created_at DESC");

            if ($stmt) {
                $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($posts);
            } else {
                error_log('SQL Error (Fetch): ' . print_r($pdo->errorInfo(), true));
                echo json_encode(['status' => 'error', 'message' => 'Failed to fetch posts.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
        }
    } catch (Exception $e) {
        // Handle unexpected errors
        error_log('Exception: ' . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred.']);
    }
}
?>