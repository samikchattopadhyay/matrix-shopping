<?php $__env->startSection('content'); ?>

<!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Category - <?php echo e(@$action); ?></h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <a href="<?php echo url('listCategories') ?>" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">List All</a>
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
                            <form id="saveCategoryForm" action="<?php echo e(url('saveCategory')); ?>" method="post" class="form-horizontal">
                                
                                <?php if (isset($category) && !empty($category->id)): ?>
                                	<input type="hidden" name="id" value="<?php echo e(@$category->id); ?>" />
                                <?php endif; ?>
                                
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 control-label col-form-label">Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo e(@$category->name); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pid" class="col-sm-3 control-label col-form-label">Parent</label>
                                        <div class="col-sm-9">
                                            <select class="select2 form-control custom-select" id="pid" name="pid" style="width: 100%; height:36px;" required>
                                            	<option value="0">None - This is a Root category</option>
                                            	<?php if (isset($categories) && count($categories)): ?>
                                            		<?php foreach ($categories as $id => $name): ?>
                                            			<option value="<?php echo $id?>" 
                                            			<?php echo isset($category->pid) && $id == $category->pid ? 'selected' : ''?>
                                            			<?php echo isset($pid) && $id == $pid ? 'selected' : ''?>><?php echo $name ?></option>
                                            		<?php endforeach; ?>
                                            	<?php endif;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="contact_person" class="col-sm-3 control-label col-form-label">Description</label>
                                        <div class="col-sm-9">
            								<textarea class="form-control" id="description" name="description"><?php echo e(@$category->description); ?></textarea>
            							</div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="image" class="col-md-3">Image</label>
                                        <div class="col-md-9">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="image" name="image">
                                                <label class="custom-file-label" for="image">Choose file...</label>
                                            </div>
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
        	$("#saveCategoryForm").validate();

        });
        </script>
<?php $__env->stopSection(); ?>
 

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>