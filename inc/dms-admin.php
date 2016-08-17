<?php
$name 		= get_option( 'dms_select_name' );
$options 	= get_option( 'dms_options' );
$multisite 	= get_option( 'dms_multisite' );
$placeholder= get_option( 'dms_placeholder' );
$settings 	= get_option( 'dms_settings' );


if( !$name || $name =='false' ){

	$name = "";

}

if ( !$multisite ) {

	$multisite = 'all';

}
 
if ( !$placeholder) {

	$placeholder = __('Select option','dropdown-multisite-selector');

}

if ( is_array($settings) && !array_key_exists('showHideTag',$settings) ) {

	$settings['showHideTag'] = 'true';

}

if ( !array_key_exists('currentSite',$settings) ) {

	$settings['currentSite'] = 'true';

}

if ( !array_key_exists('alphabeticOrder',$settings) ) {

	$settings['alphabeticOrder'] = 'true';

}

if ( !array_key_exists('targetBlank',$settings) ) {
	
	$settings['targetBlank'] = 'true';

}
?>

<div class="dms-admin">

	<h1>Dropdown Multisite Selector</h1>

	<div class="dms-formular">

		<?php require_once( PLUGIN_PATH_DMS .'/templates/admin-content.php'); ?>

	</div>

</div>
