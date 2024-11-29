<?php
// Include the configuration file for database connection
require_once('../conf/config.php');

// Check if the user is logged in
session_start();
if (!isset($_SESSION['username'])) {
    die("You must be logged in to vote.");
}

// Get the current session username
$username = $_SESSION['username'];
$ip_address = $_SERVER['REMOTE_ADDR']; // Get the user's IP address

// Check if the user has voted in the last 12 hours from the same IP address
$check_ip_sql = "SELECT * FROM vote_logs WHERE ip_address = :ip_address AND vote_time > NOW() - INTERVAL 12 HOUR";
$check_ip_stmt = $pdo->prepare($check_ip_sql);
$check_ip_stmt->execute(['ip_address' => $ip_address]);
$ip_vote = $check_ip_stmt->fetch();

if ($ip_vote) {
    die("You can only vote once every 12 hours from the same IP address.");
}

// Redirect to GTOP100 vote page with the username as a query parameter
$gtop_url = "https://gtop100.com/MapleStory/Awaken-v206-FRESH-WIPE-103554?vote=1&pingUsername=$username";
header("Location: $gtop_url");
exit();
?>
