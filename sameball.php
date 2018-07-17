<?php 
require("basefun.php");
require("out.php");
$result = array();
for($i = 0; $i < 1; $i++){
	$insertDatas = demoGenBalls(1440);
	$result[] = validate($insertDatas,"b2");
	
}
print_r(array_sum($result));exit;
?>