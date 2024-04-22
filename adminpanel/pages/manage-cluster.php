<?php
    $stmt1 = $conn->prepare("SELECT * FROM cluster_tbl ORDER BY clu_created DESC");
    $selCluster = $stmt1->execute();

    $clu_status = 1;
    $stmt2 = $conn->prepare("SELECT * FROM cluster_tbl WHERE clu_status = :clu_status");
    $stmt2->bindParam(':clu_status', $clu_status);
    $stmt2->execute();
?>

<!-- #START# manage-cluster.php -->
                <!-- ### Cluster PAGE ### -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-culture icon-gradient bg-grow-early">
                                    </i>
                                </div>
                                <div>Cluster Management
                                    <div class="page-title-subheading">
                                        Manage Employment Clusters
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                <li class="breadcrumb-item">Management</li>
                                <li class="breadcrumb-item active" aria-current="page">Cluster</li>
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
                                            <div class="widget-subheading">Active Clusters</div>
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
                                            <th data-dt-order="disable">Description</th>
                                            <th>Status</th>
                                            <th data-dt-order="disable">Action</th>
                                        </tr>
                                        </thead>
                                        <!--<tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>-->
                                        <tbody>
                                        <?php
                                            while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                                $clu_id = $row['clu_id'];
                                                $clu_name = $row['clu_name'];
                                                $clu_description = $row['clu_description'];
                                                $clu_status = $row['clu_status'];
                                                $statusText = ($clu_status == 1) ? 'Active' : 'Inactive';
                                        ?>
                                            <tr id="<?php echo htmlspecialchars($clu_id); ?>">
                                                <td><?php echo htmlspecialchars($clu_name); ?></td>
                                                <td><?php echo htmlspecialchars($clu_description); ?></td>
                                                <td><?php echo htmlspecialchars($statusText); ?></td>
                                                <td>
                                                    <a href="javascript:void(0);" class="btn btn-warning" id="edit-btn" data-toggle="modal" data-target="#mdlEditCluster" data-toggle="tooltip" data-placement="bottom" title="Edit"
                                                    data-edit-id="<?php echo htmlspecialchars($clu_id); ?>" 
                                                    data-edit-name="<?php echo htmlspecialchars($clu_name); ?>"
                                                    data-edit-description="<?php echo htmlspecialchars($clu_description); ?>"
                                                    data-edit-status="<?php echo htmlspecialchars($clu_status); ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <?php if ($clu_status == 1) { ?>
                                                    <a href="javascript:void(0);" class="btn btn-danger" id="disable-btn" data-toggle="modal" data-target="#mdlDisableCluster" data-toggle="tooltip" data-placement="bottom" title="Disable" 
                                                    data-disable-id="<?php echo htmlspecialchars($clu_id); ?>" 
                                                    data-disable-name="<?php echo htmlspecialchars($clu_name); ?>" 
                                                    data-disable-status="<?php echo htmlspecialchars($clu_status); ?>">
                                                        <i class="fas fa-times-circle"></i>
                                                    </a>
                                                    <?php } else { ?>
                                                    <a href="javascript:void(0);" class="btn btn-success" id="enable-btn" data-toggle="modal" data-target="#mdlEnableCluster" data-toggle="tooltip" data-placement="bottom" title="Enable" 
                                                    data-enable-id="<?php echo htmlspecialchars($clu_id); ?>" 
                                                    data-enable-name="<?php echo htmlspecialchars($clu_name); ?>" 
                                                    data-enable-status="<?php echo htmlspecialchars($clu_status); ?>">
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
                </div> <!-- #END# Cluster PAGE -->
<!-- #END# manage-cluster.php -->
