<script>
    sessionStorage.removeItem("reminderShown");
    sessionStorage.removeItem("camWorking");
</script>

<?php 
session_start();

session_unset();
session_destroy();

header("location:/online-exam/");
?>
