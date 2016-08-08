<?php
/*
* Brings all the tweaks and hacks you can do with the plugin... the options page
**/
?>
<div class="block-tabs dms-tab1">

	<form action="" id="dms-all-inputs">

		<fieldset>
			<legend><?php _e('Dropdown settings','dropdown-multisite-selector');?></legend>

			<p class="error-log-name"></p>
			<div class="name-opt" <?php if($settings['showHideTag'] == 'false') {echo 'style="display:none"';} ?>>
				<label for="select_name"><?php _e('The select tag label','dropdown-multisite-selector');?></label></br>
				<input type="text" id="select_name" value="<?php echo $name; ?>" name="select_name"></br>
			</div>
			<div class="select-opt" <?php if($settings['currentSite'] == 'true') {echo 'style="display:none"';} ?>>
				<hr>
				<label for="select_placeholder"><?php _e('The first option to show in the select element (for instance "Select site", "Select Option")','dropdown-multisite-selector');?></label></br>
				<input type="text" id="select_placeholder" value="<?php echo $placeholder; ?>" name="select_placeholder"></br>
			</div>
			<hr>
			<input type="checkbox" <?php if($settings['showHideTag'] == 'true'){echo "checked";} ?> id="label-opt" name="label-opt">
			<label for="label-opt"><?php _e('Show the select tag label','dropdown-multisite-selector') ?></label>

			<hr>
			<input type="checkbox" <?php if($settings['targetBlank'] == 'true'){echo "checked";} ?> id="new-window-opt" name="new-window-opt">
			<label for="new-window-opt"><?php _e('On change open the links in new tab.','dropdown-multisite-selector') ?></label>

			<hr>
			<input type="checkbox" <?php if($settings['alphabeticOrder'] == 'true'){echo "checked";} ?> id="order-opt" name="order-opt">
			<label for="order-opt"><?php _e('List all the links in alphabetical order. ','dropdown-multisite-selector') ?></label>

			<div class="first-tag-wrap <?php if($multisite=='none'){echo 'hidden';} ?>" >
				<hr>
				<input type="checkbox" <?php if($settings['currentSite'] == 'true'){echo "checked";} ?> id="first-tag" name="first-tag">
				<label for="first-tag"><?php _e('First option from the select menu is the current/active site (from the multisite\'s list). ','dropdown-multisite-selector') ?></label>
			</div>

		</fieldset>

		<fieldset>
			<legend><?php _e('Wordpress Multisite Network(WMN) Options','dropdown-multisite-selector'); ?></legend>
			<input id="radio-none" type="radio" name="multisite" <?php if ($multisite=='none' || ! $multisite) {echo 'checked="checked"';} ?> value="none"><?php _e('Disabled (use your own links)','dropdown-multisite-selector'); ?><br>
			<input id="radio-all" type="radio" name="multisite" <?php if ($multisite=='all') {echo 'checked="checked"';} ?> value="all"><?php _e('Show all sites from the WMN.','dropdown-multisite-selector'); ?><br>
			<input id="radio-users" type="radio" name="multisite" <?php if ($multisite=='usersonly') {echo 'checked="checked"';} ?> value="usersonly"><?php _e('Show only the sites where the user is registered in the WMN.','dropdown-multisite-selector'); ?><br>
		</fieldset>

		<fieldset class="middle-box">
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
									<input type="button" class="del_row" value=" X ">
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
						</tr>

					<?php }?>

				</tbody>
			</table>

			<input type="button" value="<?php _e('Add field','dropdown-multisite-selector');?>" name="add-field" id="dms-add">
			<!-- <input type="button" class="clear-all" value="<?php _e('Clear all fields','dropdown-multisite-selector');?>" name="clear-all-fields" id="dms-clear-all"> -->
		</fieldset>
		<input type="submit" value="<?php _e('Save','dropdown-multisite-selector');?>" name="submit" id="dms-submit">
		<!-- <input type="button" value="<?php _e('Reset all Settings & Styles','dropdown-multisite-selector');?>" name="reset" id="dms-reset"> -->
	</form>
</div>
