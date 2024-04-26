<?php
    session_start();
    include("../conn.php");
    
    if (isset($_SESSION['ex_user']['exmne_fname']) && isset($_SESSION['ex_user']['exmne_lname'])) {
        $exmne_fname = $_SESSION['ex_user']['exmne_fname'];
        $exmne_lname = $_SESSION['ex_user']['exmne_lname'];
      } else {
        $exmne_fname = 'null';
        $exmne_lname = 'null';
      }
    
      if (isset($_SESSION['ex_user']['exmne_mname'])) {
        $exmne_mname = $_SESSION['ex_user']['exmne_mname'];
        $exmne_minitial = substr($exmne_mname, 0, 1) . ". ";
      } else {
        $exmne_minitial = '_ ';
      }
    
      if (isset($_SESSION['ex_user']['exmne_sfname'])) {
        $exmne_sfname = $_SESSION['ex_user']['exmne_sfname'];
      } else {
        $exmne_sfname = '';
      }  
    
    /*
        Fetch Exam Display Limit (Questions Per List Group)
        Fetch Exam Questions
    */
    $ex_id = $_GET['id'];
    $exmne_clu_id = $_SESSION['ex_user']['exmne_clu_id'];
    $exmne_id = $_SESSION['ex_user']['exmne_id'];
    //Select ex_title, ex_description, ex_time_limit, ex_qstn_limit, ex_disable_prv, ex_random_qstn
    $stmt1 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :ex_id");
    $stmt1->bindparam(':ex_id', $ex_id);
    $stmt1->execute();

    $ex_details = $stmt1->fetch(PDO::FETCH_ASSOC);
    $ex_title = $ex_details['ex_title'];
    $ex_description = $ex_details['ex_description'];
    $ex_time_limit = $ex_details['ex_time_limit'];
    $ex_qstn_limit = $ex_details['ex_qstn_limit'];
    $ex_disable_prv = $ex_details['ex_disable_prv'];
    $ex_random_qstn = $ex_details['ex_random_qstn'];

    if ($ex_random_qstn == 'yes') {
        $orderBy = "ORDER BY RAND()";
    } else {
        $orderBy = "ORDER BY exqstn_id ASC";
    }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>LBRDC | Online Exam</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <link href="../../asset/img/logo/lbrdc-logo-rnd.webp" rel="icon">
    <link href="../../css/main.min.css" rel="stylesheet">
    <link href="../../css/sweetalert.css" rel="stylesheet">
    <link href="../../css/select2.min.css" rel="stylesheet">
    <link href="../../css/select2-bootstrap4.min.css" rel="stylesheet">
    <link href="../../css/datatables.css" rel="stylesheet">
    <link href="../../css/custom.css" rel="stylesheet">
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
<!-- #END# header.php -->

<!-- #START# navbar.php -->
        <!-- NAVBAR MAIN -->
        <div class="app-header header-shadow">
            <div class="app-header__logo" style="width: auto;">
                <div class="logo-src"></div>
                <!--<div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>-->
            </div>
            <!--<div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>-->
            <div class="app-header__menu">
                <!--<span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>-->
                <span class="font-weight-bold mr-2">Remaining Time: </span><input style="border:none;background-color: transparent;color:blue;font-size: 25px;" type="text" class="clock" id="disp_clock_mobile" value="00:00" size="5" readonly="true" />
            </div>    
            <div class="app-header__content">
                <div class="app-header-left">
                    <!-- EMPTY -->
                    <span class="font-weight-bold mr-2">Remaining Time: </span><input style="border:none;background-color: transparent;color:blue;font-size: 25px;" type="text" class="clock" id="disp_clock" value="00:00" size="5" readonly="true" />
                </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left  ml-3 mr-2 header-user-info">
                                    <div class="widget-heading">
                                        <?php 
                                        echo htmlspecialchars($exmne_fname) . " ";
                                        echo htmlspecialchars($exmne_minitial);
                                        echo htmlspecialchars($exmne_lname) . " ";
                                        echo htmlspecialchars($exmne_sfname);
                                        ?>
                                    </div>
                                    <div class="widget-subheading">
                                        <?php echo htmlspecialchars("Examinee"); ?>
                                    </div>
                                </div>
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <img width="42" class="rounded-circle" src="../../asset/img/avatars/default_user.webp" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- #END# NAVBAR MAIN -->  

<!-- #START# ui-theme.php -->
        <!-- THEME SETTINGS -->
        <div class="ui-theme-settings">
            <!--<button type="button" id="TooltipDemo" class="btn-open-options btn btn-warning">
                <i class="fa fa-cog fa-w-16 fa-spin fa-2x"></i>
            </button>-->
            <div class="theme-settings__inner">
                <div class="scrollbar-container">
                    <div class="theme-settings__options-wrapper">
                        <h3 class="themeoptions-heading">Layout Options
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="switch has-switch switch-container-class" data-class="fixed-header">
                                                    <div class="switch-animate switch-on">
                                                        <input type="checkbox" checked data-toggle="toggle" data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Header
                                                </div>
                                                <div class="widget-subheading">Makes the header top fixed, always visible!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="switch has-switch switch-container-class" data-class="fixed-sidebar">
                                                    <div class="switch-animate switch-on">
                                                        <input type="checkbox" checked data-toggle="toggle" data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Sidebar
                                                </div>
                                                <div class="widget-subheading">Makes the sidebar left fixed, always visible!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="switch has-switch switch-container-class" data-class="fixed-footer">
                                                    <div class="switch-animate switch-off">
                                                        <input type="checkbox" data-toggle="toggle" data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Footer
                                                </div>
                                                <div class="widget-subheading">Makes the app footer bottom fixed, always visible!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!--<h3 class="themeoptions-heading">
                            <div>
                                Header Options
                            </div>
                            <button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-header-cs-class" data-class="">
                                Restore Default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Choose Color Scheme
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div class="swatch-holder bg-primary switch-header-cs-class" data-class="bg-primary header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-secondary switch-header-cs-class" data-class="bg-secondary header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-success switch-header-cs-class" data-class="bg-success header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-info switch-header-cs-class" data-class="bg-info header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-warning switch-header-cs-class" data-class="bg-warning header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-danger switch-header-cs-class" data-class="bg-danger header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-light switch-header-cs-class" data-class="bg-light header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-dark switch-header-cs-class" data-class="bg-dark header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-focus switch-header-cs-class" data-class="bg-focus header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-alternate switch-header-cs-class" data-class="bg-alternate header-text-light">
                                        </div>
                                        <div class="divider">
                                        </div>
                                        <div class="swatch-holder bg-vicious-stance switch-header-cs-class" data-class="bg-vicious-stance header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-midnight-bloom switch-header-cs-class" data-class="bg-midnight-bloom header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-night-sky switch-header-cs-class" data-class="bg-night-sky header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-slick-carbon switch-header-cs-class" data-class="bg-slick-carbon header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-asteroid switch-header-cs-class" data-class="bg-asteroid header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-royal switch-header-cs-class" data-class="bg-royal header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-warm-flame switch-header-cs-class" data-class="bg-warm-flame header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-night-fade switch-header-cs-class" data-class="bg-night-fade header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-sunny-morning switch-header-cs-class" data-class="bg-sunny-morning header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-tempting-azure switch-header-cs-class" data-class="bg-tempting-azure header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-amy-crisp switch-header-cs-class" data-class="bg-amy-crisp header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-heavy-rain switch-header-cs-class" data-class="bg-heavy-rain header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-mean-fruit switch-header-cs-class" data-class="bg-mean-fruit header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-malibu-beach switch-header-cs-class" data-class="bg-malibu-beach header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-deep-blue switch-header-cs-class" data-class="bg-deep-blue header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-ripe-malin switch-header-cs-class" data-class="bg-ripe-malin header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-arielle-smile switch-header-cs-class" data-class="bg-arielle-smile header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-plum-plate switch-header-cs-class" data-class="bg-plum-plate header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-fisher switch-header-cs-class" data-class="bg-happy-fisher header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-happy-itmeo switch-header-cs-class" data-class="bg-happy-itmeo header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-mixed-hopes switch-header-cs-class" data-class="bg-mixed-hopes header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-strong-bliss switch-header-cs-class" data-class="bg-strong-bliss header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-grow-early switch-header-cs-class" data-class="bg-grow-early header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-love-kiss switch-header-cs-class" data-class="bg-love-kiss header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-premium-dark switch-header-cs-class" data-class="bg-premium-dark header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-green switch-header-cs-class" data-class="bg-happy-green header-text-light">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div>Sidebar Options</div>
                            <button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-sidebar-cs-class" data-class="">
                                Restore Default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Choose Color Scheme
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div class="swatch-holder bg-primary switch-sidebar-cs-class" data-class="bg-primary sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-secondary switch-sidebar-cs-class" data-class="bg-secondary sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-success switch-sidebar-cs-class" data-class="bg-success sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-info switch-sidebar-cs-class" data-class="bg-info sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-warning switch-sidebar-cs-class" data-class="bg-warning sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-danger switch-sidebar-cs-class" data-class="bg-danger sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-light switch-sidebar-cs-class" data-class="bg-light sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-dark switch-sidebar-cs-class" data-class="bg-dark sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-focus switch-sidebar-cs-class" data-class="bg-focus sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-alternate switch-sidebar-cs-class" data-class="bg-alternate sidebar-text-light">
                                        </div>
                                        <div class="divider">
                                        </div>
                                        <div class="swatch-holder bg-vicious-stance switch-sidebar-cs-class" data-class="bg-vicious-stance sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-midnight-bloom switch-sidebar-cs-class" data-class="bg-midnight-bloom sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-night-sky switch-sidebar-cs-class" data-class="bg-night-sky sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-slick-carbon switch-sidebar-cs-class" data-class="bg-slick-carbon sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-asteroid switch-sidebar-cs-class" data-class="bg-asteroid sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-royal switch-sidebar-cs-class" data-class="bg-royal sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-warm-flame switch-sidebar-cs-class" data-class="bg-warm-flame sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-night-fade switch-sidebar-cs-class" data-class="bg-night-fade sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-sunny-morning switch-sidebar-cs-class" data-class="bg-sunny-morning sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-tempting-azure switch-sidebar-cs-class" data-class="bg-tempting-azure sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-amy-crisp switch-sidebar-cs-class" data-class="bg-amy-crisp sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-heavy-rain switch-sidebar-cs-class" data-class="bg-heavy-rain sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-mean-fruit switch-sidebar-cs-class" data-class="bg-mean-fruit sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-malibu-beach switch-sidebar-cs-class" data-class="bg-malibu-beach sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-deep-blue switch-sidebar-cs-class" data-class="bg-deep-blue sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-ripe-malin switch-sidebar-cs-class" data-class="bg-ripe-malin sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-arielle-smile switch-sidebar-cs-class" data-class="bg-arielle-smile sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-plum-plate switch-sidebar-cs-class" data-class="bg-plum-plate sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-fisher switch-sidebar-cs-class" data-class="bg-happy-fisher sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-happy-itmeo switch-sidebar-cs-class" data-class="bg-happy-itmeo sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-mixed-hopes switch-sidebar-cs-class" data-class="bg-mixed-hopes sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-strong-bliss switch-sidebar-cs-class" data-class="bg-strong-bliss sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-grow-early switch-sidebar-cs-class" data-class="bg-grow-early sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-love-kiss switch-sidebar-cs-class" data-class="bg-love-kiss sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-premium-dark switch-sidebar-cs-class" data-class="bg-premium-dark sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-green switch-sidebar-cs-class" data-class="bg-happy-green sidebar-text-light">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div>Main Content Options</div>
                            <button type="button" class="btn-pill btn-shadow btn-wide ml-auto active btn btn-focus btn-sm">Restore Default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Page Section Tabs
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div role="group" class="mt-2 btn-group">
                                            <button type="button" class="btn-wide btn-shadow btn-primary btn btn-secondary switch-theme-class" data-class="body-tabs-line">
                                                Line
                                            </button>
                                            <button type="button" class="btn-wide btn-shadow btn-primary active btn btn-secondary switch-theme-class" data-class="body-tabs-shadow">
                                                Shadow
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>-->
                    </div>
                </div>
            </div>
        </div> <!-- #END# THEME SETTINGS -->
<!-- #END# ui-theme.php -->

        <div class="app-main">
            <!-- MAIN SIDEBAR
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <li class="app-sidebar__heading"></li>
                            <li>
                                <a href="home.php" class="<?php //if($activePage=="home"){echo"mm-active";} ?>">
                                    <i class="metismenu-icon pe-7s-home"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Examination</li>
                            <li>
                                <a href="?page=exam-list" class="<?php //if($activePage=="exam-list"){echo"mm-active";} ?>">
                                    <i class="metismenu-icon pe-7s-study"></i>
                                    Examination List
                                </a>
                            </li>
                            <li class="app-sidebar__heading"><hr class="sidebar-divider"></li>
                            <li style="padding-right: 139px;">
                                <a href="javascript:void(0);" class="m-0 p-0 text-monospace text-muted" data-toggle="modal" data-target="#mdlSystemInfo">
                                    v0.3.0-alpha
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> #END# SIDEBAR -->
<!-- #END# navbar.php -->

            <div class="app-main__outer" style="padding-left: 0px;">
            <div id="scrollTop"></div>

<!-- #START# dashboard.php -->
                <!-- ### MAIN PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-pen icon-gradient bg-grow-early">
                                    </i>
                                </div>
                                <div><?php echo htmlspecialchars($ex_title); ?>
                                    <div class="page-title-subheading" id="exDesc">
                                        <?php echo htmlspecialchars($ex_description); ?>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="page-title-actions">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                                </ol>
                            </div>-->
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-12 col-xl-10 mb-4">
                            <div class="card" id="examCard">
                                <div class="card-header justify-content-center"> 
                                    <span class="pr-1">Page</span><span class="current-page pr-1">1</span>of<span class="total-pages pl-1">1</span>
                                </div>
                                <div class="card-body">
                                    <div class="">
                                        <table class="table table-borderless dt-sort" id="tableList" style="width:100%">
                                            <thead>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                            <?php
                                                //Select exqstn_id, exam_image, exam_question, exam_ch1-10, exqstn_answer
                                                //Randomize if ex_random_qstn = yes else order by ascending
                                                $stmt2 = $conn->prepare("SELECT * FROM exam_question_tbl WHERE ex_id = :ex_id $orderBy");
                                                $stmt2->bindParam(':ex_id', $ex_id);
                                                $stmt2->execute();
                                                
                                                $i = 0;
                                                $ch_id = 0;

                                                //Loop through each exam ID fetched from exam_cluster_tbl
                                                    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                                    $exqstn_id = $row['exqstn_id'];
                                                    $exam_image = $row['exam_image'];
                                                    $exam_question = $row['exam_question'];
                                                    $exam_ch1 = $row['exam_ch1'];
                                                    $exam_ch2 = $row['exam_ch2'];
                                                    $exam_ch3 = $row['exam_ch3'];
                                                    $exam_ch4 = $row['exam_ch4'];
                                                    $exam_ch5 = $row['exam_ch5'];
                                                    $exam_ch6 = $row['exam_ch6'];
                                                    $exam_ch7 = $row['exam_ch7'];
                                                    $exam_ch8 = $row['exam_ch8'];
                                                    $exam_ch9 = $row['exam_ch9'];
                                                    $exam_ch10 = $row['exam_ch10'];
                                                    $exqstn_answer = $row['exqstn_answer'];
                                            ?>
                                            <tr id="scrollRow">
                                                <td>
                                                    <ul class="list-group">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <?php $i++; ?>
                                                                    <h6 class="list-group-item-heading"><span class="font-weight-bold"><?php echo htmlspecialchars($i); ?>.)</span> <?php echo htmlspecialchars($exam_question); ?></h5>
                                                                    <div class="row questions scrollQuest" id="questionsContainer">
                                                                        <div class="col-md-6">
                                                                            <?php 
                                                                            $ch_id++; 
                                                                            if (isset($exam_ch1) && $exam_ch1 != '') {
                                                                            ?>
                                                                            <div class="">
                                                                                <input 
                                                                                type="radio" 
                                                                                name="answer[<?php echo htmlspecialchars($exqstn_id); ?>][correct]" 
                                                                                id="choice_<?php echo htmlspecialchars($ch_id); ?>"
                                                                                value="<?php echo htmlspecialchars($exam_ch1); ?>"
                                                                                onclick="updateHiddenInput(this)">
                                                                                <label for="choice_<?php echo htmlspecialchars($ch_id); ?>" data-question-number="A">
                                                                                    <?php echo htmlspecialchars($exam_ch1); ?>
                                                                                </label>
                                                                            </div>
                                                                            <?php } ?>
                                                                            <?php 
                                                                            $ch_id++; 
                                                                            if (isset($exam_ch2) && $exam_ch2 != '') {
                                                                            ?>
                                                                            <div class="">
                                                                                <input 
                                                                                type="radio" 
                                                                                name="answer[<?php echo htmlspecialchars($exqstn_id); ?>][correct]" 
                                                                                id="choice_<?php echo htmlspecialchars($ch_id); ?>"
                                                                                value="<?php echo htmlspecialchars($exam_ch2); ?>"
                                                                                onclick="updateHiddenInput(this)">
                                                                                <label for="choice_<?php echo htmlspecialchars($ch_id); ?>" data-question-number="B">
                                                                                    <?php echo htmlspecialchars($exam_ch2); ?>
                                                                                </label>
                                                                            </div>
                                                                            <?php } ?>
                                                                            <?php 
                                                                            $ch_id++; 
                                                                            if (isset($exam_ch3) && $exam_ch3 != '') {
                                                                            ?>
                                                                            <div class="">
                                                                                <input 
                                                                                type="radio" 
                                                                                name="answer[<?php echo htmlspecialchars($exqstn_id); ?>][correct]" 
                                                                                id="choice_<?php echo htmlspecialchars($ch_id); ?>"
                                                                                value="<?php echo htmlspecialchars($exam_ch3); ?>"
                                                                                onclick="updateHiddenInput(this)">
                                                                                <label for="choice_<?php echo htmlspecialchars($ch_id); ?>" data-question-number="C">
                                                                                    <?php echo htmlspecialchars($exam_ch3); ?>
                                                                                </label>
                                                                            </div>
                                                                            <?php } ?>
                                                                            <?php 
                                                                            $ch_id++; 
                                                                            if (isset($exam_ch4) && $exam_ch4 != '') {
                                                                            ?>
                                                                            <div class="">
                                                                                <input 
                                                                                type="radio" 
                                                                                name="answer[<?php echo htmlspecialchars($exqstn_id); ?>][correct]" 
                                                                                id="choice_<?php echo htmlspecialchars($ch_id); ?>"
                                                                                value="<?php echo htmlspecialchars($exam_ch4); ?>"
                                                                                onclick="updateHiddenInput(this)">
                                                                                <label for="choice_<?php echo htmlspecialchars($ch_id); ?>" data-question-number="D">
                                                                                    <?php echo htmlspecialchars($exam_ch4); ?>
                                                                                </label>
                                                                            </div>
                                                                            <?php } ?>
                                                                            <?php 
                                                                            $ch_id++; 
                                                                            if (isset($exam_ch5) && $exam_ch5 != '') {
                                                                            ?>
                                                                            <div class="">
                                                                                <input 
                                                                                type="radio" 
                                                                                name="answer[<?php echo htmlspecialchars($exqstn_id); ?>][correct]" 
                                                                                id="choice_<?php echo htmlspecialchars($ch_id); ?>"
                                                                                value="<?php echo htmlspecialchars($exam_ch5); ?>"
                                                                                onclick="updateHiddenInput(this)">
                                                                                <label for="choice_<?php echo htmlspecialchars($ch_id); ?>" data-question-number="E">
                                                                                    <?php echo htmlspecialchars($exam_ch5); ?>
                                                                                </label>
                                                                            </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <?php 
                                                                            $ch_id++; 
                                                                            if (isset($exam_ch6) && $exam_ch6 != '') {
                                                                            ?>
                                                                            <div class="">
                                                                                <input 
                                                                                type="radio" 
                                                                                name="answer[<?php echo htmlspecialchars($exqstn_id); ?>][correct]" 
                                                                                id="choice_<?php echo htmlspecialchars($ch_id); ?>"
                                                                                value="<?php echo htmlspecialchars($exam_ch6); ?>"
                                                                                onclick="updateHiddenInput(this)">
                                                                                <label for="choice_<?php echo htmlspecialchars($ch_id); ?>" data-question-number="F">
                                                                                    <?php echo htmlspecialchars($exam_ch6); ?>
                                                                                </label>
                                                                            </div>
                                                                            <?php } ?>
                                                                            <?php 
                                                                            $ch_id++; 
                                                                            if (isset($exam_ch7) && $exam_ch7 != '') {
                                                                            ?>
                                                                            <div class="">
                                                                                <input 
                                                                                type="radio" 
                                                                                name="answer[<?php echo htmlspecialchars($exqstn_id); ?>][correct]" 
                                                                                id="choice_<?php echo htmlspecialchars($ch_id); ?>"
                                                                                value="<?php echo htmlspecialchars($exam_ch7); ?>"
                                                                                onclick="updateHiddenInput(this)">
                                                                                <label for="choice_<?php echo htmlspecialchars($ch_id); ?>" data-question-number="G">
                                                                                    <?php echo htmlspecialchars($exam_ch7); ?>
                                                                                </label>
                                                                            </div>
                                                                            <?php } ?>
                                                                            <?php 
                                                                            $ch_id++; 
                                                                            if (isset($exam_ch8) && $exam_ch8 != '') {
                                                                            ?>
                                                                            <div class="">
                                                                                <input 
                                                                                type="radio" 
                                                                                name="answer[<?php echo htmlspecialchars($exqstn_id); ?>][correct]" 
                                                                                id="choice_<?php echo htmlspecialchars($ch_id); ?>"
                                                                                value="<?php echo htmlspecialchars($exam_ch8); ?>"
                                                                                onclick="updateHiddenInput(this)">
                                                                                <label for="choice_<?php echo htmlspecialchars($ch_id); ?>" data-question-number="H">
                                                                                    <?php echo htmlspecialchars($exam_ch8); ?>
                                                                                </label>
                                                                            </div>
                                                                            <?php } ?>
                                                                            <?php 
                                                                            $ch_id++; 
                                                                            if (isset($exam_ch9) && $exam_ch9 != '') {
                                                                            ?>
                                                                            <div class="">
                                                                                <input 
                                                                                type="radio" 
                                                                                name="answer[<?php echo htmlspecialchars($exqstn_id); ?>][correct]" 
                                                                                id="choice_<?php echo htmlspecialchars($ch_id); ?>"
                                                                                value="<?php echo htmlspecialchars($exam_ch9); ?>"
                                                                                onclick="updateHiddenInput(this)">
                                                                                <label for="choice_<?php echo htmlspecialchars($ch_id); ?>" data-question-number="I">
                                                                                    <?php echo htmlspecialchars($exam_ch9); ?>
                                                                                </label>
                                                                            </div>
                                                                            <?php } ?>
                                                                            <?php 
                                                                            $ch_id++; 
                                                                            if (isset($exam_ch10) && $exam_ch10 != '') {
                                                                            ?>
                                                                            <div class="">
                                                                                <input 
                                                                                type="radio" 
                                                                                name="answer[<?php echo htmlspecialchars($exqstn_id); ?>][correct]" 
                                                                                id="choice_<?php echo htmlspecialchars($ch_id); ?>"
                                                                                value="<?php echo htmlspecialchars($exam_ch10); ?>"
                                                                                onclick="updateHiddenInput(this)">
                                                                                <label for="choice_<?php echo htmlspecialchars($ch_id); ?>" data-question-number="J">
                                                                                    <?php echo htmlspecialchars($exam_ch10); ?>
                                                                                </label>
                                                                            </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 text-center">
                                                                <?php if ($exam_image != "") { ?>
                                                                    <a href="javascript:void(0);" id="viewimg-btn" data-toggle="modal" data-target="#mdlViewImage" data-view-img="<?php echo htmlspecialchars($exam_image); ?>">
                                                                        <img src="../uploads/exam_question/<?php echo htmlspecialchars($exam_image); ?>" alt="<?php echo htmlspecialchars($exam_image); ?>" class="img-fluid" >
                                                                    </a>
                                                                    <?php } else { echo ""; }?>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <form method="post" id="submitAnswerFrm">
                                    <input type="text" name="exam_id" id="exam_id" value="<?php echo htmlspecialchars($ex_id); ?>" hidden>
                                    <input type="text" name="timeLimit" id="timeLimit" value="<?php echo htmlspecialchars($ex_time_limit); ?>" hidden>
                                    <input type="text" name="examLimit" id="examLimit" value="<?php echo htmlspecialchars($ex_qstn_limit); ?>" hidden>
                                    <input type="text" name="examUser" id="examUser" value="<?php echo htmlspecialchars($exmne_id); ?>" hidden>
                                    <input type="text" name="examAction" id="examAction" hidden>
                                    <input type="text" name="disablePrevBtn" id="disablePrevBtn" value="<?php echo htmlspecialchars($ex_disable_prv); ?>" hidden>
                                    <!-- ANSWERS HIDDEN INPUTS -->
                                    <?php 
                                    $stmt3 = $conn->prepare("SELECT * FROM exam_question_tbl WHERE ex_id = :ex_id");
                                    $stmt3->bindParam(':ex_id', $ex_id);
                                    $stmt3->execute();

                                    if($stmt3->rowCount() >  0) { //if stmnt
                                        while ($qstnRow = $stmt3->fetch(PDO::FETCH_ASSOC)) { //While loop
                                            $qstn_Id = $qstnRow['exqstn_id'];
                                    ?>
                                    <input type="hidden" name="answer[<?php echo htmlspecialchars($qstn_Id); ?>][correct]" id="qstnAns_<?php echo htmlspecialchars($qstn_Id); ?>" value="">
                                    <?php 
                                        } //END while Loop 
                                    } //END if stmnt
                                    ?>
                                <div class="card-footer justify-content-center">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary" id="prev-btn"><i class="fa fa-arrow-circle-left"></i> Previous</button>
                                            <button type="button" class="btn btn-success ml-5 mr-5" id="submit-btn" style="width: 100px; height: 50px;">Submit</button>
                                            <button type="button" class="btn btn-primary" id="nxt-btn">Next <i class="fa fa-arrow-circle-right"></i></button>
                                        </div>
                                    </div>
                                    <!-- END ANSWERS HIDDEN INPUTS -->
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# MAIN PAGE -->
<!-- #END# dashboard.php -->


<!-- #START# footer.php -->
                <!-- MAIN FOOTER --> 
                <div class="app-wrapper-footer">
                    <div class="app-footer">
                        <div class="app-footer__inner justify-content-center">
                            <div class="container my-auto">
                                <div class="copyright text-center my-auto">
                                    <div class="col-md-12">
                                        <span>copyright &copy; <script> document.write(new Date().getFullYear()); </script> - developed by
                                        <b><a href="https://lbpresources.com" target="_blank">LBP Resources and Development Corp.</a></b>
                                        </span>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="javascript:void(0);" class="text-monospace justify-content-center" data-toggle="modal" data-target="#mdlSystemInfo">
                                            <u>v0.3.0-alpha</u>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# MAIN FOOTER -->
            </div> <!-- END app-main__inner div -->
        </div> <!-- END app-main div -->
    </div> <!-- END app-container div -->

    <!-- SCRIPTS -->
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <!-- Template JS -->
    <script type="text/javascript" src="../../js/main.min.js"></script>
    <!-- SweetAlert JS -->
    <script type="text/javascript" src="../../js/sweetalert.js"></script>
    <!-- Select2 JS -->
    <script type="text/javascript" src="../../js/select2.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" src="../../js/datatables.js"></script>
    <!-- session -->
    <script src="./js/session.js"></script>
    <script src="./js/anticheat.js"></script>
    <!-- AJAX JS -->
    <script type="text/javascript" src="./js/exmne-ajax.js"></script>
    <!-- Custom JS -->
    <script type="text/javascript" src="./js/exam-js.js"></script>
    <script>
        //Function Update Form Hidden Input
        function updateHiddenInput(radio) {
            // Get the name of the selected radio button
            var radioName = radio.name;

            // Find the hidden input field with the same name and update its value
            var hiddenInputs = document.getElementsByName(radioName);
            for (var i = 0; i < hiddenInputs.length; i++) {
                if (hiddenInputs[i].type === 'hidden') {
                    hiddenInputs[i].value = radio.value;
                    break;
                }
            }
        }
    </script>
    <script>
        // View Image Modal
        document.querySelectorAll('#viewimg-btn').forEach(function(viewimgbtn) {
            viewimgbtn.addEventListener('click', function() {
                var imageFilename = this.getAttribute('data-view-img');

                var imageUrl = '../uploads/exam_question/' + imageFilename;

                // Update the image source in the modal
                var modalImage = document.querySelector('#mdlViewImage .modal-body img');
                modalImage.src = imageUrl;
                modalImage.alt = 'Image for exam ID ' + imageFilename;
            });
        });
    </script>
    <script>
    document.getElementById('prev-btn').addEventListener('click', function() {
        // Scroll to the top of the page
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    document.getElementById('nxt-btn').addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    </script>
</body>
</html>

<!-- System Info MODAL -->
<div class="modal fade" id="mdlSystemInfo" tabindex="-1" role="dialog" aria-labelledby="mdlSystemInfoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlSystemInfoLabel">System Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row m-2">
                    <div class="col-md-12">
                        <h5 class="font-weight-bold text-center">Online Exam Management System</h5>
                        <div class="text-justify">
                            The "Online Exam Management System" is a web-based application tailored to enhance the administrative processes associated with examinations. 
                            The system enables easy creation, modification, and conducting of examinations, simplifying applicant management improving the user experience and administrative operations. 
                            A dedicated examination page supports a seamless online testing experience, optimized for performance and usability. 
                        </div>
                    </div>
                </div>
                <div class="row m-2">
                    <div class="col-md-12">
                        <div class="divider"></div>
                    </div>
                </div>
                <div class="row m-2">
                    <div class="col-md-6">
                        <div class="mb-2">Lead Developer:</div>
                        <div class="font-weight-bold text-center">Mark Aldrin J. Fule</div>
                        <div class="text-center">IT Specialist</div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">Assistant Developer:</div>
                        <div class="font-weight-bold text-center">George S. De Vera Jr.</div>
                        <div class="text-center">IT Intern</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- #END# System Info MODAL -->

<!-- VIEW IMAGE MODAL -->
<div class="modal" id="mdlViewImage" tabindex="-1" role="dialog" aria-labelledby="mdlViewImageLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlViewImageLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">  
                    <img src="" alt="" style="width: 80%; height: 80%;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> <!-- #END# VIEW IMAGE MODAL -->