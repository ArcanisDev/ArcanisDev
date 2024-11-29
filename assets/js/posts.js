$(document).ready(function () {
    // Load categories
    $.get('fetch_categories.php', function (categories) {
        let categoryHtml = '';
        categories.forEach(category => {
            categoryHtml += `<li><a href="#" class="category-link" data-id="${category.id}"><img src="assets/img/flower.png" alt="">${category.name}</a></li>`;
        });
        $('.patch__list ul').html(categoryHtml);

        // Load the first category by default
        if (categories.length > 0) {
            loadPosts(categories[0].id);
        }
    });

    // Load posts on category click
    $(document).on('click', '.category-link', function (e) {
        e.preventDefault();
        const categoryId = $(this).data('id');
        loadPosts(categoryId);
    });

    // Like post
    $(document).on('click', '.like-button', function () {
        const postId = $(this).data('id');
        $.post('like_post.php', { post_id: postId }, function (response) {
            alert(response.message);
        });
    });

    // Load posts
    function loadPosts(categoryId) {
        $.get(`fetch_posts.php?category_id=${categoryId}`, function (posts) {
            let postHtml = '';
            posts.forEach(post => {
                postHtml += `
                    <div class="single__time">
                        <h2>${post.title}</h2>
                        <p>${post.content}</p>
                        <button class="like-button" data-id="${post.id}">Like</button>
                    </div>`;
            });
            $('.patch__timelist').html(postHtml);
        });
    }
});
