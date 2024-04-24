<?php
    /*
        Fetch Exam Display Limit (Questions Per List Group)
        Fetch Exam Questions
    */
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
                <span class="font-weight-bold mr-2">Remaining Time: </span><input style="border:none;background-color: transparent;color:blue;font-size: 25px;" type="text" class="clock" value="00:00:00" size="5" readonly="true" />
            </div>    
            <div class="app-header__content">
                <div class="app-header-left">
                    <!-- EMPTY -->
                    <span class="font-weight-bold mr-2">Remaining Time: </span><input style="border:none;background-color: transparent;color:blue;font-size: 25px;" type="text" class="clock" value="00:00:00" size="5" readonly="true" />
                </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left  ml-3 mr-2 header-user-info">
                                    <div class="widget-heading">
                                        <?php 
                                        //echo htmlspecialchars($exmne_fname) . " ";
                                        //echo htmlspecialchars($exmne_minitial);
                                        //echo htmlspecialchars($exmne_lname) . " ";
                                        //echo htmlspecialchars($exmne_sfname);
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
                                <div>[EXAM]
                                    <div class="page-title-subheading">
                                        [DESCRIPTION]
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
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-group" name="Part_1">
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">1.)</span> Question 1</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row questions">
                                                        <div class="col-md-6">
                                                            <div class="">
                                                                <input type="radio" name="answer" id="answer-1">
                                                                <label for="answer-1" data-question-number="A">Choice 1</label>
                                                            </div>
                                                            <div class="">
                                                                <input type="radio" name="answer" id="answer-2"> 
                                                                <label for="answer-2" data-question-number="B">Choice 2</label>
                                                            </div>
                                                            <div class="">
                                                                <input type="radio" name="answer" id="answer-3">
                                                                <label for="answer-3" data-question-number="C">Choice 3</label>
                                                            </div>
                                                            <div class="">
                                                                <input type="radio" name="answer" id="answer-4">
                                                                <label for="answer-4" data-question-number="D">Choice 4</label>
                                                            </div>
                                                            <div class="">
                                                                <input type="radio" name="answer" id="answer-5"> 
                                                                <label for="answer-5" data-question-number="E">Choice 5</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="">
                                                                <input type="radio" name="answer" id="answer-6">
                                                                <label for="answer-6" data-question-number="F">Choice 6</label>
                                                            </div>
                                                            <div class="">
                                                                <input type="radio" name="answer" id="answer-7">
                                                                <label for="answer-7" data-question-number="G">Choice 7</label>
                                                            </div>
                                                            <div class="">
                                                                <input type="radio" name="answer" id="answer-8">
                                                                <label for="answer-8" data-question-number="H">Choice 8</label>
                                                            </div>
                                                            <div class="">
                                                                <input type="radio" name="answer" id="answer-9">
                                                                <label for="answer-9" data-question-number="I">Choice 9</label>
                                                            </div>
                                                            <div class="">
                                                                <input type="radio" name="answer" id="answer-10">
                                                                <label for="answer-10" data-question-number="J">Choice 10</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-center">
                                                    <img src="../../asset/img/avatars/default_user.webp" alt="">
                                                </div>
                                            </div>
                                            
                                            
                                        </li>
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">2.)</span> Question 2</h5>
                                            <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                                        </li>
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">3.)</span> Question 3</h5>
                                            <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                                        </li>
                                    </ul>
                                    <ul class="list-group" name="Part_2">
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">4.)</span> Question 4</h5>
                                            <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                                        </li>
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">5.)</span> Question 5</h5>
                                            <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                                        </li>
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">6.)</span> Question 6</h5>
                                            <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer justify-content-center">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Previous</button>
                                            <button type="button" class="btn btn-success ml-5 mr-5" style="width: 100px; height: 50px;">Submit</button>
                                            <button type="button" class="btn btn-primary">Next <i class="fa fa-arrow-circle-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# MAIN PAGE -->
<!-- #END# dashboard.php -->


<!-- #START# footer.php -->
                <!-- MAIN FOOTER 
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div> #END# MAIN FOOTER -->
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
    <!-- AJAX JS -->
    <script type="text/javascript" src="./js/exmne-ajax.js"></script>
    <!-- Custom JS -->
    <script type="text/javascript" src="./js/exmne-myjs.js"></script>
</body>
</html>