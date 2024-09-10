<?php
$exmne_clu_id = isset($_SESSION['ex_user']['exmne_clu_id']) ? $_SESSION['ex_user']['exmne_clu_id'] : '';
$exmne_id = isset($_SESSION['ex_user']['exmne_id']) ? $_SESSION['ex_user']['exmne_id'] : '';
$exmne_religion = isset($_SESSION['ex_user']['exmne_religion']) ? $_SESSION['ex_user']['exmne_religion'] : '';
$exmne_status = isset($_SESSION['ex_user']['exmne_status']) ? $_SESSION['ex_user']['exmne_status'] : '';
$exmne_disablecam = isset($_SESSION['ex_user']['exmne_disablecam']) ? $_SESSION['ex_user']['exmne_disablecam'] : '';

//echo $_SESSION['sess']['sessionid'];
//echo $_SESSION['sess']['time'];

// Fetch Exam IDs based on cluster
$stmt1 = $conn->prepare("SELECT ex_id FROM exam_cluster_tbl WHERE clu_id = ?");
$stmt1->execute([$exmne_clu_id]);

$examIds = $stmt1->fetchAll(PDO::FETCH_COLUMN, 0);

// If no exams are found, handle this case
if (empty($examIds)) {
    $unattemptedExamsData = [];
    return; 
}

// Fetch all exams for the given cluster
$placeholders = implode(',', array_fill(0, count($examIds), '?'));
$stmt2 = $conn->prepare("
    SELECT e.*, 
        CASE 
            WHEN ea.ex_id IS NOT NULL THEN 1 
            ELSE 0 
        END AS attempted
    FROM exam_tbl e
    LEFT JOIN examinee_attempt ea ON e.ex_id = ea.ex_id AND ea.exmne_id = ?
    WHERE e.ex_id IN ($placeholders) AND e.ex_status = 1
");
$params = array_merge([$exmne_id], $examIds);
$stmt2->execute($params);

$results = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Filter out exams that have been attempted
$unattemptedExams = array_filter($results, function ($exam) {
    return $exam['attempted'] == 0;
});

// Custom sorting function
usort($unattemptedExams, function ($a, $b) {
    $aTitle = $a['ex_title'];
    $bTitle = $b['ex_title'];

    // Check if the title is "APPLICANT RISK PROFILER (ARP)"
    if ($aTitle === 'APPLICANT RISK PROFILER (ARP)' && $bTitle !== 'APPLICANT RISK PROFILER (ARP)') {
        return 1;
    }
    if ($bTitle === 'APPLICANT RISK PROFILER (ARP)' && $aTitle !== 'APPLICANT RISK PROFILER (ARP)') {
        return -1;
    }

    // Extract the numeric part of the title for sorting
    preg_match('/TEST (\d+)/', $aTitle, $aMatch);
    preg_match('/TEST (\d+)/', $bTitle, $bMatch);
    $aNumber = isset($aMatch[1]) ? (int)$aMatch[1] : 0;
    $bNumber = isset($bMatch[1]) ? (int)$bMatch[1] : 0;

    // If both titles are tests, sort by the number
    if ($aNumber > 0 && $bNumber > 0) {
        return $aNumber - $bNumber;
    }

    // For non-test titles, or if one is a test and the other is not, sort alphabetically
    return strcmp($aTitle, $bTitle);
});

// DEBUG: Print details of unattempted exams
/*foreach ($unattemptedExams as $row) {
    echo "Exam Title: " . htmlspecialchars($row['ex_title']) . "<br>";
    echo "Exam ID: " . htmlspecialchars($row['ex_id']) . "<br>";
    echo "Exam Practice: " . htmlspecialchars($row['ex_practice']) . "<br>";
}*/

// Store unattempted exam IDs and practices
$unattemptedExamsData = [];
foreach ($unattemptedExams as $exam) {
    $unattemptedExamsData[] = [
        'ex_id' => $exam['ex_id'],
        'ex_practice' => $exam['ex_practice']
    ];
}

$ex_count = count($unattemptedExams);
if ($ex_count > 0) {
    $selEx_id = $unattemptedExams[0]['ex_id'];
} else {
    $selEx_id = '';

    if ($exmne_status == 1 && $ex_count == 0) {
    //update examinee acc
    $stmt3 = $conn->prepare("UPDATE examinee_tbl SET exmne_status = 2 WHERE exmne_id = :exmne_id");
    $stmt3->bindParam(':exmne_id', $exmne_id);
    if ($stmt3->execute()) {
        $_SESSION['ex_user']['exmne_status'] = 2;
    }
    }
}
?>


<!-- #START# dashboard.php -->
                <!-- ### MAIN PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-home icon-gradient bg-grow-early">
                                    </i>
                                </div>
                                <div>LBRDC Online Exam
                                    <div class="page-title-subheading">
                                        Welcome!
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xl-6">
                            <!-- Date and Time -->
                            <div class="col-xl-12 col-md-12 mb-4 align-items-center">
                                <div class="card card-bg" style="min-height: 180px;">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col mr-2">
                                                <div class="h3 mb-0 font-weight-bold text-white" id="currentDate"></div>
                                                <div class="h3 mb-0 font-weight-bold text-white" id="currentTime"></div>
                                                <div class="h3 mb-0 font-weight-bold text-white" id="currentDay"></div>
                                                <script type="text/javascript">
                                                    function updateDateTime() {
                                                        const now = new Date();
                                                        const date = now.toLocaleDateString();
                                                        const timeOptions = { hour: '2-digit', minute: '2-digit' };
                                                        const time = now.toLocaleTimeString(undefined, timeOptions);

                                                        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                                        const day = days[now.getDay()];

                                                        document.getElementById('currentDate').textContent = date;
                                                        document.getElementById('currentTime').textContent = time;
                                                        document.getElementById('currentDay').textContent = day;
                                                    }

                                                    updateDateTime();
                                                    setInterval(updateDateTime, 5000);
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- #END# Date and Time -->
                        </div>
                        <div class="col-md-6 col-xl-6">
                            <div class="row">
                                <!-- Total Clusters -->
                                <div class="col-md-6 col-xl-6">
                                    <div class="card mb-3 widget-content bg-midnight-bloom">
                                        <div class="widget-content-wrapper text-white">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Pending Exams</div>
                                                <div class="widget-subheading">Active</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-white"><span><?php echo htmlspecialchars($ex_count); ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- #END# Total Clusters -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xl-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title"><i class="metismenu-icon pe-7s-attention"></i> Reminders <i class="metismenu-icon pe-7s-attention"></i></h3>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">1.)</span> Reminder 1</h5>
                                            <div class="list-group-item-text pl-4">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</div>
                                        </li>
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">2.)</span> Reminder 2</h5>
                                            <div class="list-group-item-text pl-4">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</div>
                                        </li>
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">3.)</span> Don't leave the page</h5>
                                            <div class="list-group-item-text pl-4">While taking the exam, avoid refreshing, clicking the back button in your browser, or closing the web page as it may disrupt the exam and you may lose progress.</div>
                                        </li>
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">4.)</span> Don't Open Other Tabs</h5>
                                            <div class="list-group-item-text pl-4">Refrain from opening other tabs and applications while taking the exam.</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title"><i class="metismenu-icon pe-7s-tools"></i> Requirements <i class="metismenu-icon pe-7s-tools"></i></h3>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">1.)</span> Device Specifications</h5>
                                            <div class="list-group-item-text pl-4">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</div>
                                        </li>
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">2.)</span> Internet Specifications</h5>
                                            <div class="list-group-item-text pl-4">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</div>
                                        </li>
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">3.)</span> Requirement 3</h5>
                                            <div class="list-group-item-text pl-4">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($selEx_id != '') { ?>
                    <div class="row justify-content-center">
                        <div class="col-md-12 col-xl-6">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-12 text-center">
                                        <?php
                                            // Assume $exmne_religion is already defined somewhere in your code
                                            $query = "SELECT * FROM page_messages ";
                                            
                                            if ($exmne_religion == 1 || $exmne_religion == 2) {
                                                $query .= "";
                                            } else {
                                                $query .= " WHERE religion != 1 ";
                                            }
                                            
                                            $query .= " ORDER BY RAND() LIMIT 1";
                                            
                                            // Prepare and execute the query
                                            $stmt4 = $conn->prepare($query);
                                            $stmt4->execute();
                                            
                                            if ($stmt4->rowCount() > 0) {
                                                $msg = $stmt4->fetch(PDO::FETCH_ASSOC);
                                                $msg_txt = $msg['msg_text'];
                                                $msg_src = $msg['src_text'];
                                            } else {
                                                $msg_txt = "There are no secrets to success. It is the result of preparation, hard work, and learning from failure.";
                                                $msg_src = "General Colin Powell, former US Secretary of State";
                                            }
                                        ?>


                                            <span class='font-italic font-weight-bold'><?php echo htmlspecialchars($msg_txt) ?><br> -<?php echo htmlspecialchars($msg_src) ?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <?php if ($exmne_disablecam == 'yes') { ?>
                                            <button type="button" class="btn btn-success ml-5 mr-5 font-weight-bold" style="width: 100px; height: 50px;" id="strt-btn" data-exam-id="<?php echo htmlspecialchars($selEx_id); ?>" data-exam-disablecam="<?php echo htmlspecialchars($exmne_disablecam); ?>">START EXAM</button>
                                            <?php } else { ?>
                                            <button type="button" class="btn btn-warning ml-5 mr-5 font-weight-bold" style="width: 100px; height: 50px;" data-toggle="modal" data-target="#mdlStartExam">START</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div> <!-- #END# MAIN PAGE -->
<!-- #END# dashboard.php -->
