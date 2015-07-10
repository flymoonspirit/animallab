<?php
namespace Home\Controller;
use Think\Controller;

class SurveyController extends Controller {
    public function showSurvey(){
    	$se_findex_id = I('se_findex_id');
		$this->se_findex_id = $se_findex_id;
    	$findexList = $this->getFindexList();
		$this->findexList = $findexList;
    	$this->display();
    }
    

	private function getAllStrains(){
		$strainList = M('mouse')->distinct('strain')->getField('strain',true);
		return $strainList;
	}
	
	public function getFindexList(){
		$findexList = M('findex')->where(array('is_able'=>1))->select();
		return $findexList;
	}
	
	public function getSindex(){
		$findex_id = I('findex_id');
		$findex = M('findex')->where(array('findex_id'=>$findex_id))->find();
		if($findex['remark'] == null || $findex['remark'] == ''){
			$findex['remark'] = none;
		}
		$sindexMap['is_able'] = 1;
		$sindexMap['index'] = array('like',$findex['table'].'%');
		$sindexList = M('index_map')->where($sindexMap)->select();
		for($i=0;$i<count($sindexList);$i++){
			if($sindexList[$i]['unit'] == null || $sindexList[$i]['unit'] == ''){
				$sindexList[$i]['unit'] = none;
			}
			if($sindexList[$i]['remark'] == null || $sindexList[$i]['remark'] == ''){
				$sindexList[$i]['remark'] = none;
			}
		}
		$returnData = array(
			'findex' => $findex,
			'sindexList' => $sindexList
		);
		$this->ajaxReturn($returnData);
	}
}

?>