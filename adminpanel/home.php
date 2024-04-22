<?php
    session_start();
    include("../conn.php");
    
    // Header
    include("includes/header.php"); 
    
    //Main Page
    if (!isset($_SESSION['user'])) {
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
                case 'manage-cluster':
                    include("pages/manage-cluster.php");
                    break;
                case 'manage-exam':
                    include("pages/manage-exam.php");
                    break;
                case 'manage-exam-edit':
                    include("pages/manage-exam-edit.php");
                    break;
                case 'manage-examinee':
                    include("pages/manage-examinee.php");
                    break;
                case 'report-ranking':
                    include("pages/report-ranking.php");
                    break;
                case 'report-examinee':
                    include("pages/report-examinee.php");
                    break;
                case 'feedback':
                    include("pages/feedback.php");
                    break;
                case 'manage-admin':
                    include("pages/manage-admin.php");
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
    if (!isset($_SESSION['user'])) {
        /* Redirect to login */
    } else {
        // Pages
        @$page = $_GET['page'];
        if (!isset($page)) {
        } else {
            switch ($page) {
                case 'manage-cluster':
                    include("modals/mdl-manage-cluster.php");
                    break;
                case 'manage-exam':
                    include("modals/mdl-manage-exam.php");
                    break;
                case 'manage-exam-edit':
                    include("modals/mdl-manage-exam-edit.php");
                    break;
                case 'manage-examinee':
                    include("modals/mdl-manage-examinee.php");
                    break;
                case 'report-ranking':
                    include("modals/mdl-report-ranking.php");
                    break;
                case 'report-examinee':
                    include("modals/mdl-report-examinee.php");
                    break;
                case 'feedback':
                    include("modals/mdl-feedback.php");
                    break;
                case 'manage-admin':
                    include("modals/mdl-manage-admin.php");
                    break;
                default:
                    break;
            }
        }
    }
    