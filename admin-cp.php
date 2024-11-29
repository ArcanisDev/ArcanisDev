<?php
// Start session and set session lifetime to 30 minutes
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(1800);
session_start();

// Redirect if user is not an admin
if (!isset($_SESSION['username']) || !isset($_SESSION['webadmin']) || $_SESSION['webadmin'] != 1) {
    header('Location: index.php');
    exit;
}
require_once 'conf/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="https://cdn.tiny.cloud/1/ddc0f7xh1zfeb38wnx05gxuh1o6k8oym3yuozjlrf5vlzfge/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <title>Admin Control Panel | Awaken</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/all.min.css" rel="stylesheet">
    <link href="assets/css/fontawesome.css" rel="stylesheet">
    <link href="assets/css/aos.css" rel="stylesheet">
    <link href="assets/css/default.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">

    <style>
        .admin__list ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .admin__list li {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .admin__list li:hover,
        .admin__list li.active {
            background-color: #007bff;
            color: white;
        }

        .admin__content {
            padding: 20px;
            border: 1px solid #ddd;
            background: #f8f9fa;
            border-radius: 8px;
            min-height: 300px;
        }

        .admin__content h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .admin__content p {
            font-size: 14px;
        }
/* Style for the Admin Section */
.admin__section {
    background: #f4f6f9;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.admin__section h1 {
    font-size: 28px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.admin__section p {
    font-size: 16px;
    color: #555;
    margin-bottom: 20px;
}

/* Form Styles */
#featureForm {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}

#featureForm input,
#featureForm textarea,
#featureForm button {
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

#featureForm input:focus,
#featureForm textarea:focus,
#featureForm button:hover {
    border-color: #0056b3;
    outline: none;
}

#featureForm button {
    background: #0056b3;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#featureForm button:hover {
    background: #003d80;
}

/* Feature List Styles */
#featuresList {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 250px; /* Compact height */
    overflow-y: auto;
    border: 1px solid #ddd;
    border-radius: 3px;
    padding: 5px;
}

/* Feature Item Styles */
.feature {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 3px;
    background-color: #f7f7f7;
    box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1);
    font-size: 14px;
}

/* Feature Content Styling */
.feature div:first-child {
    flex: 1;
}

.feature div:last-child {
    display: flex;
    justify-content: flex-end;
    gap: 5px;
}

/* Feature Headings and Text */
.feature h3 {
    font-size: 14px;
    margin: 0;
    color: #333;
}

.feature p {
    margin: 0;
    font-size: 12px;
    color: #555;
}

.feature small {
    font-size: 10px;
    color: #999;
}

/* Feature Buttons */
.feature button {
    padding: 2px 6px; /* Compact padding */
    font-size: 10px; /* Small font size */
    width: 60px; /* Consistent width */
    border: none;
    border-radius: 3px;
    cursor: pointer;
    text-align: center;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.feature button:hover {
    transform: scale(1.05); /* Slight zoom on hover */
}

.feature .edit-btn {
    background-color: #007bff;
    color: #fff;
}

.feature .delete-btn {
    background-color: #dc3545;
    color: #fff;
}

.feature .edit-btn:hover {
    background-color: #0056b3;
}

.feature .delete-btn:hover {
    background-color: #b52b38;
}

/* Scrollbar Styles */
#featuresList::-webkit-scrollbar {
    width: 6px;
}

#featuresList::-webkit-scrollbar-thumb {
    background-color: #aaa;
    border-radius: 3px;
}

#featuresList::-webkit-scrollbar-thumb:hover {
    background-color: #888;
}

/* General Form Styles */
form {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}

form select,
form input,
form textarea,
form button {
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

form button {
    background: #0056b3;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background: #003d80;
}

/* Categories Section */
#categoriesList {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 250px;
    overflow-y: auto;
    border: 1px solid #ddd;
    border-radius: 3px;
    padding: 5px;
    background: #f9f9f9;
}

.category {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 3px;
    background-color: #f7f7f7;
    box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1);
    font-size: 14px;
}

.category div:first-child {
    flex: 1;
}

.category div:last-child {
    display: flex;
    justify-content: flex-end;
    gap: 5px;
}

/* Category Text */
.category h3 {
    font-size: 14px;
    margin: 0;
    color: #333;
}

.category p {
    margin: 0;
    font-size: 12px;
    color: #555;
}

/* Category Buttons */
.category button {
    padding: 2px 6px;
    font-size: 10px;
    width: 60px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    text-align: center;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.category button:hover {
    transform: scale(1.05);
}

.category .edit-btn {
    background-color: #007bff;
    color: #fff;
}

.category .delete-btn {
    background-color: #dc3545;
    color: #fff;
}

.category .edit-btn:hover {
    background-color: #0056b3;
}

.category .delete-btn:hover {
    background-color: #b52b38;
}

/* Posts Section */
#postsList {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #ddd;
    border-radius: 3px;
    padding: 5px;
    background: #f9f9f9;
}

.post {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 3px;
    background-color: #f7f7f7;
    box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1);
    font-size: 14px;
}

.post div:first-child {
    flex: 1;
}

.post div:last-child {
    display: flex;
    justify-content: flex-end;
    gap: 5px;
}

/* Post Headings and Text */
.post h3 {
    font-size: 14px;
    margin: 0;
    color: #333;
}

.post p {
    margin: 0;
    font-size: 12px;
    color: #555;
}

/* Post Buttons */
.post button {
    padding: 2px 6px;
    font-size: 10px;
    width: 60px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    text-align: center;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.post button:hover {
    transform: scale(1.05);
}

.post .edit-btn {
    background-color: #007bff;
    color: #fff;
}

.post .delete-btn {
    background-color: #dc3545;
    color: #fff;
}

.post .edit-btn:hover {
    background-color: #0056b3;
}

.post .delete-btn:hover {
    background-color: #b52b38;
}

/* Scrollbar Styles */
#categoriesList::-webkit-scrollbar,
#postsList::-webkit-scrollbar {
    width: 6px;
}

#categoriesList::-webkit-scrollbar-thumb,
#postsList::-webkit-scrollbar-thumb {
    background-color: #aaa;
    border-radius: 3px;
}

#categoriesList::-webkit-scrollbar-thumb:hover,
#postsList::-webkit-scrollbar-thumb:hover {
    background-color: #888;
}
.general-options-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: space-between;
}

.general-options-form {
    flex: 1 1 48%;
    max-width: 48%;
    padding: 10px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    font-size: 14px;
}

.webadmin-management {
    flex: 1 1 48%;
    max-width: 48%;
    padding: 10px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    font-size: 14px;
}

.form-group {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

label {
    font-size: 13px;
    color: #333;
    margin-right: 10px;
    width: 150px;
    text-align: left;
}

input,
select {
    width: calc(100% - 160px);
    padding: 6px 8px;
    font-size: 13px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

button {
    margin-top: 10px;
    padding: 6px 12px;
    font-size: 13px;
    color: white;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

.save-btn {
    font-size: 13px;
    padding: 6px 12px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.save-btn:hover {
    background-color: #0056b3;
}

#userList {
    margin-top: 15px;
    font-size: 13px;
}

.user-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 5px;
    font-size: 13px;
}

.user-item button {
    font-size: 12px;
    padding: 4px 8px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.user-item button.add {
    background-color: #28a745;
    color: #fff;
}

.user-item button.remove {
    background-color: #dc3545;
    color: #fff;
}

.user-item button:hover {
    opacity: 0.9;

}

button#addWebAdminBtn {
    margin-top: 10px;
    font-size: 13px;
    padding: 6px 12px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}

button#addWebAdminBtn:hover {
    background-color: #0056b3;
}


/* General Styling for Manage GMs Section */
#gmList {
    max-height: 400px; /* Adjust the height as needed */
    overflow-y: auto; /* Enable vertical scroll */
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
    padding: 10px;
    margin-bottom: 20px;
}

/* GM List Items */
#gmList .gm-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #e0e0e0;
    background-color: #fff;
    border-radius: 3px;
    margin-bottom: 5px;
    transition: background-color 0.2s ease-in-out;
}

#gmList .gm-item:hover {
    background-color: #f1f1f1;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    #gmList {
        max-height: 300px; /* Adjust height for smaller screens */
        padding: 5px;
    }

    #gmList .gm-item {
        flex-direction: column; /* Stack items vertically on smaller screens */
        align-items: flex-start;
    }
}

/* Save Button Styling */
#gmList .save-btn {
    background-color: #28a745;
    color: #fff;
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 12px;
    transition: background-color 0.2s ease-in-out;
}

#gmList .save-btn:hover {
    background-color: #218838;
}

/* Styling for the User List Container */
#userList {
    max-height: 400px; /* Adjust the height as needed */
    overflow-y: auto; /* Enable vertical scrolling */
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    background-color: #f9f9f9;
}

/* Styling for User Items */
.user-item {
    display: flex;
    flex-wrap: wrap; /* Allow items to wrap on smaller screens */
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 10px;
    font-size: 14px;
    gap: 10px; /* Space between elements */
}

/* Responsive Layout */
@media (max-width: 768px) {
    .user-item {
        flex-direction: column; /* Stack user details and buttons vertically on smaller screens */
        align-items: flex-start;
    }

    .user-item button {
        width: 100%; /* Make buttons take full width on smaller screens */
    }
}

/* Styling for Buttons */
.user-item button {
    padding: 6px 12px;
    font-size: 13px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
}

.user-item button.add {
    background-color: #28a745;
    color: #fff;
}

.user-item button.remove {
    background-color: #dc3545;
    color: #fff;
}

.user-item button:hover {
    opacity: 0.9;
}
/* Styling for the vote logs table */
#voteLogsTable {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-family: Arial, sans-serif;
}

#voteLogsTable th, #voteLogsTable td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

#voteLogsTable th {
    background-color: #f4f4f4;
    color: #333;
    font-weight: bold;
}

#voteLogsTable tr:nth-child(even) {
    background-color: #f9f9f9;
}

#voteLogsTable tr:hover {
    background-color: #f1f1f1;
}

/* Styling for the pagination buttons */
#pagination {
    margin-top: 15px;
    text-align: center;
}

#pagination button {
    margin: 0 5px;
    padding: 8px 12px;
    border: 1px solid #ccc;
    background-color: #f4f4f4;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}

#pagination button:hover {
    background-color: #ddd;
}

#pagination button:disabled {
    background-color: #007bff;
    color: #fff;
    border: 1px solid #007bff;
    cursor: not-allowed;
}

#pagination button.active {
    background-color: #007bff;
    color: #fff;
    border: 1px solid #007bff;
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
                    <li><a href="patch.php">Awaken New's</a></li>
                    <li><a href="/community">Community</a></li>
                    <li><a href="https://sites.google.com/view/awakenms/home">Guide</a></li>
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
    <!-- Offcanvas Menu End -->

    <!-- Main Body -->
    <div class="main__body">
        <!-- Header -->
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
                                <li><a href="https://sites.google.com/view/awakenms/home">Guide</a></li>
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

        <!-- Admin Control Panel -->
        <div class="patch__box" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
            <div class="container">
                <div class="patch__container">
                    <div class="patch__heading text-center">
                        <h1>Admin Control Panel</h1>
                    </div>
                    <div class="patch__flex d-flex">
                        <!-- Sidebar Menu -->
                        <div class="patch__left admin__list">
                            <ul>
                                <li data-section="manage-features" class="active">Manage Features</li>
                                <li data-section="manage-gms">Manage GMs</li>
                                <li data-section="manage-news-cat">Manage News Cat</li>
                                <li data-section="manage-news-posts">Manage News Posts</li>
                                <li data-section="ex-posts">Exiting Posts</li>
                                <li data-section="vote-logs">Vote Logs</li>
                                <li data-section="general-options">General Options</li>
                            </ul>
                        </div>
                        <!-- Content Section -->
                        <div class="patch__right admin__content">
						<div id="manage-features" class="admin__section">
							<h1>Manage Features</h1>
							<p>Customize and edit server features.</p>

							<form id="featureForm">
								<input type="hidden" name="id" id="featureId">
								<input type="text" name="title" id="featureTitle" placeholder="Feature Title" autocomplete="off" required>
								<textarea name="content" id="featureContent" placeholder="Feature Content" autocomplete="off" required></textarea>
								<button type="submit" id="saveFeatureButton">Save Feature</button>
							</form>
							<hr>
							<h2>Existing Features</h2>
							<div id="featuresList"></div>
						</div>
							<div id="manage-gms" class="admin__section" style="display: none;">
								<h1>Manage GMs</h1>
								<p>Add, edit, or remove Game Masters.</p>
								<div id="gmList">
									<!-- User list will be loaded here -->
								</div>
							</div>
							<div id="manage-news-cat" class="admin__section" style="display: none;">
								<h1>Manage News Categories</h1>
								<p>Create or edit categories for Awaken news and updates.</p>
								<form id="categoryForm">
									<input type="text" id="categoryName" placeholder="Category Name" required>
									<button type="submit">Save Category</button>
								</form>
								<hr>
								<h2>Existing Categories</h2>
								<div id="categoriesList"></div>
							</div>
							<div id="manage-news-posts" class="admin__section" style="display: none;">
								<h1>Manage News Posts</h1>
								<p>Create or edit server news and updates posts.</p>
								<form id="postForm">
									<select id="postCategory" required>
										<option value="" disabled selected>Select Category</option>
									</select>
									<input type="text" id="postTitle" placeholder="Post Title" required>
									<textarea id="postContent" placeholder="Post Content"></textarea>
									<button type="submit">Save Post</button>
								</form>
							</div>

							<div id="ex-posts" class="admin__section" style="display: none;">
								<h1>Existing Posts</h1>
								<p>View and Edit Posts</p>
								<div id="postsList"></div>
							</div>
                         
							<div id="vote-logs" class="admin__section" style="display: block;">
								<h1>Vote Logs</h1>
								<p>View and analyze vote logs.</p>
								<table id="voteLogsTable" border="1" style="width: 100%; border-collapse: collapse;">
									<thead>
										<tr>
											<th>ID</th>
											<th>Username</th>
											<th>IP Address</th>
											<th>Vote Time</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
								<div id="pagination"></div>
							</div>

							<script>
								document.addEventListener('DOMContentLoaded', function() {
									loadLogs(1);

									function loadLogs(page) {
										fetch('adminfunc/get_vote_logs.php?page=' + page)
											.then(response => response.json())
											.then(data => {
												const tbody = document.querySelector('#voteLogsTable tbody');
												tbody.innerHTML = '';

												if (data.logs.length > 0) {
													data.logs.forEach(log => {
														const row = `<tr>
															<td>${log.id}</td>
															<td>${log.username}</td>
															<td>${log.ip_address}</td>
															<td>${log.vote_time}</td>
														</tr>`;
														tbody.innerHTML += row;
													});
												} else {
													tbody.innerHTML = '<tr><td colspan="4">No logs available.</td></tr>';
												}

												// Pagination controls
												const pagination = document.getElementById('pagination');
												pagination.innerHTML = '';

												for (let i = 1; i <= data.totalPages; i++) {
													const pageLink = `<button onclick="loadLogs(${i})" ${i === data.currentPage ? 'disabled' : ''}>${i}</button>`;
													pagination.innerHTML += pageLink;
												}
											})
											.catch(error => console.error('Error fetching vote logs:', error));
									}
								});
							</script>

							<div id="general-options" class="admin__section" style="display: none;">
								<h1>General Options</h1>
								<p>Adjust server-wide settings.</p>

							<div class="general-options-container">
								<!-- General Options Form -->
								<div class="general-options-form">
									<form id="generalOptionsForm">
										<div class="form-group">
											<label for="youtubeLink">YouTube Link:</label>
											<input type="url" id="youtubeLink" placeholder="Enter YouTube Link">
										</div>

										<div class="form-group">
											<label for="discordLink">Discord Link:</label>
											<input type="url" id="discordLink" placeholder="Enter Discord Link">
										</div>

										<div class="form-group">
											<label for="megaMirror">Mega Mirror Link:</label>
											<input type="url" id="megaMirror" placeholder="Enter Mega Mirror Link">
										</div>

										<div class="form-group">
											<label for="driveMirror">Drive Mirror Link:</label>
											<input type="url" id="driveMirror" placeholder="Enter Drive Mirror Link">
										</div>

										<div class="form-group">
											<label for="indexTitle">Index Page Title:</label>
											<input type="text" id="indexTitle" placeholder="Enter Index Page Title">
										</div>

										<div class="form-group">
											<label for="metaKeywords">Meta Keywords:</label>
											<input type="text" id="metaKeywords" placeholder="Enter Meta Keywords">
										</div>

										<div class="form-group">
											<label for="metaDescription">Meta Description:</label>
											<input type="text" id="metaDescription" placeholder="Enter Meta Description">
										</div>

										<button type="submit" class="save-btn">Save Changes</button>
									</form>
								</div>

								<!-- WebAdmin Management Section -->
								<div class="webadmin-management">
									<h2>Manage WebAdmin Users</h2>
									<p>Select users and set/remove WebAdmin privileges.</p>

									<!-- Dropdown to Add New WebAdmin -->
									<div class="form-group">
										<label for="newWebAdmin">Add New WebAdmin:</label>
										<select id="newWebAdmin">
											<!-- Options populated dynamically -->
										</select>
										<button id="addWebAdminBtn" class="save-btn">set</button>
									</div>

									<!-- List of Current WebAdmins -->
									<div id="userList">
										<div class="user-item">
											<span>User 1 (example@example.com)</span>
											<button class="remove" onclick="removeAdmin(1)">Remove WebAdmin</button>
										</div>
										<div class="user-item">
											<span>User 2 (admin@example.com)</span>
											<button class="add" onclick="addAdmin(2)">Set WebAdmin</button>
										</div>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Edit Post Modal -->
<div id="editPostModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditPostModal()">&times;</span>
        <h2>Edit Post</h2>
        <form id="editPostForm">
            <select id="editPostCategory" required>
                <option value="" disabled selected>Select Category</option>
            </select>
            <input type="text" id="editPostTitle" placeholder="Post Title" required>
            <textarea id="editPostContent" placeholder="Post Content"></textarea>
            <button type="submit">Save Changes</button>
        </form>
    </div>
</div>


<style>
/* Modal Styling */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border-radius: 5px;
    width: 50%;
    position: relative;
}

.modal-content h2 {
    margin-top: 0;
}

.modal-content .close {
    position: absolute;
    right: 10px;
    top: 10px;
    font-size: 24px;
    cursor: pointer;
}

.modal-content form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
</style>

    <!-- JavaScript -->
	<script>

tinymce.init({
    selector: '#postContent, #editPostContent',
    plugins: 'link image lists code',
    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
    height: 200,
    setup: function (editor) {
        editor.on('change', function () {
            tinymce.triggerSave(); // Ensure the hidden textarea is updated
        });
    },
});


	</script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/main.js"></script>
	<script src="adminfunc/managefe.js"></script>
	<script src="adminfunc/managenew.js"></script>
	<script src="adminfunc/managegm.js"></script>
	<script src="adminfunc/general.js"></script>
    <script>
        // Live switch for admin sections
        document.querySelectorAll('.admin__list li').forEach(item => {
            item.addEventListener('click', function () {
                document.querySelectorAll('.admin__list li').forEach(li => li.classList.remove('active'));
                document.querySelectorAll('.admin__section').forEach(section => section.style.display = 'none');
                this.classList.add('active');
                const sectionId = this.getAttribute('data-section');
                document.getElementById(sectionId).style.display = 'block';
            });
        });
    </script>
</body>

</html>

