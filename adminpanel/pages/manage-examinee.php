<?php
    $stmt1 = $conn->prepare("SELECT * FROM examinee_tbl ORDER BY exmne_created DESC");
    $selCluster = $stmt1->execute();

    $exmne_status = 1;
    $stmt2 = $conn->prepare("SELECT * FROM examinee_tbl WHERE exmne_status = :exmne_status");
    $stmt2->bindParam(':exmne_status', $exmne_status);
    $stmt2->execute();
?>

<!-- #START# manage-examinee.php -->
                <!-- ### Examinee PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-users icon-gradient bg-grow-early">
                                    </i>
                                </div>
                                <div>Examinee Management
                                    <div class="page-title-subheading">
                                        Manage Examinee Information
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                <li class="breadcrumb-item">Management</li>
                                <li class="breadcrumb-item active" aria-current="page">Examinee</li>
                            </ol>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xl-4">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading"><?php echo $stmt2->rowCount(); ?></div>
                                            <div class="widget-subheading">Active Examinees</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#mdlAddExaminee" data-toggle="tooltip" data-placement="bottom" title="Add Examinee">
                                                    <i class="fa fa-3x fa-plus-circle icon-gradient bg-grow-early"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Filter Options -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                            <div class="card-body">
                                    <div class="card-title">Filter Options</div>
                                    <div class="row">
                                        <div class="col-md-3 mr-2 mb-2">
                                            <label for="filter_status">Status</label>
                                            <select class="form-control" name="filter_status" id="filter_status">
                                                <option value="">Select...</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div> 
                                        <div class="col-md-3 mr-2 mb-2">
                                            <label for="filter_cluster">Cluster</label>
                                            <select class="form-control" name="filter_cluster" id="filter_cluster">
                                                <option value="">Select...</option>
                                                <?php 
                                                $stmtflt = $conn->prepare("SELECT * FROM cluster_tbl ORDER BY clu_id ASC");
                                                $stmtflt->execute();
                                                $result = $stmtflt->fetchAll(PDO::FETCH_ASSOC);
                                                
                                                // Check if there are any clusters
                                                if ($stmtflt->rowCount() > 0) {
                                                    foreach ($result as $row) {
                                                        // Check if clu_status is 1 and append "Inactive" to the cluster name
                                                        $clu_name = $row['clu_status'] == 0 ? $row['clu_name'] . " (Inactive)" : $row['clu_name'];
                                                        echo '<option value="' . htmlspecialchars($row['clu_name']) . '">' . htmlspecialchars($clu_name) . '</option>';
                                                    }
                                                } else {
                                                    // Display a message if there are no clusters
                                                    echo '<option value="" disabled="disabled">No clusters available</option>';
                                                }
                                                ?>
                                            </select>
                                        </div> 
                                        <div class="col-md-3 d-flex align-items-end mb-2">
                                            <button class="btn btn-lg btn-primary mr-2" id="filter-btn">Filter</button>
                                            <button class="btn btn-lg btn-secondary" id="reset-btn">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                <th>Cluster</th>
                                                <th>Email</th>
                                                <th>Properties</th>
                                                <th>Status</th>
                                                <th data-dt-order="disable">Action</th>
                                            </tr>
                                            </thead>
                                            <!--<tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Cluster</th>
                                                <th>Email</th>
                                                <th>Properties</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>-->
                                            <tbody>
                                            <?php
                                                while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                                    $exmne_id = $row['exmne_id'];
                                                    $exmne_clu_id = $row['exmne_clu_id'];
                                                    $exmne_fname = $row['exmne_fname'];
                                                    $exmne_mname = $row['exmne_mname'];
                                                    $exmne_lname = $row['exmne_lname'];
                                                    $exmne_sfname = $row['exmne_sfname'];
                                                    $exmne_sex = $row['exmne_sex'];
                                                    $exmne_birthdate = $row['exmne_birthdate'];
                                                    $exmne_disablecam = $row['exmne_disablecam'];
                                                    $exmne_email = $row['exmne_email'];
                                                    $exmne_pass = $row['exmne_pass'];
                                                    $exmne_status = $row['exmne_status'];
                                                    $statusText = ($exmne_status == 1) ? 'Active' : (($exmne_status == 3) ? 'Disabled' : 'Inactive');
                                                    $disableCamText = ($exmne_disablecam == 'yes') ? 'Disabled Cam' : '';

                                                    $disp_fname = $row['exmne_fname'] != '' ? $row['exmne_fname'] : 'null';
                                                    $disp_mname = $row['exmne_mname'] != '' ? substr($row['exmne_mname'], 0, 1) . ". " : '_ ';
                                                    $disp_lname = $row['exmne_lname'] != '' ? $row['exmne_lname'] : 'null';
                                                    $disp_sfname = $row['exmne_sfname'] != '' ? $row['exmne_sfname'] : '';
                                                    $exmne_name = $disp_lname . ', ' . $disp_fname . ' ' . $disp_mname . $disp_sfname;

                                                    // Fetch the cluster name and status
                                                    $clusterName = '';
                                                    $stmt3 = $conn->prepare("SELECT clu_name, clu_status FROM cluster_tbl WHERE clu_id = :exmne_clu_id");
                                                    $stmt3->bindParam(':exmne_clu_id', $exmne_clu_id);
                                                    $stmt3->execute();
                                                    $clusterRow = $stmt3->fetch(PDO::FETCH_ASSOC);

                                                    if ($clusterRow) {
                                                        $clusterName = $clusterRow['clu_name'];
                                                        $clu_status = $clusterRow['clu_status'];
                                                    }

                                                    if ($clu_status == 1 && !empty($clusterName)) {
                                                        $cluster = $clusterName;
                                                    } else if ($clu_status == 0 && !empty($clusterName)) {
                                                        $cluster = $clusterName . " (Inactive)";
                                                    } else {
                                                        $cluster = "N/A";
                                                    }
                                            ?>
                                            <tr id="<?php echo htmlspecialchars($exmne_id); ?>">
                                                <td><?php echo htmlspecialchars($exmne_name) ?></td>
                                                <td><?php echo htmlspecialchars($cluster) ?></td>
                                                <td><?php echo htmlspecialchars($exmne_email) ?></td>
                                                <td><?php echo htmlspecialchars($disableCamText) ?></td>
                                                <td><?php echo htmlspecialchars($statusText) ?></td>
                                                <td>
                                                    <a href="javascript:void(0);" class="btn btn-info m-1" id="view-btn" data-toggle="modal" data-target="#mdlViewExaminee" data-toggle="tooltip" data-placement="bottom" title="View"
                                                    data-view-fname = "<?php echo htmlspecialchars($exmne_fname); ?>"
                                                    data-view-mname = "<?php echo htmlspecialchars($exmne_mname); ?>"
                                                    data-view-lname = "<?php echo htmlspecialchars($exmne_lname); ?>"
                                                    data-view-sfname = "<?php echo htmlspecialchars($exmne_sfname); ?>"
                                                    data-view-cluster = "<?php echo htmlspecialchars($exmne_clu_id); ?>"
                                                    data-view-sex = "<?php echo htmlspecialchars($exmne_sex); ?>"
                                                    data-view-birth = "<?php echo htmlspecialchars($exmne_birthdate); ?>"
                                                    data-view-cam = "<?php echo htmlspecialchars($exmne_disablecam); ?>"
                                                    data-view-status = "<?php echo htmlspecialchars($exmne_status); ?>"
                                                    data-view-email = "<?php echo htmlspecialchars($exmne_email); ?>"
                                                    data-view-pass = "<?php echo htmlspecialchars($exmne_pass); ?>">
                                                        <i class="fas fa-info-circle"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="btn btn-warning m-1" id="edit-btn" data-toggle="modal" data-target="#mdlEditExaminee" data-toggle="tooltip" data-placement="bottom" title="Edit"
                                                    data-edit-id = "<?php echo htmlspecialchars($exmne_id); ?>"
                                                    data-edit-fname = "<?php echo htmlspecialchars($exmne_fname); ?>"
                                                    data-edit-mname = "<?php echo htmlspecialchars($exmne_mname); ?>"
                                                    data-edit-lname = "<?php echo htmlspecialchars($exmne_lname); ?>"
                                                    data-edit-sfname = "<?php echo htmlspecialchars($exmne_sfname); ?>"
                                                    data-edit-cluster = "<?php echo htmlspecialchars($exmne_clu_id); ?>"
                                                    data-edit-sex = "<?php echo htmlspecialchars($exmne_sex); ?>"
                                                    data-edit-birth = "<?php echo htmlspecialchars($exmne_birthdate); ?>"
                                                    data-edit-cam = "<?php echo htmlspecialchars($exmne_disablecam); ?>"
                                                    data-edit-status = "<?php echo htmlspecialchars($exmne_status); ?>"
                                                    data-edit-email = "<?php echo htmlspecialchars($exmne_email); ?>"
                                                    data-edit-pass = "<?php echo htmlspecialchars($exmne_pass); ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <?php if ($exmne_status == 1) { ?>
                                                    <a href="javascript:void(0);" class="btn btn-danger m-1" id="disable-btn" data-toggle="modal" data-target="#mdlDisableExaminee" data-toggle="tooltip" data-placement="bottom" title="Disable" 
                                                    data-disable-id="<?php echo htmlspecialchars($exmne_id); ?>" 
                                                    data-disable-fname="<?php echo htmlspecialchars($exmne_fname); ?>" 
                                                    data-disable-lname="<?php echo htmlspecialchars($exmne_lname); ?>" 
                                                    data-disable-status="<?php echo htmlspecialchars($exmne_status); ?>">
                                                        <i class="fas fa-times-circle"></i>
                                                    </a>
                                                    <?php } else if ($exmne_status == 0) { ?>
                                                    <a href="javascript:void(0);" class="btn btn-success m-1" id="enable-btn" data-toggle="modal" data-target="#mdlEnableExaminee" data-toggle="tooltip" data-placement="bottom" title="Enable" 
                                                    data-enable-id="<?php echo htmlspecialchars($exmne_id); ?>" 
                                                    data-enable-fname="<?php echo htmlspecialchars($exmne_fname); ?>" 
                                                    data-enable-lname="<?php echo htmlspecialchars($exmne_lname); ?>" 
                                                    data-enable-status="<?php echo htmlspecialchars($exmne_status); ?>">
                                                        <i class="fas fa-check-circle"></i>
                                                    </a>
                                                    <?php } ?>
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
                </div> <!-- #END# Examinee PAGE -->
<!-- #END# manage-examinee.php -->
