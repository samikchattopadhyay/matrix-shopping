<?php $__env->startSection('content'); ?>

<!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Address Book - <?php echo e(@$action); ?></h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <a href="<?php echo url('listAddress') ?>" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">List All</a>
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
                            <form id="saveAddress" action="<?php echo e(url('saveAddress')); ?>" method="post" class="form-horizontal">
                                
                                <?php if (isset($address) && !empty($address->id)): ?>
                                	<input type="hidden" name="id" value="<?php echo e(@$address->id); ?>" />
                                <?php endif; ?>
                                
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="address" class="col-sm-3 control-label col-form-label">Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control required" id="address" name="address" value="<?php echo e(@$address->address); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="locality" class="col-sm-3 control-label col-form-label">Locality</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control required" id="locality" name="locality" value="<?php echo e(@$address->locality); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pin" class="col-sm-3 control-label col-form-label">PIN</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control required" id="pin" name="pin" value="<?php echo e(@$address->pin); ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="state_id" class="col-sm-3 control-label col-form-label">State</label>
                                        <div class="col-sm-9">
                                            <select class="select2 form-control custom-select required" id="state_id" name="state_id" style="width: 100%; height:36px;">
                                            	<option value="">Select</option>
                                            	<?php if (isset($states) && count($states)): ?>
                                            		<?php foreach ($states as $state):?>
                                            			<option value="<?php echo $state->id ?>" <?php echo (isset($address->state_id) && $address->state_id == $state->id) ? 'selected' : ''?>><?php echo $state->name ?></option>
                                            		<?php endforeach;?>
                                            	<?php endif;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="city_id" class="col-sm-3 control-label col-form-label">City</label>
                                        <div class="col-sm-9">
                                            <select class="select2 form-control custom-select required" id="city_id" name="city_id" style="width: 100%; height:36px;">
                                            	<option value="">Select</option>
                                            	<?php if (isset($cities) && count($cities)): ?>
                                            		<?php foreach ($cities as $city):?>
                                            			<option value="<?php echo $city->id ?>" <?php echo (isset($address->city_id) && $address->city_id == $city->id) ? 'selected' : ''?>><?php echo $city->name ?></option>
                                            		<?php endforeach;?>
                                            	<?php endif;?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="mobile" class="col-sm-3 control-label col-form-label">Mobile</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control required" id="mobile" name="mobile" value="<?php echo e(@$address->mobile); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="phone" class="col-sm-3 control-label col-form-label">Phone</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo e(@$address->phone); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fax" class="col-sm-3 control-label col-form-label">FAX</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="fax" name="fax" value="<?php echo e(@$address->fax); ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-3 control-label col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo e(@$address->email); ?>">
                                        </div>
                                    </div>
                                    
                                    <!--  validate example 
                                    <input required data-msg="Please fill this field">
									<input data-rule-minlength="2" data-rule-maxlength="4" data-msg-minlength="At least two chars" data-msg-maxlength="At most fours chars">
                                    -->
                                    
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
    		var foundAddress = null;
            $(document).ready(function() {

            	// Form validation
            	$("#saveAddress").validate();

                // Try to find state and city depending on the PIN code
				$('#pin').on('blur', function() {
					var pin = $(this).val();
					$.get('<?php echo url('findByPin') ?>' + pin, function(response) {
						foundAddress = response;
						if (foundAddress.state_id != undefined && foundAddress.state_id != '') {
							$(".select2").val(foundAddress.state_id).select2().trigger('change');
						}
					}, 'json');
				});

                // Load cities of the selected state
            	$("#state_id").on('change', function() {
            		var stateId = $(this).val();
            		$.get('<?php echo url('listCityByStateId') ?>' + stateId, function(result) {
						$('#city_id').html('<option value="">Select</option>');
						if (result.length) {
                			for ( x in result) {
                				$('#city_id').append('<option value="' + result[x].id + '">' + result[x].name + '</option>');
                			}
                			if (foundAddress != undefined && foundAddress != null) {
                				$('#city_id').val(foundAddress.city_id).select2().trigger('change');
                			}
						}
            		}, 'json');
            	});
            });
        </script>
<?php $__env->stopSection(); ?>
 

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>