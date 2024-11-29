<?php
// Start session and set session lifetime to 30 minutes
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(1800);
session_start();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Awaken News System</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/all.min.css" rel="stylesheet">
    <link href="assets/css/fontawesome.css" rel="stylesheet">
    <link href="assets/css/aos.css" rel="stylesheet">
    <link href="assets/css/default.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">
</head>

<body>
    <!-- offcanva start here -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header justify-content-end">
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <nav>
                <ul>
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="index.php#World-Ranking">World Ranking</a></li>
                    <li><a href="patch.php">Awaken New's</a></li>
                    <li><a href="/community">Community</a></li>
                    <li><a href="#">Guide</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li><a href="vote.php">Vote</a></li>
                        <li><a href="donate.php">Donate</a></li>
                    <?php endif; ?>
                    <li><a href="patch.php">Events</a></li>
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
    <!-- offcanva end here -->

    <div class="main__body">
        <header>
            <div class="header__area" data-aos="fade-up" data-aos-duration="1000">
                <div class="header__flex d-flex justify-content-between align-items-center">
                    <div class="header__logo">
                        <a href="index.php"><img src="assets/img/site-logo.png" alt=""></a>
                    </div>
                    <div class="header__navigation">
                        <nav>
                            <ul>
                                <li><a href="index.php" class="active">Home</a></li>
                                <li><a href="index.php#World-Ranking">World Ranking</a></li>
                                <li><a href="patch.php">Awaken New's</a></li>
                                <li><a href="/community">Community</a></li>
                                <li><a href="#">Guide</a></li>
                                <?php if (isset($_SESSION['username'])): ?>
                                    <li><a href="vote.php">Vote</a></li>
                                    <li><a href="donate.php">Donate</a></li>
                                <?php endif; ?>
                                <li><a href="patch.php">Events</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="header__buttons d-flex align-items-center">
                        <?php if (isset($_SESSION['username'])): ?>
                            <a href="logout.php">Logout</a>
                            <a href="user-cp.php" class="theme__btn">User CP</a>
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
		<style>
		#full-content {
    max-height: 500px; /* Adjust height as needed */
    overflow-y: auto;  /* Enable vertical scrolling */
    padding: 15px;     /* Optional padding for better readability */
    border: 1px solid #ddd; /* Optional for visual purposes */
}

		</style>
        <div class="patch__box" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
            <div class="container">
                <div class="patch__container">
                    <div class="patch__heading text-center">
                        <h1>Awaken Patch Notes and Server Updates</h1>
                    </div>
                    <div class="patch__flex d-flex">
                        <div class="patch__left">
                            <div class="patch__text">
                                <h1>Awaken News System</h1>
                                <div class="patch__list">
                                    <ul id="categories">
                                        <!-- Categories will be dynamically loaded here -->
                                    </ul>
                                </div>
                            </div>
                        </div>
							<div class="patch__right">
							<div class="patch__text">
								<h1>Posts</h1> <!-- Title will be dynamically updated -->
								<div id="content">
									<p>Loading posts...</p>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="shadow__img" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="1000">
            <img class="shadow__bottom" src="assets/img/awaken-shadow.png" alt="">
        </div>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="news/news.js"></script>
</body>

</html>
