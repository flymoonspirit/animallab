<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;

class StrainController extends Controller {
    public function showStrain(){
    	$strainList = $this->getAllStrains();
		$n = count($strainList);
		$count = $n/5;
		
		$this->count = $count;
    	$this->strainList = $strainList;
    	$this->display();
    	
	}
    

	private function getAllStrains(){
		$strainList = M('mouse')->distinct('strain')->getField('strain',true);
		return $strainList;
	}
	
	//进入详细数据界面
	public function showDetailByStrain(){
		$data = array(
    		'map_id' => I('map_id'),
    		'findex_id' => I('findex_id'),
			'selectStrain' => I('selectStrain')
		);
		$data['selectStrain'] = urlUnReplace($data['selectStrain']);
		$findex = null;
		$sindex = null;
		$Survey = A('Home/Survey');
		$findexList = $Survey->getFindexList();
		$sindexList = $this->getSindex($findexList[0]['findex_id']);
		$selectStrain = $data['selectStrain'];
		
		//需要返回的数据
		$rs = null;
		if($data['map_id'] != null && $data['map_id'] != '' && $data['findex_id'] != null && $data['findex_id'] != ''){
			$findex = M('findex')->where(array('findex_id'=>$data['findex_id']))->find();
			$sindex = M('index_map')->where(array('map_id'=>$data['map_id']))->find();
			$rs = $this->getMouseData($data,$sindex);
		}
		
		
		
		//单值时进入默认模板
		if($sindex != null){
			if($sindex['type'] == '1'){
				$this->count = $rs['count'];
				$this->mouseDataList = $rs['returnData'];
				$selectStrain1 = str_replace(',', ', ', $selectStrain);
				$this->selectStrain = $selectStrain1;
				$this->findex = $findex;
				$this->sindex = $sindex;
				$this->findexList = $findexList;
				$this->sindexList = $sindexList;
				$graphData = $this->mouseDP($rs['returnData'],$sindex['index']);
				$this->graphData = $graphData;
				$this->display();
			}
	    	
			//多值时进入其他****************************************myerror
			if($sindex['type'] == '2'){
				$selectStrain2 = str_replace(',', ', ', $selectStrain);
				$this->selectStrain = $selectStrain2;
				$this->findex = $findex;
				$this->sindex = $sindex;
				$this->findexList = $findexList;
				$this->sindexList = $sindexList;
				$graphData = $this->mouseMDP($rs['returnData']);
			
				$detail_data = array(
					'count' => $rs['count'],
					'mouseDataList' => $rs['returnData'],
					'graphData' => $graphData
				);
				
				$this->detail_data = json_encode($detail_data);
				session("detail_data",json_encode($detail_data));
				$this->graphData = $graphData;
			
				$this->display('showMDetailByStrain');
			}
			
			//单值不需要数据分析是的模板
			if($sindex['type'] == '3'){
				//返回的数据
				$mf_count = array();
				$this->count = $rs['count'];
				$mouseDataList = $rs['returnData'];
				for($i=0;$i<count($mouseDataList);$i++){
					for($j=0;$j<count($mouseDataList[$i]);$j++){
						if(trim($mouseDataList[$i][$j]['gender']) == 'M'){
							$mf_count[$i]['M'] = 1;
						}
						if(trim($mouseDataList[$i][$j]['gender']) == 'F'){
							$mf_count[$i]['F'] = 1;
						}
					}
				}
				$this->mf_count = $mf_count;
				$this->mouseDataList = $mouseDataList;
				$selectStrain3 = str_replace(',', ', ', $selectStrain);
				$this->selectStrain = $selectStrain3;
				$this->findex = $findex;
				$this->sindex = $sindex;
				$this->findexList = $findexList;
				$this->sindexList = $sindexList;
				$this->display('showSDetailByStrain');
			}
			
		}else{
			$this->count = $rs['count'];
			$this->mouseDataList = $rs['returnData'];
			$selectStrain4 = str_replace(',', ', ', $selectStrain);
			$this->selectStrain = $selectStrain4;
			$this->findex = $findex;
			$this->sindex = $sindex;
			$this->findexList = $findexList;
			$this->sindexList = $sindexList;
			$this->graphData = null;
			$this->display();
		}
		
	}

//数据处理，分品系、分性别计算平均值，标准差,针对多值属性
	private function mouseMDP($dataList){
		//构造返回数据的结构，一维表示strain，二维表示性别，M和F
		$reData = null;
		$rsData = null;
		$MList = array();
		$FList = array();
		$DateList = array();
		if($dataList != null){
			for($i=0;$i<count($dataList);$i++){
				//第一次循环，循环所有的strain
				$M = array();
				$F = array();
				for($j=0;$j<count($dataList[$i]);$j++){
					//第二次循环，将雌雄分开
					if(trim($dataList[$i][$j]['gender']) == 'M'){
						//第三次循环，将实验天数分开
						for($t=0;$t<(count($dataList[$i][$j])-8);$t++){
							$flag = 0;
							for($k=0;$k<count($M);$k++){
								if(trim($M[$k]['date']) == trim($dataList[$i][$j][$t]['date'])){
									
									$temp = count($M[$k]['value']);
									$M[$k]['value'][$temp] = $dataList[$i][$j][$t]['value'];
									$flag = 1;
								}else{
									continue;
								}
							}
							if($flag == 0){
								$tmp = count($M);
								$M[$tmp]['date'] = $dataList[$i][$j][$t]['date'];
								$M[$tmp]['value'][0] = $dataList[$i][$j][$t]['value'];
							}
						}
					}
					if(trim($dataList[$i][$j]['gender']) == 'F'){
						//第三次循环，将实验天数分开
						for($t=0;$t<(count($dataList[$i][$j])-8);$t++){
							$flag = 0;
							for($k=0;$k<count($F);$k++){
								if(trim($F[$k]['date']) == trim($dataList[$i][$j][$t]['date'])){
									$temp = count($F[$k]['value']);
									$F[$k]['value'][$temp] = $dataList[$i][$j][$t]['value'];
									$flag = 1;
								}else{
									continue;
								}
							}
							if($flag == 0){
								$tmp = count($F);
								$F[$tmp]['date'] = $dataList[$i][$j][$t]['date'];
								$F[$tmp]['value'][0] = $dataList[$i][$j][$t]['value'];
							}else{
								continue;
							}
						}
					}
					
				}//第二次循环，结束
				//进行数据处理
				for($m=0;$m<count($M);$m++){
					$rsData[$i]['M'][$m] = dataCompute($M[$m]['value']);
					$rsData[$i]['M'][$m]['date'] = $M[$m]['date'];
				}
				
				for($f=0;$f<count($F);$f++){
					$rsData[$i]['F'][$f] = dataCompute($F[$f]['value']);
					$rsData[$i]['F'][$f]['date'] = $F[$f]['date'];
				}
				
			}//第一次循环，将雌雄分开
		
			$indexCountMax = 0; //获取天数（实验时间）最大值
			for($i=0;$i<count($rsData);$i++){
				for($j=0;$j<count($rsData[$i]['M']);$j++){
					if($indexCountMax < $rsData[$i]['M'][$j]['date']){
						$indexCountMax = $rsData[$i]['M'][$j]['date'];
					}
				}
				for($j=0;$j<count($rsData[$i]['F']);$j++){
					if($indexCountMax < $rsData[$i]['F'][$j]['date']){
						$indexCountMax = $rsData[$i]['F'][$j]['date'];
					}
				}
			}
			
			//分雌雄计算strain的（老鼠指标）平均值的平均值
			for($t=1;$t<=$indexCountMax;$t++){
				//构造需要计算的数据数组,$t可以表示实验时间，即天数
				array_push($DateList,$t);
				$MArray = array();
				$FArray = array();
				for($i=0;$i<count($rsData);$i++){
					for($j=0;$j<count($rsData[$i]['M']);$j++){
						if($t == $rsData[$i]['M'][$j]['date']){
							array_push($MArray,$rsData[$i]['M'][$j]['avg']);
						}
					}
					for($j=0;$j<count($rsData[$i]['F']);$j++){
						if($t == $rsData[$i]['F'][$j]['date']){
							array_push($FArray,$rsData[$i]['F'][$j]['avg']);
						}
					}
				}
				
				$reData['M'][$t] = dataCompute($MArray);
				$reData['F'][$t] = dataCompute($FArray);
				$MList[$t] = $reData['M'][$t]['avg'];
				$FList[$t] = $reData['F'][$t]['avg'];
			}
			
			//构造绘图所需的数据
			$m_str = implode(',',$MList);
			$f_str = implode(',',$FList);
			$t_str = implode(',',$DateList);
			$reData['m_str'] = $m_str;
			$reData['f_str'] = $f_str;
			$reData['t_str'] = $t_str;
			$reData['dateCount'] = $indexCountMax;
			
		}//if over
		
		//注$rsData是每个品系的平均值等，$reData是所有品系按天数计算的平均值等
		return array('rs'=>$rsData,'re'=>$reData);
	}
	
	//数据处理，分品系、分性别计算平均值，标准差,针对单值属性
	private function mouseDP($dataList,$index){
		//构造返回数据的结构，一维表示strain，二维表示性别，M和F
		$reData = null;
		$MList = array();
		$FList = array();
		$StrainList = array();
		if($dataList != null){
				//第一次循环，循环所有的strain
			for($i=0;$i<count($dataList);$i++){
				//第二次循环，将雌雄分开
				$M = array();
				$F = array();
				for($j=0;$j<count($dataList[$i]);$j++){
					if(trim($dataList[$i][$j]['gender']) == 'M'){
						array_push($M,$dataList[$i][$j][$index]);
					}
					if(trim($dataList[$i][$j]['gender']) == 'F'){
						array_push($F,$dataList[$i][$j][$index]);
					}
				}
				$reData[$i]['M'] = dataCompute($M);
				if($reData[$i]['M'] != null){
					array_push($MList,$reData[$i]['M']['avg']);
				}else{
					array_push($MList,0);
				}
				$reData[$i]['F'] = dataCompute($F);
				if($reData[$i]['F'] != null){
					array_push($FList,$reData[$i]['F']['avg']);
				}else{
					array_push($FList,0);
				}
				array_push($StrainList,$dataList[$i][0]['strain']);
			}
		}
		
		//构造绘图所需的数据
		$m_str = implode(',',$MList);
		$f_str = implode(',',$FList);
		$s_str = implode(',',$StrainList);
		$reData['m_str'] = $m_str;
		$reData['f_str'] = $f_str;
		$reData['s_str'] = $s_str;
		return $reData;
	}
	
	//根据选定的指标和品系后的老鼠的属性
	private function getMouseData($data,$sindex){
		$mouseDataList = null;
		$strainList = array();
		$str1 = str_replace('，', ',', $data['selectStrain']);
		$strainList = explode(',', $str1);
		$sidarray = '(\''.implode('\',\'', $strainList).'\')';
	
		$index = $sindex['index'];
		$str2 = explode('_', $sindex['index']);
		$tab = $str2[0];
		$returnData = array();
		$count = count($strainList);
		//单值情况下的查询
		if($sindex['type'] != '2'){
			//单值数据
			$model = new Model();
			$mouseList = $model->table('t_mouse m,t_'.$tab.' s')
				->where('m.mouse_num = s.mouse_num and m.strain in'.$sidarray)
				->field('m.*,s.'.$index)
				->order('m.create_time desc')
				->select();
				
			for($i=0;$i<count($mouseList);$i++){
				$id = array_search($mouseList[$i]['strain'],$strainList);
				$temp = count($returnData[$id]);
				$returnData[$id][$temp]=$mouseList[$i];
			}
		}
		
		//多值情况下的查询,******************************************myerror
		if($sindex['type'] == '2'){
			//多值数据
			$mouseList = M('mouse')->where('strain in'.$sidarray)->order('create_time desc')->select();
			$mouse_count = count($mouseList);
			for($i=0;$i<$mouse_count;$i++){
				$mouse_num = $mouseList[$i]['mouse_num'];
				$sindexList = M('sindex')->where(array('mouse_num'=>$mouse_num,'index'=>$index))->order('date asc')->select();
				for($j=0;$j<count($sindexList);$j++){
					$mouseList[$i][$j]['value'] = $sindexList[$j]['value'];
					$mouseList[$i][$j]['date'] = $sindexList[$j]['date'];
				}
			}
			for($i=0;$i<count($mouseList);$i++){
				$id = array_search($mouseList[$i]['strain'],$strainList);
				$temp = count($returnData[$id]);
				$returnData[$id][$temp]=$mouseList[$i];
			}
		}
		
		return array('count'=>$count,'returnData'=>$returnData);
		
	}
	
	
	public function getSindex($findex_id){
		$findex = M('findex')->where(array('findex_id'=>$findex_id))->find();
	
		$sindexMap['is_able'] = 1;
		$sindexMap['index'] = array('like',$findex['table'].'%');
		$sindexList = M('index_map')->where($sindexMap)->select();
		return $sindexList;
	}
	
	public function getDetailData(){
		$data = array(
			'findex_id' => I('findex_id'),
			'map_id' => I('map_id'),
			'strain_name' => I('strain_name')
		);
		$selectStrain = str_replace(', ', ',', $data['strain_name']);
		$selectStrain = urlReplace($selectStrain);
		$this->redirect('Home/Strain/showDetailByStrain',array('map_id'=>$data['map_id'],'findex_id'=>$data['findex_id'],'selectStrain'=>$selectStrain));
	}
}

?>