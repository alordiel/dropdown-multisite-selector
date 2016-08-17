jQuery(document).ready(function(){

	//show hide the lable options
	jQuery('#label-opt').click( function(){
		jQuery('.name-opt').fadeToggle('slow');
	});

	jQuery('#first-tag').click( function(){	
		jQuery('.select-opt').fadeToggle('slow');
	});


	//show/hide styles boxes
	jQuery('.dms-styles-interface').click(function(){
		
		var css_value = jQuery(this).val();

		switch (css_value) {
			case 'style-options':
				jQuery('.style-opt-block').fadeToggle('slow');
				jQuery('.custom-css-block').fadeOut('slow');
				break;
			case 'custom-css':
				jQuery('.custom-css-block').fadeToggle('slow');
				jQuery('.style-opt-block').fadeOut('slow');
				break;
			case 'default-css':
				jQuery('.custom-css-block').fadeOut('slow');
				jQuery('.style-opt-block').fadeOut('slow');
				break;
		}
	});


	//TABS NAVIGATION
	jQuery('.ttab1').click(function(){
		hideTheElemnts(this);
		jQuery('.dms-tab1').removeClass('hide-option');
		jQuery('.dms-tab1').css('display','block');
		jQuery('.dms-tab1').addClass("transition show-option");
	});

	jQuery('.ttab2').click(function(){
		hideTheElemnts(this);
		jQuery('.dms-tab2').removeClass('hide-option');
		jQuery('.dms-tab2').css('display','block');
		jQuery('.dms-tab2').addClass("transition show-option");

	});

	function hideTheElemnts(x){
		jQuery('.li-tabs').removeClass('active');
		jQuery(x).addClass('active');

		jQuery('.block-tabs').each(function(){
			if(!jQuery(this).hasClass('hide-option')){
				jQuery(this).addClass('hide-option');
			}

			if( jQuery(this).hasClass('transition')){
				jQuery(this).removeClass('transition');
			}
			jQuery(this).removeClass('show-option');
			jQuery(this).css('display','none');
		});
	}

	//Add new row in the table with new fields
	jQuery('#dms-add').on('click',function(){
		
		var newRow = jQuery('<tr></tr>').addClass('new-row');
		var tdName = jQuery('<td></td>').html('<input type="text" name="field_name" >').appendTo(newRow);
		var tdUrl = jQuery('<td></td>').html('<input type="text" class="urls" name="field_url" >').appendTo(newRow);
		var tdDel = jQuery('<td></td>').html('<input type="button" class="del_row" value=" X ">').appendTo(newRow);
		
		newRow.fadeIn('slow', function(){
			jQuery(this).appendTo('#dms-table');
		})
		return false;

	});
	
	//Delete row
	jQuery('body').on('click', 'input.del_row',function(){

		var this_row = jQuery(this).parent().parent();
		var numRow = jQuery('#dms-table > tbody >tr').length;//Get the number of rows

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
	  	jQuery('.middle-box > div').removeClass('mask-middle');
	  	jQuery('.first-tag-wrap').addClass('hidden');
	  }
	  else{
	  	jQuery('.middle-box > div').addClass('mask-middle');
	  	jQuery('.first-tag-wrap').removeClass('hidden');
	  }
	});

	//Clear all fields 
	jQuery('.reset-all').on('click',function(){
		var confirmation;
		//confirmation question
		if (confirm(trans_str.confirm)) {
			
			//Ajax
			var the_data = {
				action: 'delete_all_fields',
				confirmation: "true"
			}

			jQuery.ajax({
				url: dms_ajax_vars.ajax_url,
				data: the_data,
				type: "post",
				success: function (response){
					if (response==1) {
						jQuery(".succes_log").text(trans_str.suc_err);
					}
					else{
						jQuery(".overall-error").text(response);
					}
				},
				error: function() {
					jQuery('#error').text(trans_str.err_err);
				}
			});

			return false;

		} else {

		    return false;

		}
	});

	//Submit form with options and fields
	jQuery('#dms-submit').on('click',function(){
		var error_fields = 0;
		var error_name = 0;
		var theSelectName;
		var theOptions = {};
		var placeholder = "";
		var settings = {};
		
		//Clear the success and error log
		jQuery('.succes_log').hide();
		jQuery('overall-error').hide();
		jQuery('.succes_log').empty();
		jQuery('overall-error').empty();

		//Get the name of the Select option
		theSelectName = jQuery('#select_name').val();
		placeholder = jQuery('#select_placeholder').val();
		settings = {
			showHideTag:jQuery('#label-opt').is(':checked'),
			targetBlank:jQuery('#new-window-opt').is(':checked'),
			alphabeticOrder:jQuery('#order-opt').is(':checked'),
			currentSite:jQuery('#first-tag').is(':checked')
		}

		for(var item in settings){
			if (settings[item] != true && settings[item] != false ) {
				jQuery(".error-log-name").show();
				jQuery(".error-log-name").text(trans_str.let_err); 
				error_fields ++;
			}
		}

		if (theSelectName == "") {
			
		}
		else{

			var regex_letters=/^[\u00C0-\u1FFF\u2C00-\uD7FFa-zA-Z\s'\- ]+$/;

			if (!regex_letters.test(theSelectName)) {
				
				jQuery(".error-log-name").show();
				jQuery(".error-log-name").text(trans_str.let_err);
				error_fields ++;

			}
			else{
				jQuery(".error-log-name").empty();
			}	
			
		}
		//Get multisite options
		var multisite = jQuery('input[name="multisite"]:checked').val();


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
					jQuery(".error-log-fields").show();
					jQuery(".error-log-fields").text(trans_str.err_err);
					error_fields ++;

				}

				i++;

			});

			//check if empty fields exists
			if (! jQuery('.middle-box > div' ).hasClass('mask-middle')) {
				if ( theName=="" || theUrl=="" ){
					
					jQuery(".error-log-fields").show();
					jQuery(".error-log-fields").text(trans_str.emt_err);
					error_fields ++;

				}
				else if ( theName == "" && theUrl == "" ){

					jQuery(".error-log-fields").text(trans_str.emt_err);
					error_fields ++;

				}
			};
			//check if key does not exist already
			if ( theName in theOptions ) {

				jQuery(".error-log-fields").show();
				jQuery(".error-log-fields").text(trans_str.dup_err);
				error_fields ++;

			};

			//push into array
			theOptions[theName] = theUrl

		});

		//check for errors and clear if none
		if ( error_fields != 0 ) {
			return false;
		}
		else{
			jQuery(".error-log-fields").empty();
			jQuery(".error-log-fields").hide();
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
			settings: settings,
			placeholder: placeholder,
		}
		
		jQuery.ajax({
			url: dms_ajax_vars.ajax_url,
			data: the_data,
			type: "post",
			success: function (response){

				if (response==1) {
					jQuery(".succes_log").show();
					jQuery(".succes_log").text(trans_str.suc_err);
				}
				else{
					jQuery(".overall-error").show();
					jQuery(".overall-error").text(response);
				}
				jQuery('html,body').animate({ scrollTop: 0 }, 'slow');
			},
			error: function() {
				jQuery('#error').text(trans_str.err_err);
				jQuery('html,body').animate({ scrollTop: 0 }, 'slow');
			}
		});
		return false;
	});

	//Submit form with styles
	jQuery('#submit-styles').on('click', function (){
		
		jQuery(".overall-error").text('');
		jQuery('#error').text('');
		jQuery(".succes_log").text('');

		var error_fields = 0;
		var error_name = 0;
		var styles = '';
		var theOption='default';
		var css_value = jQuery('input[name=style-opt]:checked').val(); // get selected style option

		switch (css_value) {
			case 'style-options':
				theOption = 'ui';
				//here goes all style fields from the ui option
				styles = {
					labelFontSize:jQuery('#label-font-size').val(),
					labelFontColor:jQuery('#lable-font-color').val(),
					selectWidth:jQuery('#select-width').val(),
					borderSize:jQuery('#border-size').val(),
					borderRadiusTop:jQuery('#border-radius-top').val(),
					borderRadiusRight:jQuery('#border-radius-right').val(),
					borderRadiusBottom:jQuery('#border-radius-bottom').val(),
					borderRadiusLeft:jQuery('#border-radius-left').val(),
					borderStyle:jQuery('input:radio[name=border-style]:checked').val(),
					borderColor:jQuery('#border-color').val(),
					selectFontSize:jQuery('#select-font-size').val(),
					selectFontColor:jQuery('#select-font-color').val(),				
					selectBackgroundColor:jQuery('#select-background-color').val(),		
				}
				
				//validate colors
				var colorTest= /(^#[0-9A-F]{6})|(^#[0-9A-F]{3})/i;
				var labeFontColorTest	= colorTest.test(styles.labelFontColor);
				var borderColorTest		=colorTest.test(styles.borderColor);
				var selectFontColorTest = colorTest.test(styles.selectFontColor);
				var selectBackgroundColorTest = colorTest.test(styles.selectBackgroundColor);

				if (  !labeFontColorTest || !borderColorTest || !selectFontColorTest || !selectBackgroundColorTest) {
					jQuery(".error-log-name-tab2").show();
					jQuery(".error-log-name-tab2").text(trans_str.style_color); 
					error_fields ++;
				};

				//validation - if fields are only numbers
				if ( !IsNumeric(styles.labelFontSize) ||
					 !IsNumeric(styles.borderSize) || !IsNumeric(styles.borderRadiusTop) || 
					 !IsNumeric(styles.borderRadiusRight) || !IsNumeric(styles.borderRadiusBottom) || 
					 !IsNumeric(styles.borderRadiusLeft) || !IsNumeric(styles.selectFontSize) ) {
					jQuery(".error-log-name-tab2").show();
					jQuery(".error-log-name-tab2").text(trans_str.style_numbers); 
					error_fields ++;
				};

				//validate width
				if (styles.selectWidth != 'auto' && !IsNumeric(styles.selectWidth)) {
					jQuery(".error-log-name-tab2").show();
					jQuery(".error-log-name-tab2").text(trans_str.style_numbers); 
					error_fields ++;
				};

				//validating border style
				var borderStylesArray = new Array('none','hidden','dotted','dashed','solid','double','groove','ridge','inset','outset','initial','inherit');
				if (borderStylesArray.indexOf(styles.borderStyle) == -1) {
					jQuery(".error-log-name-tab2").show();
					jQuery(".error-log-name-tab2").text(trans_str.style_border); 
					error_fields ++;
				};

				break;

			case 'custom-css':
				var regex_letters=/[<?>]/; //small validation
				theOption='custom';
				styles = jQuery('#custom-css').val();
				if (regex_letters.test(styles)) {
					jQuery(".error-log-name-tab2").show();
					jQuery(".error-log-name-tab2").text(trans_str.style_err); 
					error_fields ++;
				}
				break;
		}

		if(error_fields > 1) {
			return false;
		}

		var the_data = {
			action: 'dms_update_styles',
			styles: styles,
			option: theOption,
		}

		jQuery.ajax({
			url: dms_ajax_vars.ajax_url,
			data: the_data,
			type: "post",
			success: function (response){

				if (response==1) {
					jQuery(".succes_log").show();
					jQuery(".succes_log").text(trans_str.suc_err);
				}
				else{
					jQuery(".overall-error").show();
					jQuery(".overall-error").text(response);
				}
				jQuery('html,body').animate({ scrollTop: 0 }, 'slow');
			},
			error: function() {
				jQuery('#error').text(trans_str.err_err);
				jQuery('html,body').animate({ scrollTop: 0 }, 'slow');
			}
		});
		return false;
	})

});

function IsNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}