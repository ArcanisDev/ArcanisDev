<?php
/**
 * Secure Configuration File
 *
 * This file handles database connection settings with hardcoded values.
 * Ensure you follow best practices to keep this file secure.
 */

// Disable error display in production (change to 1 for debugging during development)
ini_set('display_errors', 0); 
error_reporting(E_ALL);

// Database Configuration - Hardcoded but secured
define('DB_HOST', '45.94.222.54');       // Database host
define('DB_PORT', '3306');            // MySQL port (custom port in your setup)
define('DB_NAME', 'v206');          // Database name
define('DB_USER', 'Awaken');            // Database username
define('DB_PASS', 'PksvGMLB8~g_');      // Database password (secure and strong)

try {
    // Use PDO for a secure database connection
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,    // Enable exception handling
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch associative arrays
        PDO::ATTR_EMULATE_PREPARES => false,           // Use real prepared statements
    ]);
} catch (PDOException $e) {
    // Log the error without exposing sensitive details to users
    error_log("Database connection failed: " . $e->getMessage());
    die("Database connection failed. Please contact the administrator.");
}

// Secure session configuration to prevent session hijacking and CSRF
session_set_cookie_params([
    'lifetime' => 0,                 // Session expires when the browser closes
    'path' => '/',                   // Cookie is valid site-wide
    'domain' => $_SERVER['HTTP_HOST'], // Set dynamically
    'secure' => isset($_SERVER['HTTPS']), // Use HTTPS if available
    'httponly' => true,              // Prevent JavaScript access
    'samesite' => 'Strict',          // Protect against CSRF
]);
session_start();
?>
