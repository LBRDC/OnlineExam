<?php
    session_start();
    include("../conn.php");
    
    // Header
    include("includes/header.php"); 
    
    //Main Page
    if (!isset($_SESSION['ex_user'])) {
        /* Redirect to login */
        echo '<div class="app-main__outer">';
    } else {
        include('includes/navbar.php');
        echo '<div class="app-main__outer">';
        // Pages
        @$page = $_GET['page'];
        if (!isset($page)) {
            include("pages/dashboard.php");
        } else {
            switch ($page) {
                case 'exam-list':
                    include("pages/exam-list.php");
                    break;
                case 'exam':
                    include("pages/exam.php");
                    break;
                default:
                    include("pages/404.php");
                    break;
            }
        }
    }

    // Footer
    include("includes/footer.php");
    include("includes/modals.php"); 

    //Modals
    if (!isset($_SESSION['ex_user'])) {
        /* Redirect to login */
    } else {
        // Pages
        @$page = $_GET['page'];
        if (!isset($page)) {
            include("modals/mdl-dashboard.php");
        } else {
            switch ($page) {
                case 'exam-list':
                    include("modals/mdl-exam-list.php");
                    break;
                case 'exam':
                    include("modals/mdl-exam.php");
                    break;
                default:
                    break;
            }
        }
    }
    