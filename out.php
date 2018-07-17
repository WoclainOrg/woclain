<?php 



function out($template){
	$content = file_get_contents($template);
	foreach($GLOBALS as $varKey=>$varValue){
		$reg = '/\{\$'.$varKey.'\}/i';
		$reg1 = '/\{\$.+\}/i';
		if(preg_match($reg, $content))
			$content = preg_replace($reg, $varValue, $content);
	}
	$content = preg_replace($reg1, "", $content);
	return $content;
}

?>