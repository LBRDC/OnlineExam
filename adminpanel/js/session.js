//Check Session
document.addEventListener('DOMContentLoaded', function() {
    let timerInterval;
    $.ajax({
        url: 'query/session.php',
        type: 'POST',
        dataType: "json",
        success: function(response) {
            if (response.res == "valid") {
                //alert('User Valid.');
            } else if (response.res == "invalid") {
                Swal.fire({
                    icon: "error",
                    title: "Session Expired!",
                    html: "Redirecting in <b>5</b> seconds.", // Changed to seconds
                    timer: 5000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                        const timer = Swal.getPopup().querySelector("b");
                        timerInterval = setInterval(() => {
                            // Convert milliseconds to seconds and update the timer text every second
                            timer.textContent = `${Math.ceil(Swal.getTimerLeft() / 1000)}`;
                        }, 1000); // Update every second
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                }).then(function() {
                    window.location.href = '/';
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Session Error",
                    html: "Redirecting in <b>5</b> seconds.", // Changed to seconds
                    timer: 5000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const timer = Swal.getPopup().querySelector("b");
                        timerInterval = setInterval(() => {
                            // Convert milliseconds to seconds and update the timer text every second
                            timer.textContent = `${Math.ceil(Swal.getTimerLeft() / 1000)}`;
                        }, 1000); // Update every second
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                }).then(function() {
                    window.location.href = '/';
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('An error occurred with the session.');
            console.error(textStatus, errorThrown);
            window.location.href = '/';
        }
    });
});