<?php
    $stmt1 = $conn->prepare("SELECT * FROM cluster_tbl ORDER BY clu_created DESC");
    $selCluster = $stmt1->execute();

    $clu_status = 1;
    $stmt2 = $conn->prepare("SELECT * FROM cluster_tbl WHERE clu_status = :clu_status");
    $stmt2->bindParam(':clu_status', $clu_status);
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
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#mdlAddCluster" data-toggle="tooltip" data-placement="bottom" title="Add Cluster">
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
                                    <div class="card-title">Employment Cluster</div>
                                    <table class="mb-0 table table-hover dt-sort" id="tableList">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Cluster</th>
                                            <th>Sex</th>
                                            <th>Birthdate</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <!--<tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Cluster</th>
                                            <th>Sex</th>
                                            <th>Birthdate</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>-->
                                        <tbody>
                                        <tr>
                                            <td>LBRDC Examinee</td>
                                            <td>AGSD</td>
                                            <td>Male</td>
                                            <td>Feb. 19, 2024</td>
                                            <td>lbrdc@email.com</td>
                                            <td>Active</td>
                                            <td>
                                                <a href="javascript:void(0);" class="btn btn-info m-1" id="view-btn" data-toggle="tooltip" data-placement="bottom" title="View">
                                                    <i class="fas fa-info-circle"></i>
                                                </a>
                                                <a href="?page=manage-exam-edit&id=" class="btn btn-warning m-1" id="edit-btn" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-danger m-1" id="disable-btn" data-toggle="modal" data-target="#mdlDisableExam" data-toggle="tooltip" data-placement="bottom" title="Disable" 
                                                data-disable-id="" 
                                                data-disable-name="" 
                                                data-disable-status="">
                                                    <i class="fas fa-times-circle"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-success m-1" id="enable-btn" data-toggle="modal" data-target="#mdlEnableExam" data-toggle="tooltip" data-placement="bottom" title="Enable" 
                                                data-enable-id="" 
                                                data-enable-name="" 
                                                data-enable-status="">
                                                    <i class="fas fa-check-circle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# Examinee PAGE -->
<!-- #END# manage-examinee.php -->
