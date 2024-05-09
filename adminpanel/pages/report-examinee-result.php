<?php
    $exmne_Id = $_GET['exmne'];
    $ex_id = $_GET['exam'];

    //Fetch Examinee Details
    $stmt1 = $conn->prepare("SELECT * FROM examinee_tbl WHERE exmne_id = :exmne_id");
    $stmt1->bindParam(':exmne_id', $exmne_Id);
    $stmt1->execute();

    if ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        // Prepare examinee name
        $exmne_fname = $row['exmne_fname'] != '' ? $row['exmne_fname'] : 'null';
        $exmne_mname = $row['exmne_mname'] != '' ? substr($row['exmne_mname'], 0, 1) . ". " : '_ ';
        $exmne_lname = $row['exmne_lname'] != '' ? $row['exmne_lname'] : 'null';
        $exmne_sfname = $row['exmne_sfname'] != '' ? $row['exmne_sfname'] : '';
        $exmne_name = $exmne_lname . ', ' . $exmne_fname . ' ' . $exmne_mname . $exmne_sfname;
    }

    //Fetch Exam Details
    $stmt2 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :ex_id");
    $stmt2->bindParam(':ex_id', $ex_id);
    $stmt2->execute();

    if ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $ex_title = isset($row['ex_title']) ? $row['ex_title'] : 'null';
    }
?>

<!-- #START# report-examinee-result.php -->
                <!-- ### EXAMINEE RESULT PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-note2 icon-gradient bg-happy-fisher">
                                    </i>
                                </div>
                                <div>"<span class="text-info"><?php echo htmlspecialchars($exmne_name); ?></span>" Result Report
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
                    <div class="row mb-4">
                        <div class="col-md-12">
                        <a href="?page=report-examinee" class="btn btn-lg btn-dark"><i class="fa fa-arrow-circle-left"></i> Back</a>
                        </div>
                    </div>
                    <!-- TABLE -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <div class="card-title"><?php echo htmlspecialchars($ex_title); ?> Answers</div>
                                    <table class="mb-0 table table-hover dt-sort" id="tableList" width="100%">
                                        <thead class="thead-light">
                                        <tr>
                                            <th></th>
                                            <th>Question</th>
                                            <th>Answer</th>
                                            <th>Correct Answer</th>
                                        </tr>
                                        </thead>
                                        <!--<tfoot>
                                        <tr>
                                            <th>Question</th>
                                            <th>Answer</th>
                                            <th>Correct Answer</th>
                                        </tr>
                                        </tfoot>-->
                                        <tbody>
                                        <?php 
                                        //Fetch Exam Questions
                                        $stmt3 = $conn->prepare("SELECT * FROM exam_question_tbl WHERE ex_id = :ex_id");
                                        $stmt3->bindParam(':ex_id', $ex_id);
                                        $stmt3->execute();

                                        while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                            $exqstn_id = isset($row['exqstn_id']) ? $row['exqstn_id'] : 'null';
                                            $exqstn_question = isset($row['exam_question']) ? $row['exam_question'] : 'null';
                                            $exqstn_answer = isset($row['exqstn_answer']) ? $row['exqstn_answer'] : 'null';

                                            //Fetch Examinee Answer
                                            $stmt4 = $conn->prepare("SELECT * FROM examinee_answers WHERE exmne_id = :exmne_id AND exqstn_id = :exqstn_id");
                                            $stmt4->bindParam(':exmne_id', $exmne_Id);
                                            $stmt4->bindParam(':exqstn_id', $exqstn_id);
                                            $stmt4->execute();

                                            $exmne_answer = ''; // Initialize examinee answer as null
                                            if ($ans = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                                $exmne_answer = isset($ans['exmne_answer']) ? $ans['exmne_answer'] : 'null';
                                            }
                                        ?>

                                        <tr id="<?php echo $exqstn_id; ?>">
                                            <td>
                                            <?php 
                                            if ($exmne_answer == $exqstn_answer) {
                                                echo '<span class="mb-2 mr-2 badge badge-pill badge-success">Correct</span>';
                                            } else if ($exmne_answer == '') {
                                                echo '<span class="mb-2 mr-2 badge badge-pill badge-secondary">Not Answered</span>';
                                            } else {
                                                echo '<span class="mb-2 mr-2 badge badge-pill badge-danger">Incorrect</span>';
                                            }
                                            ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($exqstn_question); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($exmne_answer); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($exqstn_answer); ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# EXAMINEE RESULT PAGE -->
<!-- #END# report-examinee-result.php -->
