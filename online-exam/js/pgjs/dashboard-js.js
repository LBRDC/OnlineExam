//Check Session
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: "warning",
        title: "NOTE",
        text: "Please Read all reminders before proceeding with the exam.",
    });
    /*document.addEventListener("visibilitychange", (event) => {
        if (document.visibilityState == "visible") {
          console.log("tab is active")
        } else {
          console.log("tab is inactive")
          Swal.fire({
            icon: "error",
            title: "CHEATING DETECTED",
            text: "Psalm 37:23-24 The LORD makes firm the steps of the one who delights in him; though he may stumble, he will not fall, for the LORD upholds him with his hand.",
          });
        }
      });*/
});
