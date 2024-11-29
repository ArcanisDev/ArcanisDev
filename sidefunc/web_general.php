<?php
require_once '../conf/config.php'; // Include your config file for database connection

header('Content-Type: application/json');

// Query to fetch the YouTube and Discord links from the `web_general` table
$query = "SELECT youtube_link, discord_link FROM web_general LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->execute();

$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data) {
    echo json_encode(['status' => 'success', 'data' => $data]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data found']);
}
?>
