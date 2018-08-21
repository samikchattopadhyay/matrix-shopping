<?php $__env->startSection('content'); ?>

<!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Categories</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                        		<?php if (isset($categoryTree) && count($categoryTree)): ?>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?php echo e(url('listCategories', [ 'pid' => '' ])); ?>">Root</a></li>
                                        <?php foreach($categoryTree as $cId => $cat): ?>
                                        	<li class="breadcrumb-item active" aria-current="page">
                                        		<?php if ($cId < (count($categoryTree) - 1) && ($cat['rgt'] - $cat['lft']) > 1): ?>
                                        			<a href="<?php echo e(url('listCategories', [ 'pid' => $cat['id'] ])); ?>"><?php echo $cat['name'] ?></a>
                                        		<?php else: ?>
                                        			<?php echo $cat['name'] ?>
                                        		<?php endif; ?>
                                        	</li>
                                        <?php endforeach; ?>
                                        <!-- <li class="breadcrumb-item active" aria-current="page">Library</li> -->
                                    </ol>
                                <?php else: ?>
                                    <a href="<?php echo e(url('addCategory', [ 'pid' => '' ])); ?>" 
                                    class="btn btn-primary btn-sm active" 
                                    role="button" aria-pressed="true">Add New</a>
                                <?php endif; ?>
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
                <div class="row">
                    <div class="col-12">
            			<div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="55">ID</th>
                                                <th>Name</th>
                                                <th width="150">Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                        	<?php if (isset($categories) && count($categories)): ?>
                                            	<?php foreach($categories as $category): ?>
                                                <tr>
                                                    <td><?php echo @$category->id ?></td>
                                                    <td>
                                                        <?php if($category->has_child): ?>
                                                        	<a href="<?php echo url('listCategories', ['pid' => $category->id]) ?>">
                                                        		<?php echo @$category->name?>
                                                			</a>
                                                        <?php else: ?>
                                                        	<?php echo @$category->name?>
                                                        <?php endif;?>
                                                    </td>
                                                    <td>
                                                    	<a role="button" class="btn btn-outline-primary btn-sm" href="<?php echo e(url('addCategory', [ 'pid' => $category->id ])); ?>" title="Add sub category"><i class="mdi mdi-folder-plus"></i></a>
                                                    	<a role="button" class="btn btn-outline-primary btn-sm" href="<?php echo e(url('editCategory', [ 'id' => $category->id ])); ?>" title="Edit"><i class="mdi mdi-lead-pencil"></i></a>
                                                    	<button type="button" class="btn btn-outline-danger btn-sm deleteBtn" data-index="<?php echo @$category->id?>" title="Delete"><i class="mdi mdi-delete"></i></button>
                									</td>
                                                </tr>
                                                <?php endforeach;?>
                                            <?php else: ?>
                                            	<tr>
                                            		<td colspan="4" align="center"> No records found</td>
                                            	</tr>
                                            <?php endif;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <script>
                function allowDrop(ev) {
                    ev.preventDefault();
                }
                
                function drag(ev) {
                    var id = $(ev.target).data('id');
                    ev.dataTransfer.setData("text", id);
                }
                
                function drop(ev) {
                    ev.preventDefault();
                    var data = ev.dataTransfer.getData("text");
                    ev.target.appendChild(document.getElementById(data));
                }
                </script>
                

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
            
<?php $__env->stopSection(); ?>


<?php $__env->startSection('customcss'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo assets('extra-libs/multicheck/multicheck.css') ?>">
    <link href="<?php echo assets('libs/datatables.net-bs4/css/dataTables.bootstrap4.css') ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo assets('libs/jquery-sweetalert/dist/sweetalert.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo assets('dist/css/bootstrap-treeview.css') ?>">
<?php $__env->stopSection(); ?>



<?php $__env->startSection('thispagejs'); ?>
<script src="<?php echo assets('extra-libs/multicheck/datatable-checkbox-init.js') ?>"></script>
    <script src="<?php echo assets('extra-libs/multicheck/jquery.multicheck.js') ?>"></script>
    <script src="<?php echo assets('extra-libs/DataTables/datatables.min.js') ?>"></script>
    <script src="<?php echo assets('libs/jquery-sweetalert/dist/sweetalert.min.js')?>"></script>
    <script>
        /****************************************
         *       Basic Table                   *
         ****************************************/
        var dtable = $('#zero_config').DataTable();

        $(document).ready(function() {

            $('body').on('click', '.deleteBtn', function() {

                var id = $(this).data('index');
                var tr = $(this).parents('tr');

            	swal({
            	      title: "Are you sure?",
            	      text: "You will not be able to recover this and it's child categories!",
            	      type: "warning",
            	      showCancelButton: true,
            	      confirmButtonClass: "btn-danger",
            	      confirmButtonText: "Yes, delete it!",
            	      showLoaderOnConfirm: true,
            	      closeOnConfirm: false
        	    },
        	    function(isConfirm){
            	      if (isConfirm) {
            	    	  $.ajax({
            	    		    url: '<?php echo url('deleteCategory') ?>' + id,
            	    		    type: 'DELETE',
            	    		    dataType: 'json',
            	    		    success: function(response) {
            	    		        if (response.success) {
            	    		        	dtable.row(tr).remove().draw();
            	    		        	swal("Deleted!", response.message, "success");
            	    		        } else {
            	    		        	swal("Failed!", response.message, "error");
            	    		        }
            	    		    }
            	    		});
            	      }
        	    });
            });

        });
    </script>
<?php $__env->stopSection(); ?>
 

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>