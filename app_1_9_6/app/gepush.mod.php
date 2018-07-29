<?php
class ModuleObject extends AppObject{
	function ModuleObject($config)
	{
		$this->AppObject($config);
		$this->Execute();
	}
	function Execute(){
		if($this->Act == 'getCarModel'){
			$this->getCarModel();
		}
		else if($this->Act == 'getTelCache'){
			$this->getTelCache();
		}
		else if($this->Act == 'getStr'){
			$this->getStr();
		}
		else if($this->Act == 'getMem'){
			$this->getMem();
		}
		else if($this->Act == 'getSuburb'){
			$this->getSuburb();
		}
	}
	function index(){
		die('Error');
	}

	function getCarModel(){
		header("Content-type: application/json");
		$returnAry = array();
		$returnAry['value'] = array();
		$returnAry['child'] = array();
		$returnAry['child']['label'] = '车辆型号';
		$returnAry['child']['name'] = 'model';
		$returnAry['child']['value'] = array();
		$carMakeAry = $this->Db->fetch_all_assoc("select make from professional_car_model group by make");
		foreach($carMakeAry as $make){
			$tmp = array();
			$returnAry['value'][] = array($make['make'],$make['make']);
			$modelAry = $this->Db->fetch_all_assoc("select model from  professional_car_model where make='".$make['make']."'");
			foreach($modelAry as $model){
				if(strstr($model['model'],'(')){
					continue;
				}
				$tmp[] = array($model['model'],$model['model']);
			}
			$returnAry['child']['value'][] = $tmp;
		}
		$str = json_encode($returnAry);
		echo $str;
		exit;
	}

	function getTelCache(){
		$tel = $this->Post['tel'];
		$keyCode = 'sms_'.$tel;
		$successKey = 'sms_check_'.$tel;
		echo getVar($keyCode);
		echo "==========================";
		echo getVar($successKey);
	}

	function getStr(){
		$authcode = $this->Post['authcode'];
		echo authcode($authcode,'DECODE');
	}

	function getMem(){
		$memKey = $this->Post['memKey'];
		echo getVar($memKey);
	}
	function getSuburb(){
		$suburb = $this->Db->fetch_all_row("select suburb,suburb from api_common_city_suburb where city='NSW'");
		$return = array();
		$return['NSW'] = $suburb;
		echo json_encode($return);
		exit;
	}
}