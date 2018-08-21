@extends('layouts.app')



@section('content')

<!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Suppliers</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <a href="<?php echo url('addSupplier') ?>" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">Add New</a>
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
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                            	<th>ID</th>
                                                <th>Name (Contact Person / Phone / Mobile / Locality)</th>
                                                <th width="55">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php if (isset($suppliers) && count($suppliers)): ?>
                                            	<?php foreach($suppliers as $supplier): ?>
                                                <tr>
                                                    <td><?php echo $supplier->id?></td>
                                                    <td><?php echo $supplier->name . ' (' . $supplier->contact_person . ' | ' . $supplier->phone . ' / ' . $supplier->mobile . ' | ' . $supplier->locality, ', ', $supplier->city . ')'?></td>
                                                    <td>
                                                    	<a role="button" class="btn btn-primary btn-sm" href="{{ url('editSupplier') }}<?php echo $supplier->id?>" title="Edit"><i class="mdi mdi-lead-pencil"></i></a>
                                                    	<button type="button" class="btn btn-danger btn-sm deleteBtn" data-index="<?php echo $supplier->id?>" title="Delete"><i class="mdi mdi-delete"></i></button>
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
            
@endsection


@section('customcss')
<link rel="stylesheet" type="text/css" href="<?php echo assets('extra-libs/multicheck/multicheck.css') ?>">
    <link href="<?php echo assets('libs/datatables.net-bs4/css/dataTables.bootstrap4.css') ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo assets('libs/jquery-sweetalert/dist/sweetalert.css') ?>">
@endsection



@section('thispagejs')
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
            	      text: "You will not be able to recover this supplier!",
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
            	    		    url: '<?php echo url('deleteSupplier') ?>' + id,
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
@endsection
 
