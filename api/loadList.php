<?php 
require("../basefun.php");
$index_file = "../index/5mth.txt";
$record_dir = "../record";
$files = scanFiles($record_dir);

$result = array();
foreach($files as $index => $fn){
	$result[$index]['fn'] = $fn;
	$result[$index]['fn_url'] = "http://".$_SERVER['HTTP_HOST']."/$project_name/record/".$fn;
}
echo json_encode($result);exit;
?>