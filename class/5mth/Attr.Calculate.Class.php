<?php 
class AttrCalculate{
	public $_data = array();
	public $QM = array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0);
	public $AVE = 0;
	
	public $ATTR_COUNT_ROW = array();
	public $ATTR_COUNT_COL = array();
	public $ATTR_COUNT_SUM = array();
	
	public $ATTR_COUNT_CHA_ROW = array();
	public $ATTR_COUNT_CHA_COL = array();
	public $ATTR_COUNT_CHA_SUM = array();
	
	
	
	
	function __construct($data){
		$this->_data = $data;
		$this->calculateData = $data["cd"];
		$this->validateData = $data["vd"];
		
		$this->AVE =  count($this->validateData) * 5 / 10;
		print_r($this->AVE);
		$this->calculateAttr();
	}
	
	public function calculateAttr(){
		$canculateDataAttr = $this->calculateAppearTimesATTR($this->calculateData);
		$validateDataAttr = $this->calculateAppearTimesATTR(array($this->validateData));
	
// 		print_r($canculateDataAttr['cc']['sum']);
		
		print_r($validateDataAttr);
		
		exit;
	}
	
	public function setCalculateAppearTimesATTR(){
// 		$this->ATTR_COUNT_ROW = $appearCountRowDatas;
// 		$this->ATTR_COUNT_COL = $appearCountColumnDatas;
// 		$this->ATTR_COUNT_SUM = $appearCountSumData;
		
// 		$this->ATTR_COUNT_CHA_ROW = $appearCountRowChaDatas;
// 		$this->ATTR_COUNT_CHA_COL = $appearCountColumnChaDatas;
// 		$this->ATTR_COUNT_CHA_SUM = $appearCountChaSumData;
		
	}
	
	public function calculateAppearTimesATTR($_data){
		$result = array();
		
		$appearCountRowDatas = array();
		$appearCountColumnDatas = array();
		$appearCountSumData = $this->QM;
		
		$appearCountRowChaDatas = array();
		$appearCountColumnChaDatas = array();
		$appearCountChaSumData = $this->QM;
		
		foreach($_data as $d){
			$appearCountData = $this->_getQMAppearCount($d);
			
			$appearCountChaData = $this->_getQMAppearCountCha($appearCountData);
			
			$appearCountRowDatas[]  = $appearCountData;
			$appearCountRowChaDatas[] = $appearCountChaData;
			
			foreach($this->QM as $b => $_null){
				$appearCountColumnDatas[$b][] = $appearCountData[$b];
				$appearCountColumnChaDatas[$b][] = $appearCountChaData[$b];
				$appearCountSumData[$b] += $appearCountData[$b];
				$appearCountChaSumData[$b] += $appearCountChaData[$b];
			}
		}
		
		
		$result["c"]["row"] = $appearCountRowDatas;
		$result["c"]["col"] = $appearCountColumnDatas;
		$result["c"]["sum"] = $appearCountSumData;
		
		$result["cc"]["row"] = $appearCountRowChaDatas;
		$result["cc"]["col"] = $appearCountColumnChaDatas;
		$result["cc"]["sum"] = $appearCountChaSumData;
		return $result;
	}
	
	
	
	private function _getQMAppearCountCha($appearCountData){
		$result = array();
		foreach($appearCountData as $b => $count){
			$result[$b] = $count - $this->AVE;
		}
		return $result;
	}
	
	private function _getQMAppearCount($data){
		$result = $this->QM;
		foreach($data as $d){
			foreach(explode(",",$d['ball']) as $b){
				$result[$b] += 1;
			}
		}
		return $result;
	}
}

?>