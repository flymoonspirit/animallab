<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {
    	
    public function index(){
    	$hIndexList = $this->getHomeIndex();
		$strainList = $this->getAllStrains();
		$this->strainList = $strainList;
		$this->hIndexlist = $hIndexList;
        $this->display();
    }
	
	public function login(){
		session(null);
		$this->display();
	}
	
	public function userLogin(){
		if (! IS_POST) halt( "页面不存在" );
		
		$data = array(
			'username' => I('username'),
			'password' => I('password')
		);
		
		if($data['username'] == "" || $data['password'] == ""){
			$this->ajaxReturn(array('status'=>'0','json'));
		}
		
		$result = M('user')->where($data)->find();
		
		if($result != null){
			//将用户信息，存入session
			session('user',$result);
			if($result['limits'] == 0){
				//进入前台
				$this->ajaxReturn(array('status'=>'1','json'));
			}else if($result['limits'] == 1){
				//进入后台
				$this->ajaxReturn(array('status'=>'2','json'));
			}
		}else{
			$this->ajaxReturn(array('status'=>'0'),'json');
		}
	}
	
	public function userLoginOut(){
		session(null);
		$this->redirect('Home/Index/login');
	}
	
	private function getHomeIndex(){
		$hIndexList = M('findex')->where('is_able=1')->select();
		for($i=0;$i<count($hIndexList);$i++){
			$sIndexMap['is_able'] = 1;
			$sIndexMap['index'] = array('like',$hIndexList[$i]['table'].'%');
			$sIndexList = M('index_map')->where($sIndexMap)->limit(2)->select();
			for($j=0;$j<count($sIndexList);$j++){
				if($sIndexList[$j]['unit'] != null && $sIndexList[$j]['unit'] != ''){
					$hIndexList[$i][$j] = $sIndexList[$j]['name'].' ('.$sIndexList[$j]['unit'].')';
				}else{
					$hIndexList[$i][$j] = $sIndexList[$j]['name'];
				}
			}
		}
		return $hIndexList;
	}
	
	private function getAllStrains(){
		$strainList = M('mouse')->distinct('strain')->getField('strain',true);
		return $strainList;
	}
}

?>