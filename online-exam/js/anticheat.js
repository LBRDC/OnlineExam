var pgActive = true;
document.addEventListener('DOMContentLoaded', function() {
  document.addEventListener("visibilitychange", (event) => {
      if (document.visibilityState == "visible") {
        pgActive = true;
        console.log("tab active");
      } else {
        pgActive = false;
        console.log("tab inactive");
        alert("CHEATING DETECTED\n\nPsalm 37:23-24 The LORD makes firm the steps of the one who delights in him; though he may stumble, he will not fall, for the LORD upholds him with his hand.");
      }
  });
});


