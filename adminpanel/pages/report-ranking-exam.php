<?php


    /*
        Fetch Exam Clusters
        Fetch Examinees assigned to cluster



    */
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
                                        View Ranking of [EXAM]
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
                                            <a href="query/export_ExamQuestExe.php?id=">
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
                                                <option value="">Excellent</option>
                                                <option value="">Very Good</option>
                                                <option value="">Good</option>
                                                <option value="">Danger</option>
                                                <option value="">Not Answered</option>
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
                                    <div class="card-title">[EXAM NAME]</div>
                                    <table class="mb-0 table table-hover dt-sort" id="tableList">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Ranking</th>
                                            <th>Name</th>
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
                                            <th>Score</th>
                                            <th>Total</th>
                                            <th>Percentage</th>
                                            <th>Date</th>
                                        </tr>
                                        </tfoot>-->
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span class="mb-2 mr-2 badge badge-pill badge-warning">Excellent</span>
                                                </td>
                                                <td>LBRDC User</td>
                                                <td>30</td>
                                                <td>30</td>
                                                <td>100%</td>
                                                <td>2024-2-19</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="mb-2 mr-2 badge badge-pill badge-success">Very Good</span>
                                                </td>
                                                <td>LBRDC User</td>
                                                <td>30</td>
                                                <td>30</td>
                                                <td>100%</td>
                                                <td>2023-2-19</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="mb-2 mr-2 badge badge-pill badge-info">Good</span>
                                                </td>
                                                <td>LBRDC User</td>
                                                <td>30</td>
                                                <td>30</td>
                                                <td>100%</td>
                                                <td>2021-2-19</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="mb-2 mr-2 badge badge-pill badge-danger">Failed</span>
                                                </td>
                                                <td>LBRDC User</td>
                                                <td>30</td>
                                                <td>30</td>
                                                <td>100%</td>
                                                <td>2022-5-10</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="mb-2 mr-2 badge badge-pill badge-secondary">Not Answered</span>
                                                </td>
                                                <td>LBRDC User</td>
                                                <td>30</td>
                                                <td>30</td>
                                                <td>100%</td>
                                                <td>2020-3-19</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# Ranking PAGE -->
<!-- #END# report-ranking.php -->
