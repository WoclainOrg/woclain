<?php 



$balls = genPointBalls(1440);


$rowBall = array();
$columBall = array();
foreach($balls as $index=>$ball){
	$ballArr = explode(",",$ball);
	$rowBall[] = $ballArr;
	foreach($ballArr as $btype => $_b){
		$columBall[$btype][] = $_b;
	}
}



$lianchu = array();

$winloss = array(
	"win" => 0,
	"loss"=>0
);
$winloss5ma = array(
	"win" => 0,	
	"loss"=>0
);
$start = false;
$nowActive = false;
foreach($columBall as $_btype=>$_balls){
	
	for($i = 0; $i < count($_balls); $i++){
		if($i > 0){
			$beforeBall = $_balls[$i-1];
			$b = $_balls[$i];
			$genbBall = get4mGenBall();
			$bet4balls  = $genbBall["B1"];
			
			if($i > 1){
				if($b == $beforeBall && $nowActive == false){
					$start = true;
					$round = 1;
				}else{
					if($start == true){
						
						if(in_array($b,$bet4balls)){
							if($round == 1){
								$winloss5ma["win"] += 11;
							}elseif($round == 2){
								$winloss5ma["win"] += 14;
							}elseif($round == 3){
								$winloss5ma["win"] += 24;
							}
							
							$round = 1;
							$start = false;
							$nowActive = false;
						}else{
							if($round == 1){
								$winloss5ma["loss"] += 8;
							}elseif($round == 2){
								$winloss5ma["loss"] += 16;
								
							}elseif($round == 3){
								$winloss5ma["loss"] += 24;
							}
							$nowActive = true;
							$round++;
							if($round == 4){
								$start = false;
								$nowActive = false;
								$round = 1;
							}
							
						}
					}
				}
				
				
				
// 				if(1 == $b){
// 					$winloss["win"] += 11;
// 				}else{
// 					$winloss["loss"] += 8;
// 				}
			}
		}
		
	}
	
	
	
	for($i = 0; $i < count($_balls); $i++){
		$_b = $_balls[$i];
		
		if($i == 0){
			$lianchu[$_btype][$i] = $_b;
		}else{
			$before = $_balls[$i-1];
			$now = $_b;
			if($before == $now){
				$lcStr = "";
				if(preg_match("/\(\d+\)/",$lianchu[$_btype][$i-1])){
					preg_match("/\d+/",$lianchu[$_btype][$i-1],$match);
					$lcStr = "(".($match[0]+1).")";
				}else{
					$lcStr = "(2)";
				}
				$lianchu[$_btype][$i] = $lcStr;
			}else{
				$lianchu[$_btype][$i] = $_b;
			}
		}
	}

	
}
function getCountValue($arr){
	$result = array();
	foreach($arr as $v){
		$result[$v] = (isset($result[$v]) ? $result[$v]+1 : 1);
	}
	arsort($result);
	return $result;
}
// echo "<pre>";
// print_r($winloss['win'] - $winloss['loss']);exit;
// print_r($lianchu);
// print_r(json_encode($columBall));
preg_match_all("/\(\d+\)/", json_encode($lianchu),$match);
$lianchuArr = getCountValue($match[0]);
$totalMoney = 0;
foreach($lianchuArr as $key=>$val){
	preg_match_all("/\d+/", json_encode($key),$match);
	$lc = $match[0][0];
	if($lc == 2 || $lc == 3 || $lc == 4){
		$totalMoney += $val * 1;
	}elseif($lc >= 5 && $lc < 10){
		$totalMoney -=  2 * 9 * 140 * $val;
	}
	
}
function getFourBall(){
	$result = array();
	$key = rand(0,9);
	for($i = 0; $i < 10; $i++){
		if($i != $exceptBall){
			$result[] = $i;
		}
	}
	$key = rand(0,8);
	return $result[$key];
}

function getOneGenBall($exceptBall){
	$result = array();
	for($i = 0; $i < 10; $i++){
		if($i != $exceptBall){
			$result[] = $i;
		}
	}
	$key = rand(0,8);
	return $result[$key];
}
function getGenBall($exceptBall){
	$result = array();
	for($i = 0; $i < 10; $i++){
		if($i != $exceptBall){
			$result[] = $i;
		}
	}
	return $result;
}
print_r($lianchuArr);
print_r($winloss5ma);

exit;
?>