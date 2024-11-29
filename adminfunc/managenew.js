$(document).ready(function () {
    // Fetch and display categories
    const fetchCategories = () => {
        $.post('adminfunc/manage_categories.php', { action: 'fetch' }, function (response) {
            try {
                const res = JSON.parse(response); // Parse the JSON response
                if (res.status === 'success' && Array.isArray(res.data)) {
                    const categories = res.data;
                    let dropdown = '<option value="" disabled selected>Select Category</option>';
                    let listHtml = '';
                    categories.forEach((category) => {
                        dropdown += `<option value="${category.id}">${category.name}</option>`;
                        listHtml += `
                            <div class="category">
                                <div class="category-details">
                                    <h3>${category.name}</h3>
                                </div>
                                <div class="category-actions">
                                    <button class="edit-btn" onclick="editCategory(${category.id}, '${category.name}')">Edit</button>
                                    <button class="delete-btn" onclick="deleteCategory(${category.id})">Delete</button>
                                </div>
                            </div>
                        `;
                    });
                    $('#postCategory').html(dropdown);
                    $('#editPostCategory').html(dropdown); // Populate edit modal dropdown
                    $('#categoriesList').html(listHtml); // Populate category list
                } else {
                    console.error('Error fetching categories:', res.message || 'Invalid response structure');
                    alert(res.message || 'Failed to load categories.');
                }
            } catch (error) {
                console.error('Error parsing categories response:', error);
                alert('An error occurred while fetching categories.');
            }
        }).fail(function () {
            console.error('Error fetching categories');
            alert('An error occurred while fetching categories.');
        });
    };

    // Handle Add Category Submission
    $('#categoryForm').submit(function (e) {
        e.preventDefault(); // Prevent page refresh
        const categoryName = $('#categoryName').val().trim();

        if (!categoryName) {
            alert('Please enter a category name.');
            return;
        }

        $.post('adminfunc/manage_categories.php', { action: 'add', name: categoryName }, function (response) {
            try {
                const res = JSON.parse(response); // Parse the JSON response
                if (res.status === 'success') {
                    alert(res.message);
                    $('#categoryForm')[0].reset(); // Clear the form
                    fetchCategories(); // Refresh categories
                } else {
                    alert(res.message || 'Failed to add the category.');
                }
            } catch (error) {
                console.error('Error parsing add category response:', error);
                alert('An error occurred while adding the category.');
            }
        }).fail(function () {
            console.error('Error adding category');
            alert('An error occurred while adding the category.');
        });
    });

    // Fetch and display posts
    const fetchPosts = () => {
        $.post('adminfunc/manage_posts.php', { action: 'fetch' }, function (response) {
            try {
                const res = JSON.parse(response); // Parse the JSON response
                if (Array.isArray(res)) {
                    let html = '';
                    res.forEach((post) => {
                        html += `
                            <div class="post">
                                <h3>${post.title} <small>[Category: ${post.category_name}]</small></h3>
                                <p>${post.content}</p>
                                <div>
                                    <button class="edit-btn" onclick="openEditPostModal(${post.id}, '${post.title}', \`${post.content.replace(/`/g, '\\`')}\`, ${post.category_id})">Edit</button>
                                    <button class="delete-btn" onclick="deletePost(${post.id})">Delete</button>
                                </div>
                            </div>
                        `;
                    });
                    $('#postsList').html(html);
                } else {
                    console.error('Error fetching posts:', res.message || 'Invalid response structure');
                    alert(res.message || 'Failed to load posts.');
                }
            } catch (error) {
                console.error('Error parsing posts response:', error);
                alert('An error occurred while fetching posts.');
            }
        }).fail(function () {
            console.error('Error fetching posts');
            alert('An error occurred while fetching posts.');
        });
    };

    // Open Edit Post Modal
    window.openEditPostModal = (id, title, content, categoryId) => {
        $('#editPostTitle').val(title);
        tinyMCE.get('editPostContent').setContent(content);
        $('#editPostCategory').val(categoryId);
        $('#editPostForm').data('id', id); // Attach post ID to form
        $('#editPostModal').fadeIn(); // Show modal
    };

    // Close Edit Post Modal
    window.closeEditPostModal = () => {
        $('#editPostModal').fadeOut();
        $('#editPostForm')[0].reset();
        tinyMCE.get('editPostContent').setContent('');
        $('#editPostForm').removeData('id'); // Remove post ID
    };

    // Handle Edit Post Submission
    $('#editPostForm').submit(function (e) {
        e.preventDefault();
        const id = $(this).data('id');
        const postTitle = $('#editPostTitle').val();
        const postContent = tinyMCE.get('editPostContent').getContent();
        const postCategory = $('#editPostCategory').val();

        $.post('adminfunc/manage_posts.php', {
            action: 'edit',
            id,
            title: postTitle,
            content: postContent,
            category_id: postCategory,
        }, function (response) {
            try {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    alert(res.message);
                    closeEditPostModal();
                    fetchPosts();
                } else {
                    alert(res.message);
                }
            } catch (error) {
                console.error('Error parsing edit post response:', error);
                alert('An error occurred while updating the post.');
            }
        }).fail(function () {
            console.error('Error updating post');
            alert('An error occurred while updating the post.');
        });
    });

    // Handle Add Post Submission
    $('#postForm').submit(function (e) {
        e.preventDefault();
        const postTitle = $('#postTitle').val();
        const postContent = tinyMCE.get('postContent').getContent();
        const postCategory = $('#postCategory').val();

        if (!postTitle || !postContent || !postCategory) {
            alert('Please fill all fields.');
            return;
        }

        $.post('adminfunc/manage_posts.php', {
            action: 'add',
            title: postTitle,
            content: postContent,
            category_id: postCategory,
        }, function (response) {
            try {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    alert(res.message);
                    $('#postForm')[0].reset();
                    tinyMCE.get('postContent').setContent('');
                    fetchPosts();
                } else {
                    alert(res.message || 'Failed to add the post.');
                }
            } catch (error) {
                console.error('Error parsing add post response:', error);
                alert('An error occurred while adding the post.');
            }
        }).fail(function () {
            console.error('Error adding post');
            alert('An error occurred while adding the post.');
        });
    });

    // Delete post
    window.deletePost = (id) => {
        if (confirm('Are you sure you want to delete this post?')) {
            $.post('adminfunc/manage_posts.php', { action: 'delete', id }, function (response) {
                try {
                    const res = JSON.parse(response);
                    alert(res.message);
                    fetchPosts();
                } catch (error) {
                    console.error('Error parsing delete post response:', error);
                    alert('An error occurred while deleting the post.');
                }
            }).fail(function () {
                console.error('Error deleting post');
            });
        }
    };

    // Edit category
    window.editCategory = (id, name) => {
        const newName = prompt('Edit Category Name:', name);
        if (newName && newName !== name) {
            $.post('adminfunc/manage_categories.php', { action: 'edit', id, name: newName }, function (response) {
                try {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert(res.message);
                        fetchCategories();
                    } else {
                        alert(res.message);
                    }
                } catch (error) {
                    console.error('Error parsing edit category response:', error);
                    alert('An error occurred while editing the category.');
                }
            }).fail(function () {
                console.error('Error editing category');
                alert('An error occurred while editing the category.');
            });
        }
    };

    // Delete category
    window.deleteCategory = (id) => {
        if (confirm('Are you sure you want to delete this category?')) {
            $.post('adminfunc/manage_categories.php', { action: 'delete', id }, function (response) {
                try {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert(res.message);
                        fetchCategories();
                    } else {
                        alert(res.message);
                    }
                } catch (error) {
                    console.error('Error parsing delete category response:', error);
                    alert('An error occurred while deleting the category.');
                }
            }).fail(function () {
                console.error('Error deleting category');
                alert('An error occurred while deleting the category.');
            });
        }
    };

    // Initialize TinyMCE
    tinymce.init({
        selector: '#postContent, #editPostContent',
        plugins: 'link image lists code',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
        height: 200,
    });

    // Initial Data Fetch
    fetchCategories();
    fetchPosts();
});
