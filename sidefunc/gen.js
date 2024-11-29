$(document).ready(() => {
    // Fetch YouTube and Discord links
    $.ajax({
        url: 'sidefunc/web_general.php', // Backend script to fetch the data
        method: 'GET',
        success: (response) => {
            if (response.status === 'success') {
                const data = response.data;

                // Extract YouTube video ID
                const videoId = getYouTubeVideoId(data.youtube_link);
                if (videoId) {
                    // Prepare the embed URL
                    const embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&loop=1&mute=0&controls=0&modestbranding=1&disablekb=0&fs=0&playlist=${videoId}`;

                    // Set the YouTube iframe source
                    $('#youtubeIframe').attr('src', embedUrl);

                    // Add a click fallback for sound
                    $('#youtubeIframe').on('click', () => {
                        $('#youtubeIframe').attr('src', embedUrl); // Reload iframe with the same URL
                    });
                } else {
                    console.error('Invalid YouTube link:', data.youtube_link);
                }

                // Set the Discord button link
                $('#discordButton').attr('href', data.discord_link);
            } else {
                console.error("Error fetching data:", response.message);
            }
        },
        error: (xhr, status, error) => {
            console.error("AJAX error:", error, xhr.responseText);
        }
    });
});

// Helper function to extract YouTube video ID
const getYouTubeVideoId = (url) => {
    const regex = /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([^&]+)/;
    const match = url.match(regex);
    return match ? match[1] : null;
};
