<?php
//Add custom nav menu meta box
function mynav_add_custom_box() {
    add_meta_box(
        'dms-mynav',
        'Dropdown multisite menu',
        'dms_add_custom_menu',
        'nav-menus',
        'side',
        'default');
}
add_action( 'admin_init', 'mynav_add_custom_box' );

//display nav menu meta box, copy of wp_nav_menu_item_link_meta_box()
function dms_add_custom_menu() {
	global $nav_menu_selected_id;

	$all_wmn_sites = wp_get_sites();
	$current_site_id = get_current_blog_id();

	?>

	<div id="posttype-wl-login" class="posttypediv">
	    <div id="tabs-panel-wishlist-login" class="tabs-panel tabs-panel-active">
	    	<ul id ="wishlist-login-checklist" class="categorychecklist form-no-clear">
	    		
				<?php 
				$i = 0;
				foreach ($all_wmn_sites as $site) {
					
					if ($current_site_id != $site["blog_id"]) {
						$the_site = get_blog_details($site["blog_id"]);
						$i++;
						?>

						<li>
							<label class="menu-item-title">
								<input type="checkbox" class="menu-item-checkbox" name="menu-item[-<?php echo $i; ?>][menu-item-object-id]" value="-<?php echo $i; ?>"> <?php echo $the_site->blogname; ?>
							</label>
							<input type="hidden" class="menu-item-type" name="menu-item[-<?php echo $i; ?>][menu-item-type]" value="custom">
							<input type="hidden" class="menu-item-title" name="menu-item[-<?php echo $i; ?>][menu-item-title]" value="<?php echo $the_site->blogname ?>">
							<input type="hidden" class="menu-item-url" name="menu-item[-<?php echo $i; ?>][menu-item-url]" value="<?php echo $the_site->siteurl; ?>">
						</li>
						
						<?php
					}
				}

				?>

	    		
	    	</ul>
	    </div>

	    <p class="button-controls">
	    	<span class="add-to-menu">
	    		<input type="submit" class="button-secondary submit-add-to-menu right" value="Add to Menu" name="add-post-type-menu-item" id="submit-posttype-wl-login">
	    		<span class="spinner"></span>
	    	</span>
	    </p>
	</div>
	<?php
}