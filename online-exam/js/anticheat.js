document.addEventListener('DOMContentLoaded', function() {
  document.addEventListener("visibilitychange", (event) => {
      if (document.visibilityState == "visible") {
        console.log("tab is active");
      } else {
        console.log("tab is inactive");
        // Close any existing Swal alerts if you want to ensure no Swal alerts are open
        // Use the default browser alert instead of Swal
        alert("CHEATING DETECTED\n\nPsalm 37:23-24 The LORD makes firm the steps of the one who delights in him; though he may stumble, he will not fall, for the LORD upholds him with his hand.");
      }
  });
});


