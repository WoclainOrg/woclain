<?php 
date_default_timezone_set('PRC');
set_time_limit(0);

define("MysqlHost","localhost");
define("MysqlUsername","root");
define("MysqlPassword","woclain");
define("MysqlDb","danma");
require("mysql.php");
$linkdb = new Mysql();

$project_name = "danma";


if(isset($_GET["pre"]))
	echo "<pre>";

function winlossCalculate($jm,$bs=array(),$bsfw = 50,$dw = 1,$ptjj = 19){
	$result = array();
	$bsi = 1;
	$oneballmoney = 2 * $dw;
	$lin = 0;
	$j = 0;
	if(empty($bs)){
		
		for($i = 0;  $i < $bsfw; $i++){
			$in = $jm * $bsi * $oneballmoney;
			$lin += $in;
			$out = $ptjj * $bsi;
			
			$result[$j]['bs'] = $bsi;
			$result[$j]['in'] = $in;
			$result[$j]['out'] = $out;
			$result[$j]['win'] = $out - $lin;
			$result[$j]['loss'] = -$lin;
			$bsi++;
			$j++;
		}
	}else{
		foreach($bs as $_bs){
			$in = $jm * $_bs* $oneballmoney;
			$lin += $in;
			$out = $ptjj * $_bs;
			
			$result[$j]['bs'] = $_bs;
			$result[$j]['in'] = $in;
			$result[$j]['out'] = $out;
			$result[$j]['win'] = $out - $lin;
			$result[$j]['loss'] = -$lin;
			$j++;
		}
	}
	
	return $result;
}
function demoGenBalls($number = 1,$newInsert = false){
	global $linkdb;
	if($newInsert == true){
	
		$genBalls = genPointBalls($number);
		$insertSql = "insert into OPEN_BALL_DATA (ball,b1,b2,b3,b4,b5,isDemo) values ";
		$insertItem = array();
		foreach($genBalls as $_gb){
			$tempSql = array();
			$balls = explode(",",$_gb);
			$tempSql[] = "'$_gb'";
			foreach($balls as $_b){
				$tempSql[] = $_b;
				
			}
			$tempSql[] = true;
			$insertItem[] = "(".join(",",$tempSql).")";
		}
		$insertSql .= join(",",$insertItem);
		$linkdb ->query($insertSql);
		
	}
	$insertid = $linkdb ->getInsertId();
	
	if($number > 1){
		if($insertid == 0){
			$data  = $linkdb -> getAll("select id,ball,b1,b2,b3,b4,b5,isDemo from OPEN_BALL_DATA order by id desc limit $number");
			krsort($data);
			$data = array_values($data);
		}else{
			$data  = $linkdb -> getAll("select id,ball,b1,b2,b3,b4,b5,isDemo from OPEN_BALL_DATA order by id asc limit ".($insertid-1).",$number");
		}
		return $data;
	}
}

function genBetBall($ms=4,$mustHave=array(),$except=array()){
	$randomGenCount = 0;
	$genBallBaseArr = array(0,1,2,3,4,5,6,7,8,9);
	$genBallBaseTempArr = array();
	if(count($mustHave) >= $ms){
		return $mustHave;
	}
	
	if(!empty($mustHave)){
		$randomGenCount = $ms - count($mustHave); 
	}else{
		if((10 - count($except)) < $ms){
			return null;
		}
	}
	if(!empty($except)){
		foreach($genBallBaseArr as $gb){
			if(!in_array($gb,$except)){
				$genBallBaseTempArr[] = $gb;
			}
		}
	}else{
		$genBallBaseTempArr = $genBallBaseArr;
	}
	
	if(!empty($mustHave)){
		$hasMustHaveGenBallBaseTempArr = array();
		foreach($genBallBaseTempArr as $gb){
			if(!in_array($gb,$mustHave)){
				
				$hasMustHaveGenBallBaseTempArr[] = $gb;
			}
		}
		
		$resultTemp = array_rand($hasMustHaveGenBallBaseTempArr,$randomGenCount);
		$result = array();
		foreach($resultTemp as $k){
			$result[] = $hasMustHaveGenBallBaseTempArr[$k];
		}
		return array_merge($result,$mustHave);
	}
	
	$resultTemp = array_rand($genBallBaseTempArr,$ms);
	$result = array();
	foreach($resultTemp as $k){
		$result[] = $genBallBaseTempArr[$k];
	}
	return $result;
}

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
function getAppearCount($data){
	$result = array();
	foreach($data as $_balls){
		foreach(explode(",",$_balls) as $k=>$v){
			$bn = "B".($k+1);
			$result[$bn][$v] = isset($result[$bn][$v]) ? $result[$bn][$v] +1 : 1;
		}
	}
	foreach($result as $k=>$v){
		arsort($v);
		$result[$k][] = $v;
	}
	return $result;
}
function getRandomBall($jm=4,$qishu = 1){
	$result = array();
	$randomBalls = genPointBalls($qishu);
	
	$appearCountData = getAppearCount($randomBalls);
	if($jm != "no"){
		$result = $appearCountData;
	}else{
		foreach($appearCountData as $k=>$v){
			$i = 0;
			foreach($v as $_k =>$_v){
				if($i < $jm){
					$result[$k][] = $_k;
				}
				$i++;
			}
		}
	}
	return $result;
}

function scanFiles($path) {
	global $result;
	$files = scandir($path);
	foreach ($files as $file) {
		if ($file != '.' && $file != '..') {
			if (is_dir($path . '/' . $file)) {
				scanFile($path . '/' . $file);
			} else {
				$result[] = basename($file);
			}
		}
	}
	return $result;
}
function get_file_last_line($rs){
	$fp = fopen($rs, 'r');
	fseek($fp,-1,SEEK_END);
	
	$s = '';
	while(($c = fgetc($fp)) !== false)
	{
		if($c == "\n" && $s) break;
		$s = $c . $s;
		fseek($fp, -2, SEEK_CUR);
	}
	fclose($fp);
	return $s;
}

function deldir($dir){
	//删除目录下的文件：
	$dh=opendir($dir);
	
	while ($file=readdir($dh))
	{
		if($file!="." && $file!="..")
		{
			$fullpath=$dir."/".$file;
			
			if(!is_dir($fullpath))
			{
				unlink($fullpath);
			}
			else
			{
				deldir($fullpath);
			}
		}
	}
	
	closedir($dh);
}
?>