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

    <title>Awaken | Home</title>




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
				<a href="user-cp.php" >User CP</a>
                <?php if (isset($_SESSION['webadmin']) && $_SESSION['webadmin'] == 1): ?>
                    <a href="user-cp.php" >User CP</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="register.php">Register</a>
                <a href="login.php" class="theme__btn">Login</a>
            <?php endif; ?>
        </div>
    </div>
</div>


    <!-- offcanva end here -->


    <!-- header and hero area start here -->
<div class="main__body server__status">
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
                        <a href="logout.php">Logout</a>
                        <a href="user-cp.php" class="theme__btn">User CP</a>
                
                        <?php if (isset($_SESSION['webadmin']) && $_SESSION['webadmin'] == 1): ?>
                            <a href="admin-cp.php" class="theme__btn">Admin CP</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="register.php">Register</a>
                        <a href="login.php" class="theme__btn">Login</a>
                    <?php endif; ?>
					<!--<a href="awakenprotocol://" class="theme__btn">Play Now!</a>-->
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




        <section class="hero__area section__padding">
            <div class="hero__animate1">
                <img class="hero1" src="assets/img/hero1.png" alt="">
            </div>
            <div class="hero__animate2">
                <img class="hero2" src="assets/img/hero2.png" alt="">
            </div>
            <div class="hero__content">
<div class="hero__server-status">
    <h5 data-aos="fade-right" data-aos-duration="1000" data-aos-delay="0">
        Server is: <span id="serverStatus">Checking...</span>
    </h5>
    <h5 data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200">
        Online Count: <span id="onlineCount">0</span>
    </h5>
</div>

                <div class="hero__middle">
                    <div class="hero__middle-item text-center">
                        <img data-aos="fade-right" data-aos-duration="1000" src="assets/img/awaken__overlay-logo.png" alt="">
                        <div class="hero__middle-button">
                            <div class="hero_btn" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="50">
                                <a href="/Community">Patch Notes</a>
                            </div>
                            <div class="hero_btn" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                            <a href="Downloads.php">Downloads</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <img class="hero__aura-effect" src="assets/img/aura.png" alt="">
            <img src="assets/img/hero__particle.png" alt="" class="hero__particle">
        </section>
        <img src="assets/img/awaken-shadow.png" alt="" class="video__shadow-top">
    </div>

    <!-- header and hero area end here -->



    <!-- video area start here -->

<section class="video__area overflow-hidden">
    <div class="custom__container">
        <div class="video__content d-flex justify-content-between align-items-center">
            <div class="video__text" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="300">
                <div class="video__text-heading">
                    <h1>Welcome To Awaken</h1>
                    <h1>Now the adventure begins!</h1>
                </div>
                <p>Experience the remastered heroes with brand-new,
                    flashy and powerful skills, dominating hunting grounds and boss fights!</p>
                <div class="release__date">
                    <span>Release date: 24/4/2023</span>
                </div>
				
				<br />
                <div class="discord__button">
                    <a id="discordButton" href="#" target="_blank" class="btn btn-primary">Join Discord</a>
                </div>
            </div>
            <div class="video__preview" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="100">
                <div class="responsive-video">
                    <iframe 
                      id="youtubeIframe"
                      src="" 
                      allow="autoplay; encrypted-media" 
                      allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- video area end here -->



    <!-- feature area start here -->

<section class="feature__area position-relative overflow-hidden">
    <img src="assets/img/awaken-shadow-down.png" alt="" class="video__shadow-down">
    <div class="container">
        <div class="section__title text-center" data-aos="zoom-out" data-aos-duration="1000">
            <h1>Server Features</h1>
            <p>What makes Awaken better?</p>
        </div>
        <div class="feature__content d-flex justify-content-between flex-wrap" id="featureContent">
            <!-- Features will be dynamically inserted here -->
        </div>
    </div>
    <img class="rank__shadow" src="assets/img/awaken-shadow.png" alt="">
</section>


    <!-- feature area end here -->



    <!-- rank area start here -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<section id="World-Ranking" class="rank__area position-relative overflow-hidden">
    <div class="container">
        <div class="section__title text-center" data-aos="zoom-out" data-aos-duration="1000">
            <h1>Awaken World Top 5 Rank</h1>
            <p>Awaken top 5 Heroes, Updating Live!</p>
        </div>
        <div class="rank__content">
            <div class="rank__filter text-center">
                <div class="rank__filter-search" data-aos="fade-left" data-aos-duration="1000">
                    <input type="search" id="searchBox" placeholder="Username">
                    <button onclick="searchUser()">Search</button>
                </div>
                <div class="rank__pagination" data-aos="fade-right" data-aos-duration="1000" id="paginationBtns">
                    <!-- Pagination buttons will be inserted here dynamically -->
                </div>
            </div>
            <div class="rank__box" id="rankBox">
                <!-- Ranking data will be dynamically inserted here -->
            </div>
        </div>
    </div>
</section>

<script>
    let currentPage = 1;
    let totalPages = 1;

    // Fetch ranking data
    const fetchRankData = (page = 1, search = '') => {
        $.ajax({
            url: 'sidefunc/rank_info.php', // Backend endpoint
            method: 'GET',
            data: { page, search },
            success: (response) => {
                if (response.status === 'success') {
                    updateRanking(response.characters);
                    updatePagination(response.totalPages);
                    totalPages = response.totalPages;
                } else {
                    console.error("Error: Response status is not 'success'");
                }
            },
            error: (xhr, status, error) => {
                console.error("AJAX error:", error);
                console.error("Response Text:", xhr.responseText);
            }
        });
    };

    // Update ranking display
    const updateRanking = (characters) => {
        const rankBox = $('#rankBox');
        rankBox.empty();

        const rankStart = (currentPage - 1) * 5 + 1; // Calculate starting rank for the page (5 per page)

        characters.forEach((character, index) => {
            try {
                const rank = rankStart + index; // Correct rank calculation
                const name = character.name || "Unknown"; // Default to "Unknown" if name is missing
                const avatarUrl = character.avatarUrl || "assets/img/default-avatar.png"; // Default avatar
                const jobIcon = character.jobIcon || "assets/img/default-job.png"; // Default job icon
                const level = character.level || "N/A"; // Default level
                const job = character.job || "N/A"; // Default job
                const rankClass = getRankClass(index + 1); // Rank-specific class (gold, silver, bronze)

                const rankHtml = `
                    <div class="rank__inner_box" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="${index * 50}">
                        <div class="single__rank-box position-relative">
                            <div class="rank__box-content d-flex justify-content-between align-items-center">
                                <span class="${rankClass}">${rank}</span>
                                <div class="rank__avatar">
                                    <img src="${avatarUrl}" alt="${name}">
                                    <h5>${name}</h5>
                                </div>
                                <div class="rank__level d-flex justify-content-between align-items-center">
                                    <img src="${jobIcon}" alt="Job Icon">
                                    <div class="rank__level-class">
                                        <span>Level: ${level}</span>
                                        <span>Class: ${job}</span>
                                    </div>
                                </div>
                            </div>
                            <img class="rank__box-overlay position-absolute" src="assets/img/rank__bg-overlay.png" alt="">
                        </div>
                    </div>
                `;
                rankBox.append(rankHtml);
            } catch (error) {
                console.error("Error processing character:", character, error);
            }
        });
    };

    // Get rank class
    const getRankClass = (rank) => {
        if (rank === 1) return 'gold';
        if (rank === 2) return 'silver';
        if (rank === 3) return 'bronze';
        return '';
    };

    // Update pagination
    const updatePagination = (totalPages) => {
        const paginationBtns = $('#paginationBtns');
        paginationBtns.empty();

        // Add "Previous" button
        paginationBtns.append(`<button onclick="changePage('prev')" ${currentPage === 1 ? 'disabled' : ''}><i class="fal fa-angle-left"></i></button>`);

        // Add page buttons
        const visiblePages = 5; // Number of visible page buttons
        const startPage = Math.max(1, currentPage - Math.floor(visiblePages / 2));
        const endPage = Math.min(totalPages, startPage + visiblePages - 1);

        for (let i = startPage; i <= endPage; i++) {
            paginationBtns.append(`
                <button class="${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>
            `);
        }

        // Add "Next" button
        paginationBtns.append(`<button onclick="changePage('next')" ${currentPage === totalPages ? 'disabled' : ''}><i class="fal fa-angle-right"></i></button>`);
    };

    // Handle page changes
    const changePage = (page) => {
        if (page === 'prev' && currentPage > 1) {
            currentPage--;
        } else if (page === 'next' && currentPage < totalPages) {
            currentPage++;
        } else if (typeof page === 'number') {
            currentPage = page;
        }
        fetchRankData(currentPage);
    };

    // Search user
    const searchUser = () => {
        const searchQuery = $('#searchBox').val();
        currentPage = 1; // Reset to the first page when searching
        fetchRankData(currentPage, searchQuery);
    };

    // Initial fetch on page load
    $(document).ready(() => {
        fetchRankData(currentPage);
    });
</script>






    <!-- rank area end here -->



    <!-- footer area start here -->

    <footer style="position: relative;">
        <img class="rank__shadow-bottom" src="assets/img/awaken-shadow-down.png" alt="">
        <div class="container">
            <div class="footer__content text-center">
                <div class="footer__logo">
                    <a href="#"><img src="assets/img/footer-logo.png" alt=""></a>
                </div>
                <p>All Righs resevd to Awaken.Photos / Wz Belong to NexonWebsite by <a href="mailto:arcanisonline@gmail.com">ArcanisDev</a></p>
            </div>
        </div>
    </footer>

    <!-- footer area end here -->




    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/Popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="sidefunc/fete.js"></script>
    <script src="sidefunc/gen.js"></script>
    <script src="sidefunc/server.js"></script>



</body>

</html>