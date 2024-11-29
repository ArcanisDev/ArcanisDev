$(document).ready(function () {
    // Fetch and display general options
    const fetchGeneralOptions = () => {
        $.post('adminfunc/manage_general.php', { action: 'fetch' }, function (response) {
            console.log("Raw server response:", response); // Log the raw response
            try {
                const res = typeof response === 'object' ? response : JSON.parse(response); // Parse JSON only if not already an object
                if (res.status === 'success') {
                    const options = res.data;
                    $('#youtubeLink').val(options.youtube_link || '');
                    $('#discordLink').val(options.discord_link || '');
                    $('#megaMirror').val(options.mega_mirror || '');
                    $('#driveMirror').val(options.drive_mirror || '');
                    $('#indexTitle').val(options.index_title || '');
                    $('#metaKeywords').val(options.meta_keywords || '');
                    $('#metaDescription').val(options.meta_description || '');
                } else {
                    alert(res.message || 'Failed to load general options.');
                }
            } catch (error) {
                console.error('Error parsing general options response:', error, response); // Include raw response in error log
                alert('An error occurred while fetching general options.');
            }
        }).fail(function () {
            console.error('Error fetching general options');
            alert('An error occurred while fetching general options.');
        });
    };

    // Handle General Options Form Submission
    $('#generalOptionsForm').submit(function (e) {
        e.preventDefault();
        const data = {
            action: 'update',
            youtube_link: $('#youtubeLink').val(),
            discord_link: $('#discordLink').val(),
            mega_mirror: $('#megaMirror').val(),
            drive_mirror: $('#driveMirror').val(),
            index_title: $('#indexTitle').val(),
            meta_keywords: $('#metaKeywords').val(),
            meta_description: $('#metaDescription').val(),
        };

        console.log("Submitting data:", data); // Log data being sent
        $.post('adminfunc/manage_general.php', data, function (response) {
            console.log("Raw server response (update):", response); // Log the raw response
            try {
                const res = typeof response === 'object' ? response : JSON.parse(response); // Parse JSON only if not already an object
                if (res.status === 'success') {
                    alert(res.message);
                    fetchGeneralOptions(); // Refresh options after successful update
                } else {
                    alert(res.message || 'Failed to update general options.');
                }
            } catch (error) {
                console.error('Error parsing general options update response:', error, response); // Include raw response in error log
                alert('An error occurred while updating general options.');
            }
        }).fail(function () {
            console.error('Error updating general options');
            alert('An error occurred while updating general options.');
        });
    });

    // Fetch and display all users for webadmin selection
    const fetchUsers = () => {
        $.post('adminfunc/manage_users.php', { action: 'fetch' }, function (response) {
            console.log("Raw server response (users):", response); // Log raw response
            try {
                const res = typeof response === 'object' ? response : JSON.parse(response); // Parse JSON if necessary
                if (res.status === 'success') {
                    let html = '<option value="" disabled selected>Select User</option>';
                    res.data.forEach(user => {
                        html += `
                            <option value="${user.id}">${user.username} (${user.email})</option>
                        `;
                    });
                    $('#newWebAdmin').html(html);
                    let userListHtml = '';
                    res.data.forEach(user => {
                        userListHtml += `
                            <div class="user-item">
                                <span>${user.username} (${user.email})</span>
                                <button class="edit-btn remove" onclick="toggleWebAdmin(${user.id}, ${user.webadmin})">
                                    ${user.webadmin === 1 ? 'Remove WebAdmin' : 'Set WebAdmin'}
                                </button>
                            </div>
                        `;
                    });
                    $('#userList').html(userListHtml);
                } else {
                    alert(res.message || 'Failed to load users.');
                }
            } catch (error) {
                console.error('Error parsing users response:', error, response); // Include raw response in error log
                alert('An error occurred while fetching users.');
            }
        }).fail(function () {
            console.error('Error fetching users');
            alert('An error occurred while fetching users.');
        });
    };

    // Add WebAdmin
    $('#addWebAdminButton').click(function () {
        const userId = $('#newWebAdmin').val();
        if (!userId) {
            alert('Please select a user to add as WebAdmin.');
            return;
        }

        $.post('adminfunc/manage_users.php', { action: 'update_webadmin', id: userId, webadmin: 1 }, function (response) {
            console.log("Raw server response (add webadmin):", response); // Log raw response
            try {
                const res = typeof response === 'object' ? response : JSON.parse(response); // Parse JSON if necessary
                if (res.status === 'success') {
                    alert(res.message);
                    fetchUsers(); // Refresh users list
                } else {
                    alert(res.message || 'Failed to add WebAdmin.');
                }
            } catch (error) {
                console.error('Error parsing add webadmin response:', error, response); // Include raw response in error log
                alert('An error occurred while adding WebAdmin.');
            }
        }).fail(function () {
            console.error('Error adding WebAdmin');
            alert('An error occurred while adding WebAdmin.');
        });
    });

    // Toggle WebAdmin Status
    window.toggleWebAdmin = (id, currentStatus) => {
        const newStatus = currentStatus === 1 ? 0 : 1;
        $.post('adminfunc/manage_users.php', { action: 'update_webadmin', id, webadmin: newStatus }, function (response) {
            console.log("Raw server response (toggle webadmin):", response); // Log raw response
            try {
                const res = typeof response === 'object' ? response : JSON.parse(response); // Parse JSON if necessary
                if (res.status === 'success') {
                    alert(res.message);
                    fetchUsers(); // Refresh users list
                } else {
                    alert(res.message || 'Failed to update webadmin status.');
                }
            } catch (error) {
                console.error('Error parsing update webadmin response:', error, response); // Include raw response in error log
                alert('An error occurred while updating webadmin status.');
            }
        }).fail(function () {
            console.error('Error updating webadmin status');
            alert('An error occurred while updating webadmin status.');
        });
    };

    // Initial Data Fetch
    fetchGeneralOptions();
    fetchUsers();
});
