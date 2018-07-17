<?php
date_default_timezone_set('PRC');
set_time_limit(0);
$sleeptime = 45;
// randomContinueArray(0,9);
// createRandomKeys(0,9);
// $balls = genBall1();
// print_r($balls);exit;
function genBall(){
	
	$ball = array();
	for($i = 1; $i <= 5; $i++){
		$temp = array();
		for($j = 0; $j < 4; $j++){
			$temp[] = rand(1,80);
		}
		$sum = "".array_sum($temp);
		
		$ball["B".$i] = substr($sum,-1,1);
	}
	return join(",",$ball);
}

function genPointBalls($point = 1){
	$balls = array();
	for($i = 0; $i < $point; $i++){
		$balls[] = genBall();
	}
	return $balls;
}

function genBall1(){
	$ball = array();
	for($i = 1; $i <= 5; $i++){
		
		$ball["B".$i] = rand(0,9);
	}
	return join(",",$ball);
}

function az($num){
	if($num < 10){
		return "000".$num;
	}elseif($num >= 10 && $num < 100){
		return "00".$num;
	}elseif($num >= 100 && $num < 1000){
		return "0".$num;
	}else{
		return ''.$num;
	}
}



function createRandomKeys($start,$end,$count=10){
	$rangeArray = range($start,$end);
	$result = array();
	for($i = 0; $i < $count; $i++){
		$randNum = rand(0,count($rangeArray));
		$result[] = $randNum;
		array_pop($rangeArray);
	}
	return $result;
}
function randomContinueArray($start,$end,$count = 10){
	$rangeArray = range($start,$end);
	$result = array();
	for($i = 0; $i < $count; $i++){
		$randNum = array_rand($rangeArray,1);
		$num = $rangeArray[$randNum];
		$result[] = $num;
		$tempArray = array();
		foreach($rangeArray as $val){
			if($val != $num){
				$tempArray[] = $val;
			}
		}
		$rangeArray = $tempArray;
	}
	return $result;
}
$i = 1;

$date = date("Ymd");
$j = 1;
$checkStart = true;
while(true){
	
	if($checkStart){
		$s = date('s');
		if($s == '59'){
			$checkStart = false;
		}
		sleep(1);
	}else{
		$qs = az($i);
		$lottID = $date.$qs;
		$ball = genBall();
		$ball = $lottID.','.$ball.','.date('Y-m-d H:i:s').PHP_EOL;
		file_put_contents("data/".$date.'.txt',$ball,FILE_APPEND);
		if($i == 1920){
			$i = 0;
			$date = date("Ymd",time()+(86400*$j));
			$j++;
		}
		$i++;
		sleep($sleeptime);
	}
	
}
?>