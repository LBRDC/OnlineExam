
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
        $pages_js = '<script src="./js/pgjs/dashboard-js.js"></script>';
    } else {
      switch ($page) {
        case 'exam-list':
            $pages_js = '<script src="./js/pgjs/exam-list-js.js"></script>';
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
    <script type="text/javascript" src="./js/exmne-ajax.js"></script>
    <!-- Custom JS -->
    <script type="text/javascript" src="./js/exmne-myjs.js"></script>
    <?php echo $pages_js; ?>
</body>
</html>