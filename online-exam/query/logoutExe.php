<script>sessionStorage.removeItem("reminderShown");</script>

<?php 
session_start();

session_unset();
session_destroy();

header("location:/online-exam/");
?>