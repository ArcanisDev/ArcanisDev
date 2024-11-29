$(document).ready(function () {
    // Function to fetch users and populate the GM table
    const fetchUsers = () => {
        $.post('adminfunc/manage_gms.php', { action: 'fetch' }, function (response) {
            console.log('Server Response:', response); // Debugging

            // Ensure the response is in the correct structure
            if (response && response.status === 'success' && Array.isArray(response.data)) {
                const users = response.data;
                let html = '<table class="table">';
                html += `
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Account Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                `;
                users.forEach(user => {
                    html += `
                        <tr>
                            <td>${user.id}</td>
                            <td>${user.username}</td>
                            <td>${user.email}</td>
                            <td>
                                <select class="account-type-select" data-id="${user.id}">
                                    <option value="0" ${user.accounttype == 0 ? 'selected' : ''}>0</option>
                                    <option value="1" ${user.accounttype == 1 ? 'selected' : ''}>1</option>
                                    <option value="2" ${user.accounttype == 2 ? 'selected' : ''}>2</option>
                                    <option value="3" ${user.accounttype == 3 ? 'selected' : ''}>3</option>
                                    <option value="4" ${user.accounttype == 4 ? 'selected' : ''}>4</option>
                                    <option value="5" ${user.accounttype == 5 ? 'selected' : ''}>5</option>
                                    <option value="6" ${user.accounttype == 6 ? 'selected' : ''}>6</option>
                                </select>
                            </td>
                            <td>
                                <button class="save-account-type-btn btn btn-success" data-id="${user.id}">Save</button>
                            </td>
                        </tr>
                    `;
                });
                html += '</tbody></table>';
                $('#gmList').html(html);
            } else {
                alert(response.message || 'Unexpected response structure from the server.');
            }
        }).fail(function () {
            console.error('Error fetching users');
            alert('An error occurred while fetching users.');
        });
    };

    // Event listener for saving account type changes
    $(document).on('click', '.save-account-type-btn', function () {
        const userId = $(this).data('id');
        const accountType = $(`.account-type-select[data-id="${userId}"]`).val();

        console.log('Updating User:', userId, 'with Account Type:', accountType); // Debugging

        // Send POST request to update the account type
        $.post('adminfunc/manage_gms.php', {
            action: 'update',
            id: userId,
            account_type: accountType,
        }, function (response) {
            console.log('Update Response:', response); // Debugging
            if (response.status === 'success') {
                alert('Account type updated successfully.');
                fetchUsers(); // Refresh the user list
            } else {
                alert(`Error: ${response.message}`);
            }
        }).fail(function () {
            console.error('Error updating account type');
            alert('An error occurred while updating the account type.');
        });
    });

    // Initial fetch of users when the page loads
    fetchUsers();
});
