
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
                                                <div class="widget-numbers text-white"><span>10</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- #END# Total Clusters -->
                            </div>
                            <div class="row">
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
                                            <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                                        </li>
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">2.)</span> Reminder 2</h5>
                                            <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                                        </li>
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">3.)</span> Reminder 3</h5>
                                            <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
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
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">1.)</span> PC Specifications</h5>
                                            <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                                        </li>
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">2.)</span> Internet Specifications</h5>
                                            <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                                        </li>
                                        <li class="list-group-item">
                                            <h6 class="list-group-item-heading"><span class="font-weight-bold">3.)</span> Requirement 3</h5>
                                            <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- #END# MAIN PAGE -->
<!-- #END# dashboard.php -->
