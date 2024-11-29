(function ($) {
    "use strict";

    jQuery(document).ready(function () {
        let currentPage = 1;  // Default starting page number
        let currentCategoryId = new URLSearchParams(window.location.search).get('category_id'); // Get category_id from the URL
        let isLoading = false; // Prevents multiple requests at the same time
        let hasMorePosts = true; // To check if there are more posts to load

        // Dynamically load categories
        $.get("./news/get_categories.php", function (data) {
            $("#categories").html(data);

            // Automatically load the first category's posts if no category is selected
            if (!currentCategoryId) {
                currentCategoryId = $("#categories li:first a").data("id");
                loadCategory(currentCategoryId);
            } else {
                // Highlight the active category in the sidebar
                $("#categories a").each(function () {
                    if ($(this).data("id") == currentCategoryId) {
                        $(this).addClass("active");
                    }
                });
                loadCategory(currentCategoryId);
            }
        }).fail(function () {
            console.error("Failed to load categories. Please check the path.");
        });

        // Load posts for a specific category
        $("#categories").on("click", "a", function (e) {
            e.preventDefault();
            const categoryId = $(this).data("id");
            currentCategoryId = categoryId; // Update current category ID
            currentPage = 1; // Reset to page 1 when category changes
            hasMorePosts = true; // Reset the flag for more posts
            $("#content").empty(); // Clear previous content
            loadCategory(categoryId); // Load new category posts
            updateUrl(categoryId); // Update URL with the new category
        });

        // Function to load posts for a given category ID and page
        function loadCategory(categoryId) {
            if (isLoading || !hasMorePosts) return; // Prevent duplicate loading

            isLoading = true; // Set loading state to true

            $.get("./news/get_posts.php", { category_id: categoryId, page: currentPage }, function (data) {
                if (data.trim() === "No posts found.") {
                    if (currentPage === 1) {
                        $("#content").html("<p>No posts available for this category at the moment.</p>");
                    }
                    hasMorePosts = false; // No more posts to load
                } else {
                    $("#content").append(data); // Append new posts
                    checkLikedPosts(); // Check if the post is already liked
                    currentPage++; // Increment page number for the next load
                }
                isLoading = false; // Reset loading state
            }).fail(function () {
                $("#content").append("<p>Failed to load posts. Please try again later.</p>");
                isLoading = false; // Reset loading state
            });
        }

        // Infinite scroll handling
        $(window).on("scroll", function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                if (!isLoading && hasMorePosts) {
                    loadCategory(currentCategoryId); // Load more posts as user scrolls
                }
            }
        });

        // Function to update the URL to reflect current category
        function updateUrl(categoryId) {
            window.history.pushState(null, "", "?category_id=" + categoryId);
        }

        // Check if the user has already liked the post (via check_if_liked.php)
        function checkLikedPosts() {
            $(".like-btn").each(function () {
                const postId = $(this).data("id");

                $.get("./news/check_if_liked.php", { post_id: postId }, function (response) {
                    if (response === "liked") {
                        $(this).prop('disabled', true).text('Liked');
                        $(this).addClass("liked"); // Apply "liked" class for styling
                    }
                });
            });
        }

        // View a post's full content
        $("#content").on("click", ".view-post", function (e) {
            e.preventDefault();
            const postId = $(this).data("id");
            fadeOutContent(() => {
                $.get("./news/get_post.php", { post_id: postId }, function (data) {
                    $("#content").html(data);
                    fadeInContent();
                    checkLikedPosts(); // Check liked status after viewing the post
                }).fail(function () {
                    $("#content").html("<p>Failed to load the post. Please try again later.</p>");
                    fadeInContent();
                });
            });
        });

        // Like a post
        $("#content").on("click", ".like-btn", function () {
            const postId = $(this).data("id");

            // Disable the like button immediately to prevent further clicks
            $(this).prop('disabled', true).text('Liked').addClass("liked"); // Add liked class for styling

            // Send like request to the backend
            $.post("./news/like_post.php", { post_id: postId }, function (data) {
                if (data === "You have already liked this post from this IP address.") {
                    alert(data); // Display message if user has already liked the post
                } else {
                    $(`#like-count-${postId}`).text(data); // Update the like count
                    $(this).addClass("liked"); // Apply the "liked" class for animation and style
                }
            }).fail(function () {
                alert("Failed to like the post. Please try again.");
            });
        });

        // Fade out content (animation before data load)
        function fadeOutContent(callback) {
            $("#content").fadeOut(300, function () {
                callback(); // Execute the data loading function after fade-out
            });
        }

        // Fade in content (animation after data load)
        function fadeInContent() {
            $("#content").fadeIn(300); // Fade in the content after it's loaded
        }
    });
})(jQuery);
