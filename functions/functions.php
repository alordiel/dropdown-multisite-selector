<?php
/**
* Functions for displaying the select options on the front
*/
	
function noneOptions(){
	$out 			= "";
	$options 	= get_option( 'dms_options' );
	$sorting 	= get_option( 'dms_sorting' );

	//check if options data is entered
	if ( !$options || !is_array($options) || count($options) == 0) {
		$err = "<p class='error-front'>" . __("Missing data. Check if all the settigns are correctly set in your admin area regarding 'Dropdown Multisite selector'",'dropdown-multisite-selector') . "</p>";
		return $err;
		die();
	}

	//check for sorting options
	if ($sorting == 'alphabetic') {

		ksort($options,SORT_NATURAL);

	} elseif( $sorting == 'lastfirst'){

		$options = array_reverse($options, TRUE);

	}

	//build the options
	foreach ( $options as $key => $value ) {
		$out .= "<option value='" . esc_url($value) . "'>" . trim($key) . "</option>";
	}

	return $out;
}

//show all sites from the WMN
function showAll(){

	$out = '';
	/*$site_arguments = array (
		'public' => 1,
		'archive'=> 0,
		'deleted'=> 0,
		'spam' 	 => 0,
		'orderby'=> array('path'),
	);*/
	$all_wmn_sites = get_sites();
	$current_site_id = get_current_blog_id();
	$multisite_pairs = array();

	foreach ($all_wmn_sites as $site) {

		if ($current_site_id != $site->blog_id) {
			$the_site = get_blog_details($site->blog_id);
			$multisite_pairs[addslashes($the_site->blogname)] = $the_site->siteurl;
		}

	}

	ksort($multisite_pairs);
	foreach ($multisite_pairs as $name => $url) {
		$out .= "<option value='" . esc_url($url) . "'>" . trim($name) . "</option>";
	}
	echo "</pre>";
	return $out;
}

//show only the sites from the WMN which the user is regged in
function usersOnly(){

	$out = "";
	$users_sites 		= get_blogs_of_user( get_current_user_ID() );
	$current_site_id 	= get_current_blog_id();

	foreach ($users_sites as $site) {
		if ($current_site_id != $site->userblog_id) {
			$out .= "<option value='" . esc_url($site->siteurl) . "'>" . trim($site->blogname) . "</option>";
		}		
	}

	return $out;
}

// Function for sanitiz
function cleanInput($input) {
	
	$search = array(
		'@<script[^>]*?>.*?</script>@si',
		'@<[\/\!]*?[^<>]*?>@si',
		'@<style[^>]*?>.*?</style>@siU',
		'@<![\s\S]*?--[ \t\n\r]*>@'
	);
	
	$output = preg_replace($search, '', $input);
	return $output;
}

function sanitize($input) {

	if (is_array($input)) {

		foreach($input as $var=>$val) {
			$output[$var] = sanitize($val);
		}

	}
	else {

		if (get_magic_quotes_gpc()) {
			$input = stripslashes($input);
		}
		$input  = cleanInput($input);

	}

	return $input;
}