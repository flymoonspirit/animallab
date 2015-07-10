<?php

function importExecl($filename,$suffixName) {
	if (!file_exists($filename)) {
		return array("error" => 0, 'message' => 'file not found!');
	}
	//创建PHPExcel对象
	Vendor("PHPExcel.PHPExcel.IOFactory");
	$PHPExcel = new PHPExcel();
	//如果excel文件后缀名为.xls，导入这个类
	Vendor("PHPExcel.PHPExcel.IOFactory");
	$PHPReader = PHPExcel_IOFactory::createReader('Excel5');
	if($suffixName == "slx"){
		$PHPReader = PHPExcel_IOFactory::createReader('Excel5');
	}
	if($suffixName == "xslx"){
		$PHPReader = PHPExcel_IOFactory::createReader('Excel2007');
	}
	
	try {
		//载入文件
		$PHPExcel = $PHPReader -> load($filename);
	} catch(Exception $e) {
	}
	if (!isset($PHPExcel))
		return array("error" => 0, 'message' => 'read error!');
	
	//获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
	$currentSheet = $PHPExcel -> getSheet(0);
	//获取总列数
	$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
        'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
		'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ');
	$allColumn = $currentSheet -> getHighestColumn();
	//获取总行数
	$allRow = $currentSheet -> getHighestRow();
	//循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
	for ($currentRow = 1; $currentRow <= $allRow; $currentRow++) {
		//从哪列开始，A表示第一列
		for ($currentColumn = 0; $currentColumn <= count($cellName); $currentColumn++) {
			//数据坐标
			$address = $cellName[$currentColumn] . $currentRow;
			//读取到的数据，保存到数组$arr中
			$arr[$currentRow-1][$currentColumn] = $currentSheet -> getCell($address) -> getValue();
			if($allColumn == $cellName[$currentColumn]){
				break;
			}else{
				continue;
			}
		}

	}
	return array("error"=>1,"data"=>$arr); 
}

function exportExcel($filename,$expCellName,$expTableData){
		$xlsTitle = iconv('utf-8', 'gb2312', $filename);//文件名称
        $fileName = iconv("utf-8", "gb2312", './Updata/'.$filename.'.xls');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("PHPExcel.PHPExcel");
        $objPHPExcel = new PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
        'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
		'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ');
        
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]); 
        } 
        // Miscellaneous glyphs, UTF-8   
        for($i=0;$i<$dataNum;$i++){
          for($j=0;$j<$cellNum;$j++){
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $expTableData[$i][$expCellName[$j][0]]);
          }             
        }  
        
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$filename.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save($fileName);
        $objWriter->save('php://output'); 
        exit;  
}

?>
