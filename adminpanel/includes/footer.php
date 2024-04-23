
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
    
    <?php 
    // Pages
    $pages_js="";
    if (!isset($page)) {
      //$pages_js = '<script src="./js/intervals.js"></script>';
    } else {
      switch ($page) {
        case 'manage-cluster':
            $pages_js = '<script src="./js/pgjs/cluster-js.js"></script>';
            break;
        case 'manage-exam':
            $pages_js = '<script src="./js/pgjs/exam-js.js"></script>';
            break;
        case 'manage-exam-edit':
            $pages_js = '<script src="./js/pgjs/exam-edit-js.js"></script>';
            break;
        case 'manage-examinee':
            $pages_js = '<script src="./js/pgjs/examinee-js.js"></script>';
            break;
        case 'report-ranking':
            $pages_js = '<script src="./js/pgjs/ranking-js.js"></script>';
            break;
        case 'report-ranking-exam':
            $pages_js = '<script src="./js/pgjs/ranking-exam-js.js"></script>';
            break;
        case 'report-examinee':
            break;
        case 'feedback':
            break;
        case 'manage-admin':
            break;
        default:
            break;
      }
    }
    ?>

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
    <script type="text/javascript" src="./js/admin-ajax.js"></script>
    <!-- Custom JS -->
    <script type="text/javascript" src="./js/admin-myjs.js"></script>
    <?php echo $pages_js; ?>
</body>
</html>