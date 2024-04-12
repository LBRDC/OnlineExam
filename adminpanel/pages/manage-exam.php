<?php
    $stmt1 = $conn->prepare("SELECT * FROM exam_tbl ORDER BY ex_created DESC");
    $selExam = $stmt1->execute();

    $stmt2 = $conn->prepare("SELECT * FROM exam_cluster_tbl");

    $ex_status = 1;
    $stmt3 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_status = :ex_status");
    $stmt3->bindParam(':ex_status', $ex_status);
    $stmt3->execute();
?>

<!-- #START# manage-exam.php -->
                <!-- ### Exam PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-news-paper icon-gradient bg-grow-early">
                                    </i>
                                </div>
                                <div>Exam Management
                                    <div class="page-title-subheading">
                                        Manage Examinations
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                <li class="breadcrumb-item">Management</li>
                                <li class="breadcrumb-item active" aria-current="page">Exam</li>
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
                                            <div class="widget-heading"><?php echo $stmt3->rowCount(); ?></div>
                                            <div class="widget-subheading">Active Exams</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#mdlAddExam" data-toggle="tooltip" data-placement="bottom" title="Add Exam">
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
                                                $stmtflt = $conn->prepare("SELECT * FROM cluster_tbl WHERE clu_status=1 ORDER BY clu_id ASC");
                                                $stmtflt->execute();
                                                $result = $stmtflt->fetchAll(PDO::FETCH_ASSOC);
                                                
                                                // Check if there are any clusters
                                                if ($stmtflt->rowCount() > 0) {
                                                    foreach ($result as $row) {
                                                        echo '<option value="' . htmlspecialchars($row['clu_name']) . '">' . htmlspecialchars($row['clu_name']) . '</option>';
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
                                    <div class="card-title">Examinations</div>
                                    <div class="table-responsive">
                                        <table class="table table-hover dt-sort" id="tableList">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Exam Title</th>
                                                <th>Cluster</th>
                                                <th style="display:none">Clusters_Filter</th>
                                                <th>Description</th>
                                                <th>Question Limit</th>
                                                <th>Time Limit</th>
                                                <th>Properties</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <!--<tfoot>
                                            <tr>
                                                <th>Exam Title</th>
                                                <th>Cluster</th>
                                                <th>Description</th>
                                                <th>Question Limit</th>
                                                <th>Time Limit</th>
                                                <th>Properties</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>-->
                                            <tbody>
                                                <?php
                                                while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                                    $ex_id = $row['ex_id'];
                                                    $ex_title = $row['ex_title'];
                                                    $ex_description = $row['ex_description'];
                                                    $ex_qstn_limit = $row['ex_qstn_limit'];
                                                    $ex_time_limit = $row['ex_time_limit'];
                                                    $ex_disable_prv = $row['ex_disable_prv'];
                                                    $ex_random_qstn = $row['ex_random_qstn'];
                                                    $ex_status = $row['ex_status'];
                                                    $statusText = ($ex_status == 1) ? 'Active' : 'Inactive';

                                                    $stmt4 = $conn->prepare("SELECT * FROM exam_cluster_tbl WHERE ex_id = :ex_id");
                                                    $stmt4->bindParam(':ex_id', $ex_id);
                                                    $stmt4->execute();

                                                    $clusterCount = 0;
                                                    $clusterNames = []; 

                                                    while ($row = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                                        $clusterCount++;
                                                        $clu_id = $row['clu_id'];
                                                        
                                                        $stmt5 = $conn->prepare("SELECT clu_name FROM cluster_tbl WHERE clu_id = :clu_id");
                                                        $stmt5->bindParam(':clu_id', $clu_id);
                                                        $stmt5->execute();

                                                        $clusterName = $stmt5->fetch(PDO::FETCH_ASSOC);
                                                        if ($clusterName) {
                                                            $clusterNames[] = $clusterName['clu_name'];
                                                        }
                                                    }
                                                        // Convert cluster names to a string for the data attribute
                                                    $clusterNamesString = implode(', ', $clusterNames);
                                                ?>
                                                <tr id="<?php echo htmlspecialchars($ex_id); ?>" data-clusters="<?php echo htmlspecialchars($clusterNamesString); ?>">
                                                    <td><?php echo htmlspecialchars($ex_title); ?></td>
                                                    <td>
                                                        <?php 
                                                        if ($clusterCount > 2) {
                                                            echo '<button class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="' . implode(', ', $clusterNames) . '">+' . $clusterCount . '</button>';
                                                        } else {
                                                            echo implode(', ', $clusterNames);
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="display:none"><?php echo implode(', ', $clusterNames); ?></td>
                                                    <td><?php echo htmlspecialchars($ex_description); ?></td>
                                                    <td><?php echo htmlspecialchars($ex_qstn_limit); ?></td>
                                                    <td><?php echo htmlspecialchars($ex_time_limit); ?></td>
                                                    <td>
                                                        <?php 
                                                        if ($ex_disable_prv != '') {
                                                            echo "<div>Disabled Previous</div>"; 
                                                        } else {
                                                            echo "";
                                                        }
                                                        if ($ex_random_qstn != '') {
                                                            echo "<div>Randomized</div>"; 
                                                        } else {
                                                            echo "";
                                                        } 
                                                        ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($statusText); ?></td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="btn btn-warning m-1" id="edit-btn" data-toggle="modal" data-target="#mdlEditCluster" data-toggle="tooltip" data-placement="bottom" title="Edit"
                                                        data-edit-id="<?php echo htmlspecialchars($ex_id); ?>" 
                                                        data-edit-name="<?php echo htmlspecialchars($ex_title); ?>"
                                                        data-edit-description="<?php echo htmlspecialchars($ex_description); ?>"
                                                        data-edit-status="<?php echo htmlspecialchars($ex_status); ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <?php if ($ex_status == 1) { ?>
                                                        <a href="javascript:void(0);" class="btn btn-danger m-1" id="disable-btn" data-toggle="modal" data-target="#mdlDisableCluster" data-toggle="tooltip" data-placement="bottom" title="Disable" 
                                                        data-disable-id="<?php echo htmlspecialchars($ex_id); ?>" 
                                                        data-disable-name="<?php echo htmlspecialchars($ex_title); ?>" 
                                                        data-disable-status="<?php echo htmlspecialchars($ex_status); ?>">
                                                            <i class="fas fa-times-circle"></i>
                                                        </a>
                                                        <?php } else { ?>
                                                        <a href="javascript:void(0);" class="btn btn-success m-1" id="enable-btn" data-toggle="modal" data-target="#mdlEnableCluster" data-toggle="tooltip" data-placement="bottom" title="Enable" 
                                                        data-enable-id="<?php echo htmlspecialchars($ex_id); ?>" 
                                                        data-enable-name="<?php echo htmlspecialchars($ex_title); ?>" 
                                                        data-enable-status="<?php echo htmlspecialchars($ex_status); ?>">
                                                            <i class="fas fa-check-circle"></i>
                                                        </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php
                                                } // End of while loop
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# Exam PAGE -->
<!-- #END# manage-exam.php -->
