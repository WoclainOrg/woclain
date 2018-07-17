<?php 
require("basefun.php");
require("out.php");
require("config/5mth_config.php");
require("method/5mth.php");
require("class/5mth/Attr.Class.php");
require("method/5mthAttr.php");
$title = "5M Same Ball";


$index_file = "index/5mth.txt";
$index_content = file_get_contents($index_file);
if($index_content == ""){
	$index_content = 1;
}else{
	$last_line = get_file_last_line($index_file);
	$index_content = explode("_",$last_line)[0]+1;
}

/************************************* Program *************************************/

if($debug){
	$linkdb->query("TRUNCATE TABLE danma.OPEN_BALL_DATA;");
}

$ld_data = demoGenBalls($tvc_count,true); // lott data from database;
print_r($ld_data);exit;



//split lott data start ----->>>
$sp_ld = split_lottery_data($ld_data);
//split lott data end-----<<<<
// $appear_ball_count = convert_data_to_count($sp_ld[30][0]);
// print_r($appear_ball_count);exit;
//left content template start --->>>
$tm_left_content = show_base_lottery_data($sp_ld[0],"template/leftContent.html");
//left content template end --->>>

//center content data start ----->>>
$tm_center_content = show_my_center_content($sp_ld["FD"],"template/centerContent.html");
//center content data end ----->>>


//center content licha data start ----->>>
$tm_center_content_lc = show_my_center_lc_content($sp_ld["FD"],"template/centerContent.html");
//center content licha data end ----->>>

//center content licha lv data start ----->>>
$tm_center_content_lcl = show_my_center_lc_content($sp_ld["FD"],"template/centerContent.html",true);
//center content licha lv data end ----->>>


foreach($sp_ld[5] as $_qs => $_split_datas){
	//center content template start --->>>
// 	$_tm_qm_sum = $ld_qm;
// 	$line_split = "";
// 	foreach($_split_datas as $_key => $_s_d){
// 		$_tm_qm = $ld_qm;
// 		$_tm_ball_unique_ball_datas = array();
// 		$_tm_ball_unique_count_datas = array();
// 		$_s_d_balls = explode(",",$_s_d['ball']);
// 		foreach($_s_d_balls as $_s_d_ball){
// 			$_tm_ball_unique_ball_datas[$_s_d_ball] = !isset($_tm_ball_unique_ball_datas[$_s_d_ball]) ? 1 : $_tm_ball_unique_ball_datas[$_s_d_ball]+1;
// 		}
// 		foreach($_tm_ball_unique_ball_datas as $_ball => $_count){
// 			$_tm_qm[$_ball] = $_count;
// 			$_tm_ball_unique_count_datas[$_count] = 0;
// 		}
// 		$_tm_qm_count = count($_tm_ball_unique_count_datas);
		
// 		$no = $_s_d['no'];
// 		$_tm_max_count = max($_tm_qm);
		
// 		foreach($_tm_qm as $_ball => $_count){
// 			$_tm_name = "b".$_ball;
// 			$_tm_hilight_name = 'hilight_center_content_'.$_ball;
// 			$$_tm_hilight_name = "";
// 			if($_tm_qm_count > 1 && $_tm_max_count == $_count){
// 				$$_tm_hilight_name = "hilight-content-red";
// 			}else if($_tm_qm_count > 1 && $_count > 0){
// 				$$_tm_hilight_name= "hilight-content-red-2";
// 			}else if($_tm_qm_count == 1 && $_count > 0){
// 				$$_tm_hilight_name= "hilight-content-red-2";
// 			}
// 			$$_tm_name = $_count;
// 			$_tm_qm_sum[$_ball] += $_count;
// 		}
// 		if($_key == (count($_split_datas) - 1)){
// 			$line_split = "bottom_line_split";
// 		}
// 		$tm_center_content .= out("template/centerContent.html");
// 	}
	
	
	
	//right content template start --->>>
	//----------right content qm sum start --->>>
// 	$_tm_qm_sum_unique = array();
// 	foreach($_tm_qm_sum as $_ball => $_count){
// 		$_tm_qm_sum_unique[$_count] = 0;
// 	}
	
// 	$_tm_qm_sum_unique = array_keys($_tm_qm_sum_unique);
// 	rsort($_tm_qm_sum_unique);
// 	$_tm_max_qm_sum_unique = max($_tm_qm_sum_unique);
	
// 	$_tm_second_max_qm_sum_unique = array();
// 	$_tm_i = 0;
// 	foreach($_tm_qm_sum_unique as $_tm_qm_sum_unique_val){
// 		if($_tm_qm_sum_unique_val != 0 && ($_tm_i == 1 || $_tm_i == 2)){
// 			$_tm_second_max_qm_sum_unique[] = $_tm_qm_sum_unique_val;
// 		}
// 		$_tm_i++;
// 	}
// 	//----------right content qm sum end --->>>
	
// 	//----------config right content qm sum remain count and sum count start --->>>
// 	$_tm_qm_sum_remain_count = array();
// 	$_tm_qm_sum_remain_count_unique = array();
// 	foreach($_tm_qm_sum as $_ball => $_count){
// 		$_tm_remain = $tvc_split_data_num_ave - $_count;
// 		$_tm_qm_sum_remain_count[$_ball] = $_tm_remain;
		
// 	}
	
// 	arsort($_tm_qm_sum_remain_count);
	
// 	$_tm_max_qm_sum_remain_count_unique = max($_tm_qm_sum_remain_count);
// 	$_tm_min_qm_sum_remain_count_unique = min($_tm_qm_sum_remain_count);
	
// 	foreach($_tm_qm_sum_remain_count as $_count){
// 		$_tm_qm_sum_remain_count_unique["'$_count'"] = 0;
// 	}


// 	$_tm_qm_sum_remain_count_unique_temp = array();
// 	foreach($_tm_qm_sum_remain_count_unique as $_count => $v){
// 		$_tm_qm_sum_remain_count_unique_temp[] = preg_replace("/\'/","",$_count);
// 	}
	
// 	rsort($_tm_qm_sum_remain_count_unique_temp);
// 	$_tm_qm_sum_remain_count_unique = $_tm_qm_sum_remain_count_unique_temp;

// 	$_tm_second_qm_sum_remain_count = array();
// 	$_tm_i = 0;
// 	foreach($_tm_qm_sum_remain_count_unique as $_tm_qm_sum_remain_count_unique_val){
// 		if($_tm_qm_sum_remain_count_unique_val > $_tm_min_qm_sum_remain_count_unique && ($_tm_i == 1 || $_tm_i == 2)){
// 			$_tm_second_qm_sum_remain_count[] = $_tm_qm_sum_remain_count_unique_val;
// 		}
// 		$_tm_i++;
// 	}

	
// 	//----------config right content qm sum remain count and sum count end--->>>
	
// 	//----------right content qm sum remain count and sum count start --->>>
// 	$line_split = "";
// 	$tm_right_content_2_temp = array();
// 	foreach($_split_datas as $_key => $_s_d){
// 		$no = $_s_d['no'];
// 		$line_split = "";
		
// 		if($_key == (count($_split_datas) - 2)){
// 			$_tm_max_qm_sum_remain_count = max($_tm_qm_sum_remain_count);
			
// 			foreach($_tm_qm_sum_remain_count as $_ball => $_remain_count){
// 				$_tm_name = "b".$_ball;
// 				$_tm_hilight_name = 'hilight_center_content_'.$_ball;
// 				$$_tm_hilight_name = "";
// 				$$_tm_name = "";
				
				
// 				$$_tm_name = $_remain_count;
// 				if($_tm_max_qm_sum_remain_count == $_remain_count){
// 					$$_tm_hilight_name = "hilight-content-green";
// 					$tm_right_content_2_temp[] = $_ball;
//  				}else if(in_array($_remain_count,$_tm_second_qm_sum_remain_count)){
// 					$$_tm_hilight_name = "hilight-content-red-2";
// 				}else if($_remain_count > $_tm_min_qm_sum_remain_count_unique){
// 					$$_tm_hilight_name = "hilight-content-red-3";
// 				}else{
// 					$$_tm_hilight_name = "hilight-content-white";
// 				}
// 			}
// 			$tm_right_content .= out("template/rightContent.html");
			
			
// 			$gen_ball = join(",",$tm_right_content_2_temp);
// 			$tm_right_content_2 .= out("template/rightContent1.html");
// 		}else if($_key == (count($_split_datas) - 1)){
// 			foreach($_tm_qm_sum as $_ball => $_count){
// 				$_tm_name = "b".$_ball;
// 				$_tm_hilight_name = 'hilight_center_content_'.$_ball;
// 				$$_tm_hilight_name = "";
// 				$$_tm_name = "";
				
// 				$line_split = "bottom_line_split";
// 				$$_tm_name = $_count;
// 				if($_tm_max_qm_sum_unique == $_count){
// 					$$_tm_hilight_name = "hilight-content-red";
// 				}else if(in_array($_count,$_tm_second_max_qm_sum_unique)){
// 					$$_tm_hilight_name = "hilight-content-red-2";
// 				}else if($_count > 0){
// 					$$_tm_hilight_name = "hilight-content-red-3";
// 				}else if($_count == 0){
// 					$$_tm_hilight_name = "hilight-content-white";
// 				}
				
// 			}
// 			$tm_right_content .= out("template/rightContent.html");
			
// 			$gen_ball = "";
// 			$tm_right_content_2 .= out("template/rightContent1.html");
// 		}else{
// 			foreach($_tm_qm_sum as $_ball => $_count){
// 				$_tm_name = "b".$_ball;
// 				$_tm_hilight_name = 'hilight_center_content_'.$_ball;
// 				$$_tm_hilight_name = "";
// 				$$_tm_name = "";
// 			}
			
// 			$tm_right_content .= out("template/rightContent.html");
			
// 			$gen_ball = "";
// 			$tm_right_content_2 .= out("template/rightContent1.html");
// 		}
		
// 	}

// 	//----------right content qm sum remain count and sum count end --->>>
	
	
// 	//----------bet content start --->>>
	
	
// 	$ld_bet_content_gb[$_qs] = $tm_right_content_2_temp;
// 	$_before_qs = $_qs - 1;
// 	$_before_gbs = $ld_qm;
// 	$line_split = "";
// 	if($_qs > $tvc_start_bet_qs){
// 		foreach($_before_gbs as $_b => $_c){
// 			if(in_array($_b,$ld_bet_content_gb[$_before_qs])){
// 				$_before_gbs[$_b] = 1;
// 			}
// 		}
// 	}
	
// 	foreach($_split_datas as $_sqs => $_s_d){
// 		if($_sqs == (count($_split_datas) - 1)){
// 			$line_split = "bottom_line_split";
// 		}
// 		$no = $_s_d['no'];
// 		if($_qs > $tvc_start_bet_qs){
// 			$_before_qs = $_qs - 1;
// 			$_open_ball = $_s_d['ball'];
// 			foreach($_before_gbs as $_ball => $isBet){
// 				$_tm_bet_content_name = "bet$_ball";
				
// 				if($isBet){
// 					preg_match_all("/$_ball/",$_open_ball,$match);
// 					$winCount = count($match[0]);
// 					$bs = $ld_bs[$_sqs+1];
// 					$loss = - ($bs * 10);
					
// 					$win = $winCount * $bs * 19;
					
// 					if($winCount > 0){
						
						
// 						$_tm_sum_loss = isset($ld_bet_winloss[$_qs][$_ball]) ? array_sum($ld_bet_winloss[$_qs][$_ball])+$loss : $loss;
						
// 						$ld_bet_winloss[$_qs][$_ball][$_sqs] = $win+$_tm_sum_loss;
// 						$$_tm_bet_content_name = $win+$_tm_sum_loss;
						
// 						$_before_gbs[$_ball] = 0;
// 					}else{
// 						$$_tm_bet_content_name = $loss;
// 						$ld_bet_winloss[$_qs][$_ball][$_sqs]= $loss;
// 					}
// 				}else{
// 					$$_tm_bet_content_name = "";
// 				}
// 			}
			
// 		}else{
// 			foreach($_before_gbs as $_ball => $isBet){
// 				$_tm_bet_content_name = "bet$_ball";
// 				$$_tm_bet_content_name = "";
				
// 			}
// 		}
		
// 		$tm_bet_content .= out("template/betContent.html");
// 	}
	
// 	$line_split = "";
// 	foreach($_split_datas as $_sqs => $_s_d){
// 		$no = $_s_d['no'];
// 		if($_sqs == (count($_split_datas) - 1)){
// 			$line_split = "bottom_line_split";
// 			$gen_ball = sum_bet_result($ld_bet_winloss);
// 			$tm_bet_content_result .= out("template/rightContent1.html");
// 			if(isset($ld_bet_winloss[$_qs])){
// 				$gen_ball = sum_bet_result(array($ld_bet_winloss[$_qs]));
// 			}else{
// 				$gen_ball = "";
// 			}
// 			$tm_bet_content_result_1 .= out("template/rightContent1.html");
// 		}else{
// 			$gen_ball = "";
// 			$tm_bet_content_result .= out("template/rightContent1.html");
// 			$gen_ball = "";
// 			$tm_bet_content_result_1 .= out("template/rightContent1.html");
// 		}
// 	}
	//----------bet content end --->>>
}

$tm_tip_content_bet = sum_bet_result($ld_bet_winloss);
$record_data = $index_content."_".$tvc_count."_".$tvc_split_data_num."_".$tvc_start_bet_qs."_".$tvc_stop_win_money."_".$tvc_stop_loss_money."_".$tm_tip_content_bet;
$record_data_content = $record_data."\t".str_replace("_", "\t", $record_data);
$record_file_name = $record_data.".html";


if($index_content == 1){
	file_put_contents($index_file,$record_data_content."\n");
}else{
	file_put_contents($index_file,$record_data_content."\n",FILE_APPEND);
}
	
	
$tip_content_hilight = '';
if($tm_tip_content_bet < 0){
	$tip_content_hilight = 'loss';
}


$index_content = file_get_contents($index_file);
$bet_totla_result = sum_bet_total_result($index_content);
$tm_tip_content_bet_total_qs = $bet_totla_result["t_qs"];
$tm_tip_content_bet_total_result = $bet_totla_result["t_result"];

$tm_tip_content_bet_result = $tm_tip_content_bet;
//center content data end ----->>>

$tm_main = out("template/main.html");
echo $tm_main;
file_put_contents("record/$record_file_name",$tm_main);

exit;
/************************************* Function *************************************/
function sum_bet_total_result($content){
	$result = array(
		"t_qs" => 0,
		"t_result" => 0
	);
	$data = explode("\n",$content);
	foreach($data as $d){
		if(!empty($d)){
			$data_1 = explode("\t",$d);
			
			$result["t_qs"] = $data_1[1];
			$result["t_result"] += $data_1[7];
			
		}
	}
	return $result;
}
function sum_bet_result($data){
	if(empty($data)){
		return "";
	}else{
		$result = 0;
		foreach($data as $_qs => $_bet_ball_record){
			foreach($_bet_ball_record as $_bet_ball=>$_bet_data){
				if($_bet_data[count($_bet_data)-1] < 0){
					$result += array_sum($_bet_data);
				}else{
					$result += $_bet_data[count($_bet_data)-1];
				}
				
			}
		}
		return $result;
	}
	
}


?>