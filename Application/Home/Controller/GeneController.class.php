<?php
namespace Home\Controller;
use Think\Controller;

class GeneController extends Controller {
	
	public function showGene(){
		$data=M('gene')->select();
		$this->index=M('index_gene')->select();
		$this->assign('data',$data)->display();
	}
	
}
