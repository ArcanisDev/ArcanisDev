<?php
require_once '../conf/config.php'; // Include config for database connection

header('Content-Type: application/json');

// Function to check if the server is online
function isServerOnline($ip, $port, $timeout = 1) {
    $socket = @fsockopen($ip, $port, $errno, $errstr, $timeout);
    if ($socket) {
        fclose($socket);
        return true;
    }
    return false;
}

try {
    $serverIp = '45.94.222.54'; // Replace with your server's IP
    $serverPort = 8484;          // Replace with your server's port

    // Check if the server is online
    $serverOnline = isServerOnline($serverIp, $serverPort);

    // Query to get the online count from the users table
    $query = "SELECT COUNT(*) AS onlineCount FROM users WHERE clientstate > 0";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $onlineCount = $result ? (int)$result['onlineCount'] : 0;

    echo json_encode([
        'status' => 'success',
        'serverStatus' => $serverOnline,
        'onlineCount' => $onlineCount,
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
    ]);
}
?>
