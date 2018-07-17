<?php 
require("../basefun.php");

$index_file = "../index/5mth.txt";
$record_dir = "../record";
file_put_contents($index_file,"");
deldir($record_dir);

?>