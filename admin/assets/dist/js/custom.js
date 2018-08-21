$(function() {
    "use strict";
    
    //***********************************//
    // For select 2
    //***********************************//
    if (jQuery().select2) {
    	$(".select2").select2();
        $(".select2").on('change.select2', function(e) {
            $(this).trigger('blur');
        });
    }
    
    
    //**************************************//
    // Form validation and Ajax submission
    //**************************************//
    if (jQuery().validate) {
    	jQuery.validator.setDefaults({
    		ignore: [],
    		validClass: 'is-valid',
        	errorClass: 'is-invalid',
        	errorElement: 'div',
        	errorPlacement: function(error, element) {
            	error.addClass('invalid-feedback');
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else if (element.hasClass('select2-hidden-accessible')) {
                	error.insertAfter(element.parent().find('.select2-container'));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element, errorClass, validClass) {
            	if ($(element).hasClass('select2-hidden-accessible')) {
                	$(element).parent().find('.select2-selection').addClass('select2-' + errorClass).removeClass('select2-' + validClass);
            	} else {
            		$(element).addClass(errorClass).removeClass(validClass);
            	}
            },
            unhighlight: function(element, errorClass, validClass) {
            	  if ($(element).hasClass('select2-hidden-accessible')) {
    				  $(element).parent().find('.select2-selection').removeClass('select2-' + errorClass).addClass('select2-' + validClass);
            	  } else {
            		  $(element).removeClass(errorClass).addClass(validClass);
        		  }
            },
            submitHandler: function(form) {
            	$(form).ajaxSubmit({
            		dataType: 'json',
                    beforeSubmit:  function(formData, jqForm, options) {
                    	jqForm.preloader();
                    }, 
                    success:       function(response, status, xhr, $form) {
                    	$form.preloader('remove');
                    	swal({
                        	title: 'Admin',
                    		type: response.success ? "success" : "error",
                    	    text: response.message != undefined ? response.message : "Submitted data has been recorded successfully!",
                    	    closeOnConfirm: true,
                    	},
                    	function(isConfirm) {
                    		if (response.action == 'add' && response.success) {
                    	    	document.location.href = response.location;
                    		}
                    	}); 
                    }
                });
    		}
    	});
    }
    
});