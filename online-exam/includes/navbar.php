<?php
    // Active Page
  if (!isset($_GET['page'])) {
    $activePage = 'home';
    //$page = 'null';
  } else {
    $activePage = $_GET['page'];
  }
  //class="mm-active"

  if (isset($_SESSION['ex_user']['exmne_fname']) && isset($_SESSION['ex_user']['exmne_lname'])) {
    $exmne_fname = $_SESSION['ex_user']['exmne_fname'];
    $exmne_lname = $_SESSION['ex_user']['exmne_lname'];
  } else {
    $exmne_fname = 'null';
    $exmne_lname = 'null';
  }

  if ($_SESSION['ex_user']['exmne_mname'] != "") {
    $exmne_mname = $_SESSION['ex_user']['exmne_mname'];
    $exmne_minitial = substr($exmne_mname, 0, 1) . ". ";
  } else {
    $exmne_minitial = '_ ';
  }

  if ($_SESSION['ex_user']['exmne_sfname'] != "") {
    $exmne_sfname = $_SESSION['ex_user']['exmne_sfname'];
  } else {
    $exmne_sfname = '';
  }  

  $exmne_Id = $_SESSION['ex_user']['exmne_id'];

  // fetch feedback
  $stmt1 = $conn->prepare("SELECT * FROM feedback_tbl WHERE exmne_id = :fb_ExmneId LIMIT 1");
  $stmt1->bindParam(':fb_ExmneId', $exmne_Id);
  $stmt1->execute();

  if ($stmt1->rowCount() > 0) {
    $fb = $stmt1->fetch(PDO::FETCH_ASSOC);
    $fb_txt = $fb['fb_feedback'];
    $fb_anon = $fb['fb_exmne_as'];
  } else {
    $fb_txt = '';
    $fb_anon = '';  
  }

?>

<!-- #START# navbar.php -->
        <!-- NAVBAR MAIN -->
        <div class="app-header header-shadow">
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
            <div class="app-header__content">
                <div class="app-header-left">
                    <!-- EMPTY -->
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
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            <img width="42" class="rounded-circle" src="../../asset/img/avatars/default_user.webp" alt="">
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <button type="button" tabindex="0" class="dropdown-item">User Account</button>
                                            <div tabindex="-1" class="dropdown-divider"></div>
                                            <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#mdlLogout">Logout</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- #END# NAVBAR MAIN -->  

        <!-- ########## UI-THEME HERE ########## -->
        <?php include("ui-theme.php") ?>

        <div class="app-main">
            <!-- MAIN SIDEBAR -->
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
                                <a href="home.php" class="<?php if($activePage=="home"){echo"mm-active";} ?>">
                                    <i class="metismenu-icon pe-7s-home"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Examination</li>
                            <li>
                                <a href="?page=exam-list" class="<?php if($activePage=="exam-list"){echo"mm-active";} ?>">
                                    <i class="metismenu-icon pe-7s-study"></i>
                                    Examination List
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Feedback</li>
                            <li>
                                <a href="javascript:void(0);" id="feedback-btn" class="" data-toggle="modal" data-target="#mdlFeedback" 
                                data-feedback-id="<?php echo htmlspecialchars($exmne_Id); ?>"
                                data-feedback-txt="<?php echo htmlspecialchars($fb_txt); ?>"
                                data-feedback-anon="<?php echo htmlspecialchars($fb_anon); ?>">
                                    <i class="metismenu-icon pe-7s-comment"></i>
                                    Feedback
                                </a>
                            </li>
                            <li class="app-sidebar__heading"><hr class="sidebar-divider"></li>
                            <li style="padding-right: 139px;">
                                <a href="javascript:void(0);" class="m-0 p-0 text-monospace text-muted" data-toggle="modal" data-target="#mdlSystemInfo">
                                    v0.3.4
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- #END# SIDEBAR -->
<!-- #END# navbar.php -->
