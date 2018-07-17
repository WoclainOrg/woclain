<?php 
$_data_for_attr_count_bs = 10;
$_data_for_attr = demoGenBalls($tvc_count * $_data_for_attr_count_bs,true); 


$_dfa_split_data = split_lottery_data($_data_for_attr);
$q5_data = $_dfa_split_data[5];
$q10_data = $_dfa_split_data[10];


$allCalculateData = getAllCalculateData($q5_data);

$attrObj = array();
foreach($allCalculateData as $key=>$val){
	$attrObj[] = new Attr($val);
	exit;
	
}



function getAllCalculateData($q5_data,$q=5){
	$calculate_data = array();
	$i = 0;
	foreach($q5_data as $index => $spDatas){
		if($index >= $q){
			$calculate_data[$i]["cd"] = getCalculateData($q5_data,$index - $q,$index-1);
			$calculate_data[$i]["vd"] = $spDatas;
			$i++;
		}
	}
	return $calculate_data;
}
function getCalculateData($data,$from,$to){
	$result = array();
	foreach($data as $index=>$d){
		if($index >= $from && $index <= $to){
			$result[] = $d;
		}
	}
	return $result;
}


?>