<?php 
function split_lottery_data($data,$split_attr = array(5,10,15,30)){
	$result = array();
	$result1 = array();
	if(empty($split_attr) || empty($data) || count($data) <= max($split_attr))
		return false;
	
	$split_attr[] = 0;
	foreach($split_attr as $sa_key => $sa_num){
		$i = 0;
		$j = 0;
		$k = 1;
		foreach($data as $index => $d){
			$d['no'] = $k;
			if($sa_num == 0){
				if(($k) % 5 == 0){
					$d['line_split'] = true;
				}else{
					$d['line_split'] = false;
				}
				
				$result[$sa_num][] = $d;
				
			}else{
				if(($j+1) == $sa_num)
					$d['line_split'] = true;
				else
					$d['line_split'] = false;
					
				$result[$sa_num][$i][$j] = $d;
				
				if($sa_num == 5){
					$result1[$i]["5"][$j] = $d;
				}
					
				$j++;
				if(($index+1) % $sa_num == 0){
					
					
						if($sa_num == 5){
							if($i > 0){
								$result1[$i]["10"] = array_merge($result1[$i-1]["5"],$result1[$i]["5"]);
							}
							if($i > 1){
								$result1[$i]["15"] = array_merge($result1[$i-1]["10"],$result1[$i]["5"]);
							}
							if($i > 4){
								$result1[$i]["30"] = array_merge($result1[$i-5]["5"],$result1[$i-4]["5"],$result1[$i-3]["5"],$result1[$i-2]["5"],$result1[$i-1]["5"],$result1[$i]["5"]);
							}
						}
					$i++;
					$j = 0;
				}
			}
			
			$k++;
		}
	}
	$result["FD"] = $result1;
	return $result;
}
function revert_data_by($data){
	$result = array();
	$fresult = array();
	foreach($data as $ball => $v){
		if(gettype($v) == 'double'){
			$result["'$v'"][] = $ball;
		}else{
			$result[$v][] = $ball;
		}
	}
	$temp = [];
	foreach($result as $v => $ball){
		$_v = preg_replace("/\'/","",$v);
		$temp[] = $_v;
	}
	rsort($temp);
	foreach($temp as $_v){
		
		foreach($result as $v => $ball){
			$v1 = preg_replace("/\'/","",$v);
			if($_v == $v1){
				$fresult[$v] = $ball;
			}
			
		}
	}
	return $fresult;
}

function convert_data_to_count($data){
	$final = array();
	$result = array();
	foreach($data as $d){
		$balls = explode(",",$d['ball']);
		foreach($balls as $ball){
			$result[$ball] = !isset($result[$ball]) ? 1 : $result[$ball]+1;
		}
	}
	$final["FQM"] = $result;
	$qmResult = array();
	for($i = 0; $i < 10; $i++){
		if(isset($result[$i])){
			$qmResult[$i] = $result[$i];
		}else{
			$qmResult[$i] = 0;
		}
	}
	$final["QM"] = $qmResult;
	$revert_data = revert_data_by($qmResult);
	$final["RC"] = $revert_data;
	
	$final["DC"] = array();
	$maxCount = max($qmResult);
	$minCount = min($qmResult);
	$countCount = count($qmResult);
	$i = $countCount - 1;
	foreach($revert_data as $count => $balls){
		
		if($maxCount == $count){
			$final["DC"][$count] = 'hmax';
		}elseif($count == 0){
			$final["DC"][$count] = 'hmin';
		}else{
			$final["DC"][$count] = 'h'.$count;
		}
		if($maxCount != $count && $count != 0){
			$percent = round((10 / $countCount * $i) / 10,1) - 0.3;
			$final["DCB"][$count] = "background-color:rgba(255,0,0,$percent);";
			$i--;
		}
	}
	return $final;
	
}

function convert_data_to_count_lc($data){
	$final = array();
	$lc = array(); // count li cha
	$lcl = array(); // count li cha bi lv
	$cdtc = convert_data_to_count($data);
	$final["AVE"] = 0;
	$qmCount = $cdtc['QM'];
	$final["QM"] = $qmCount;
	$final["QMLC"] = $qmCount;
	$final["QMLCL"] = $qmCount;
	$final["RLC"] = revert_data_by($qmCount);
	$final["RLCL"] = revert_data_by($qmCount);
	$final["DLC"] = array(0=>'hmin');
	$final["DLCL"] = array(0=>'hmin');
	$final["LCB"] = revert_data_by($qmCount);
	$final["LCLB"] = revert_data_by($qmCount);
	
	if(!empty($data)){
		$final = array();
		$aveCount = (array_sum($qmCount) / 10);
		$final["AVE"] = $aveCount;
		$final["QMC"] = $qmCount;
		foreach($qmCount as $ball => $count){
			$lc_val = $count - $aveCount;
			$lc[$ball] = $lc_val;
			$lcl[$ball] = round($lc_val / $aveCount * 100,0);
		}
		$final["QMLC"] = $lc;
		$final["QMLCL"] = $lcl;
		
		$revert_lcc_data = revert_data_by($lc);
		$revert_lclc_data = revert_data_by($lcl);
		$final["RLC"] = $revert_lcc_data;
		$final["RLCL"] = $revert_lclc_data;
		
		
		$final["DLC"] = array();
		$final["DLCL"] = array();
		
		$countRLC = count($revert_lcc_data);
		$maxLC = max($lc);
		$minLC = min($lc);
		
		$final['maxLC'] = $maxLC;
		$final['minLC'] = $minLC;
	
		$countRLCL = count($revert_lclc_data);
		$maxLCL = max($lcl);
		$minLCL = min($lcl);
		
		$final['maxLCL'] = $maxLCL;
		$final['minLCL'] = $minLCL;
		$i = $countRLC  - 1;
		foreach($revert_lcc_data as $lcv => $balls){
		
			$clcv = preg_replace("/\'/","",$lcv);
			
			if($maxLC == $clcv){
				$final["DLC"][$lcv] = 'hmax';
			}elseif($minLC== $clcv){
				$final["DLC"][$lcv] = 'hmin';
			}else{
				$final["DLC"][$lcv] = 'h'.round(abs($clcv));
			}
			
			if($maxLC != $clcv && $minLC != $clcv){
				$percent = round((10 / $countRLC * $i) / 10,1) - 0.2;
				$final["LCB"][$lcv] = "background-color:rgba(255,0,0,$percent);";
				$i--;
			}
		}
		
		$j = $countRLCL - 1;
		foreach($revert_lclc_data as $lclv => $balls){
			
			$clclv = preg_replace("/\'/","",$lclv);
			if($maxLCL == $clclv){
				$final["DLCL"][$lclv] = 'hmax';
			}elseif($minLCL == $clclv){
				$final["DLCL"][$lclv] = 'hmin';
			}else{
				$final["DLCL"][$lclv] = 'h'.round(abs($clclv));
			}
			
			if($maxLCL != $clclv && $minLCL != $clclv){
				$percent = round((10 / $countRLCL * $j) / 10,1) - 0.2;
				$final["LCLB"][$lclv] = "background-color:rgba(255,0,0,$percent);";
				$j--;
			}
		}
		
		
	}
	return $final;
}




//center content licha function start ----->>>


function show_center_lc_content($data,$template_path,$lcl,$line_split = false,$no = "&nbsp;",$index=""){
	$template = "";
	
	$cdtlc = convert_data_to_count_lc($data);
	if($lcl){
		$qmLC = $cdtlc['QMLCL'];
		$lcColor = $cdtlc['DLCL'];
		$bgColor = $cdtlc['LCLB'];
	}else{
		$qmLC = $cdtlc['QMLC'];
		$lcColor = $cdtlc['DLC'];
		$bgColor = $cdtlc['LCB'];
	}
	

	$GLOBALS['index'] = $index;
	$GLOBALS['no'] = $no;
	if(empty($data)){
		for($i = 0; $i < 10; $i++){
			$_tm_name = "b".$i;
			$_tm_hilight_name = 'hilight_center_content_'.$i;
			$_tm_hilight_style = 'hilight_content_style_'.$i;
			$GLOBALS[$_tm_hilight_style] = "";
			$GLOBALS[$_tm_name] = "";
			$GLOBALS[$_tm_hilight_name] = "";
			$GLOBALS[$_tm_hilight_style] = "";
		}
	}else{
		foreach($qmLC as $_ball => $_lc){
			$_tm_name = "b".$_ball;
			$_tm_hilight_name = 'hilight_center_content_'.$_ball;
			$_tm_hilight_style = 'hilight_content_style_'.$_ball;
			$GLOBALS[$_tm_name] = $_lc;
			$GLOBALS[$_tm_hilight_name] = isset($lcColor["'$_lc'"]) ? $lcColor["'$_lc'"] : (isset($lcColor[$_lc]) ? $lcColor[$_lc] : "");
			$GLOBALS[$_tm_hilight_style] = isset($bgColor["'$_lc'"]) ? $bgColor["'$_lc'"] : (isset($bgColor[$_lc]) ? $bgColor[$_lc] : "");
		}
	}
	if($line_split){
		$GLOBALS['line_split'] = "bottom_line_split";
	}else{
		$GLOBALS['line_split'] = "";
	}
	$template .= out($template_path);
	return $template;
}
function show_my_center_lc_content($sp_ld,$template_path,$lcl = false){
	$template = "";
	$empty_no = "N";
	foreach($sp_ld as $_qs => $_sp_data){
		
		foreach($_sp_data[5] as $key => $_d){
			$index = $_d['no'];
			if($_qs > 4){
				if($key==1){
					$template .= show_center_lc_content($_sp_data[5],$template_path,$lcl,false,5,$index);
				}elseif($key==2 && $_qs > 0){
					$template .= show_center_lc_content($_sp_data[10],$template_path,$lcl,false,10,$index);
				}elseif($key==3 && $_qs > 1){
					$template .= show_center_lc_content($_sp_data[15],$template_path,$lcl,false,15,$index);
				}elseif($key==4 && $_qs > 4){
					$template .= show_center_lc_content($_sp_data[30],$template_path,$lcl,true,30,$index);
				}else{
					$template .= show_center_lc_content(array(),$template_path,$lcl,false,$empty_no,$index);
				}
			}else{
				if($_qs == 0 && $key == 4){
					$template .= show_center_lc_content($_sp_data[5],$template_path,$lcl,true,5,$index);
				}elseif($_qs == 1){
					if($key == 3){
						$template .= show_center_lc_content($_sp_data[5],$template_path,$lcl,false,5,$index);
					}elseif($key == 4){
						$template .= show_center_lc_content($_sp_data[10],$template_path,$lcl,true,10,$index);
					}else{
						$template .= show_center_lc_content(array(),$template_path,$lcl,false,$empty_no,$index);
					}
				}elseif($_qs == 2){
					if($key == 2){
						$template .= show_center_lc_content($_sp_data[5],$template_path,$lcl,false,5,$index);
					}elseif($key == 3){
						$template .= show_center_lc_content($_sp_data[10],$template_path,$lcl,false,10,$index);
					}elseif($key == 4){
						$template .= show_center_lc_content($_sp_data[15],$template_path,$lcl,true,15,$index);
					}else{
						$template .= show_center_lc_content(array(),$template_path,$lcl,false,$empty_no,$index);
					}
				}elseif($_qs == 3){
					if($key == 2){
						$template .= show_center_lc_content($_sp_data[5],$template_path,$lcl,false,5,$index);
					}elseif($key == 3){
						$template .= show_center_lc_content($_sp_data[10],$template_path,$lcl,false,10,$index);
					}elseif($key == 4){
						$template .= show_center_lc_content($_sp_data[15],$template_path,$lcl,true,15,$index);
					}else{
						$template .= show_center_lc_content(array(),$template_path,$lcl,false,$empty_no,$index);
					}
				}elseif($_qs == 4){
					if($key == 2){
						$template .= show_center_lc_content($_sp_data[5],$template_path,$lcl,false,5,$index);
					}elseif($key == 3){
						$template .= show_center_lc_content($_sp_data[10],$template_path,$lcl,false,10,$index);
					}elseif($key == 4){
						$template .= show_center_lc_content($_sp_data[15],$template_path,$lcl,true,15,$index);
					}else{
						$template .= show_center_lc_content(array(),$template_path,$lcl,false,$empty_no,$index);
					}
				}else{
					$template .= show_center_lc_content(array(),$template_path,$lcl,false,$empty_no,$index);
				}
			}
			
		}
	}
	return $template;
}
//center content licha function end ----->>>


//center content function start ----->>>
function show_center_content($data,$template_path,$line_split = false,$no = "&nbsp;",$index=""){
	$template = "";
	$cdtc = convert_data_to_count($data);
	$qmCount = $cdtc['QM'];
	$countColor = $cdtc['DC'];
	
	$countBgColor = isset($cdtc['DCB']) ? $cdtc['DCB'] : array();
	
	$GLOBALS['no'] = $no;
	$GLOBALS['index'] = $index;
	if(empty($data)){
		for($i = 0; $i < 10; $i++){
			$_tm_name = "b".$i;
			$_tm_hilight_name = 'hilight_center_content_'.$i;
			$_tm_hilight_style = 'hilight_content_style_'.$i;
			$GLOBALS[$_tm_name] = "";
			$GLOBALS[$_tm_hilight_name] = "";
			$GLOBALS[$_tm_hilight_style] = "";
		}
	}else{
		foreach($qmCount as $_ball => $_count){
			$_tm_name = "b".$_ball;
			$_tm_hilight_name = 'hilight_center_content_'.$_ball;
			$_tm_hilight_style = 'hilight_content_style_'.$_ball;
			$GLOBALS[$_tm_name] = $_count;
			$GLOBALS[$_tm_hilight_name] = $countColor[$_count];
			$GLOBALS[$_tm_hilight_style] = (isset($countBgColor[$_count]) ? $countBgColor[$_count] : "");
		}
	}
	if($line_split){
		$GLOBALS['line_split'] = "bottom_line_split";
	}else{
		$GLOBALS['line_split'] = "";
	}
	
	$template .= out($template_path);
	return $template;
}

function show_my_center_content($sp_ld,$template_path){
	$template = "";
	$empty_no = "N";
	foreach($sp_ld as $_qs => $_sp_data){
		foreach($_sp_data[5] as $key => $_d){
			$index = $_d['no'];
			if($_qs > 4){
				if($key==1){
					$template .= show_center_content($_sp_data[5],$template_path,false,5,$index);
				}elseif($key==2 && $_qs > 0){
					$template .= show_center_content($_sp_data[10],$template_path,false,10,$index);
				}elseif($key==3 && $_qs > 1){
					$template .= show_center_content($_sp_data[15],$template_path,false,15,$index);
				}elseif($key==4 && $_qs > 4){
					$template .= show_center_content($_sp_data[30],$template_path,true,30,$index);
				}else{
					$template .= show_center_content(array(),$template_path,false,$empty_no,$index);
				}
			}else{
				if($_qs == 0 && $key == 4){
					$template .= show_center_content($_sp_data[5],$template_path,true,5,$index);
				}elseif($_qs == 1){
					if($key == 3){
						$template .= show_center_content($_sp_data[5],$template_path,false,5,$index);
					}elseif($key == 4){
						$template .= show_center_content($_sp_data[10],$template_path,true,10,$index);
					}else{
						$template .= show_center_content(array(),$template_path,false,$empty_no,$index);
					}
				}elseif($_qs == 2){
					if($key == 2){
						$template .= show_center_content($_sp_data[5],$template_path,false,5,$index);
					}elseif($key == 3){
						$template .= show_center_content($_sp_data[10],$template_path,false,10,$index);
					}elseif($key == 4){
						$template .= show_center_content($_sp_data[15],$template_path,true,15,$index);
					}else{
						$template .= show_center_content(array(),$template_path,false,$empty_no,$index);
					}
				}elseif($_qs == 3){
					if($key == 2){
						$template .= show_center_content($_sp_data[5],$template_path,false,5,$index);
					}elseif($key == 3){
						$template .= show_center_content($_sp_data[10],$template_path,false,10,$index);
					}elseif($key == 4){
						$template .= show_center_content($_sp_data[15],$template_path,true,15,$index);
					}else{
						$template .= show_center_content(array(),$template_path,false,$empty_no,$index);
					}
				}elseif($_qs == 4){
					if($key == 2){
						$template .= show_center_content($_sp_data[5],$template_path,false,5,$index);
					}elseif($key == 3){
						$template .= show_center_content($_sp_data[10],$template_path,false,10,$index);
					}elseif($key == 4){
						$template .= show_center_content($_sp_data[15],$template_path,true,15,$index);
					}else{
						$template .= show_center_content(array(),$template_path,false,$empty_no,$index);
					}
				}else{
					$template .= show_center_content(array(),$template_path,false,$empty_no,$index);
				}
			}
			
		}
	}
	return $template;
}
//center content function end ----->>>



function show_base_lottery_data($data,$template_path){
	$template = "";
	foreach($data as $index => $d){
		$GLOBALS['line_split'] = "";
		$GLOBALS['no'] = $d["no"];
		$GLOBALS['b1'] = $d["b1"];
		$GLOBALS['b2'] = $d["b2"];
		$GLOBALS['b3'] = $d["b3"];
		$GLOBALS['b4'] = $d["b4"];
		$GLOBALS['b5'] = $d["b5"];
		$GLOBALS['balls'] = $d["ball"];
		if($d["line_split"])
			$GLOBALS['line_split'] = "bottom_line_split";
			// 		if($line_split = "bottom_line_split";)
			$template .= out($template_path);
	}
	return $template;
}
?>