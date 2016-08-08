<?php
/*
* Here comes the Styles options
**/
 ?>
<div class="block-tabs dms-tab2 hide-option">
	<form action="" id="all-styles">
		<p class="error-log-name-tab2"></p>
		<fieldset>
			<legend><?php _e('Choose style option:',''); ?></legend>

			<p>
				<input type="radio" value="style-options" id="style-opt" name="style-opt" class="dms-styles-interface dms-css-1" <?php if ($styles_option == 'ui'){ echo 'checked';} ?>>
				<label for="dms-css-1"><?php _e('User interface styles navigation.','dropdown-multisite-selector') ?></label>
				</p>

			<p>
				<input type="radio" value="custom-css" id="custom-style-opt" name="style-opt" class="dms-styles-interface dms-css-2" <?php if ($styles_option == 'custom'){ echo 'checked';} ?>>
				<label for="dms-css-2"><?php _e('Add your own custom css.','dropdown-multisite-selector') ?></label>
			</p>

			<p>
				<input type="radio" value="default-css" id="default-style-opt" name="style-opt" class="dms-styles-interface dms-css-3" <?php if ($styles_option == 'default' || $styles_option == 'none' || $styles_option == ''){ echo 'checked';} ?> >
				<label for="dms-css-3"><?php _e('Use Browser\'s Default Options','dropdown-multisite-selector') ?></label>
			</p>

		</fieldset>

		<fieldset class="style-opt-block" <?php if($styles_option != 'ui'){echo "style='display:none'";} ?> >
			<legend><?php _e('Style your select and option','dropdown-multisite-selector') ?></legend>

			<h3><?php _e('Label\'s styles','dropdown-multisite-selector') ?></h3>
			<p>
				<label for="label-font-size"><?php _e('Font size (in px)','dropdown-multisite-selector') ?></label>
				<input type="number" style="width:50px" min='1' max='99' name="label-font-size" id="label-font-size" value="<?php echo ( is_array($styles) && $styles['labelFontSize'] != "" ?  $styles['labelFontSize'] :  '16') ?>" >
			</p>
			<p>
				<label for="lable-font-color"><?php _e('Font Color','dropdown-multisite-selector') ?></label>
				<input type="text" value="<?php echo (  is_array($styles) && $styles['labelFontColor'] != "" ? $styles['labelFontColor'] :  '#000') ?>" class="color-field" id="lable-font-color" name="lable-font-color"/>
			</p>
			<hr>

			<h3><?php _e('Select\'s styles','dropdown-multisite-selector') ?></h3>
			<p>
				<label for="select-width" ><?php _e('Width (in px or "auto")') ?></label>
				<input type="text" id="select-width" style="width:50px" value="<?php echo (  is_array($styles) && $styles['selectWidth'] != "" ?  $styles['selectWidth'] : 'auto') ?>" name="select-width"></p>
			<p>
				<label for="border-size"><?php _e('Border size','dropdown-multisite-selector') ?> <span class="hint">(?)</span><span class="hidden border-radius-hint"><?php _e('Use 0 for none','dropdown-multisite-selector') ?></span></label>
				<input type="number"  style="width:50px" min='0' max='99' id="border-size"  value='<?php echo (  is_array($styles) && $styles['borderSize'] != "" ? $styles['borderSize'] : '1') ?>' name="border-size">
			</p>
			<p>
				<label class="border-radius" for="border-radius"><?php _e('Border radius','dropdown-multisite-selector') ?> <span class="hint">(?)</span><span class="hidden border-radius-hint">Border radius: Top-left; Top-right; Bottom-right; Bottom-left</span></label>
				<input type="number"  style="width:50px" min='0' max='99' id="border-radius-top" value="<?php echo (  is_array($styles) && $styles['borderRadiusTop'] != "" ?  $styles['borderRadiusTop'] :  '0') ?>" name="border-radius-top-r">
				<input type="number"  style="width:50px" min='0' max='99' id="border-radius-right" value="<?php echo(  is_array($styles) && $styles['borderRadiusRight'] != "" ? $styles['borderRadiusRight'] :  '0') ?>" name="border-radius-bottom-r">
				<input type="number"  style="width:50px" min='0' max='99' id="border-radius-bottom" value="<?php echo (  is_array($styles) && $styles['borderRadiusBottom'] != "" ? $styles['borderRadiusBottom'] : '0') ?>" name="border-radius-bottom-l">
				<input type="number"  style="width:50px" min='0' max='99' id="border-radius-left" value="<?php echo (  is_array($styles) && $styles['borderRadiusLeft'] != "" ? $styles['borderRadiusLeft'] :  '0') ?>" name="border-radius-top-l">

			</p>
			<p>

				<label for=""><?php _e('Border style','dropdown-multisite-selector') ?></label>
				<input type="radio" id="border-style1"  name="border-style" <?php echo ( is_array($styles) && array_key_exists('borderStyle', $styles) &&  $styles['borderStyle'] == "dashed" ? "checked" : '') ?>  value="dashed"><label style="width:60px" for="border-style1">Dashed</label>
				<input type="radio" id="border-style2"  name="border-style" <?php echo (  is_array($styles) && array_key_exists('borderStyle', $styles) && $styles['borderStyle'] == "dotted" ? "checked" : '') ?> value="dotted"><label style="width:60px" for="border-style2">Dotted</label>
				<input type="radio" id="border-style3"  name="border-style" <?php echo (  (is_array($styles) && array_key_exists('borderStyle', $styles) && $styles['borderStyle'] == "solid") || !is_array($styles) || ( is_array($styles) && !array_key_exists('borderStyle', $styles)) ? "checked" : '') ?>  value="solid"><label style="width:60px" for="border-style3">Solid</label>
			</p>
			<p>
				<label for="border-color"><?php _e('Border Color','dropdown-multisite-selector') ?></label>
				<input type="text" value="#ccc" class="color-field" id="border-color" value="<?php echo (  is_array($styles) && $styles['borderColor'] != "" ? $styles['borderColor'] : '#ccc') ?>" name="border-color"/>
			</p>
			<p>
				<label for="selec-font-size"><?php _e('Font size (in px)','dropdown-multisite-selector') ?></label>
				<input type="number" style="width:50px" min='1' max='99' name="select-font-size" id="select-font-size" value="<?php echo (  is_array($styles) && $styles['selectFontSize'] != "" ? $styles['selectFontSize'] : '16') ?>" >
			</p>
			<p>
				<label for="select-font-color"><?php _e('Select Font Color','dropdown-multisite-selector') ?></label>
				<input type="text" value="<?php echo ( is_array($styles) &&  $styles['selectFontColor'] != "" ? $styles['selectFontColor'] : '#000') ?>" class="color-field" id="select-font-color" name="select-font-color"/>
			</p>
			<p>
				<label for="select-background-color"><?php _e('Select Background Color','dropdown-multisite-selector') ?></label>
				<input type="text" value="<?php echo (  is_array($styles) && $styles['selectBackgroundColor'] != "" ? $styles['selectBackgroundColor'] : '#fff') ?>" class="color-field" id="select-background-color" name="select-background-color"/>
			</p>

			<hr>

		</fieldset>

		<fieldset class="custom-css-block" <?php if($styles_option != 'custom'){echo "style='display:none'";} ?>>
			<legend><?php _e('Custom Styles css','dropdown-multisite-selector') ?></legend>
			<p> <?php _e('You can use the following two classe: <em>div.dms-container</em> which conatins the select input with class <em>select.dms-select</em>','dropdown-multisite-selector') ?></p>
			<label for="custom-css"></label>
			<textarea rows="10" cols="40" id="custom-css" name="custom-css"> <?php if($styles_option =='custom' && !is_array($styles)){ echo $styles ;} ?>
			</textarea>
		</fieldset>

		<input type="submit" value="<?php _e('Save Styles','dropdown-multisite-selector');?>" name="submit-styles" id="submit-styles">

	</form>
</div>
