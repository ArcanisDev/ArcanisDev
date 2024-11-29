<?php
// Include the configuration file for database connection
require_once('conf/config.php');

// Fetch data from the `web_general` table (if needed for any data like link or text)
$sql = "SELECT * FROM web_general LIMIT 1"; // Assuming we only need the first row
$stmt = $pdo->prepare($sql);
$stmt->execute();
$row = $stmt->fetch();

// Check if data exists
if (!$row) {
    die("No data found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Awaken Donate</title>

    <!-- CSS Dependencies -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/all.min.css" rel="stylesheet">
    <link href="assets/css/fontawesome.css" rel="stylesheet">
    <link href="assets/css/aos.css" rel="stylesheet">
    <link href="assets/css/default.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">

    <style>
        /* Simple Gradient Background */
        .donate-container {
            background: linear-gradient(to bottom, #333, #555);
            min-height: 100vh;
            padding: 50px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Content Box */
        .donate-content {
            background: rgba(0, 0, 0, 0.7); 
            padding: 40px 60px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            color: white;
            max-width: 600px;
            width: 100%;
            position: relative;
        }

        .donate-content h2 {
            font-size: 2.5em;
            margin-bottom: 30px;
        }

        .donate-content p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .back-btn {
            margin-top: 20px;
            padding: 12px 30px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }

        /* Styling images */
        .donate-image {
            margin-top: 20px;
            max-width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            display: block;
            margin: 20px auto;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .donate-content {
                padding: 25px 20px;
            }

            .donate-content h2 {
                font-size: 2em;
            }

            .back-btn {
                font-size: 1.2em;
            }
        }
    </style>
</head>

<body>
    <div class="donate-container">
        <div class="donate-content" data-aos="fade-up" data-aos-duration="1500">
            <h2>Support Awaken - Make a Difference</h2>
            <p>By donating to Awaken, you are helping us grow and improve the server for all players. Every contribution is highly appreciated and supports our future development!</p>
            <!-- First Donate Image (donate1.png) -->
            <img class="donate-image" src="assets/img/donate1.png" alt="Donate to Awaken">
            <!-- Second Donate Image (donate2.png) -->
            <img class="donate-image" src="assets/img/donate2.png" alt="Donate to Awaken">
            <!-- Back to Website Button -->
            <a href="index.php" class="back-btn">Back to Website</a>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
