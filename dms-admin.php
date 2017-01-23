<?php

$name="";
$options;
$multisite;
$placeholder = __('Select option','dropdown-multisite-selector');
$sorting = 'none';


if(get_option( 'dms_select_name') ){
	$name = get_option( 'dms_select_name');
	if($name =='false'){
		$name = "";
	}
}

if (get_option( 'dms_options' )) {
	$options = get_option( 'dms_options' );
}

if (get_option( 'dms_multisite')) {
	$multisite = get_option( 'dms_multisite' );
}

if (get_option('dms_placeholder')) {
	$placeholder = get_option( 'dms_placeholder' );
}

if (get_option('dms_sorting')) {
	$sorting = get_option( 'dms_sorting' );
}
else
?>

<div class="dms-admin">
	
	<h1>Dropdown Multisite Selector</h1>
	
	

	<div class="dms-formular">
		<h2><?php _e('Options','dropdown-multisite-selector');?></h2>
		<p class="succes_log"></p>
		<p class="overall-error"></p>
		<form action="" id="dms-all-inputs">
		
			<fieldset>
				<legend><?php _e('Dropdown settings','dropdown-multisite-selector');?></legend>
				<p class="error-log-name"></p>
				<label for="select_name"><?php _e('The select tag label','dropdown-multisite-selector');?></label></br>
				<input type="text" id="select_name" value="<?php echo $name; ?>" name="select_name"></br>
				<label for="select_placeholder"><?php _e('The first option to show in the select element (for instance "Select site", "Select Option")','dropdown-multisite-selector');?></label></br>
				<input type="text" id="select_placeholder" value="<?php echo $placeholder; ?>" name="select_placeholder"></br>
			</fieldset>


			<fieldset>
				
				<legend><?php _e('Wordpress Multisite Network(WMN) Options','dropdown-multisite-selector'); ?></legend>

				<input id="radio-none" type="radio" name="multisite" <?php if ($multisite=='none' || ! $multisite) {echo 'checked="checked"';} ?> value="none"><?php _e('Disabled','dropdown-multisite-selector'); ?><br>
				<input id="radio-all" type="radio" name="multisite" <?php if ($multisite=='all') {echo 'checked="checked"';} ?> value="all"><?php _e('Show all sites in the WMN.','dropdown-multisite-selector'); ?><br>
				<input id="radio-users" type="radio" name="multisite" <?php if ($multisite=='usersonly') {echo 'checked="checked"';} ?> value="usersonly"><?php _e('Show only the sites where the user is registered in the WMN.(works only for loged in users)','dropdown-multisite-selector'); ?><br>

			</fieldset>

			<fieldset class="sorting-options-block" <?php if ($multisite !='none' ) {echo 'style="display:none"';} ?>>
				
				<legend><?php _e('Sorting options','dropdown-multisite-selector'); ?></legend>

				<input id="sorting-none" type="radio" name="sorting-option" <?php if ($sorting=='none' || ! $sorting) {echo 'checked="checked"';} ?> value="none"><?php _e('Default','dropdown-multisite-selector'); ?><br>
				<input id="sorting-alphabetic" type="radio" name="sorting-option" <?php if ($sorting=='alphabetic') {echo 'checked="checked"';} ?> value="alphabetic"><?php _e('Alphabetic sorting','dropdown-multisite-selector'); ?><br>
				<input id="sorting-last-be-first" type="radio" name="sorting-option" <?php if ($sorting=='lastfirst') {echo 'checked="checked"';} ?> value="lastfirst"><?php _e('Reverse the order (last entries will be the first options in the dropdown).','dropdown-multisite-selector'); ?><br>

			</fieldset>
			
			<fieldset class="middle-box" <?php if ($multisite !='none' ) {echo 'style="display:none"';} ?>>
				<legend><?php _e('Dropdown fields','dropdown-multisite-selector');?></legend>
				<div <?php if($multisite!='none' && $multisite){echo 'class="mask-middle"';} ?> ></div>
				<p class="error-log-fields"></p>
				<table id="dms-table">
					<thead>
						<tr>
							<th><?php _e('Option name','dropdown-multisite-selector');?></th>
							<th><?php _e('URL to redirect','dropdown-multisite-selector');?></th>
						</tr>
					<thead>
					<tbody>

						<?php 
						if ( is_array($options) ) {
							$k = 1;

							foreach ( $options as $key => $value ) {?>

								<tr class="new-row">
									<td>
										<input type="text" value="<?php echo $key; ?>" name="field_name">
									</td>
									<td>
										<input type="text" value="<?php echo $value; ?>"  class="urls" name="field_url">
									</td>
									<td>
										<input type="button" class="del_row" title="Delete this row" value="x">
									</td>
									<td>
										<input type="button" class="add_row" title="Add new row" value="+">
									</td>
								</tr>
							<?php
								$k++;
							}	
						}
						else{ ?>
							<tr class="new-row">
								<td>
									<input type="text" name="field_name">
								</td>
								<td>
									<input type="text" name="field_url">
								</td>
								<td>
									<input type="button" class="del_row" value=" X ">
								</td>
								<td>
									<input type="button" class="add_row" title="Add new row" value="+">
								</td>
							</tr>

						<?php }?>

					</tbody>
				</table>

			</fieldset>
			

				<input type="submit" value="<?php _e('Save','dropdown-multisite-selector');?>" name="submit" id="dms-submit">
				
				
		
		</form>
		 
	</div>
	
	<div class="dms-description">
		
		<h2><?php _e('Description','dropdown-multisite-selector');?></h2>
		
		<p> <?php _e('This plugin allows you to add a simple select filed to your page giving the option to the user to switch between different urls/pages/sites. In the fields below just fill the requiered information. "Option Name" is the name that will be seen by the user, and "URL to redirect" is the place you would like to redirect your visitor when selecting the relevant option.');?></p>
		<p> <?php _e('The Wordpress Multisite Network(WMN) Options gives you the option for creating an automatic list of options. <b>Show all sites in the WMN</b> is for a list with all the sites from the WMN, while the <b>Show only the sites where the user is registered in the WMN</b> is only for those sites where the logged in user is already registered - it is a nice and easy way to navigate throug your multisite.','dropdown-multisite-selector'); ?></p>
		<p> <?php _e('To add the select option on a page you can use this shortcode <code>[dms]</code>. It will use the options you have set from settings page.</br>If you would like to include it in a php file - use</br> <code>&lt;?php echo do_shortcode(\'[dms]\'); ?&gt;</code>','dropdown-multisite-selector');?></p>
		<p> <?php _e('To add your own values in the shortcode use this one: </br><code>[dms_manual name="" placeholder="" target="" options=""]</code>','dropdown-multisite-selector');?> </br> 
			<?php _e('Where:','dropdown-multisite-selector') ?>
			<ol>
				<li><?php _e('name - the label of the select option (leave empty for no label)','dropdown-multisite-selector') ?></li>
				<li><?php _e('placeholder - the first option that is showen in the select menu (like: "--  Select --")','dropdown-multisite-selector') ?></li>
				<li><?php _e('target - could be "default" or "blank". This is the target of the link - "blank" is to be open in new window','dropdown-multisite-selector') ?></li>
				<li><?php _e('options - name-link pairs, should be placed as : "name1|url1, name2|url2, name3|url3"','dropdown-multisite-selector') ?></li>
			</ol>
		</p>
		<p><?php _e('Please note that if you use a multisite and your site url is different from your wordpress url there the main site url will as the wordpress site url for fixing this issue check the <a href="http://codex.wordpress.org/Changing_The_Site_URL">wordpress codex</a>.','dropdown-multisite-selector') ?></p>
		<p><?php _e('For any support or bug reporting please use this <a href="http://wordpress.org/support/plugin/dropdown-multisite-selector">link</a>') ?></p>
	
	</div>

</div>
