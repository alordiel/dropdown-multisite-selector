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

	//check for sorting options
	if ( $sorting === 'alphabetic' ) {

		ksort( $options, SORT_NATURAL );

	} elseif ( $sorting === 'lastfirst' ) {

		$options = array_reverse( $options, true );

	}

	foreach ( $options as $key => $value ) {
		$out .= "<option value='" . esc_url( $value ) . "'>" . trim( $key ) . "</option>";
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
			$the_site                                             = get_blog_details( $site->blog_id );
			$multisite_pairs[ addslashes( $the_site->blogname ) ] = $the_site->siteurl;
		}

	}

	uasort( $multisite_pairs, 'compareAlphabetically' );
	$multisite_pairs = apply_filters( 'dms_multisite_pairs', $multisite_pairs );

	foreach ( $multisite_pairs as $name => $url ) {
		$out .= "<option value='" . esc_url( $url ) . "'>" . trim( $name ) . '</option>';
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

	// Sort the sites by their blog name (as blog name is used in the select's options)
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
		'@<[\/\!]*?[^<>]*?>@si',
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


function compareAlphabetically( $a, $b ) {
	if (empty($a) || empty($b)){
		return 1;
	}

	$alphabet = 'aąbcćdeęfghijklłmnnoóqprsśtuvwxyzźż'; // i used polish letters
	$a        = mb_strtolower( array_keys($a)[0] );
	$b        = mb_strtolower( array_keys($b)[0] );

	for ( $i = 0, $iMax = mb_strlen( $a ); $i < $iMax; $i ++ ) {
		if ( mb_substr( $a, $i, 1 ) === mb_substr( $b, $i, 1 ) ) {
			continue;
		}
		if ( $i > mb_strlen( $b ) ) {
			return 1;
		}
		if ( mb_strpos( $alphabet, mb_substr( $a, $i, 1 ) ) > mb_strpos( $alphabet, mb_substr( $b, $i, 1 ) ) ) {
			return 1;
		}

		return - 1;
	}
}
