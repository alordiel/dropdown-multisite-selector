<?php
	 $name="";
	$options;
	$multisite;
	$placeholder;
	$settings = array();
	$styles_option = '';
	$styles = array();

	if(get_option( 'dms_select_name' ) ){
		$name = get_option( 'dms_select_name' );
		if($name =='false'){
			$name = "";
		}
	} else {
		$name = "";
	}

	if (get_option( 'dms_options' )) {
		$options = get_option( 'dms_options' );
	}

	if (get_option( 'dms_multisite' )) {
		$multisite = get_option( 'dms_multisite' );
	} else {
			$multisite = 'all';
	}

	if (get_option( 'dms_settings' )) {
		$settings = get_option( 'dms_settings' );
	}

	if (get_option( 'dms_placeholder' )) {
		$placeholder = get_option( 'dms_placeholder' );
	} else {
		$placeholder = __('Select option','dropdown-multisite-selector');
	}

	if (get_option( 'dms_style_option' )) {
		$styles_option = get_option( 'dms_style_option' );
	} else {
		$styles_option = 'default';
	}

	if (get_option( 'dms_styles' )) {
		$styles = get_option( 'dms_styles' );
	} else {
		$styles = array('default');
	}
	if (!array_key_exists('showHideTag',$settings)) {
		$settings['showHideTag'] = 'true';
	}
	if (!array_key_exists('currentSite',$settings)) {
		$settings['currentSite'] = 'true';
	}
	if (!array_key_exists('alphabeticOrder',$settings)) {
		$settings['alphabeticOrder'] = 'true';
	}
	if (!array_key_exists('targetBlank',$settings)) {
		$settings['targetBlank'] = 'true';
	}

	if (!array_key_exists('labelFontSize',$styles)) {
		$styles['labelFontSize'] = '12';
	}
	if (!array_key_exists('labelFontColor',$styles)) {
		$styles['labelFontColor'] = '#000000';
	}
	if (!array_key_exists('selectWidth',$styles)) {
		$styles['selectWidth'] = 'auto';
	}
	if (!array_key_exists('borderSize',$styles)) {
		$styles['borderSize'] = '0';
	}
	if (!array_key_exists('borderRadiusTop',$styles)) {
		$styles['borderRadiusTop'] = '2';
	}
	if (!array_key_exists('borderRadiusLeft',$styles)) {
		$styles['borderRadiusLeft'] = '2';
	}
	if (!array_key_exists('borderRadiusRight',$styles)) {
		$styles['borderRadiusRight'] = '2';
	}
	if (!array_key_exists('borderRadiusBottom',$styles)) {
		$styles['borderRadiusBottom'] = '2';
	}
	if (!array_key_exists('borderColor',$styles)) {
		$styles['borderColor'] = '#cccccc';
	}
	if (!array_key_exists('selectFontSize',$styles)) {
		$styles['selectFontSize'] = '12';
	}
	if (!array_key_exists('selectFontColor',$styles)) {
		$styles['selectFontColor'] = '#000000';
	}
	if (!array_key_exists('selectBackgroundColor',$styles)) {
		$styles['selectBackgroundColor'] = '#ffffff';
	}

?>
<div class="dms-admin">

	<h1>Dropdown Multisite Selector</h1>

	<div class="dms-formular">

		<?php require_once( PLUGINS_PATH .'views/admin-content.php'); ?>

	</div>

</div>
