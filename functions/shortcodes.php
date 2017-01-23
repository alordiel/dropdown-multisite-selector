<?php

//general shortcode
add_shortcode('dms','build_select');
function build_select(){
   
	$sites_per_user;
	$current_site_id;

	$name = false; // the name of the select's label
	$out=""; // the output
	$multisite; // the multisite option
	$placeholder = __('Select Option','dropdown-multisite-selector');

	
	if ( get_option( 'dms_select_name' ) ) {
		$name = get_option( 'dms_select_name');
	}

	if ( get_option('dms_multisite') ) {
		$multisite = get_option('dms_multisite' );
	}

	if ( get_option( 'dms_placeholder' ) ) {
		$placeholder = get_option( 'dms_placeholder');
	}

	$out .="<div class='dms-container'>";
	if($name !== false){$out .= "<label for='dms-select'>" . $name . "</label>";}
	$out .= "<select class='dms-select'>"; 
	$out .= "<option value=''>".$placeholder."</option>";

	if ($multisite == 'none') {
		$out .= noneOptions();
	}
	elseif ($multisite == 'all') {
		$out .= showAll();
	}
	elseif ($multisite =="usersonly"){
		if (is_user_logged_in()) {
			$out .= usersOnly();
		}
		else{
			return false;
		}
	}


	$out .= "</select>";
	$out .= "</div>";

	return $out;  

}


add_shortcode('dms_manual','build_select_manual');
function build_select_manual($atts){
	$output_error = '';
	$output = "";
	$a = shortcode_atts( array(
        'name' => '',
        'placeholder' => 'Go to',
        'target' => 'default',
        'options' => array('sitename|url, sitename1|url1')
    ), $atts );

	$output .="<div class='dms-container'>";

	//Hide the label
	if ($a['name'] != ''){
		$output .= "<label for='dms-select'>" . $a['name'] . "</label>";
	}

	// add class for opening in new tab
	if ($a['target'] == 'blank') {
		$output .= "<select class='dms-select open-in-new-tab'>";
	} else {
		$output .= "<select class='dms-select'>";
	}

	$output .= "<option value=''>".$a['placeholder']."</option>";

	//load the options for the site
	$all_sites = explode( ',', $a['options'] );
	$sites = array();
	foreach ($all_sites as $site) {
		$one_site = explode('|', $site);
		if (count($one_site) == 2) {
		 	$sites[$one_site[0]]=trim($one_site[1]);
		} else {
 			$output_error .= '<p>'.__('You have entered wrong array of sites! They should be in format "url|sitename, url1|sitename1, ..."','dropdown-multisite-selector').'</p>';
		}

	}
	foreach ( $sites as $blogname => $url ) {
		$output .= "<option value='" . $url . "'>" . $blogname . "</option>";
	}

	$output .= "</select>";
	$output .= "</div>";

	if ($output_error != '') {
		$output = $output_error;
	}

	return $output;

}
