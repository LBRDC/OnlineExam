
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
                                <div>LBRDC Online Exam Management
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
                                                <script type="text/javascript">
                                                    // Function to update the date, time, and day
                                                    function updateDateTime() {
                                                        // Get the current date and time
                                                        const now = new Date();

                                                        // Format the date
                                                        const date = now.toLocaleDateString();

                                                        // Format the time to show only hours and minutes
                                                        const timeOptions = { hour: '2-digit', minute: '2-digit' };
                                                        const time = now.toLocaleTimeString(undefined, timeOptions);

                                                        // Get the day of the week
                                                        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                                        const day = days[now.getDay()];

                                                        // Update the HTML elements
                                                        document.getElementById('currentDate').textContent = date;
                                                        document.getElementById('currentTime').textContent = time;
                                                        document.getElementById('currentDay').textContent = day;
                                                    }

                                                    // Call the function immediately to update the elements on page load
                                                    updateDateTime();

                                                    // Set an interval to update the date, time, and day every minute
                                                    setInterval(updateDateTime, 5000); // 60000 milliseconds = 1 minute
                                                </script>
                                                <div class="h3 mb-0 font-weight-bold text-white" id="currentDate">DATE</div>
                                                <div class="h3 mb-0 font-weight-bold text-white" id="currentTime">TIME</div>
                                                <div class="h3 mb-0 font-weight-bold text-white" id="currentDay">DAY</div>
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
                                                <div class="widget-heading">Total Employment Cluster</div>
                                                <div class="widget-subheading">Active</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-white"><span>10</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- #END# Total Clusters -->
                                <!-- Total Examination -->
                                <div class="col-md-6 col-xl-6">
                                    <div class="card mb-3 widget-content bg-arielle-smile">
                                        <div class="widget-content-wrapper text-white">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Total Examinations</div>
                                                <div class="widget-subheading">Active</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-white"><span>20</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- #END# Total Examination -->
                            </div>
                            <div class="row">
                                <!-- Total Examinees -->
                                <div class="col-md-6 col-xl-6">
                                    <div class="card mb-3 widget-content bg-grow-early">
                                        <div class="widget-content-wrapper text-white">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Total Examinees</div>
                                                <div class="widget-subheading">Active</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-white"><span>30</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- #END# Total Examinees -->
                            </div>
                            
                        </div>
                    </div>
                </div> <!-- #END# MAIN PAGE -->
<!-- #END# dashboard.php -->
