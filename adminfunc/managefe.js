$(document).ready(function () {
    const fetchFeatures = () => {
        console.log('Fetching features...');
        $.post('adminfunc/manage_features.php', { action: 'fetch' }, function (data) {
            const features = JSON.parse(data);
            let html = '';
            features.forEach((feature) => {
                html += `
                    <div class="feature">
                        <div>
                            <h3>${feature.title}</h3>
                            <p>${feature.content}</p>
                            <p><small>${feature.date}</small></p>
                        </div>
                        <div>
                            <button class="edit-btn" onclick="editFeature(${feature.id}, '${feature.title}', '${feature.content}')">Edit</button>
                            <button class="delete-btn" onclick="deleteFeature(${feature.id})">Delete</button>
                        </div>
                    </div>
                `;
            });
            $('#featuresList').html(html);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.error('Error fetching features:', textStatus, errorThrown);
        });
    };

    const addFeature = () => {
        const formData = {
            title: $('#featureTitle').val(),
            content: $('#featureContent').val(),
        };

        console.log('Adding feature:', formData);

        $.post('adminfunc/add_feature.php', formData, function (response) {
            console.log('Add Feature Response:', response);

            const res = JSON.parse(response);
            alert(res.message);

            if (res.success) {
                $('#featureForm')[0].reset(); // Clear form
                fetchFeatures(); // Reload features list
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.error('Error adding feature:', textStatus, errorThrown);
            alert('Failed to add feature.');
        });
    };

    $('#featureForm').submit(function (e) {
        e.preventDefault();

        const id = $('#featureId').val(); // Check if an ID exists
        if (id) {
            // Editing existing feature
            const formData = {
                action: 'edit',
                id,
                title: $('#featureTitle').val(),
                content: $('#featureContent').val(),
            };

            console.log('Editing feature:', formData);

            $.post('adminfunc/manage_features.php', formData, function (response) {
                const res = JSON.parse(response);
                alert(res.message);
                fetchFeatures();
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.error('Error editing feature:', textStatus, errorThrown);
                alert('Failed to edit feature.');
            });
        } else {
            // Adding new feature
            console.log('Adding new feature');
            addFeature();
        }
    });

    // Attach global functions for inline usage
    window.editFeature = (id, title, content) => {
        $('#featureId').val(id);
        $('#featureTitle').val(title);
        $('#featureContent').val(content);
        $('#featureTitle').focus();
    };

    window.deleteFeature = (id) => {
        if (confirm('Are you sure you want to delete this feature?')) {
            $.post('adminfunc/manage_features.php', { action: 'delete', id }, function (response) {
                const res = JSON.parse(response);
                alert(res.message);
                fetchFeatures();
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.error('Error deleting feature:', textStatus, errorThrown);
                alert('Failed to delete feature.');
            });
        }
    };

    // Initial fetch
    fetchFeatures();
});
