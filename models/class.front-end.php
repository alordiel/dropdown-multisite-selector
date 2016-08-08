<?php

Class DMS_FRONT {

	function noneOptions(){
		$output = "";
		$options_db_select = 'dms_options';

		if ( get_option( $options_db_select ) ) {
			$options = get_option( $options_db_select );
		}

		if ( $options ) {

			foreach ( $options as $key => $value ) {
				$output .= "<option value='" . $value . "'>" . $key . "</option>";
			}
		}
		else{
			$err = "<p class='error-front'>" . __("Missing data. Check if all the settigns are correctly set in your admin area regarding 'Dropdown Multisite selector'",'dropdown-multisite-selector') . "</p>";
			return $err;
			die();
		}

		return $output;
	}


	//show all sites from the WMN
	function showAll($sort){

		$output = "";
		$sites = array();
		$all_wmn_sites = wp_get_sites();
		$current_site_id = get_current_blog_id();

		//bulid array from all the sites
		foreach ($all_wmn_sites as $site) {

			if ($current_site_id != $site["blog_id"]) {
				$the_site = get_blog_details($site["blog_id"]);
				$sites[$the_site->blogname] = $the_site->siteurl;
			}
		}

		//check for alphabetic order
		if ($sort == 'true') {
			ksort($sites);
		}

		foreach ($sites as $blogname => $siteurl) {
			$output .= "<option value='" . $siteurl . "'>" . $blogname . "</option>";
		}

		return $output;
	}

	//show only the sites from the WMN which the user is logged in
	function usersOnly($sort){

		$output = "";
		$sites = array();
		$users_sites = get_blogs_of_user( get_current_user_ID() );
		$current_site_id = get_current_blog_id();

		//bulid array from all the sites
		foreach ($users_sites as $site) {

			if ($current_site_id != $site->userblog_id) {
				$the_site = get_blog_details($site->userblog_id);
				$sites[$the_site->blogname] = $the_site->siteurl;
			}
		}

		//check for alphabetic order
		if ($sort == 'true') {
			ksort($sites);
		}

		foreach ($sites as $blogname => $siteurl) {
			$output .= "<option value='" . $siteurl . "'>" . $blogname . "</option>";
		}
		return $output;
	}

}
