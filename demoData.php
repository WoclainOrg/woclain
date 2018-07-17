<?php 
date_default_timezone_set('PRC');
set_time_limit(0);

define("MysqlHost","localhost");
define("MysqlUsername","root");
define("MysqlPassword","woclain");
define("MysqlDb","danma");
require("mysql.php");

$linDB = new Mysql();
print_r($linDB);exit;
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
$linDB->query("TRUNCATE TABLE danma.openball");

$time = strtotime("2000-01-01 00:00:00");
$now = time();
$continue = true;
$addtime = $time;
$everyDay = array();
$sqlPre = "INSERT INTO danma.openball (LottID, B1, B2, B3, B4, B5, Ball, `datetime`) VALUES ";
// echo $now."<br>";
while($continue){
	if($addtime > $now){
		$continue = false;
		break;
	}
	$addDate = date("Ymd",$addtime);
	if(!isset($everyDay[$addDate])){
		$everyDay[$addDate] = array();
		if(count($everyDay) == 2){
			$sqlInsert = "";
			foreach($everyDay as $_data){
				if(!empty($_data)){
					$sqlInsert = $sqlPre . join(",",$_data);
				}
			}
			if($sqlInsert != ""){
				$linDB->query($sqlInsert);
				$sqlInsert = "";
				
				$everyDay = array();
			}
			
		}
	}
	
	$lottID = date("YmdHis",$addtime);
	$ball = str_replace(",", "", genBall());
	$b1 = $ball[0];
	$b2 = $ball[1];
	$b3 = $ball[2];
	$b4 = $ball[3];
	$b5 = $ball[4];
	$everyDay[$addDate][] = "('$lottID', '$b1', '$b2', '$b3', '$b4', '$b5', '$ball', $addtime)";
	$addtime += 45;
}
// echo "<pre>";
// print_r($everyDay);exit;
?>