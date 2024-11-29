<?php
require_once '../conf/config.php'; // Make sure the path to config.php is correct

// Pagination configuration
$limit = 10; // Number of logs per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

try {
    // Query to get logs with pagination
    $stmt = $pdo->prepare("SELECT * FROM vote_logs LIMIT :offset, :limit");
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $logs = $stmt->fetchAll();

    // Query to count total logs for pagination
    $countStmt = $pdo->query("SELECT COUNT(*) as total FROM vote_logs");
    $totalLogs = $countStmt->fetch()['total'];
    $totalPages = ceil($totalLogs / $limit);

    // Return data as JSON (can be used for AJAX)
    echo json_encode(['logs' => $logs, 'totalPages' => $totalPages, 'currentPage' => $page]);
} catch (PDOException $e) {
    error_log("Error fetching vote logs: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch vote logs.']);
}
?>
