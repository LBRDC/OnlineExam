<?php
    /*
        Fetch Exam Attempts
        Fetch Examinee Details
        Fetch Exam Details
    */
    
?>

<!-- #START# feedback.php -->
                <!-- ### FEEDBACK PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-comment icon-gradient bg-grow-early">
                                    </i>
                                </div>
                                <div>Feedbacks
                                    <div class="page-title-subheading">
                                        View Feedbacks
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Feedbacks</li>
                            </ol>
                            </div>
                        </div>
                    </div>
                    <!-- Actions -->
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <h5 class="card-title">Filter</h5>
                                    <div class="row">
                                        <div class="col-lg-2 col-md-4 mr-1 mb-2">
                                            <label for="filter_datefrom">From</label>
                                            <input type="date" class="form-control" name="filter_datefrom" id="filter_datefrom">
                                        </div> 
                                        <div class="col-lg-2 col-md-4 mr-1 mb-2">
                                            <label for="filter_dateto">To</label>
                                            <input type="date" class="form-control" name="filter_dateto" id="filter_dateto">
                                        </div> 
                                        <div class="col-md-1 d-flex align-items-end mb-2">
                                            <button class="btn btn-lg btn-primary mr-2" id="filter-btn">Filter</button>
                                            <button class="btn btn-lg btn-secondary" id="reset-btn">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- END Actions --> 
                    <!-- TABLE -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <div class="card-title">Feedback List</div>
                                    <div class="table-responsive">
                                        <table class="mb-0 table table-hover dt-sort" id="tableList" width="100%">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Feedback</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <!--<tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Feedback</th>
                                                <th>Date</th>
                                            </tr>
                                            </tfoot>-->
                                            <tbody>
                                            <?php
                                            //Fetch Feedback
                                            $stmt1 = $conn->prepare("SELECT * FROM feedback_tbl ORDER BY fb_id DESC");
                                            $stmt1->execute();

                                            while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                                $fb_id = $row['fb_id'];
                                                $exmne_id = $row['exmne_id'];
                                                $fb_exmne_as = $row['fb_exmne_as'];
                                                $fb_feedback = $row['fb_feedback'];
                                                $fb_date = $row['fb_date'];
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($fb_exmne_as); ?></td>
                                                <td><?php echo htmlspecialchars($fb_feedback); ?></td>
                                                <td><?php echo htmlspecialchars($fb_date); ?></td>
                                            </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# FEEDBACK PAGE -->
<!-- #END# feedback.php -->
