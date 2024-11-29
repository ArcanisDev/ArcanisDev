<?php
require 'config.php'; // Include the configuration file

$voterIP = filter_input(INPUT_GET, 'VoterIP', FILTER_VALIDATE_IP);
$success = abs(filter_input(INPUT_GET, 'Successful', FILTER_VALIDATE_INT));
$reason = filter_input(INPUT_GET, 'Reason', FILTER_SANITIZE_STRING);
$pingUsername = filter_input(INPUT_GET, 'pingUsername', FILTER_SANITIZE_STRING);

// How much NX reward the player gets
$rewardvpoints = 20;

try {
    // Get account id and last vote time
    $stmt = $pdo->prepare("SELECT id, lastvotetime FROM users WHERE name = :pingUsername");
    $stmt->execute([':pingUsername' => $pingUsername]);
    $account = $stmt->fetch();

    if ($account) {
        $myaccountid = $account['id'];

        // Check if the IP address has voted in the last 12 hours
        $check_ip_sql = "SELECT * FROM vote_logs WHERE ip_address = :ip_address AND vote_time > NOW() - INTERVAL 12 HOUR";
        $check_ip_stmt = $pdo->prepare($check_ip_sql);
        $check_ip_stmt->execute([':ip_address' => $voterIP]);
        $ip_vote = $check_ip_stmt->fetch();

        if ($ip_vote) {
            die("You can only vote once every 12 hours from the same IP address.");
        }

        // Update the last vote IP
        $updateIPStmt = $pdo->prepare("UPDATE users SET lastvoteip = :voterIP WHERE name = :pingUsername");
        $updateIPStmt->execute([':voterIP' => $voterIP, ':pingUsername' => $pingUsername]);

        // Check if the vote is successful and process rewards
        if ($success === 0) {
            // Check if the account ID already exists in the votes table
            $voteCheckStmt = $pdo->prepare("SELECT COUNT(*) FROM cms_votes WHERE accountid = :accountid");
            $voteCheckStmt->execute([':accountid' => $myaccountid]);
            $count = $voteCheckStmt->fetchColumn();

            if ($count > 0) {
                // Update existing row
                $updateVoteStmt = $pdo->prepare("UPDATE cms_votes SET vp = vp + :rewardvpoints, collected = 0 WHERE accountid = :accountid");
                $updateVoteStmt->execute([':rewardvpoints' => $rewardvpoints, ':accountid' => $myaccountid]);
            } else {
                // Insert new record
                $insertVoteStmt = $pdo->prepare("INSERT INTO cms_votes (accountid, ip, vp, collected) VALUES (:accountid, :voterIP, :rewardvpoints, 0)");
                $insertVoteStmt->execute([':accountid' => $myaccountid, ':voterIP' => $voterIP, ':rewardvpoints' => $rewardvpoints]);
            }

            // Update the last vote time
            $updateVoteTimeStmt = $pdo->prepare("UPDATE users SET lastvotetime = NOW() WHERE name = :pingUsername");
            $updateVoteTimeStmt->execute([':pingUsername' => $pingUsername]);

            // Log the vote attempt with the IP address
            $log_sql = "INSERT INTO vote_logs (username, ip_address, vote_time) VALUES (:username, :ip_address, NOW())";
            $log_stmt = $pdo->prepare($log_sql);
            $log_stmt->execute([':username' => $pingUsername, ':ip_address' => $voterIP]);

            echo "Vote successfully recorded!";
        } else {
            die("Vote was not successful.");
        }
    } else {
        die("User not found.");
    }
} catch (PDOException $e) {
    error_log("Error in voting script: " . $e->getMessage());
    die("An error occurred. Please try again later.");
}
?>

