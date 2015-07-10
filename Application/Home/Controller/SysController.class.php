<?php
namespace Home\Controller;
use Think\Controller;

class SysController extends Controller{
	public function sysInfo(){
		
		echo '该功能暂未实现！';
	}
	
	public function roleManage(){
	
		echo '该功能暂未实现！';
	}
	
	public function changePwd(){
	
		$this->display();
	}
	
	public function modifyPwd(){
		$data = array(
			'user_id' => I('user_id'),
			'user_name' => I('username'),
			'password' => I('password'),
			'newpass' => I('newpass')
		);
		$rs = M('user')->where(array('user_id'=>$data['user_id'],'password'=>$data['password']))->select();
		if($rs == null){
			$this->error('密码输入错误！');
		}else{
			D('user')->where(array('user_id'=>$data['user_id']))->setField('password',$data['newpass']);
			$_SESSION['user']['password'] = $data['newpass'];
			$this->success('恭喜你！密码修改成功');
		}
	}
}

?>