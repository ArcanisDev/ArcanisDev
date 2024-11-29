<?php
// Start session
session_start();

// Redirect if already logged in
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Login | Awaken</title>

    <!-- CSS Dependencies -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/all.min.css" rel="stylesheet">
    <link href="assets/css/fontawesome.css" rel="stylesheet">
    <link href="assets/css/aos.css" rel="stylesheet">
    <link href="assets/css/default.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">

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
            border-color: #007bff;
            outline: none;
            box-shadow: 0px 0px 10px rgba(0, 123, 255, 0.5);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            box-shadow: 0px 5px 15px rgba(0, 123, 255, 0.3);
        }

        .form-check-label {
            font-size: 14px;
            color: #666;
        }

        /* Add smooth hover effect to links */
        a {
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s ease-in-out;
        }

        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        /* Button alignment tweaks */
        .btn {
            width: 100%;
        }

        .response-message {
            margin-top: 15px;
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
                        <a href="admin-cp.php">Admin CP</a>
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
                                <a href="admin-cp.php">Admin CP</a>
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

        <!-- Login Section -->
        <div class="patch__box" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
            <div class="container">
                <div class="patch__container">
                    <div class="patch__heading text-center">
                        <h1>Login to Awaken</h1>
                    </div>
                    <div class="patch__flex d-flex">
                        <!-- Left Column -->
                        <div class="patch__left">
                            <div class="patch__text">
                                <h1>Welcome Back to Awaken</h1>
                                <p>
                                    Your next adventure awaits! Log in to reunite with friends, explore exciting new content,
                                    and rise to the top of the rankings. We’re thrilled to have you back in the world of Awaken!
                                </p>
                                <p>
                                    <strong>New to Awaken?</strong> No worries! <a href="register.php">Click here to create an account</a>
                                    and join our vibrant community of adventurers today.
                                </p>
                                <p>
                                    <span style="color: #007bff; font-weight: bold;">Tips for a seamless login:</span>
                                    <ul style="margin-left: 20px;">
                                        <li>Ensure your username and password are entered correctly.</li>
                                        <li>Forgot your password? <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Reset it here</a>.</li>
                                        <li>Remember to check out the latest patch notes for updates and events.</li>
                                    </ul>
                                </p>
                                <p style="font-style: italic; color: #666;">
                                    We’re committed to making your gaming experience truly unforgettable. See you in-game!
                                </p>
                            </div>
                        </div>

                        <!-- Right Column - Login Form -->
                        <div class="patch__right">
                            <div class="patch__text">
                                <form action="process_login.php" method="POST">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="remember-me" name="remember_me">
                                        <label class="form-check-label" for="remember-me">Remember Me</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Login</button>
                                    <div class="text-center mt-3">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Forgot Password?</a>
                                    </div>
                                </form>
                                <?php if (isset($_SESSION['error'])): ?>
                                    <div class="alert alert-danger">
                                        <?php
                                        echo $_SESSION['error'];
                                        unset($_SESSION['error']); // Clear the error after displaying
                                        ?>
                                    </div>
                                <?php endif; ?>
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

        <!-- Forgot Password Modal -->
        <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Step 1: Enter Email -->
                        <div id="step1">
                            <form id="forgotPasswordForm">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Enter your email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <button type="button" class="btn btn-primary" onclick="sendResetCode()">Send Code</button>
                                <div id="responseMessage" class="response-message"></div>
                            </form>
                        </div>

                        <!-- Step 2: Enter Code and New Password -->
                        <div id="step2" style="display: none;">
                            <form id="resetPasswordForm">
                                <div class="mb-3">
                                    <label for="resetCode" class="form-label">Enter the code</label>
                                    <input type="text" class="form-control" id="resetCode" name="resetCode" required>
                                </div>
                                <div class="mb-3">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                </div>
                                <button type="button" class="btn btn-primary" onclick="verifyResetCode()">Reset Password</button>
                                <div id="verifyMessage" class="response-message"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function sendResetCode() {
                var email = document.getElementById('email').value;
                var responseMessage = document.getElementById('responseMessage');

                fetch('sidefunc/send_reset_code.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'email=' + encodeURIComponent(email)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    responseMessage.textContent = data.message;
                    if (data.success) {
                        responseMessage.classList.remove('text-danger');
                        responseMessage.classList.add('text-success');
                        // Switch to step 2 after the code is sent
                        document.getElementById('step1').style.display = 'none';
                        document.getElementById('step2').style.display = 'block';
                    } else {
                        responseMessage.classList.remove('text-success');
                        responseMessage.classList.add('text-danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    responseMessage.textContent = 'An error occurred. Please try again later.';
                    responseMessage.classList.add('text-danger');
                });
            }

            function verifyResetCode() {
                var resetCode = document.getElementById('resetCode').value;
                var newPassword = document.getElementById('newPassword').value;
                var confirmPassword = document.getElementById('confirmPassword').value;
                var verifyMessage = document.getElementById('verifyMessage');

                if (newPassword !== confirmPassword) {
                    verifyMessage.textContent = 'Passwords do not match.';
                    verifyMessage.classList.add('text-danger');
                    return;
                }

                fetch('sidefunc/verify_code.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'resetCode=' + encodeURIComponent(resetCode) + '&newPassword=' + encodeURIComponent(newPassword)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    verifyMessage.textContent = data.message;
                    if (data.success) {
                        verifyMessage.classList.remove('text-danger');
                        verifyMessage.classList.add('text-success');
                        setTimeout(() => {
                            location.reload(); // Refresh the page after successful reset
                        }, 3000);
                    } else {
                        verifyMessage.classList.remove('text-success');
                        verifyMessage.classList.add('text-danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    verifyMessage.textContent = 'An error occurred. Please try again later.';
                    verifyMessage.classList.add('text-danger');
                });
            }
        </script>

    <!-- JavaScript -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/Popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
