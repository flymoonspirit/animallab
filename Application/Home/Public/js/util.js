//1. + URL 中+号表示空格 %2B 
//2. 空格 URL中的空格可以用+号或者编码 %20 
//3. / 分隔目录和子目录 %2F 
//4. ? 分隔实际的 URL 和参数 %3F 
//5. % 指定特殊字符 %25 
//6. # 表示书签 %23 
//7. & URL 中指定的参数间的分隔符 %26 
//8. = URL 中指定参数的值 %3D 

function urlReplace($url){
	$url=$url.replace(/\//g,"%2F");
 	$url=$url.replace(/\+/g,"%2B");
 	$url=$url.replace(/\?/g,"%3F");
 	$url=$url.replace(/\=/g,"%3D");
 	return $url;
}
