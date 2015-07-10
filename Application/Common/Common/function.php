<?php
	function p($array) {
		dump ( $array, 1, '<pre>', 0 );
	}
	
	function urlReplace($url){
		$url = str_replace('/', '%2F', $url);
		$url = str_replace('+', '%2B', $url);
		$url = str_replace('?', '%3F', $url);
		$url = str_replace('=', '%3D', $url);
 		return $url;
	}
	
	function urlUnReplace($url){
		$url = str_replace('%2F', '/', $url);
		$url = str_replace('%2B', '+', $url);
		$url = str_replace('%3F', '?', $url);
		$url = str_replace('%3D', '=', $url);
 		return $url;
	}
	
	function dataCompute($data){
		$rs = null;
		$avg = null;
		$std = null;
		$sd = null;
		$n = 0;
		$sum = 0;
		$total_var = 0;
		
		if(count($data) != 0){
			//step1 计算平均值和有效数据个数
			for($i=0;$i<count($data);$i++){
				if($data[$i] != null && $data[$i] != ''){
					$n++;
					$sum += $data[$i];
				}
			}
			$avg = $sum/$n;
			
			//step2 计算std和sd
			for($i=0;$i<count($data);$i++){
				if($data[$i] != null && $data[$i] != ''){
					$total_var += pow( ($data[$i] - $avg), 2 );
				}
			}
			
			if($n > 1){
				$sd = $total_var / ($n - 1 );
				$std = sqrt($sd);
			}else if($n == 1){
				$sd = 0;
				$std = 0;
			}
			
			$rs = array(
				'n' => $n,
				'avg' => $avg,
				'sd' => $sd,
				'std' => $std
			);
		}
		
		return $rs;
	}
	
	
	function unescape($str){ 
		$ret = ''; 
		$len = strlen($str); 
		for ($i = 0; $i < $len; $i++){ 
		if ($str[$i] == '%' && $str[$i+1] == 'u'){ 
		$val = hexdec(substr($str, $i+2, 4)); 
		if ($val < 0x7f) $ret .= chr($val); 
		else if($val < 0x800) $ret .= chr(0xc0|($val>>6)).chr(0x80|($val&0x3f)); 
		else $ret .= chr(0xe0|($val>>12)).chr(0x80|(($val>>6)&0x3f)).chr(0x80|($val&0x3f)); 
		$i += 5; 
		} 
		else if ($str[$i] == '%'){ 
		$ret .= urldecode(substr($str, $i, 3)); 
		$i += 2; 
		} 
		else $ret .= $str[$i]; 
		} 
		return $ret; 
	} 
	
	
?>
