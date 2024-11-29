<?php
// Include the config.php file correctly
include_once '../conf/config.php';

// Fetch categories from the database
try {
    $categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

    // Output the categories as a list
    foreach ($categories as $category) {
        echo "<li>
                <a href='#' data-id='{$category['id']}'>
                    <img src='/assets/img/flower.png' alt=''> {$category['name']}
                </a>
              </li>";
    }
} catch (PDOException $e) {
    // Log the error for debugging and return a user-friendly message
    error_log("Failed to fetch categories: " . $e->getMessage());
    echo "Error loading categories. Please try again later.";
}
?>
