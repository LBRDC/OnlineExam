
<!-- #START# dashboard.php -->
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
                                        View Pending Exams.
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
                                            <th>Title</th>
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
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# EXAM LIST PAGE -->
<!-- #END# dashboard.php -->
