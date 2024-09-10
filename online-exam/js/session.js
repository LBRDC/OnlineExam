// Check Session
document.addEventListener('DOMContentLoaded', function () {
    let timerInterval;
    
    // Function to check session
    function checkSession() {
        $.ajax({
            url: 'query/session.php',
            type: 'POST',
            dataType: "json",
            success: function (response) {
                if (response.res == "valid") {
                    // alert('User Valid.');
                } else if (response.res == "invalid") {
                    Swal.fire({
                        icon: "error",
                        title: "Session Invalid!",
                        text: "Redirecting to login page.",
                        timer: 5000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                            const timer = Swal.getPopup().querySelector("b");
                            timerInterval = setInterval(() => {
                                timer.textContent = `${Math.ceil(Swal.getTimerLeft() / 1000)}`;
                            }, 1000); // Update every second
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then(function () {
                        window.location.href = 'query/logoutExe.php';
                    });
                } else if (response.res == "mismatch") {
                    Swal.fire({
                        icon: "error",
                        title: "Session Expired!",
                        text: "Redirecting to login page.",
                        timer: 5000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                            const timer = Swal.getPopup().querySelector("b");
                            timerInterval = setInterval(() => {
                                timer.textContent = `${Math.ceil(Swal.getTimerLeft() / 1000)}`;
                            }, 1000); // Update every second
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then(function () {
                        window.location.href = 'query/logoutExe.php';
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Session Error",
                        html: "Redirecting to login page.",
                        timer: 5000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                            const timer = Swal.getPopup().querySelector("b");
                            timerInterval = setInterval(() => {
                                timer.textContent = `${Math.ceil(Swal.getTimerLeft() / 1000)}`;
                            }, 1000); // Update every second
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then(function () {
                        window.location.href = 'query/logoutExe.php';
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('An error occurred with the session.');
                console.error(textStatus, errorThrown);
                window.location.href = 'query/logoutExe.php';
            }
        });
    }

    // Initial session check
    checkSession();
    
    // Run checkSession every 3 minutes (180000 milliseconds)
    setInterval(checkSession, 180000);
});