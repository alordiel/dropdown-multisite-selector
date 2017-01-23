jQuery(document).ready(function(){

	
	//Add new row in the table with new fields
	jQuery('#dms-table').on('click','.add_row',function(){
		
		var parent = jQuery(this).parent().parent();
		
		//build the new row
		var newRow = jQuery('<tr></tr>').addClass('new-row');

		var tdName = jQuery('<td></td>').html('<input type="text" name="field_name" >').appendTo(newRow);
		var tdUrl = jQuery('<td></td>').html('<input type="text" class="urls" name="field_url" >').appendTo(newRow);
		var tdDel = jQuery('<td></td>').html('<input type="button" class="del_row" title="Delete tish row" value="x">').appendTo(newRow);
		var tdDel = jQuery('<td></td>').html('<input type="button" class="add_row" title="Add row" value="+">').appendTo(newRow);
		
		newRow.fadeIn('slow', function(){
			jQuery(parent).after(this);
		})
		return false;
	});
	
	//Delete row
	jQuery('#dms-table').on('click', 'input.del_row',function(){

		var this_row = jQuery(this).parent().parent();
		//Get the number of rows
		var numRow = jQuery('#dms-table > tbody >tr').length;

		//Check if is the only one
		if ( numRow == 1 ){
			jQuery('input:text[name=field_name]').val('');
			jQuery('input:text[name=field_url]').val('');
		}
		else{
			jQuery(this_row).fadeOut(400, function(){
				this_row.remove();
			});
		}
		
		return false;
	});

	//check for http://
	jQuery('body').on('change', 'input.urls', function(){
		var val = jQuery(this).val();
		if ( val.search('http://') < 0 && val.search('https://') < 0 ) {
			val = 'http://' + val.trim();
			jQuery(this).val(val);
		};
	});

	//disable / enable the options to see the manual adding links and options
	jQuery('input:radio[name=multisite]').on('click',function() {
	  var val = jQuery('input:radio[name=multisite]:checked').val();

	  if (val == 'none') {
	  	jQuery('.middle-box').show('slow');
	  	jQuery('.sorting-options-block').show('slow');
	  }
	  else{
	  	jQuery('.middle-box').hide('slow');
	  	jQuery('.sorting-options-block').hide('slow');
	  }
	});

	//Submit form
	jQuery('#dms-submit').on('click',function(){
		var error_fields = 0;
		var error_name = 0;
		var theSelectName;
		var theOptions = {};
		var placeholder = "";
		
		//Clear the success and error log
		jQuery('.succes_log').empty();
		jQuery('.overall-error').empty();

		//clear all messages
		jQuery(".message-on").removeClass('message-on');

		//Get the name of the Select option
		theSelectName = jQuery('#select_name').val();
		placeholder = jQuery('#select_placeholder').val();

		if (theSelectName != "") {

			var regex_letters=/^[\u00C0-\u1FFF\u2C00-\uD7FFa-zA-Z\s'\- ]+$/;

			if (!regex_letters.test(theSelectName)) {
				
				jQuery(".error-log-name").text(trans_str.let_err);
				error_fields ++;

			}
			else{
				jQuery(".error-log-name").empty();
			}	
			
		}

		//Get multisite options
		var multisite = jQuery('input[name="multisite"]:checked').val();
		var sorting   = jQuery('input[name="sorting-option"]:checked').val();

		if(multisite == 'none'){
			//Get all values of all inputs and build array
			jQuery("#dms-table > tbody >tr").each(function(){
				
				var theName = '';
				var theUrl = '';
				var i = 0

				jQuery('input[type=text]', this).each(function(){
					
					if ( i == 0 ){
						theName = jQuery(this).val();
					}
					else if ( i == 1 ){
						theUrl = jQuery(this).val();
					}
					else{
						jQuery(".error-log-fields").text(trans_str.err_err);
						error_fields ++;

					}

					i++;

				});

				//check if empty fields exists
				if ( theName=="" || theUrl=="" ){
					
					jQuery(".error-log-fields").text(trans_str.emt_err);
					error_fields ++;

				}

				//check if key does not exist already
				if ( theName in theOptions ) {

					jQuery(".error-log-fields").text(trans_str.dup_err);
					error_fields ++;

				};

				//push into array
				theOptions[theName] = theUrl

			});
		}


		//check for errors and clear if none
		if ( error_fields != 0 ) {
			jQuery(".error-log-fields").addClass('message-on')
			return false;
		}
		else{
			jQuery(".error-log-fields").empty();
		}

		if ( error_name != 0) {
			return false;
		}
		
		//Ajax
		var the_data = {
			action: 'dms_add_fields',
			name: theSelectName,
			options: theOptions,
			multisite: multisite,
			sorting :sorting,
			placeholder: placeholder,
		}

		jQuery.ajax({
			url: dms_ajax_vars.ajax_url,
			data: the_data,
			type: "post",
			success: function (response){

				if (response==1) {
					jQuery(".succes_log").text(trans_str.suc_err);
					jQuery(".succes_log").addClass('message-on');
				}
				else{
					jQuery(".error-log-fields").addClass('message-on');
					jQuery(".error-log-fields").text(response);
				}
				 window.scrollTo(500, 0);
			},
			error: function() {
				jQuery("#error").addClass('message-on');
				jQuery('#error').text(trans_str.err_err);
			}
		});
		return false;
	});
});