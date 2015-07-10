<?php
namespace Home\Controller;
use Think\Controller;

class DataController extends LoginCommonController {
	//指标管理
	public function indexManage() {
			$this -> display();
	}
	
	public function getAllIndex(){
		$index_id = I ('id','-1');
		$index_tab = null;
		$rs = explode('_',$index_id);
		if($rs[0] == 'f'){
			$tab_sql = array(
				'findex_id' => $rs[1]
			);
			$index_tab = M('findex')->where($tab_sql)->getField('table',1);
		}
		if ($index_id == '-1') {
			//查询一级指标
			$total = M('findex')->order('is_able desc')->count();
			$findexList = M('findex')->order('is_able desc')->select();
			$items = array ();
			foreach ($findexList as $row) {
				$temp ['index_id'] = 'f_'.$row ['findex_id'];
				$temp ['index_name'] = $row ['findex_name'];
				$temp ['table'] = $row ['table'];
				$temp ['is_able'] = $row ['is_able'];
				$temp ['remark'] = $row ['remark'];
				$temp ['type'] = 'f';
				$temp ['unit'] = '---';
				$temp ['state'] = 'closed';
				array_push ($items, $temp);
			}
			$indexList = array('total'=>$total,'rows'=>$items);
		} else {
			//查询二级指标
			$sindexListMap['index'] = array('like',$index_tab.'%');
			$sindexList = M('index_map')->where($sindexListMap)->order('is_able desc')->select();
			$items = array ();
			foreach ($sindexList as $row) {
				$temp ['index_id'] = 's_'.$row ['map_id'];
				$temp ['index_name'] = $row ['name'];
				$temp ['table'] = null;
				$temp ['is_able'] = $row ['is_able'];
				$temp ['remark'] = $row ['remark'];
				$temp ['type'] = 's';
				$temp ['unit'] = $row ['unit'];;
				$temp ['state'] = 'open';
				array_push ($items, $temp);
			}
			$indexList = $items;
		}
		$this->ajaxReturn($indexList,'json');
	}
	
	public function setIndex(){
		if(!IS_POST){
			halt('Sorry,页面不存在！');
		}
		$data = array(
			'index_id' => I('index_id'),
			'is_able' => I('is_able'),
			'op' => I('op')
		);
		$rs = explode('_',$data['index_id']);
		if($rs[0] == 'f'){
			//设定一级指标
			$sqlMap = array(
					'findex_id' => $rs[1]
			); 
			if($data['op'] == 'close'){
				D('findex')->where($sqlMap)->setField('is_able',0);
				$this->ajaxReturn(array('is_able'=>0),'json');
			}else if($data['op'] == 'open'){
				D('findex')->where($sqlMap)->setField('is_able',1);
				$this->ajaxReturn(array('is_able'=>1),'json');
			}
		}
		if($rs[0] == 's'){
			//设定二级指标
			$sqlMap = array(
					'map_id' => $rs[1]
			); 
			if($data['op'] == 'close'){
				D('index_map')->where($sqlMap)->setField('is_able',0);
				$this->ajaxReturn(array('is_able'=>0),'json');
			}else if($data['op'] == 'open'){
				D('index_map')->where($sqlMap)->setField('is_able',1);
				$this->ajaxReturn(array('is_able'=>1),'json');
			}
		}
		
	}
	
	public function modifyIndex(){
		$data = array(
			'index_id' => I('index_id'),
			'name' => I('name'),
			'remark' => I('remark'),
			'unit' => I('unit')
		);
		$rs = explode('_',$data['index_id']);
		if($rs[0] == 'f'){
			$findexMap = array(
				'findex_id' => $rs[1],
				'findex_name' => $data['name'],
				'remark' => $data['remark']
			);
			D('findex')->save($findexMap);
			$this->ajaxReturn(array('status'=>'1'),'json');
		}
		if($rs[0] == 's'){
			$indexMap = array(
				'map_id' => $rs[1],
				'name' => $data['name'],
				'remark' => $data['remark'],
				'unit' => $data['unit']
			);
			D('index_map')->save($indexMap);
			$this->ajaxReturn(array('status'=>'1'),'json');
		}
		
	}
	
	//2222**************************************************************************************************

	//进入单值指标管理页面
	public function dataManage() {
		$this -> display();

	}
	//得到所有基本指标数据
	public function getAllMouse(){
		if(!IS_GET){
			halt("Sorry,页面不存在！");
		}
		
		//先查出基本指标信息，点击之后进入dataDetail页面可以查看详细指标信息
		$mouse = M('mouse');
		$pagenum = isset($_POST['page'])?intval($_POST['page']):1;
		$rowsnum = isset($_POST['page'])?intval($_POST['rows']):20;
		$sort = isset($_POST['sort'])?strval($_POST['sort']):'create_time';
		$order = isset($_POST['order'])?strval($_POST['order']):'desc';
		$total_count  = $mouse->count();
		$mouseList = $mouse->order(''.$sort.' '.$order)->limit(($pagenum-1)*$rowsnum.','.$rowsnum)->select();
		$this->ajaxReturn(array('total'=>$total_count,'rows'=>$mouseList),'json');
	}
	
	public function modifyMouseData(){
		$data = array(
			'mouse_id' => I('mouse_id'),
			'mouse_num' => I('mouse_num'),
			'strain' => I('strain'),
			'gender' => I('gender'),
			'birth_date' => I('birth_date'),
			'exp_time' => I('exp_time'),
			'remark' => I('remark')
		); 
		//第一步判断吧mouse_num有没有被改变
		$old_mouse_num = M('mouse')->where(array('mouse_id'=>$data['mouse_id']))->getField('mouse_num',1);
		if($old_mouse_num != $data['mouse_num']){
			//找到所有启用的一级指标
			$findexList = M('findex')->where(array('is_able'=>1))->getField('table',true);
			foreach($findexList as $fil){
				D($fil)->where(array('mouse_num'=>$old_mouse_num))->setField('mouse_num',$data['mouse_num']);
			}
			D('sindex')->where(array('mouse_num'=>$old_mouse_num))->setField('mouse_num',$data['mouse_num']);
			D('mouse')->save($data);
		}else{
			//老鼠编号未发生改变
			D('mouse')->save($data);
		}
		$this->redirect('Home/Data/dataManage');
	}
	
	//查看详情指标
	public function dataDetail(){
		$mouse_num = I('mouse_num');
		$this->mouse_num = $mouse_num;
		$findexList = $this->getAllFindex();
		$this->findexList = $findexList;
		$this->display();
	}
	
	//获取一级指标
	public function getAllFindex(){
		$findexList = M('findex')->where('is_able = 1')->select();
		return $findexList;
	}
	
	//获取特定老鼠的指定一级指标数据
	public function getDetaildata(){
		$data = array(
			'findex_id' => I('findex_id'),
			'mouse_num' => I('mouse_num')
		);
		$findexMap = array(
			'findex_id' => $data['findex_id']
		);
		$findex = M('findex')->where($findexMap)->find();
		//获取启用的二级指标
		$sindexmapSql['index'] = array('like',$findex['table'].'%');
		$sindexmapSql['is_able'] = array('eq','1');
		$sindexmapSql['type'] = array('neq','2');
		$sindexmap = M('index_map')->where($sindexmapSql)->select();
		//查出所有制定的二级指标数据
		$sindexListSql = array(
			'mouse_num' => $data['mouse_num']
		);
		$sindexList = M($findex['table'])->where($sindexListSql)->find();
		//过滤掉未启用的二级指标
		$sindexFilter = array();
		for($j=0;$j<count($sindexmap);$j++){
			$sindexFilter[$j][$sindexmap[$j]['index']] = $sindexList[$sindexmap[$j]['index']];
			$sindexFilter[$j]['sindex_id'] = $sindexList['sindex_id'];
			$sindexFilter[$j]['unit'] = $sindexmap[$j]['unit'];
			$sindexFilter[$j]['remark'] = $sindexmap[$j]['remark'];
		}
		
		//够造返回的数据格式
		$sindexdataList = array();
		for($i=0;$i<count($sindexFilter);$i++){
				$sindexdataList[$i] = array(
				'sindex_id' => $sindexFilter[$i]['sindex_id'],
				'mouse_num' => $data['mouse_num'],
				'name' => $sindexmap[$i]['name'],
				'index' => $sindexmap[$i]['index'],
				'value' => $sindexFilter[$i][$sindexmap[$i]['index']],
				'remark' => $sindexFilter[$i]['remark'],
				'unit' => $sindexFilter[$i]['unit']
				);
		}
		$total = count($sindexdataList);
		$this->ajaxReturn(array('total'=>$total,'rows'=>$sindexdataList),'json');
		
	}
	
	public function deleteMouseData(){
		if(!IS_POST){
			halt("页面不存在！");
		}
		
		$data = array(
			'rowdata' => I('rowdata')
		);
		$str1 = str_replace('，', ',', $data['rowdata']);
		$mouse_numList = explode(',', $str1);
		for($i=0;$i<count($mouse_numList);$i++){
			//找到所有启用的一级指标
			$findexList = M('findex')->where(array('is_able'=>1))->getField('table',true);
			foreach($findexList as $fil){
				D($fil)->where(array('mouse_num'=>$mouse_numList[$i]))->delete();
			}
			D('sindex')->where(array('mouse_num'=>$mouse_numList[$i]))->delete();
			D('mouse')->where(array('mouse_num'=>$mouse_numList[$i]))->delete();
		}
		$this->ajaxReturn(array('status'=>'1'),'json');
	}
	
	public function modifyDetailData(){
		$data = array(
			'sindex_id' => I('sindex_id'),
			'index' => I('index'),
			'name' => I('name'),
			'value' => I('value'),
			'mouse_num' => I('mouse_num')
		);
		$rs = explode('_',$data['index']);
		D($rs[0])->where(array('sindex_id'=>$data['sindex_id']))->setField($data['index'],$data['value']);
		$this->redirect('Home/Data/dataDetail',array('mouse_num'=> $data['mouse_num']));
	}
	
	public function delDetailData(){
		if(!IS_POST){
			halt("页面不存在！");
		}
		
		$data = array(
				'rowIndex' => I('rowIndex'),
				'rowId' => I('rowId')
		);
		$str1 = str_replace('，', ',', $data['rowIndex']);
		$str2 = str_replace('，', ',', $data['rowId']);
		$indexList = explode(',', $str1);
		$idList = explode(',', $str2);
		$sindexMap = array();
		$sindexMap['sindex_id'] = $idList[0];
		for($i=0;$i<count($indexList);$i++){
			$sindexMap[$indexList[$i]] = '';
		}
		$rs = explode('_',$indexList[0]);
		D($rs[0])->save($sindexMap);
		$this->ajaxReturn(array('status'=>'1'),'json');
	}
	
	//3333****************************************************************************************************
	
	//进入多值指标管理页面
	public function mDataManage() {
		$this -> display();

	}
	
	//进入多值指标数据项
	public function dataMval(){
		$mouse_num = I('mouse_num');
		$this->mouse_num = $mouse_num;
		$sindexList = $this->getMsindex();
		$this->sindexList = $sindexList;
		$this->display();
	}
	
	//指定二级多值指标后，得到对应的实验数据
	public function getMval(){
		$data = array(
			'sindex_tab' => I('sindex_tab'),
			'mouse_num' => I('mouse_num')
		);
		$dataListMap['mouse_num'] = $data['mouse_num'];
		$dataList = M($data['sindex_tab'])->where($dataListMap)->select();
		$total = M($data['sindex_tab'])->where($dataListMap)->count();
		if($dataList == null){
			$dataList = array();
		}
		$this->ajaxReturn(array('total'=>$total,'rows'=>$dataList),'json');
	}
	
	//得到二级多值指标
	private function getMsindex(){
		$sindexMap = array(
			'is_able' => 1,
			'type' => 2
		);
		$sindexList = 	M('index_map')->where($sindexMap)->select();
		return $sindexList;
	}
	
	public function addMData(){
		$data = array(
			'mouse_num' => I('mouse_num'),
			'index' => I('index'),
			'date' => I('date'),
			'value' => I('value')
		);
		D('sindex')->add($data);
		$this->ajaxReturn(array('status' => '1'));
	}
	
	public function modifyMData(){
		$data = array(
				'id' => I('id'),
				'date' => I('date'),
				'value' => I('value')
		);
		D('sindex')->save($data);
		$this->ajaxReturn(array('status' => '1'));
	}
	
	public function delMData(){
		if(!IS_POST){
			halt("页面不存在！");
		}
		
		$data = array(
				'rowdata' => I('rowdata')
		);
		$str1 = str_replace('，', ',', $data['rowdata']);
		$idList = explode(',', $str1);
		foreach ($idList as $id){
			D('sindex')->where(array('id'=>$id))->delete();
		}
		$this->ajaxReturn(array('status' => '1'));
	}
	
	//4444**************************************************************************************************
	
	//进入Excel导入数据的页面
	public function dataExcel() {
		$this -> display();

	}
	
	//导入数据
	public function insertData(){
		$excel_name = $_FILES["upfile"]['name'];
		$excelNameList = explode('.', $excel_name);
		if($excelNameList[1] != 'xls' && $excelNameList[1] != 'xlsx'){
			$this->error('请选择excel文件！');
		}
		if($excelNameList[0] == 'oneIndexdata'){
			$Excel = A('Home/Excel');
			$execl_data = $Excel->readExcel();
			//将数据写入数据库
			$rs = $this->addData($execl_data);
			if($rs == true){
				//导入成功
				$this->success("导入成功！");
			}else{
				//导入失败
				$this->error("导入失败！");
			}
		}else if($excelNameList[0] == 'mulIndexdata'){
			$Excel = A('Home/Excel');
			$execl_data = $Excel->readExcel();
			//将数据写入数据库
			$rs = $this->addMExcelData($execl_data);
			if($rs == true){
				//导入成功
				$this->success("导入成功！");
			}else{
				//导入失败
				$this->error("导入失败！");
			}
		}else{
			$this->error('导入失败，excel文件名不不合法！');
		}
		
	}
	
	//将从Excel中读出的数据写入数据库中(多值数据)
	private function addMExcelData($execl_data){
		$flag = true;
		for($i=0;$i<count($execl_data)-2;$i++){
			$sindexval = array();
			$sindexname = array();
			for($j=0;$j<count($execl_data[0]);$j++){
				$sindexval[$execl_data[0][$j]] = $execl_data[$i+2][$j];
			}
			for($m=0;$m<count($execl_data[0])-2;$m++){
				$sindexname[$m] = $execl_data[0][$m+2];
			}
			for($t=0;$t<count($sindexname);$t++){
				//构造要导入的数据
				$sindexMap = array(
					'mouse_num' => $sindexval['mouse_num'],
					'index' => $sindexname[$t],
					'date' => $sindexval['date'],
					'value' => $sindexval[$sindexname[$t]]
				);
				$mouse = M('mouse')->where(array('mouse_num'=>$sindexMap['mouse_num']))->find();
				if($mouse == null){
					$rs1 = D('mouse')->add(array('mouse_num'=>$sindexMap['mouse_num']));
					if($rs1 == false){
						$flag = false;
						return $flag;
					}
				}
				$sindexRsMap = array(
					'mouse_num' => $sindexMap['mouse_num'],
					'index' => $sindexMap['index'],
					'date' => $sindexMap['date']
				);
				$sindexRs = M('sindex')->where($sindexRsMap)->find();
				if($sindexRs == null){
					$rs2 = D('sindex')->add($sindexMap);
					if($rs2 == false){
						$flag = false;
						return $flag;
					}
				}else if($sindexRs['value'] != $sindexMap['value']){
					$rs3 = D('sindex')->where($sindexRsMap)->setField('value',$sindexMap['value']);
					if($rs3 == false){
						$flag = false;
						return $flag;
					}
				}
			}
		}
		
		return $flag;
	}
	
	//将从Excel中读出的数据写入数据库中(单值数据)
	private function addData($execl_data){
		$flag = true;
		//$execl_data是一个二维数组，$execl_data[0]中存的是数据库中的字段，$execl_data[1]中存的是对应的指标名称，且前五个和最后一个属于基本指标
		//step1  处理基本指标
		$mouseData = array();
		$count = count($execl_data);
		for($i=0;$i<$count;$i++){
			$subcount = count($execl_data[0]);
			for($j=0;$j<5;$j++){
				$mouseData[$i][$j] = $execl_data[$i][$j];
			}
			$mouseData[$i][5] = $execl_data[$i][$subcount-1];
		}
	
		//step2 处理二级指标 
		$indexList = array();
		for($i=0;$i<$count;$i++){
			$subcount = count($execl_data[0]);
			for($j=5;$j<$subcount-1;$j++){
				$indexList[$i][$j-5] = $execl_data[$i][$j];
			}
		}
		
		//存入数据库
		for($k=0;$k<$count-2;$k++){
			//存储基本指标
			$mouseMap = array();
			$submouse = count($mouseData[0]);
			for($t=0;$t<$submouse;$t++){
				$mouseMap[$mouseData[0][$t]] = $mouseData[$k+2][$t];
			}
			$mouseMap['create_time'] = date('Y-m-d H:i:s',time());
			$sql = array(
				'mouse_num' => $mouseMap['mouse_num']
			);
			$mc = M('mouse')->where($sql)->count();
			if($mc == 0){
				$rs1 = D('mouse')->data($mouseMap)->add();
				if($rs1 == false){
					$flag = false;
					return $flag;
				}
			}else{
				D('mouse')->where($sql)->save($mouseMap);
			}
			
			//存储其他指标
			$indexMap = array();
			$tabList = array();
			$subindex = count($indexList[0]);
			for($t=0;$t<$subindex;$t++){
				$str = explode('_',$indexList[0][$t]);
				$tab = $str[0];
				if(in_array($tab, $tabList) == false){
					array_push($tabList,$tab);
				}
				$indexMap[$tab][$indexList[0][$t]] = $indexList[$k+2][$t];
			}
			
			for($m=0;$m<count($tabList);$m++){
				//构造需要存储的指标
				$sindex = $indexMap[$tabList[$m]];
				$sindex['mouse_num'] = $mouseMap['mouse_num'];
				$ic = M($tabList[$m])->where($sql)->count();
				if($ic == 0){
					$rs2 = D($tabList[$m])->data($sindex)->add();
					if($rs2 == false){
						$flag = false;
						return $flag;
					}
				}else{
					D($tabList[$m])->where($sql)->save($sindex);
				}
			}
		}
		return $flag;
	}

	//下载Excel模板(单值模板)
	public function downExcelTpl(){
		//构造数据
		$data1 =array(
				'mouse_num' => 'ID',
				'strain'   => 'strain',
				'gender' => 'gender',
				'birth_date' => 'birth date',
				'exp_time' => 'experiment date'
    		);
		$sindexList = $this->getAllSindex();
		$header = array(
				array('mouse_num' ,'mouse_num'),
				array('strain'  , 'strain'),
				array('gender' , 'gender'),
				array('birth_date' , 'birth_date'),
				array('exp_time' , 'exp_time')
    		);
		if($sindexList == null){
			$data1 = $data1;
		}else{
			for($i=0;$i<count($sindexList);$i+=1){
				$temp = array($sindexList[$i]['index'],$sindexList[$i]['index']);
				array_push($header,$temp);
				if($sindexList[$i]['unit'] != null){
					$data1[$sindexList[$i]['index']] = $sindexList[$i]['name'].'('.$sindexList[$i]['unit'].')';
				}else{
					$data1[$sindexList[$i]['index']] = $sindexList[$i]['name'];
				}
			}
		}
		$data1['remark'] = 'remark';
		$data = array();
		array_push($data,$data1);
		array_push($header,array('remark','remark'));
		$Excel_name = "oneIndexdata";
		$Excel = A('Home/Excel');
		$Excel->writeExcel($header,$data,$Excel_name);
	}

	//获取有效的所有二级单值指标
	private function getAllSindex(){
		$sql = 'is_able =  1 and type != 2';
		$sindexList = M('index_map')->where($sql)->order('map_id asc')->select();
		return $sindexList;
	}
	
	//下载Excel模板(多值模板)
	public function downMExcelTpl(){
		$header = array(
				array('mouse_num' ,'mouse_num'),
				array('date' ,'date')
		);
		$data1 = array(
				'mouse_num' => 'ID',
				'date' => 'experiment time'
		);
		
		$indexmapList = M('index_map')->where(array('is_able'=>'1','type'=>'2'))->select();
		foreach ($indexmapList as $key){
			array_push($header, array($key['index'],$key['index']));
			$data1[$key['index']] = $key['name'].'('.$key['unit'].')';
		}
		$data = array();
		array_push($data,$data1);
		
		$Excel_name = "mulIndexdata";
		$Excel = A('Home/Excel');
		$Excel->writeExcel($header,$data,$Excel_name);
	}

	public function geneManage(){
		$this->index=M('index_gene')->order('id')->select();
		$this->display();
	}
//进入Excel导入基因数据的页面
	public function dataExcelGene() {
		$this -> display();
	
	}
}
?>
