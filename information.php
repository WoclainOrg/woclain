<?php 
require("basefun.php");
$betBallPreName = "45sCP";


$result = array();
for($i = 0; $i < 1; $i++){
	$insertDatas = demoGenBalls(1440);
	$result[] = validate($insertDatas,"b2");
	 
}
echo "<pre>";
print_r(array_sum($result));exit;
function validate($insertDatas,$bn = "b1"){
	$isTest = false;
	$round = 0;
	$winloss = 0;
	$totalRound = 1;
	$totalPercent = 0;
	$wlbs = winlossCalculate(4,array(1,2,3,5,9));
	
	
	$winpercent = 0;
	if($isTest){
		echo "<pre>";
		print_r($wlbs);
	}
	foreach($insertDatas as $k=> $data){
		
		if($winloss > 100 || $winloss < -66)
			break;
			$b1 = $data[$bn];
			if($k > 3){
				$bb1 = $insertDatas[$k-1][$bn];
				$bb2 = $insertDatas[$k-2][$bn];
				$bb3 = $insertDatas[$k-3][$bn];
				$bb4 = $insertDatas[$k-4][$bn];
				$haveorexcept = array($bb1,$bb2,$bb3,$bb4);
				$gb = genBetBall(4,array(),$haveorexcept);
			}else{
				$gb = genBetBall(4,array(),array());
			}
			
			if($isTest){
				
				echo "Round: ($totalRound) , SRound: (".($round+1).") . <br>";
				echo $b1."<br>";
				print_r($gb);
			}
			
			if(!isset($wlbs[$round])){
				$round = 0;
				$totalRound ++;
			}
			
			if(in_array($b1,$gb)){
				
				if($winloss > 0){
					$tp = $totalPercent;
					$totalPercent = $winpercent / $totalRound * 100;
					
				}
				$winloss += ($wlbs[$round]["out"]-$wlbs[$round]["in"]);
				$round = 0;
				$winpercent += 1;
				
				$totalRound ++;
				
			}else{
				$winloss -= $wlbs[$round]["in"];
				$round ++;
			}
			if($isTest){
				echo "Money: ($winloss) , Percent: ($totalPercent)<br>";
				echo "-----------------------------------------------------------------<br>";
			}
			
	}
	return $winloss;
}



?>