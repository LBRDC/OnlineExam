<?php
    $clu_id = $_SESSION['ex_user']['exmne_clu_id'];
    $exmne_id = $_SESSION['ex_user']['exmne_id'];
?>


<!-- #START# exam-list.php -->
                <!-- ### EXAM LIST PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-study icon-gradient bg-grow-early">
                                    </i>
                                </div>
                                <div>Examination List
                                    <div class="page-title-subheading">
                                        View Exams.
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Home</li>
                                    <li class="breadcrumb-item">Examination</li>
                                    <li class="breadcrumb-item active" aria-current="page">List</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- TABLE -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <div class="card-title">Examination List</div>
                                    <table class="mb-0 table table-hover dt-sort" id="tableList">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Title</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            // Fetch Exam IDs based on cluster
                                            $stmt1 = $conn->prepare("SELECT ex_id FROM exam_cluster_tbl WHERE clu_id = :clu_id ORDER BY ex_id ASC");
                                            $stmt1->bindParam(':clu_id', $clu_id);
                                            $stmt1->execute();

                                            // Fetch Attempt
                                            $stmt3 = $conn->prepare("SELECT * FROM examinee_attempt WHERE ex_id = :ex_id AND exmne_id = :exmne_id");

                                            // Loop through each exam ID fetched from exam_cluster_tbl
                                            while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                                $ex_id = $row['ex_id'];

                                                // Fetch Exam Details for each exam ID
                                                $stmt2 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :ex_id AND ex_status = 1");
                                                $stmt2->bindParam(':ex_id', $ex_id);
                                                $stmt2->execute();

                                                if ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                                    $ex_title = $row['ex_title'];
                                                    $ex_status = $row['ex_status'];

                                                    // Fetch the number of attempts for the current exam
                                                    $stmt3->bindParam(':ex_id', $ex_id);
                                                    $stmt3->bindParam(':exmne_id', $exmne_id);
                                                    $stmt3->execute();
                                                    $attempts = $stmt3->rowCount();

                                                    // Determine if the exam is completed
                                                    $completed = $attempts > 0 ? 'Completed' : 'Not Completed';
                                        ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($ex_title); ?></td>
                                                        <td><?php echo htmlspecialchars($completed); ?></td>
                                                    </tr>
                                        <?php
                                                } // End of if statement checking if exam details are fetched
                                            } // End of while loop for exam IDs
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# EXAM LIST PAGE -->
<!-- #END# exam-list.php -->
