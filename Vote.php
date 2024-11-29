<?php
// Include the configuration file for database connection
require_once('conf/config.php');

// Fetch data from the `web_general` table
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
    <title>Awaken Vote Page</title>

    <!-- CSS Dependencies -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/all.min.css" rel="stylesheet">
    <link href="assets/css/fontawesome.css" rel="stylesheet">
    <link href="assets/css/aos.css" rel="stylesheet">
    <link href="assets/css/default.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">

    <style>
        /* Style the image to give it a nice effect */
        .vote-img {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            animation: moveImage 10s infinite linear;
            margin-top: 20px;
            width: 100%;
            margin-bottom: 20px;
        }

        @keyframes moveImage {
            0% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(10px);
            }

            100% {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body>
    <!-- Offcanvas Menu -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header justify-content-end">
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="index.php#World-Ranking">World Ranking</a></li>
                    <li><a href="/Community">Community</a></li>
                    <li><a href="https://sites.google.com/view/awakenms/home">Guide</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li><a href="vote.php">Vote</a></li>
                        <li><a href="https://discord.gg/z68Y9mE5QQ">Donate</a></li>
                    <?php endif; ?>
                   <li><a href="Downloads.php">Downloads</a></li>
                </ul>
            </nav>
            <div class="header__buttons d-flex align-items-center">
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="logout.php" class="theme__btn">Logout</a>
                    <a href="user-cp.php">User CP</a>
                    <?php if (isset($_SESSION['webadmin']) && $_SESSION['webadmin'] == 1): ?>
                        <a href="admin-cp.php" class="theme__btn">Admin CP</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="register.php">Register</a>
                    <a href="login.php" class="theme__btn">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Body -->
    <div class="main__body">
        <!-- Header -->
        <header>
            <div class="header__area" data-aos="fade-up" data-aos-duration="1000">
                <div class="header__flex d-flex justify-content-between align-items-center">
                    <div class="header__logo">
                        <a href="index.php"><img src="assets/img/site-logo.png" alt="Awaken"></a>
                    </div>
                    <div class="header__navigation">
                        <nav>
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="index.php#World-Ranking">World Ranking</a></li>
                                <li><a href="/Community">Community</a></li>
                                <li><a href="https://sites.google.com/view/awakenms/home">Guide</a></li>
                                <?php if (isset($_SESSION['username'])): ?>
                                    <li><a href="vote.php">Vote</a></li>
                                    <li><a href="https://discord.gg/z68Y9mE5QQ">Donate</a></li>
                                <?php endif; ?>
                                <li><a href="Downloads.php">Downloads</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="header__buttons d-flex align-items-center">
                        <?php if (isset($_SESSION['username'])): ?>
                            <a href="logout.php" class="theme__btn">Logout</a>
                            <a href="user-cp.php">User CP</a>
                            <?php if (isset($_SESSION['webadmin']) && $_SESSION['webadmin'] == 1): ?>
                                <a href="admin-cp.php" class="theme__btn">Admin CP</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="register.php">Register</a>
                            <a href="login.php" class="theme__btn">Login</a>
                        <?php endif; ?>
                        <div class="menu__trigger">
                            <a class="d-block d-lg-none" data-bs-toggle="offcanvas" href="#offcanvasExample"
                                role="button" aria-controls="offcanvasExample">
                                <i class="far fa-bars"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Vote Section -->
        <div class="patch__box" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
            <div class="container">
                <div class="patch__container">
                    <div class="patch__heading text-center">
                        <h1>Vote for Awaken</h1>
                    </div>
                    <div class="patch__flex d-flex">
                        <!-- Left Column - Vote Instructions -->
                        <div class="patch__left" style="flex: 1; padding-right: 20px;">
                            <div class="patch__text">
                                <h2>How to Vote</h2>
                                <ul class="list-unstyled">
                                    <li>✅ Login to your account on Website.</li>
                                    <li>✅ Vote.</li>
                                    <li>✅ Complete Captcha.</li>
                                    <li>✅ Gain Vote Points ingame.</li>
                                    <li>✅ type @vote ingame to claim any pending VP.</li>
                                    <li>✅ Can vote every 12 hours.</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Right Column - Voting Button -->
                        <div class="patch__right" style="flex: 1; padding-left: 20px;">
                            <div class="patch__text">
                                <h2>Vote for Awaken</h2>
                                <p>Click the button below to vote for Awaken on GTOP100!</p>
                                <a href="sidefunc/vote_handler.php" class="btn btn-primary d-block">Vote Now</a>
								<img class="vote-img" src="assets/img/vote.png" alt="Vote for Awaken">
                            </div>
								
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image inside the Vote Section -->

    </div>

    <!-- JavaScript -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
