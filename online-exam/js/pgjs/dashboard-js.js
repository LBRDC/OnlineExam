//Check Session
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: "warning",
        title: "NOTE",
        text: "Please Read all reminders before proceeding with the exam.",
    });
    document.getElementById('strt-btn').addEventListener('click', function() {
      var examId = this.getAttribute('data-exam-id');
      Swal.fire({
        title: 'Are you sure?',
        text: 'You want to take the exam now? Timer will start automatically.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, start now!'
      }).then((result) => {
        if (result.value) {
          window.location.href = "exam.php?id=" + examId;
        }
      });
    });
});

