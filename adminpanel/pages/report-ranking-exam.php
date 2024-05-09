<?php

    $ex_id = $_GET['id'];
    /*
        Fetch Exam Clusters
        Fetch Examinees assigned to cluster



    */
    $stmt1 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :ex_id");
    $stmt1->bindParam(':ex_id', $ex_id);
    $stmt1->execute();

    //fetch title
    $row = $stmt1->fetch(PDO::FETCH_ASSOC);
    $ex_title = $row['ex_title'];
?>

<!-- #START# report-ranking.php -->
                <!-- ### Ranking PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-medal icon-gradient bg-happy-fisher">
                                    </i>
                                </div>
                                <div>"<span class="text-info"><?php echo htmlspecialchars($ex_title); ?></span>" Ranking Report
                                    <div class="page-title-subheading">
                                        View Ranking of <u><?php echo htmlspecialchars($ex_title); ?></u>
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
                    <div class="row mb-4">
                        <div class="col-md-12">
                        <a href="?page=report-ranking" class="btn btn-lg btn-dark"><i class="fa fa-arrow-circle-left"></i> Back</a>
                        </div>
                    </div>
                    <!-- Actions -->
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <h5 class="card-title">Actions</h5>
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <a href="javascript:void(0);" id="save-btn" data-toggle="modal" data-target="#mdlSaveRanking" data-save-id="<?php echo htmlspecialchars($ex_id); ?>">
                                                <div class="font-icon-wrapper font-icon-lg btn" data-toggle="tooltip" data-placement="bottom" title="Save Ranking">
                                                    <i class="fa fa-save icon-gradient bg-vicious-stance"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <h5 class="card-title">Filter</h5>
                                    <div class="row">
                                        <div class="col-lg-2 col-md-4 mr-1 mb-2">
                                            <label for="filter_status">Ranking</label>
                                            <select class="form-control" name="filter_ranking" id="filter_ranking">
                                                <option value="">Select...</option>
                                                <option>Excellent</option>
                                                <option>Very Good</option>
                                                <option>Good</option>
                                                <option>Failed</option>
                                                <option>Not Answered</option>
                                            </select>
                                        </div> 
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
                    <!-- Legend -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <div class="card-title">Legend</div>
                                    <div class="row justify-content-center">
                                        <div class="mr-2">
                                            <h1><span class="badge badge-warning">Excellent</span></h1>
                                        </div>
                                        <div class="mr-2">
                                            <h1><span class="badge badge-success">Very Good</span></h1>
                                        </div>
                                        <div class="mr-2">
                                            <h1><span class="badge badge-info">Good</span></h1>
                                        </div>
                                        <div class="mr-2">
                                            <h1><span class="badge badge-danger">Failed</span></h1>
                                        </div>
                                        <div class="">
                                            <h1><span class="badge badge-secondary">Not Answered</span></h1>
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
                                    <div class="card-title"><?php echo htmlspecialchars($ex_title); ?> Rankings</div>
                                    <div class="table-responsive">
                                        <table class="mb-0 table table-hover dt-sort" id="tableList" width="100%">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Ranking</th>
                                                <th>Name</th>
                                                <th>Cluster</th>
                                                <th>Score</th>
                                                <th>Total</th>
                                                <th>Percentage</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <!--<tfoot>
                                            <tr>
                                                <th>Ranking</th>
                                                <th>Name</th>
                                                <th>Cluster</th>
                                                <th>Score</th>
                                                <th>Total</th>
                                                <th>Percentage</th>
                                                <th>Date</th>
                                            </tr>
                                            </tfoot>-->
                                            <tbody>
                                                <?php
                                                    // Fetch clusters with exam id
                                                    $stmt2 = $conn->prepare("SELECT * FROM exam_cluster_tbl WHERE ex_id = :ex_id");
                                                    $stmt2->bindParam(':ex_id', $ex_id);
                                                    $stmt2->execute();

                                                    // Iterate through each cluster
                                                    while ($cluster = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                                        $exmne_clu_id = $cluster['clu_id']; // Assuming this is the correct column name for the cluster ID

                                                        // Fetch examinees for each cluster
                                                        $stmt3 = $conn->prepare("SELECT * FROM examinee_tbl WHERE exmne_clu_id = :exmne_clu_id");
                                                        $stmt3->bindParam(':exmne_clu_id', $exmne_clu_id);
                                                        $stmt3->execute();

                                                        // Iterate through each examinee in the cluster
                                                        while ($examinee = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                                            // Prepare examinee name
                                                            $exmne_fname = $examinee['exmne_fname'] != '' ? $examinee['exmne_fname'] : 'null';
                                                            $exmne_mname = $examinee['exmne_mname'] != '' ? substr($examinee['exmne_mname'], 0, 1) . ". " : '_ ';
                                                            $exmne_lname = $examinee['exmne_lname'] != '' ? $examinee['exmne_lname'] : 'null';
                                                            $exmne_sfname = $examinee['exmne_sfname'] != '' ? $examinee['exmne_sfname'] : '';
                                                            $exmne_name = $exmne_lname . ", " . $exmne_fname . " " . $exmne_mname . $exmne_sfname;

                                                            // Fetch cluster name
                                                            $stmt4 = $conn->prepare("SELECT * FROM cluster_tbl WHERE clu_id = :clu_id");
                                                            $stmt4->bindParam(':clu_id', $exmne_clu_id);
                                                            $stmt4->execute();
                                                            $cluster_name = $stmt4->fetch(PDO::FETCH_ASSOC)['clu_name'];

                                                            // Fetch score and total for the current examinee
                                                            $stmt5 = $conn->prepare("SELECT * FROM examinee_attempt WHERE ex_id = :ex_id AND exmne_id = :exmne_id");
                                                            $stmt5->bindParam(':ex_id', $ex_id);
                                                            $stmt5->bindParam(':exmne_id', $examinee['exmne_id']); // Assuming 'exmne_id' is the correct column name for the examinee ID
                                                            $stmt5->execute();
                                                            $result = $stmt5->fetch(PDO::FETCH_ASSOC);

                                                            // Check if there are no attempts for the examinee
                                                            if (empty($result)) {
                                                                // No attempts found, set score, total, and percentage to zero
                                                                $score = '';
                                                                $total = '';
                                                                $percentage = 'noans';
                                                                $date = ''; // Optionally, you can set a default date or leave it as an empty string
                                                            } else {
                                                                // Attempts found, calculate score, total, and percentage as before
                                                                $score = isset($result['ex_score']) ? $result['ex_score'] : 0;
                                                                $total = isset($result['ex_total']) ? $result['ex_total'] : 0;
                                                                $date = isset($result['exatmpt_date']) ? $result['exatmpt_date'] : '';
                                                                $percentage = number_format(($total > 0? ($score / $total) * 100 : 0), 2);
                                                            }

                                                            // Determine the ranking based on percentage
                                                            $ranking = '';
                                                            if ($percentage < 50 && $percentage != 'noans') {
                                                                $ranking = '<span class="mb-2 mr-2 badge badge-pill badge-danger">Failed</span>';
                                                                $percentageDisplay = $percentage . '%'; // Display the percentage
                                                            } elseif ($percentage >= 90 && $percentage != 'noans') {
                                                                $ranking = '<span class="mb-2 mr-2 badge badge-pill badge-warning">Excellent</span>';
                                                                $percentageDisplay = $percentage . '%'; // Display the percentage
                                                            } elseif ($percentage >= 80 && $percentage != 'noans') {
                                                                $ranking = '<span class="mb-2 mr-2 badge badge-pill badge-success">Very Good</span>';
                                                                $percentageDisplay = $percentage . '%'; // Display the percentage
                                                            } elseif ($percentage >= 50 && $percentage != 'noans') {
                                                                $ranking = '<span class="mb-2 mr-2 badge badge-pill badge-info">Good</span>';
                                                                $percentageDisplay = $percentage . '%'; // Display the percentage
                                                            } else {
                                                                $ranking = '<span class="mb-2 mr-2 badge badge-pill badge-secondary">Not Answered</span>';
                                                                $percentageDisplay = ''; // Do not display the percentage for not answered
                                                            }

                                                            // Display examinee details with the determined ranking and percentage
                                                            echo "<tr>";
                                                            echo "<td>" . $ranking . "</td>"; // Display the ranking
                                                            echo "<td>" . htmlspecialchars($exmne_name) . "</td>"; 
                                                            echo "<td>" . htmlspecialchars($cluster_name) . "</td>"; 
                                                            echo "<td>" . htmlspecialchars($score) . "</td>"; 
                                                            echo "<td>" . htmlspecialchars($total) . "</td>"; 
                                                            echo "<td>" . htmlspecialchars($percentageDisplay) . "</td>"; // Display the percentage conditionally
                                                            echo "<td>" . htmlspecialchars($date) . "</td>"; 
                                                            echo "</tr>";
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                            <!--<tbody>
                                                <tr>
                                                    <td><span class="mb-2 mr-2 badge badge-pill badge-danger">Failed</span></td>
                                                    <td>User 1</td>
                                                    <td>Cluster 1</td>
                                                    <td>0</td>
                                                    <td>10</td>
                                                    <td>0%</td>
                                                    <td>2022-01-01</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="mb-2 mr-2 badge badge-pill badge-success">Very Good</span></td>
                                                    <td>User 2</td>
                                                    <td>Cluster 2</td>
                                                    <td>8</td>
                                                    <td>10</td>
                                                    <td>80%</td>
                                                    <td>2023-01-01</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="mb-2 mr-2 badge badge-pill badge-info">Good</span></td>
                                                    <td>User 3</td>
                                                    <td>Cluster 3</td>
                                                    <td>5</td>
                                                    <td>10</td>
                                                    <td>50%</td>
                                                    <td>2024-03-29</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="mb-2 mr-2 badge badge-pill badge-secondary">Not Answered</span></td>
                                                    <td>User 4</td>
                                                    <td>Cluster 4</td>
                                                    <td>0</td>
                                                    <td>10</td>
                                                    <td>0%</td>
                                                    <td>2024-03-10</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="mb-2 mr-2 badge badge-pill badge-danger">Failed</span></td>
                                                    <td>User 5</td>
                                                    <td>Cluster 5</td>
                                                    <td>0</td>
                                                    <td>10</td>
                                                    <td>0%</td>
                                                    <td>2023-01-01</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="mb-2 mr-2 badge badge-pill badge-success">Very Good</span></td>
                                                    <td>User 6</td>
                                                    <td>Cluster 6</td>
                                                    <td>8</td>
                                                    <td>10</td>
                                                    <td>80%</td>
                                                    <td>2024-02-01</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="mb-2 mr-2 badge badge-pill badge-info">Good</span></td>
                                                    <td>User 7</td>
                                                    <td>Cluster 7</td>
                                                    <td>5</td>
                                                    <td>10</td>
                                                    <td>50%</td>
                                                    <td>2024-03-01</td>
                                                </tr>
                                                <tr>
                                                    <td><span class="mb-2 mr-2 badge badge-pill badge-secondary">Not Answered</span></td>
                                                    <td>User 8</td>
                                                    <td>Cluster 8</td>
                                                    <td>0</td>
                                                    <td>10</td>
                                                    <td>0%</td>
                                                    <td>2024-02-19</td>
                                                </tr>
                                            </tbody>-->
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# Ranking PAGE -->
<!-- #END# report-ranking.php -->
