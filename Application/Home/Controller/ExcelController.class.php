<?php
namespace Home\Controller;
use Think\Controller;

class ExcelController extends  LoginCommonController{
	//该类主要是处理excel
	
	public function readExcel() {
		$suffixName = $this -> getSuffixName($_FILES["upfile"]['name']);
		if ($suffixName == "0") {
			$this->error('没有发现上传的excel');
		}
		if (isset($_FILES["upfile"]) && ($_FILES["upfile"]["error"] == 0)) {
			$result = importExecl($_FILES["upfile"]["tmp_name"], $suffixName);
			if ($result["error"] == 1) {
				$execl_data = $result["data"];
			}
		}
		return $execl_data;
	}

	private function getSuffixName($filename) {
		if ($filename != '' && $filename != null) {
			$string = strrev($filename);
			$array = explode('.', $string);
			return $array[0];
		} else {
			return '0';
		}
	}

	public function writeExcel($header,$data,$Excel_name) {
    	//导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
		vendor("PHPExcel.PHPExcel");
		vendor("PHPExcel.PHPExcel.Writer.Excel5");
		vendor("PHPExcel.PHPExcel.IOFactory");

		$filename= $Excel_name;
		$headArr = $header;
		exportExcel($filename,$headArr,$data);
		
	}
}

?>
