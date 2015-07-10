<?php
namespace Home\Controller;
use Think\Controller;

class MenuController extends LoginCommonController{
			
		function getMenu(){
			$data = array(
				'type' => I('type')
			);
			
			$menuList = M('menu')->where($data)->order('menu_order asc')->select();
			$this->ajaxReturn(array('menuList'=>$menuList),'json');
		}
		
}

?>
