<?php
require_once '../conf/config.php';

header('Content-Type: application/json');

// Verify request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Only POST requests are allowed.']);
    exit;
}

$action = $_POST['action'] ?? '';

try {
    if ($action === 'fetch') {
        // Fetch the current general options
        $stmt = $pdo->query("SELECT * FROM web_general LIMIT 1");
        $options = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$options) {
            // Initialize with default values if no record exists
            $pdo->query("INSERT INTO web_general (youtube_link, discord_link, mega_mirror, drive_mirror, index_title, meta_keywords, meta_description)
                         VALUES ('', '', '', '', '', '', '')");
            $stmt = $pdo->query("SELECT * FROM web_general LIMIT 1");
            $options = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Send a proper JSON response
        echo json_encode(['status' => 'success', 'data' => $options]);
        exit;
    } elseif ($action === 'update') {
        // Validate input
        $youtube = trim($_POST['youtube_link'] ?? '');
        $discord = trim($_POST['discord_link'] ?? '');
        $mega = trim($_POST['mega_mirror'] ?? '');
        $drive = trim($_POST['drive_mirror'] ?? '');
        $indexTitle = trim($_POST['index_title'] ?? '');
        $metaKeywords = trim($_POST['meta_keywords'] ?? '');
        $metaDescription = trim($_POST['meta_description'] ?? '');

        // Ensure all fields are sanitized
        $stmt = $pdo->prepare("UPDATE web_general SET 
            youtube_link = :youtube_link, 
            discord_link = :discord_link, 
            mega_mirror = :mega_mirror, 
            drive_mirror = :drive_mirror, 
            index_title = :index_title, 
            meta_keywords = :meta_keywords, 
            meta_description = :meta_description
        ");
        $stmt->execute([
            ':youtube_link' => $youtube,
            ':discord_link' => $discord,
            ':mega_mirror' => $mega,
            ':drive_mirror' => $drive,
            ':index_title' => $indexTitle,
            ':meta_keywords' => $metaKeywords,
            ':meta_description' => $metaDescription,
        ]);

        echo json_encode(['status' => 'success', 'message' => 'General options updated successfully.']);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
        exit;
    }
} catch (PDOException $e) {
    error_log('PDOException: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'A database error occurred.']);
    exit;
} catch (Exception $e) {
    error_log('Exception: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred.']);
    exit;
}
?>
