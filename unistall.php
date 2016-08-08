<?php
//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();


delete_site_option( 'dms_select_name' );
delete_site_option( 'dms_options' );
delete_site_option( 'dms_multisite' );
delete_site_option( 'dms_placeholder' );
delete_site_option( 'dms_styles' );
