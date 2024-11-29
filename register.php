<?php
session_start();
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
$form_data = $_SESSION['form_data'] ?? [];
unset($_SESSION['error'], $_SESSION['success'], $_SESSION['form_data']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register | Awaken</title>

    <!-- CSS Dependencies -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/all.min.css" rel="stylesheet">
    <link href="assets/css/fontawesome.css" rel="stylesheet">
    <link href="assets/css/aos.css" rel="stylesheet">
    <link href="assets/css/default.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">
    <script src="https://hcaptcha.com/1/api.js" async defer></script>

    <style>
        /* Enhanced Input Styles */
        .form-control {
            border: 2px solid #ddd;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
            padding: 10px 15px;
            font-size: 16px;
            box-shadow: none;
        }
        .form-control:focus {
            border-color: #28a745;
            outline: none;
            box-shadow: 0px 0px 10px rgba(40, 167, 69, 0.5);
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #218838;
            box-shadow: 0px 5px 15px rgba(40, 167, 69, 0.3);
        }
        .form-check-label {
            font-size: 14px;
            color: #666;
        }
        a {
            text-decoration: none;
            color: #28a745;
            transition: color 0.3s ease-in-out;
        }
        a:hover {
            color: #218838;
            text-decoration: underline;
        }
        .btn {
            width: 100%;
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
                    <li><a href="vote.php">Vote</a></li>
                    <li><a href="https://discord.gg/z68Y9mE5QQ">Donate</a></li>
                   <li><a href="Downloads.php">Downloads</a></li>
                </ul>
            </nav>
            <div class="header__buttons d-flex align-items-center">
                <a href="#" class="theme__btn active">Register</a>
                <a href="login.php">Login</a>
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
                                <li><a href="vote.php">Vote</a></li>
                                <li><a href="https://discord.gg/z68Y9mE5QQ">Donate</a></li>
                                <li><a href="Downloads.php">Downloads</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="header__buttons d-flex align-items-center">
                        <a href="#">Register</a>
                        <a href="login.php" class="theme__btn">Login</a>
                        <div class="menu__trigger">
                            <a class="d-block d-lg-none" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                                <i class="far fa-bars"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Register Section -->
        <div class="patch__box" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
            <div class="container">
                <div class="patch__container">
                    <div class="patch__heading text-center">
                        <h1>Register to Awaken</h1>
                    </div>

                    <!-- Display Messages -->
                    <?php if ($error): ?>
                        <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success text-center"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>

                    <div class="patch__flex d-flex">
                        <div class="patch__left">
                            <div class="patch__text">
                                <h1>Welcome to Awaken</h1>
                                <p>
                                    Join the adventure today! Create your account and step into the world of Awaken.
                                    Explore unique content, meet new friends, and make unforgettable memories.
                                </p>
                                <p>
                                    <strong>Already have an account?</strong> <a href="login.php">Click here to log in</a>
                                    and continue your journey.
                                </p>
                            </div>
                        </div>

                        <!-- Right Column - Register Form -->
                        <div class="patch__right">
                            <div class="patch__text">
                                <form action="process_register.php" method="POST">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($form_data['username'] ?? ''); ?>" placeholder="Enter your username" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>" placeholder="Enter your email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm-password" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirm-password" name="confirm_password" placeholder="Confirm your password" required>
                                    </div>
                                    <!-- hCaptcha Widget -->
                                    <div class="h-captcha" data-sitekey="d4326b8c-8a3c-4bf4-81f8-2a385c387af8"></div>
                                    <button type="submit" class="btn btn-success">Register</button>
                                    <div class="text-center mt-3">
                                        <a href="login.php">Already have an account? Log in</a>
                                    </div>
                                </form>
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
    <script src="assets/js/Popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
