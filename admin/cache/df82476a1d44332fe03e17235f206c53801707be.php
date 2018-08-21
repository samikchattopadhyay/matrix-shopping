<?php $__env->startSection('content'); ?>

<!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Suppliers - <?php echo (isset($action) && $action == 'add') ? 'Add New' : 'Edit'?></h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <a href="<?php echo url('listSuppliers') ?>" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">List All</a>
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
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <form id="saveSupplierForm" action="<?php echo e(url('saveSupplier')); ?>" method="post" class="form-horizontal">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 control-label col-form-label">Supplier Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="contact_person" class="col-sm-3 control-label col-form-label">Contact Person</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="contact_person" name="contact_person" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="address_id" class="col-sm-3 control-label col-form-label">Primary Address</label>
                                        <div class="col-sm-8">
                                            <select class="select2 form-control custom-select" id="address_id" name="address_id" style="width: 100%; height:36px;" required>
                                            	<option value="">Select</option>
                                            	<?php if (isset($addresses) && count($addresses)): ?>
                                            		<?php foreach ($addresses as $address): ?>
                                            			<option value="<?php echo $address->id?>"><?php echo $address->address . ', ' . $address->locality . ', ' . $address->city?></option>
                                            		<?php endforeach; ?>
                                            	<?php endif;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-1 text-right">
                                            <a role="button" class="btn btn-primary" title="Add new supplier address" href="<?php echo e(url('addAddress')); ?>"><i class="mdi mdi-library-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            
<?php $__env->stopSection(); ?>


<?php $__env->startSection('customcss'); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo assets('libs/select2/dist/css/select2.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo assets('libs/jquery-sweetalert/dist/sweetalert.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo assets('libs/jquery-preloader/css/preloader.css') ?>">
<?php $__env->stopSection(); ?>



<?php $__env->startSection('thispagejs'); ?>
        <script src="<?php echo assets('libs/select2/dist/js/select2.full.min.js') ?>"></script>
        <script src="<?php echo assets('libs/select2/dist/js/select2.min.js') ?>"></script>
        <script src="<?php echo assets('libs/jquery-validation/dist/jquery.validate.min.js')?>"></script>
        <script src="<?php echo assets('libs/jquery-preloader/js/jquery.preloader.min.js')?>"></script>
        <script src="<?php echo assets('libs/jquery-sweetalert/dist/sweetalert.min.js')?>"></script>
        <script src="<?php echo assets('dist/js/jquery.form.min.js') ?>"></script>
        <script>
        $(document).ready(function() {

        	// Form validation
        	$("#saveSupplierForm").validate();

        });
        </script>
<?php $__env->stopSection(); ?>
 

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>