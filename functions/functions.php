<?php
/**
 * Functions for displaying the select options on the front
 *
 * @return string
 */
function dms_none_option_selected() {
	$out     = '';
	$options = get_option( 'dms_options' );
	$sorting = get_option( 'dms_sorting' );

	//check if options data is entered
	if ( ! $options || ! is_array( $options ) || count( $options ) === 0 ) {
		return "<p class='error-front'>" . __( "Missing data. Check if all the settings are correctly set in your admin area regarding 'Dropdown Multisite selector'", 'dropdown-multisite-selector' ) . "</p>";
	}

	$sites = [];
	foreach ( $options as $name => $url ) {
		$sites[] = [ 'name' => $name, 'url' => $url ];
	}
	//check for sorting options
	if ( $sorting === 'alphabetic' ) {
		uasort( $sites, 'mb_dms_compare_alphabetically' );
	} elseif ( $sorting === 'lastfirst' ) {
		$sites = array_reverse( $sites, true );
	} elseif ( $sorting === 'numeric' ) {
		uasort( $sites, 'dms_sort_numeric' );
	}

	foreach ( $sites as $site ) {
		$out .= "<option value='" . esc_url( $site['url'] ) . "'>" . trim( $site['name'] ) . "</option>";
	}

	return $out;
}

/**
 * Show all sites from the WMN
 *
 * @return string
 */
function dms_show_all_network_sites() {

	$out             = '';
	$sites_arguments = array(
		'public'   => 1,
		'archived' => 0,
		'mature'   => 0,
		'deleted'  => 0,
		'spam'     => 0,
		'orderby'  => array( 'path' ),
		'number'   => 1000,
	);

	$sites_arguments = apply_filters( 'dms_sites_arguments', $sites_arguments );

	$all_wmn_sites   = get_sites( $sites_arguments );
	$current_site_id = get_current_blog_id();
	$multisite_pairs = array();

	foreach ( $all_wmn_sites as $site ) {

		if ( $current_site_id !== $site->blog_id ) {
			$the_site          = get_blog_details( $site->blog_id );
			$multisite_pairs[] = [ 'name' => addslashes( $the_site->blogname ), 'url' => $the_site->siteurl ];
		}

	}

	uasort( $multisite_pairs, 'mb_dms_compare_alphabetically' );
	$multisite_pairs = apply_filters( 'dms_multisite_pairs', $multisite_pairs );

	foreach ( $multisite_pairs as $site ) {
		$out .= "<option value='" . esc_url( $site['url'] ) . "'>" . trim( $site['name'] ) . '</option>';
	}

	return $out;
}


/**
 * Show only the sites from the WMN which the user is registered in
 *
 * @return string
 */
function dms_show_sites_for_registered_users_only() {

	$out             = '';
	$users_sites     = get_blogs_of_user( get_current_user_ID() );
	$current_site_id = get_current_blog_id();

	// Sort the sites by their blog name (as blog name is used in the selects options)
	usort( $users_sites, static function ( $a, $b ) {
		return strcmp( $a->blogname, $b->blogname );
	} );

	$users_sites = apply_filters( 'dms_users_sites', $users_sites );

	foreach ( $users_sites as $site ) {
		if ( $current_site_id !== $site->userblog_id ) {
			$out .= "<option value='" . esc_url( $site->siteurl ) . "'>" . trim( $site->blogname ) . "</option>";
		}
	}

	return $out;
}


/**
 * Function for sanitize users input
 *
 * @param string $input
 *
 * @return string|string[]|null
 */
function dms_clean_up_user_input( $input ) {

	$search = array(
		'@<script[^>]*?>.*?</script>@si',
		'@<[/!]*?[^<>]*?>@si',
		'@<![\s\S]*?--[ \t\n\r]*>@'
	);

	return preg_replace( $search, '', $input );
}


/**
 * Function for determine if a string or array is passed for sanitizing
 *
 * @param string|array $input
 *
 * @return string|string[]|null
 */
function dms_sanitize_input( $input ) {

	if ( is_array( $input ) ) {

		foreach ( $input as $key => $value ) {
			$output[ $key ] = dms_sanitize_input( $value );
		}

		return $input;
	}

	return dms_clean_up_user_input( stripslashes( $input ) );
}

/**
 * Will do a compare between the names of the sites to do an alphabetic sort
 *
 * @param array $a
 * @param array $b
 *
 * @return boolean
 */
function mb_dms_compare_alphabetically( $a, $b ) {
	if ( empty( $a['name'] ) || empty( $b['name'] ) ) {
		return false;
	}

	$alphabet = 'aąãáàäbcćdeęéêfghiíjklłmnnoóõôöóqprsśtuúüvwxyzźż';
	$a_string = mb_strtolower( $a['name'] );
	$b_string = mb_strtolower( $b['name'] );

	for ( $i = 0, $iMax = mb_strlen( $a_string ); $i < $iMax; $i ++ ) {
		if ( mb_substr( $a_string, $i, 1 ) === mb_substr( $b_string, $i, 1 ) ) {
			continue;
		}
		if ( $i > mb_strlen( $b_string ) ) {
			return 1;
		}
		$compared = ( mb_strpos( $alphabet, mb_substr( $a_string, $i, 1 ) ) > mb_strpos( $alphabet, mb_substr( $b_string, $i, 1 ) ) );
		return $compared ? 1 : -1;
	}

	return -1;
}


function dms_sort_numeric( $a, $b ) {
	if ( empty( $a['name'] ) || empty( $b['name'] ) ) {
		return false;
	}

	$a_string = mb_strtolower( $a['name'] );
	$b_string = mb_strtolower( $b['name'] );

	return $a_string > $b_string ? 1 : -1;
}
