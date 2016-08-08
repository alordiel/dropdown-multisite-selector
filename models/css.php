<?php

if (get_option('dms_style_option') == 'ui') { 
	
	//if width is not auto but number
	if ($data['selectWidth'] != "auto") {
		$data['selectWidth']  = $data['selectWidth'] . "px";
	}

	$output = "
	.dms-container label {
		font-size: ".$data['labelFontSize'] . "px;
		color: " . $data['labelFontColor'] . ";
	}
	.dms-container select {
		width: " . $data['selectWidth'] . ";
		border-width: " . $data['borderSize'] . "px;
		border-radius: " . $data['borderRadiusTop'] . "px " . $data['borderRadiusRight'] . "px " . $data['borderRadiusBottom'] . "px " . $data['borderRadiusLeft'] . "px;
		border-style: " . $data['borderStyle'] . ";
		border-color: " . $data['borderColor'] . ";
		font-size: " . $data['selectFontSize'] . "px;
		color: " . $data['selectFontColor'] . ";
		background-color : ". $data['selectBackgroundColor'] .";
	}";
	echo $output;
} else {
	$output = $data;
	echo $output;
}
