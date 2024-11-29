<?php
require_once '../conf/config.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Handle Delete Feature
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID is required to delete a feature.']);
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM features WHERE id = :id");
        $stmt->execute(['id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Feature deleted successfully']);
        exit;
    }

    // Handle Edit Feature
    if (isset($_POST['action']) && $_POST['action'] === 'edit') {
        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? null;
        $content = $_POST['content'] ?? null;

        if (!$id || !$title || !$content) {
            echo json_encode(['success' => false, 'message' => 'ID, title, and content are required.']);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE features SET title = :title, content = :content WHERE id = :id");
        $stmt->execute(['title' => $title, 'content' => $content, 'id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Feature updated successfully']);
        exit;
    }

    // Fetch Features
    if (isset($_POST['action']) && $_POST['action'] === 'fetch') {
        $stmt = $pdo->query("SELECT * FROM features ORDER BY date DESC");
        $features = $stmt->fetchAll();

        echo json_encode($features);
        exit;
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    exit;
}
?>
