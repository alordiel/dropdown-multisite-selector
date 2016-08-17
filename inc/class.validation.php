<?php

/**
 * Function for sanitize
 * @param  string/array $input
 * @return string/array
 */

class DMS_VALIDATION {

	public function clear_input($input) {
		
		$search = array(
			'@<script[^>]*?>.*?</script>@si',
			'@<[\/\!]*?[^<>]*?>@si',
			'@<style[^>]*?>.*?</style>@siU',
			'@<![\s\S]*?--[ \t\n\r]*>@'
		);
		
		$output = preg_replace($search, '', $input);
		$output = self :: sanitize($output);

		return $output;
	}

	public function sanitize($input) {

		if (is_array($input)) {
			foreach($input as $var=>$val) {
				$output[$var] = self :: sanitize($val);
			}
		}
		else {
			if (get_magic_quotes_gpc()) {
				$input = stripslashes($input);
			}
		}
		return $input;
	}
}