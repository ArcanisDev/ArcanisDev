// Function to fetch and display features
const fetchFeatures = () => {
    $.ajax({
        url: 'sidefunc/features.php', // Backend script to fetch features
        method: 'GET',
        success: (response) => {
            if (response.status === 'success') {
                populateFeatures(response.features);
            } else {
                console.error("Failed to fetch features:", response);
            }
        },
        error: (xhr, status, error) => {
            console.error("AJAX error:", error, xhr.responseText);
        }
    });
};

// Function to populate features into the section
const populateFeatures = (features) => {
    const featureContent = $('#featureContent');
    featureContent.empty(); // Clear any existing content

    features.forEach((feature, index) => {
        const delay = index * 50; // Incremental delay for AOS animation
        const featureHtml = `
            <div class="single__feature" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="${delay}">
                <div class="inner_single">
                    <h4>${feature.title}</h4>
                    <p>${feature.content}</p>
                </div>
            </div>
        `;
        featureContent.append(featureHtml);
    });
};

// Call the function on page load
$(document).ready(() => {
    fetchFeatures();
});
