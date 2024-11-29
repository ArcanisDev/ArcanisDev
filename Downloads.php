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
    <title>Awaken Client Download</title>

    <!-- CSS Dependencies -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/all.min.css" rel="stylesheet">
    <link href="assets/css/fontawesome.css" rel="stylesheet">
    <link href="assets/css/aos.css" rel="stylesheet">
    <link href="assets/css/default.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">
</head>

<body>
	<style>
	        .vote-img {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            margin-bottom: 20px;
        }
	</style>
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
                    <li><a href="#">Guide</a></li>
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
                                <li><a href="#">Guide</a></li>
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

        <!-- Download Section -->
        <div class="patch__box" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
            <div class="container">
                <div class="patch__container">
                    <div class="patch__heading text-center">
                        <h1>Awaken Client Download</h1>
                    </div>
                    <div class="patch__flex d-flex">
                        <!-- Left Column - Installation Guide -->
                        <div class="patch__left" style="flex: 1; padding-right: 20px;">
                            <div class="patch__text">
                                <h2>Installation Guide</h2>
                                <ul class="list-unstyled">
                                    <li>✅ Make sure your Windows Defender Realtime protection is disabled.</li>
                                    <li>✅ Download the Version from one of these links on the mirror side.</li>
                                    <li>✅ Download the Client from this link: <a href="https://drive.google.com/file/d/1i580u6_sw6n-0JqiAmW9TlyQTOGmEeEw/view">Click Me!</a></li>
                                    <li>✅ Put everything into 1 folder and exclude this folder from the Windows Defender settings</li>
                                    <li>✅ Run the Awaken.exe as Admin</li>
                                    <li>✅ Login and Tap on OK when asked to checked for File Integrity</li>
                                    <li>✅ Let the Client autopatch any files it needs</li>
                                    <li>✅ Enjoy your adventure in Awaken!</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Right Column - Download Mirrors -->
                        <div class="patch__right" style="flex: 1; padding-left: 20px;">
							<img class="vote-img" src="assets/img/download.png" alt="" />
                            <div class="patch__text">
                                <h2>Download Mirrors</h2>
                                <p>Choose one of the following download options to get started:</p>
                                <div class="mirror__card">
                                    <h3>Mirror 1 (Mega)</h3>
                                    <p><a href="<?php echo $row['mega_mirror']; ?>" class="btn btn-primary">Download from Mega</a></p>
                                </div>
                                <div class="mirror__card">
                                    <h3>Mirror 2 (Google Drive)</h3>
                                    <p><a href="<?php echo $row['drive_mirror']; ?>" class="btn btn-primary">Download from Google Drive</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shadow Image -->
        <div class="shadow__img" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="1000">
            <img class="shadow__bottom" src="assets/img/awaken-shadow.png" alt="">
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
