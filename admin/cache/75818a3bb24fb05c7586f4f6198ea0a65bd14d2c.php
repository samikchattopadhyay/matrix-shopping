<?php $__env->startSection('content'); ?>

<!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Charts</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Chart-1 -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Real Time Chart</h5>
                                 <div id="real-time" style="height:400px;"></div>
                                <p>Time between updates:
                                    <input id="updateInterval" type="text" value="" style="text-align: right; width:5em"> milliseconds
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ENd chart-1 -->
                <!-- Chart-2 -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Turning-series chart</h5>
                                <div id="placeholder" style="height: 400px;"></div>
                                <p id="choices" class="m-t-20"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Chart-2 -->
                <!-- Cards -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="card m-t-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="peity_line_neutral left text-center m-t-10"><span><span style="display: none;">10,15,8,14,13,10,10</span>
                                        <canvas width="50" height="24"></canvas>
                                        </span>
                                        <h6>10%</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold">150</h3>
                                    <span class="text-muted">New Users</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card m-t-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="peity_bar_bad left text-center m-t-10"><span><span style="display: none;">3,5,6,16,8,10,6</span>
                                        <canvas width="50" height="24"></canvas>
                                        </span>
                                        <h6>-40%</h6></div>
                                </div>
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold">4560</h3>
                                    <span class="text-muted">Orders</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card m-t-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="peity_line_good left text-center m-t-10"><span><span style="display: none;">12,6,9,23,14,10,17</span>
                                        <canvas width="50" height="24"></canvas>
                                        </span>
                                        <h6>+60%</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 ">5672</h3>
                                    <span class="text-muted">Active Users</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card m-t-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="peity_bar_good left text-center m-t-10"><span>12,6,9,23,14,10,13</span>
                                        <h6>+30%</h6>
                                    </div>
                                </div>
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold">2560</h3>
                                    <span class="text-muted">Register</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End cards -->
                <!-- Chart-3 -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Bar Chart</h5>
                                <div class="flot-chart">
                                    <div class="flot-chart-content" id="flot-line-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End chart-3 -->
                <!-- Charts -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pie Chart</h5>
                                <div class="pie" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Line Chart</h5>
                                <div class="bars" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Charts -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                All Rights Reserved by Matrix-admin. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
            
 <?php $__env->stopSection(); ?>
 
 
 
<?php $__env->startSection('customcss'); ?>
<link href="<?php echo assets('libs/flot/css/float-chart.css')?>" rel="stylesheet">
    	<link href="<?php echo assets('dist/css/style.min.css')?>" rel="stylesheet">
<?php $__env->stopSection(); ?>
 
 
<?php $__env->startSection('thispagejs'); ?>

        <!-- Charts js Files -->
        <script src="<?php echo assets('libs/flot/excanvas.js')?>"></script>
        <script src="<?php echo assets('libs/flot/jquery.flot.js')?>"></script>
        <script src="<?php echo assets('libs/flot/jquery.flot.pie.js')?>"></script>
        <script src="<?php echo assets('libs/flot/jquery.flot.time.js')?>"></script>
        <script src="<?php echo assets('libs/flot/jquery.flot.stack.js')?>"></script>
        <script src="<?php echo assets('libs/flot/jquery.flot.crosshair.js')?>"></script>
        <script src="<?php echo assets('libs/flot.tooltip/js/jquery.flot.tooltip.min.js')?>"></script>
        <script src="<?php echo assets('dist/js/pages/chart/chart-page-init.js')?>"></script>

<?php $__env->stopSection(); ?>
 
 
 
<?php echo $__env->make('matrix.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>