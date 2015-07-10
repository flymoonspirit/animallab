<?php
namespace Home\Controller;
use Think\Controller;

class LoginCommonController extends Controller {

	public function _initialize(){
		if(!isset($_SESSION['user']) || $_SESSION['user']['limits'] != 1){
			$this->redirect('Home/Index/login');
		}
	}
	
}
?>
