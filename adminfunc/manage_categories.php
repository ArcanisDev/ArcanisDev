<?php
require_once '../conf/config.php';

try {
    $action = $_POST['action'] ?? '';

    if ($action === 'fetch') {
        $stmt = $pdo->query("SELECT * FROM categories ORDER BY created_at DESC");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 'success', 'data' => $categories]);
    } elseif ($action === 'add') {
        $name = $_POST['name'] ?? '';
        if (empty($name)) {
            echo json_encode(['status' => 'error', 'message' => 'Category name is required.']);
            exit;
        }
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);
        echo json_encode(['status' => 'success', 'message' => 'Category added successfully.']);
    } elseif ($action === 'edit') {
        $id = $_POST['id'] ?? 0;
        $name = $_POST['name'] ?? '';
        if (empty($id) || empty($name)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid category ID or name.']);
            exit;
        }
        $stmt = $pdo->prepare("UPDATE categories SET name = :name WHERE id = :id");
        $stmt->execute(['name' => $name, 'id' => $id]);
        echo json_encode(['status' => 'success', 'message' => 'Category updated successfully.']);
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? 0;
        if (empty($id)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid category ID.']);
            exit;
        }
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        echo json_encode(['status' => 'success', 'message' => 'Category deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
}
?>