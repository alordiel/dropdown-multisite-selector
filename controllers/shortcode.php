<?php

/**
 * Register the shortcode
 */
function build_select(){

	$sites_per_user;
	$current_site_id;

	$name = false; // the name of the select's label
	$output=""; // the output
	$multisite =""; // the multisite option
	$placeholder="";
	$settings = array();

	$options_db_name = 'dms_select_name';
	$options_db_multisite = 'dms_multisite';
	$options_db_placeholder = 'dms_placeholder';
	$options_db_settings = 'dms_settings';

	$front = new DMS_FRONT();

	if ( get_option( $options_db_name ) ) {
		$name = get_option( $options_db_name );
	}

	if ( get_option( $options_db_multisite ) ) {
		$multisite = get_option( $options_db_multisite );
	}

	if ( get_option( $options_db_settings ) ) {
		$settings = get_option( $options_db_settings );
	}

	if ( get_option( $options_db_placeholder ) ) {
		$placeholder = get_option( $options_db_placeholder );
	} else {
		$placeholder = __('Select Option','dropdown-multisite-selector');
	}

	$output .="<div class='dms-container'>";

	//Hide the label
	if ($name !== false && $settings['showHideTag'] =='true'){
		$output .= "<label for='dms-select'>" . $name . "</label>";
	}

	// add class for opening in new window
	if ($settings['targetBlank'] == 'true') {
		$output .= "<select class='dms-select open-in-new-tab'>";
	} else {
		$output .= "<select class='dms-select'>";
	}

	if ($settings['currentSite'] == 'true') {
		$current_site_id = get_current_blog_id();
		$the_site = get_blog_details($current_site_id);
		$output .= "<option value=''>".$the_site->blogname."</option>";
	} else{
		$output .= "<option value=''>".$placeholder."</option>";
	}


	//load the options for the site
	if ($multisite == 'none') {
		$output .= $front -> noneOptions();
	} elseif ($multisite == 'all') {
		$output .= $front -> showAll($settings['alphabeticOrder']);
	} elseif ($multisite =="usersonly"){
		if (is_user_logged_in()) {
			$output .= $front -> usersOnly($settings['alphabeticOrder']);
		} else{
			return false;
		}
	}

	$output .= "</select>";
	$output .= "</div>";

	return $output;

}
add_shortcode('dms','build_select');

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
add_shortcode('dms_manual','build_select_manual');
