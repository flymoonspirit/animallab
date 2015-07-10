<?php
namespace Home\Controller;
use Home\Controller\LoginCommonController;
use Think\Controller;


class UpGeneController extends LoginCommonController{
	//下载末班控制器
	public function downExcelTpl(){
		/**
		 *
		 * 导出Excel
		 * 
		 * 
		 */
		
		$rs = M('index_gene')->select();
		//p($rs);die;
		$header = array();
		$data = array();
		$dataTemp = array();
		
		for($i=0; $i<count($rs);$i++){
			//
			$temp = array($rs[$i]['index'],$rs[$i]['index']);
			array_push($header, $temp);
			
			//
			$dataTemp[$rs[$i]['index']] = $rs[$i]['name'];
		}
		array_push($data, $dataTemp);
		
		//p($data);die;
		
		
		
		$Excel_name = "geneIndex";
		$Excel = A('Home/Excel');
		$Excel->writeExcel($header,$data,$Excel_name);

	}
	
	//保存Index_gene的修改
	public function saveIndex(){
		//p($_POST);
		if(M('index_gene')->save($_POST)){
			$this->success('修改成功',U("Home/Data/geneManage"));
		}
		else 
			$this->error('修改失败！');
	}

		//更新geneIndex
	public function updateIndex(){
			//p($_GET);
			$id=I('id',0,'intval');
			$index=M('index_gene')->where(array('id'=>$id))->select();
			//P($index);die;
			$this->assign('index',$index)->display();
		}
		
		//添加index
	public function addIndex(){
		//p($_POST);
		if(M('index_gene')->add($_POST)){
			$this->success('添加成功',U("Home/Data/geneManage"));
		}
		$this->error('添加失败！');
	}
		
//上穿Excel
	public function insertData(){
		///echo 111;
		$excel_name = $_FILES["upfile"]['name'];
		$excelNameList = explode('.', $excel_name);
		if($excelNameList[1] != 'xls' && $excelNameList[1] != 'xlsx'){
			$this->error('请选择excel文件！');
		}
	
			$Excel = A('Home/Excel');
			$excel_data = $Excel->readExcel();
			
			self::inputTableGene($excel_data);
		
	}
	//把excel写成表
	public function inputTableGene($data){
			
			M('gene')->where(true)->delete();
			for($i=2;$i<count($data);$i++){
			$arr=array(
					'index_1'=>$data[$i][0],
					'index_2'=>$data[$i][1],
					'index_3'=>$data[$i][2],
					'index_4'=>$data[$i][3],
					'index_5'=>$data[$i][4],
					'index_6'=>$data[$i][5],
					'index_7'=>$data[$i][6],
					'index_8'=>$data[$i][7],
					'index_9'=>$data[$i][8],
					'index_10'=>$data[$i][9],
					'index_11'=>$data[$i][10],
					'index_12'=>$data[$i][11],
					'index_13'=>$data[$i][12],
					'index_14'=>$data[$i][13],
					'index_15'=>$data[$i][14],
					'index_16'=>$data[$i][15],
					'index_17'=>$data[$i][16],
					'index_18'=>$data[$i][17],
					'index_19'=>$data[$i][18],
					'index_20'=>$data[$i][19],
					'index_21'=>$data[$i][20],
					'index_22'=>$data[$i][21],
					'index_23'=>$data[$i][22],
					'index_24'=>$data[$i][23],
					'index_25'=>$data[$i][24],
					'index_26'=>$data[$i][25],
					'index_27'=>$data[$i][26],
					'index_28'=>$data[$i][27],
					'index_29'=>$data[$i][28],
					'index_30'=>$data[$i][29],
					'index_31'=>$data[$i][30],
					'index_32'=>$data[$i][31],
					'index_33'=>$data[$i][32],
					'index_34'=>$data[$i][33],
					'index_35'=>$data[$i][34],
					'index_36'=>$data[$i][35],
					'index_37'=>$data[$i][36],
					'index_38'=>$data[$i][37],
					'index_39'=>$data[$i][38],
					'index_40'=>$data[$i][39],

			);
			if(!M('gene')->add($arr))
				$this->error("上传失败");
		}
		$this->success();
	}

	
}
