<?php
    $stmt1 = $conn->prepare("SELECT * FROM exam_tbl ORDER BY ex_created DESC");
    $selExam = $stmt1->execute();

    $stmt2 = $conn->prepare("SELECT * FROM exam_cluster_tbl");
?>

<!-- #START# report-ranking.php -->
                <!-- ### Ranking PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-medal icon-gradient bg-grow-early">
                                    </i>
                                </div>
                                <div>Ranking Report
                                    <div class="page-title-subheading">
                                        View Ranking by Examinations
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                <li class="breadcrumb-item">Report</li>
                                <li class="breadcrumb-item active" aria-current="page">Ranking</li>
                            </ol>
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
                                    <div class="card-title">Examinations List</div>
                                    <div class="table-responsive">
                                        <table class="mb-0 table table-hover dt-sort" id="tableList" width="100%">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Cluster</th>
                                                <th style="display:none">Clusters_Filter</th>
                                                <th data-dt-order="disable">Description</th>
                                                <th data-dt-order="disable">Action</th>
                                            </tr>
                                            </thead>
                                            <!--<tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Cluster</th>
                                                <th>Description</th>
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

                                                    if ($statusText != 'Active') {
                                                        $titleText = $ex_title . ' (' . $statusText . ')';
                                                    } else {
                                                        $titleText = $ex_title;
                                                    }

                                                    $stmt4 = $conn->prepare("SELECT * FROM exam_cluster_tbl WHERE ex_id = :ex_id");
                                                    $stmt4->bindParam(':ex_id', $ex_id);
                                                    $stmt4->execute();

                                                    $clusterCount = 0;
                                                    $clusterNames = []; 

                                                    while ($row = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                                        $clu_id = $row['clu_id'];
                                                        
                                                        // Fetch the cluster name and status from cluster_tbl
                                                        $stmt5 = $conn->prepare("SELECT clu_name, clu_status FROM cluster_tbl WHERE clu_id = :clu_id");
                                                        $stmt5->bindParam(':clu_id', $clu_id);
                                                        $stmt5->execute();

                                                        $cluster = $stmt5->fetch(PDO::FETCH_ASSOC);
                                                        if ($cluster) {
                                                            // Append "(Inactive)" to the cluster name if its status is 0
                                                            $clusterName = $cluster['clu_status'] == 0 ? $cluster['clu_name'] . "(Inactive)" : $cluster['clu_name'];
                                                            $clusterNames[] = $clusterName;
                                                            $clusterCount++;
                                                        }
                                                    }
                                                    // Convert cluster names to a string for the data attribute
                                                    $clusterNamesString = implode(', ', $clusterNames);
                                                ?>


                                                    <tr>
                                                        <td><?php echo htmlspecialchars($titleText); ?></td>
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
                                                        <td>
                                                            <a href="?page=report-ranking-exam&id=<?php echo $ex_id; ?>" class="btn btn-primary m-1" id="view-btn" data-toggle="tooltip" data-placement="bottom" title="View">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
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
                </div> <!-- #END# Ranking PAGE -->
<!-- #END# report-ranking.php -->
