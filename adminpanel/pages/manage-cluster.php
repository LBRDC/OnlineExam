
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
                                            <div class="widget-heading">5</div>
                                            <div class="widget-subheading">Active Clusters</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#mdlAddCluster" data-toggle="tooltip" data-placement="bottom" title="Add Cluster" data-original-title="Tooltip on bottom">
                                                    <i class="fa fa-3x fa-plus-circle icon-gradient bg-grow-early"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <div class="card-title">Employment Cluster</div>
                                    <table class="mb-0 table table-hover dt-sort" id="tableList">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
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
                                        <tr>
                                            <td>AGSD</td>
                                            <td>Administrative and General Services Department</td>
                                            <td>Active</td>
                                            <td>
                                            <a href="javascript:void(0);" class="btn btn-info"  data-toggle="modal" data-target="#mdlViewDepartment" data-toggle="tooltip" data-placement="bottom" title="View">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-warning" data-toggle="modal" data-target="#mdlEditDepartment" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Disable">
                                                <!--<i class="fas fa-trash"></i>-->
                                                <i class="fas fa-times-circle"></i>
                                            </a>
                                            <a href="#" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Enable">
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
                </div> <!-- #END# Cluster PAGE -->
<!-- #END# manage-cluster.php -->
