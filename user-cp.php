<?php
// Start session and set session lifetime to 30 minutes
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(1800);
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

require_once 'conf/config.php';

// Use the session 'username' to fetch the `name` field in the database
$sessionUsername = $_SESSION['username']; // This comes from the session
$userInfo = null;

try {
    // Fetch user data from the database using the session username as the name field
    $stmt = $pdo->prepare("SELECT name, email, votepoints, donationpoints, maplePoints, nxPrepaid FROM users WHERE name = :name");
    $stmt->execute(['name' => $sessionUsername]);
    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error fetching user data: " . $e->getMessage();
    exit;
}

// Check if the form to update the email is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['current_email'], $_POST['new_email'])) {
    $currentEmail = $_POST['current_email'];
    $newEmail = $_POST['new_email'];

    if ($userInfo && $userInfo['email'] === $currentEmail) {
        try {
            $updateStmt = $pdo->prepare("UPDATE users SET email = :new_email WHERE name = :name");
            $updateStmt->execute(['new_email' => $newEmail, 'name' => $sessionUsername]);
            $successMessage = "Email updated successfully!";
            $userInfo['email'] = $newEmail; // Update displayed email
        } catch (Exception $e) {
            $errorMessage = "Failed to update email: " . $e->getMessage();
        }
    } else {
        $errorMessage = "Current email is incorrect.";
    }
}

// Check if the form to change the password is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password_current_email'], $_POST['new_password'])) {
    $passwordCurrentEmail = $_POST['password_current_email'];
    $newPassword = $_POST['new_password'];

    if ($userInfo && $userInfo['email'] === $passwordCurrentEmail) {
        try {
            $updatePasswordStmt = $pdo->prepare("UPDATE users SET password = :new_password WHERE name = :name");
            $updatePasswordStmt->execute(['new_password' => $newPassword, 'name' => $sessionUsername]);
            $passwordSuccessMessage = "Password updated successfully!";
        } catch (Exception $e) {
            $passwordErrorMessage = "Failed to update password: " . $e->getMessage();
        }
    } else {
        $passwordErrorMessage = "Email verification failed. Cannot update password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Control Panel | Awaken</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/all.min.css" rel="stylesheet">
    <link href="assets/css/fontawesome.css" rel="stylesheet">
    <link href="assets/css/aos.css" rel="stylesheet">
    <link href="assets/css/default.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">

    <style>
        .user__list ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .user__list li {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .user__list li:hover,
        .user__list li.active {
            background-color: #007bff;
            color: white;
        }

        .user__content {
            padding: 20px;
            border: 1px solid #ddd;
            background: #f8f9fa;
            border-radius: 8px;
            min-height: 300px;
        }

        .user__content h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .user__content p {
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        button {
            padding: 10px 20px;
            font-size: 14px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        button:active {
            background-color: #003d80;
            transform: scale(0.95);
        }

        button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
            opacity: 0.6;
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
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="index.php#World-Ranking">World Ranking</a></li>
                    <li><a href="patch.php">Awaken News</a></li>
                    <li><a href="/community">Community</a></li>
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
                <?php else: ?>
                    <a href="register.php">Register</a>
                    <a href="login.php" class="theme__btn">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Main Body -->
    <div class="main__body">
        <header>
            <div class="header__area">
                <div class="header__flex d-flex justify-content-between align-items-center">
                    <div class="header__logo">
                        <a href="index.php"><img src="assets/img/site-logo.png" alt=""></a>
                    </div>
                    <div class="header__navigation">
                        <nav>
                            <ul>
                                <li><a href="index.php" class="active">Home</a></li>
                                <li><a href="index.php#World-Ranking">World Ranking</a></li>
                                <li><a href="patch.php">Awaken News</a></li>
                                <li><a href="/community">Community</a></li>
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
                            <a href="logout.php">Logout</a>
                            <a href="user-cp.php" class="theme__btn">User CP</a>
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

        <!-- User Control Panel -->
        <div class="patch__box">
            <div class="container">
                <div class="patch__container">
                    <div class="patch__heading text-center">
                        <h1>User Control Panel</h1>
                        <p>Welcome, <strong><?php echo htmlspecialchars($userInfo['name']); ?></strong>!</p>
                    </div>
                    <div class="patch__flex d-flex">
                        <!-- Sidebar Menu -->
                        <div class="patch__left user__list">
                            <ul>
                                <li data-section="profile" class="active">Profile</li>
                                <li data-section="settings">Settings</li>
                            </ul>
                        </div>
                        <!-- Content Section -->
                        <div class="patch__right user__content">
                            <div id="profile" class="user__section">
                                <h1>Profile</h1>
                                <p>View and update your profile information.</p>
                                <form method="post">
                                    <label for="username">Username:</label>
                                    <input type="text" id="username" value="<?php echo htmlspecialchars($userInfo['name']); ?>" disabled>

                                    <label for="current_email">Current Email:</label>
                                    <input type="email" name="current_email" id="current_email" placeholder="Enter your current email" required>

                                    <label for="new_email">New Email:</label>
                                    <input type="email" name="new_email" id="new_email" placeholder="Enter your new email" required>

                                    <button type="submit">Update Email</button>
                                </form>
                                <hr>
                                <h3>Account Information</h3>
                                <p><strong>Vote Points:</strong> <?php echo $userInfo['votepoints'] ?? '0'; ?></p>
                                <p><strong>Donation Points:</strong> <?php echo $userInfo['donationpoints'] ?? '0'; ?></p>
                                <p><strong>Maple Points:</strong> <?php echo $userInfo['maplePoints'] ?? '0'; ?></p>
                                <p><strong>NX Prepaid:</strong> <?php echo $userInfo['nxPrepaid'] ?? '0'; ?></p>
                            </div>
                            <div id="settings" class="user__section" style="display: none;">
                                <h1>Settings</h1>
                                <p>Manage your account preferences.</p>
                                <form method="post">
                                    <label for="password_current_email">Current Email:</label>
                                    <input type="email" id="password_current_email" name="password_current_email" placeholder="Enter your current email" required>
                                    <label for="new_password">New Password:</label>
                                    <input type="password" id="new_password" name="new_password" placeholder="Enter your new password" required>
                                    <button type="submit">Change Password</button>
                                </form>
                                <?php if (isset($passwordErrorMessage)): ?>
                                    <p style="color: red;"><?php echo $passwordErrorMessage; ?></p>
                                <?php elseif (isset($passwordSuccessMessage)): ?>
                                    <p style="color: green;"><?php echo $passwordSuccessMessage; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script>
        // Live switch for user sections
        document.querySelectorAll('.user__list li').forEach(item => {
            item.addEventListener('click', function () {
                document.querySelectorAll('.user__list li').forEach(li => li.classList.remove('active'));
                document.querySelectorAll('.user__section').forEach(section => section.style.display = 'none');
                this.classList.add('active');
                const sectionId = this.getAttribute('data-section');
                document.getElementById(sectionId).style.display = 'block';
            });
        });
    </script>
</body>

</html>
