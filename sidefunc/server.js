$(document).ready(() => {
    const updateServerStatus = () => {
        $.ajax({
            url: 'sidefunc/server_status.php', // Backend endpoint
            method: 'GET',
            success: (response) => {
                if (response.status === 'success') {
                    // Update server status
                    $('#serverStatus').text(response.serverStatus ? 'Online' : 'Offline');

                    // Animate online count change
                    const currentCount = parseInt($('#onlineCount').text(), 10);
                    const newCount = response.onlineCount;

                    $({ count: currentCount }).animate(
                        { count: newCount },
                        {
                            duration: 1000,
                            easing: 'swing',
                            step: function (now) {
                                $('#onlineCount').text(Math.ceil(now));
                            }
                        }
                    );
                } else {
                    $('#serverStatus').text('Error');
                    $('#onlineCount').text('0');
                }
            },
            error: (xhr, status, error) => {
                console.error("Error fetching server status:", error);
                $('#serverStatus').text('Error');
                $('#onlineCount').text('0');
            }
        });
    };

    // Fetch server status on page load and every 10 seconds
    updateServerStatus();
    setInterval(updateServerStatus, 10000);
});
