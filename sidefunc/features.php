<?php
require_once '../conf/config.php'; // Include your config file for database connection

header('Content-Type: application/json');

// Query to fetch features from the database
$query = "SELECT title, content FROM features";
$stmt = $pdo->prepare($query);
$stmt->execute();

$features = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['status' => 'success', 'features' => $features]);
?>
