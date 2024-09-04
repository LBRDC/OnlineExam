<?php
    /*
        Fetch Exam Attempts
        Fetch Examinee Details
        Fetch Exam Details
    */
    //exatmpt_id, exmne_id, ex_id, ex_score, ex_total, exatmpt_no, exatmpt_date, exatmpt_time, exatmpt_created FROM examinee_attempt WHERE 1
    $stmt1 = $conn->prepare("SELECT * FROM examinee_attempt ORDER BY exatmpt_id DESC");
    $stmt1->execute();

    //rowcount > 0
    if ($stmt1->rowCount() > 0) {
        $export_Enabled = 'true';
    } else {
        $export_Enabled = 'false';
    }
?>

<!-- #START# report-examinee.php -->
                <!-- ### RESULT PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-note2 icon-gradient bg-grow-early">
                                    </i>
                                </div>
                                <div>Examinee Result Report
                                    <div class="page-title-subheading">
                                        View Examinee Result Report
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                <li class="breadcrumb-item">Report</li>
                                <li class="breadcrumb-item active" aria-current="page">Result</li>
                            </ol>
                            </div>
                        </div>
                    </div>
                    <!-- Actions -->
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <?php if ($export_Enabled == 'true') { ?>
                                    <h5 class="card-title">Actions</h5>
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <a href="javascript:void(0);" id="save-btn" data-toggle="modal" data-target="#mdlSaveResult">
                                                <div class="font-icon-wrapper font-icon-lg btn" data-toggle="tooltip" data-placement="bottom" title="Save Results">
                                                    <i class="fa fa-save icon-gradient bg-vicious-stance"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <?php } ?>
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
                                    <div class="card-title">Examinee List</div>
                                    <div class="table-responsive">
                                        <table class="mb-0 table table-hover dt-sort" id="tableList" width="100%">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Exam Name</th>
                                                <th>Score</th>
                                                <th>Percentage</th>
                                                <th>Date</th>
                                                <th>Cheated</th>
                                                <th data-dt-order="disable">Action</th>
                                            </tr>
                                            </thead>
                                            <!--<tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Exam Name</th>
                                                <th>Score</th>
                                                <th>Percentage</th>
                                                <th data-dt-order="disable">Action</th>
                                            </tr>
                                            </tfoot>-->
                                            <tbody>
                                            <?php 
                                            while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                                $exatmpt_id = $row['exatmpt_id'];
                                                $exmne_id = $row['exmne_id'];
                                                $ex_id = $row['ex_id'];
                                                $ex_score = $row['ex_score'];
                                                $ex_total = $row['ex_total'];
                                                $ex_cheat = ($row['cheat_cnt'] > 0) ? 'Yes' : 'No';
                                                $exatmpt_no = $row['exatmpt_no'];
                                                $exatmpt_date = $row['exatmpt_date'];
                                                //$exatmpt_time = $row['exatmpt_time'];
                                                $exatmpt_created = $row['exatmpt_created'];

                                                $stmt2 = $conn->prepare("SELECT * FROM examinee_tbl WHERE exmne_id = :exmne_id");
                                                $stmt2->bindParam(':exmne_id', $exmne_id);
                                                $stmt2->execute();

                                                if ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                                    // Prepare examinee name
                                                    $exmne_fname = $row['exmne_fname'] != '' ? $row['exmne_fname'] : 'null';
                                                    $exmne_mname = $row['exmne_mname'] != '' ? substr($row['exmne_mname'], 0, 1) . ". " : '_ ';
                                                    $exmne_lname = $row['exmne_lname'] != '' ? $row['exmne_lname'] : 'null';
                                                    $exmne_sfname = $row['exmne_sfname'] != '' ? $row['exmne_sfname'] : '';
                                                    $exmne_name = $exmne_lname . ', ' . $exmne_fname . ' ' . $exmne_mname . $exmne_sfname;
                                                }

                                                $stmt3 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :ex_id");
                                                $stmt3->bindParam(':ex_id', $ex_id);
                                                $stmt3->execute();

                                                if ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                                    $ex_title = isset($row['ex_title']) ? $row['ex_title'] : 'null';
                                                }
                                                
                                                $percentage = number_format(($ex_total > 0? ($ex_score / $ex_total) * 100 : 0), 2);
                                                ?>
                                                <tr>
                                                <td><?php echo htmlspecialchars($exmne_name); ?></td>
                                                <td><?php echo htmlspecialchars($ex_title); ?></td>
                                                <td><?php echo htmlspecialchars($ex_score) . "/" . htmlspecialchars($ex_total); ?></td>
                                                <td><?php echo htmlspecialchars($percentage) . "%"; ?></td>
                                                <td><?php echo htmlspecialchars($exatmpt_date); ?></td>
                                                <td><?php echo htmlspecialchars($ex_cheat); ?></td>
                                                <td>
                                                    <a href="?page=report-examinee-result&exmne=<?php echo htmlspecialchars($exmne_id); ?>&exam=<?php echo htmlspecialchars($ex_id); ?>" class="btn btn-primary m-1" id="view-btn" data-toggle="tooltip" data-placement="bottom" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# RESULT PAGE -->
<!-- #END# report-examinee.php -->
