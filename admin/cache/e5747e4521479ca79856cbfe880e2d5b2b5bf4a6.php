<!DOCTYPE html>
<html dir="ltr" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo assets('images/favicon.png')?>">
        <title>Matrix Template - The Ultimate Multipurpose admin template</title>
        <!-- Custom CSS -->
        <?php echo $__env->yieldContent('customcss'); ?>
        <link href="<?php echo assets('dist/css/style.min.css') ?>" rel="stylesheet">
        <link href="<?php echo assets('dist/css/style.css') ?>" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>
    
    <body>
    
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        
        
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
        
        
            <!-- ============================================================== -->
            <!-- Topbar header - style you can find in pages.scss -->
            <!-- ============================================================== -->
            <?php echo $__env->make('layouts.app.topbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- ============================================================== -->
            <!-- End Topbar header -->
            <!-- ============================================================== -->
            
            
            <!-- ============================================================== -->
            <!-- Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <?php echo $__env->make('layouts.app.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- ============================================================== -->
            <!-- End Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            
            
            <!-- ============================================================== -->
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
            <!-- ============================================================== -->
            <!-- End Page wrapper  -->
            <!-- ============================================================== -->
            
            
        </div>
        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->
        
        
        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="<?php echo assets('libs/jquery/dist/jquery.min.js') ?>"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="<?php echo assets('libs/popper.js/dist/umd/popper.min.js')?>"></script>
        <script src="<?php echo assets('libs/bootstrap/dist/js/bootstrap.min.js')?>"></script>
        <script src="<?php echo assets('libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')?>"></script>
        <script src="<?php echo assets('extra-libs/sparkline/sparkline.js')?>"></script>
        <!--Wave Effects -->
        <script src="<?php echo assets('dist/js/waves.js')?>"></script>
        <!--Menu sidebar -->
        <script src="<?php echo assets('dist/js/sidebarmenu.js')?>"></script>
        <!--Custom JavaScript -->
        <script src="<?php echo assets('dist/js/custom.min.js')?>"></script>
        <script src="<?php echo assets('dist/js/custom.js')?>"></script>
        <!--This page JavaScript -->
        <?php echo $__env->yieldContent('thispagejs'); ?>
    
    </body>
</html>