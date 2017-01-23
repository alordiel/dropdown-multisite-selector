<?php
/**
 * Plugin Name:       Dropdown multisite selector
 * Plugin URI:        https://github.com/alordiel/dropdown-multisite
 * Description:       Allows you to configure a select option of redirecting to different webpages.
 * Version:           0.6
 * Author:            alordiel
 * Author URI:        http://profiles.wordpress.org/alordiel
 * Text Domain:       dropdown-multisite-selector
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages/
 * GitHub Plugin URI: https://github.com/alordiel/dropdown-multisite
 */

/*  Copyright 2014-2016 Alexander Vasilev  (email : alexander.vasilev@protonmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'WPINC' ) ) {
		die;
}

/**
 * Register textdomain.
 */
add_action('plugins_loaded', 'dropdown_multisite_meta_init');
function dropdown_multisite_meta_init() {
	load_plugin_textdomain( 'dropdown-multisite-selector', false, dirname( plugin_basename( __FILE__ ) ) ); 
}


/**
 * Register style sheet and scripts for the admin area.
 */
add_action( 'admin_enqueue_scripts', 'admin_styles_script' );
function admin_styles_script() {
	wp_enqueue_script( 'dms-functions', plugins_url( '/js/dms-functions.js' , __FILE__) );
	wp_enqueue_style( 'dms-style', plugins_url( '/css/dms-style.css', __FILE__ ) );
	
	//Adding localization for script string
	$translation_array = array( 
		'tag_err' => __('Please enter a select tag name.'),
		'let_err' => __('This field can contain only letters.'),
		'emt_err' => __('All Names and URL fields should be filled.'),
		'dup_err' => __('One of your Option names is written twice or more.'),
		'suc_err' => __('Your settings were saved successfully.'),
		'err_err' => __('Something went wrong!Please check your data and try again.')
	);
	wp_localize_script( 'dms-functions', 'trans_str', $translation_array );
	wp_localize_script( 'dms-functions', 'dms_ajax_vars', array( 'ajax_url' => admin_url( 'admin-ajax.php' )));
}

/**
 * Register style sheet and scripts for the front.
 */
add_action( 'wp_enqueue_scripts', 'front_styles_script' );
function front_styles_script(){
	wp_enqueue_script( 'dms-functions-front', plugins_url( '/js/dms-front.js' , __FILE__), array(), '1.0.0', true );
	wp_enqueue_style( 'dms-style-front', plugins_url( '/css/dms-front.css', __FILE__ ) );
}

/**
 * Register submenu in Settings.
 */
add_action('admin_menu','register_submenu');
function register_submenu(){
	
	add_submenu_page( 'options-general.php', 'Dropdown Multisite Selector', 'Dropdown Multisite', 'manage_options', 'dropdown-multisite-selector', 'dms_admin' );

}

/**
 * Building the admin part.
 */ 
function dms_admin(){

	$out = include('dms-admin.php');

	return $out;
}

/**
 * Building the admin part.
 */ 
add_action("wp_ajax_dms_add_fields", "dms_ajax_update_fields");
function dms_ajax_update_fields() {
	global $wpdb;
	$name;
	$options;
	$multisite 		= 'none';
	$sorting 		= 'none';
	$placeholder 	= '';
	$radiobuttons 	= array('none','all','usersonly');
	$sorting_options = array('none','lastfirst','alphabetic');	

	if(array_key_exists('name', $_POST)){
		$name = $_POST['name'];
		if($name==""){
			$name = false;
		}
	}

	if(array_key_exists('options', $_POST)){
		$options = $_POST['options'];
	}

	if(array_key_exists('multisite', $_POST)){
		$multisite = $_POST['multisite'];
	}

	if(array_key_exists('placeholder', $_POST)){
		$placeholder = $_POST['placeholder'];
	}

	if(array_key_exists('sorting', $_POST)){
		$sorting = $_POST['sorting'];
	}

	//validate
	if($name){
		if (preg_match('/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i', $name)) {
			_e("This field can contain only letters.",'dropdown-multisite-selector');
			die();
		}
	}


	if (!in_array($multisite, $radiobuttons)) {
		_e("Don't bug with the code, please!",'dropdown-multisite-selector');
		die();
	}

	if (!in_array($sorting, $sorting_options) ) {
		_e("Don't bug with the code, please!",'dropdown-multisite-selector');
		die();
	}

	if ( $options ) {
		if ( !is_array($options) ) {
			_e("Please make sure that you have entered all fields correctly.",'dropdown-multisite-selector');
			die();
		}
	}
	elseif(!$options && $multisite=='none'){
		_e("Please enter a place tag name.",'dropdown-multisite-selector');
		die();
	}

	if($name !== false) {
		$name = cleanInput(sanitize($name));
	}
	$options 		= cleanInput(sanitize($options));
	$placeholder 	= cleanInput(sanitize($placeholder));


  
	if ( get_option('dms_select_name' ) !=  $name ) {
		if(!update_option('dms_select_name' , $name )) {
			_e("Something went worng with updating your settigns.",'dropdown-multisite-selector');
			die();
		}
	}

	if ( get_option( 'dms_options' ) != $options && $multisite=='none') {
		if(!update_option('dms_options' , $options )) {
		   _e("Something went worng with updating your settigns.",'dropdown-multisite-selector');
			die();
		}
	}

	if ( get_option( 'dms_multisite' ) != $multisite ) {
		if(!update_option('dms_multisite' , $multisite )) {
		   _e("Something went worng with updating your settigns.",'dropdown-multisite-selector');
			die();
		}
	}

	if ( get_option( 'dms_sorting'  ) != $sorting ) {
		if(!update_option('dms_sorting' , $sorting )) {
		   _e("Something went worng with updating your settigns.",'dropdown-multisite-selector');
			die();
		}
	}

	if ( get_option( 'dms_placeholder' ) != $placeholder ) {
		if(!update_option('dms_placeholder' , $placeholder )) {
		   _e("Something went worng with updating your settigns.",'dropdown-multisite-selector');
			die();
		}
	}

	echo true;
	die();
}

/**
 * Register the shortcode
 */
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
add_shortcode('dms','build_select');


/**
* Functions for displaying the select options on the front
*/
	
function noneOptions(){
	$out = "";
	$options = get_option( 'dms_options' );
	$sorting = get_option( 'dms_sorting' );

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

/**
 * Function for sanitize
 * @param  string/array $input
 * @return string/array
 */
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

// Creating the widget 
class dms_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		// Base ID
		'dms_widget', 

		// Widget name
		__('Dropdown Multisite Selector', 'dropdown-multisite-selector'), 

		// Widget description
		array( 'description' => __( 'Shows a select options with site/multisites.', 'dropdown-multisite-selector' ), ) 
		);
	}

	// This is where the action happens
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		echo do_shortcode('[dms]');
		echo $args['after_widget'];
		
	}

	public function form( $instance ) {
		
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}

		else {
			$title = __( 'New title', 'dropdown-multisite-selector' );}
		?>
			<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}

} 

// Register and load the widget
add_action( 'widgets_init', 'dms_load_widget' );
function dms_load_widget() {
	register_widget( 'dms_widget' );
}





// On install check if dms_mutisite option exists, if not - this is updating from 0.1 so create it with option 'none'
// On install check if dms_placeholder option exists, if not - this is updating from 0.33 so create it with option 'none'
register_activation_hook( __FILE__, 'myplugin_activate' );
function myplugin_activate() {
	if(!get_option('dms_multisite')){
    	update_option('dms_multisite', 'none');
	}
	if(!get_option('dms_sorting')){
    	update_option('dms_sorting', 'none');
	}
	if(!get_option('dms_placeholder')){
    	update_option('dms_placeholder', 'Select Option');
	}
}

add_action( 'plugins_loaded', 'myplugin_update_db_check' );
function myplugin_update_db_check() {
	if(!get_option('dms_multisite')){
    	update_option('dms_multisite', 'none');
	}
	if(!get_option('dms_sorting')){
    	update_option('dms_sorting', 'none');
	}
	if(!get_option('dms_placeholder')){
	   	update_option('dms_placeholder', 'Select Option');
	}
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
