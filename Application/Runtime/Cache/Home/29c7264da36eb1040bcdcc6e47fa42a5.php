<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.STYLE1 {
	color: #43860c;
	font-size: 12px;
}
-->
</style></head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width: 900px; table-layout:fixed;">
  <tr>
    <td height="9" style="line-height:9px; background-image:url(/animallab1.5/Application/Home/Public/image/admin/main_04.gif)"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="97" height="9" background="/animallab1.5/Application/Home/Public/image/admin/main_01.gif">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="47" background="/animallab1.5/Application/Home/Public/image/admin/main_09.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="38" height="47" background="/animallab1.5/Application/Home/Public/image/admin/main_06.gif">&nbsp;</td>
        <td width="59"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="29" background="/animallab1.5/Application/Home/Public/image/admin/main_07.gif">&nbsp;</td>
          </tr>
          <tr>
            <td height="18" background="/animallab1.5/Application/Home/Public/image/admin/main_14.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;">
              <tr>
                <td  style="width:1px;">&nbsp;</td>
                <td ><span class="STYLE1"><?php echo ($_SESSION['user']['username']); ?></span></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="155" background="/animallab1.5/Application/Home/Public/image/admin/main_08.gif">&nbsp;</td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="23" valign="bottom"><img src="/animallab1.5/Application/Home/Public/image/admin/main_12.gif" width="367" height="23" border="0" usemap="#Map" /></td>
          </tr>
        </table></td>
        <td width="200" background="/animallab1.5/Application/Home/Public/image/admin/main_11.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="11%" height="23">&nbsp;</td>
            <td width="89%" valign="bottom"><span  class="STYLE1">时间：<span id="time"></span></span></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="5" style="line-height:5px; background-image:url(/animallab1.5/Application/Home/Public/image/admin/main_18.gif)"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="180" background="/animallab1.5/Application/Home/Public/image/admin/main_16.gif"  style="line-height:5px;">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>

	<map name="Map" id="Map">
		<area shape="rect" coords="3,1,49,22" href="<?php echo U('Home/Admin/admin','','');?>" target="_parent"/>
		<area shape="rect" coords="52,2,95,21" href="javascript:history.go(-1);" target="_parent"/>
		<area shape="rect" coords="102,2,144,21" href="javascript:history.go(1);" target="_parent"/>
		<area shape="rect" coords="150,1,197,22" href="javascript:parent.location.reload();" target="_parent"/>
		<area shape="rect" coords="210,2,304,20" href="<?php echo U('Home/Sys/changePwd','','');?>"  target="center"/>
		<area shape="rect" coords="314,1,361,23" href="<?php echo U('Home/Index/userLoginout','','');?>" target="_parent"/>
	</map>
</body>
<script type="text/javascript" src="/animallab1.5/Application/Home/Public/js/jquery-1.11.1.js"></script>
<script>
	document.getElementById('time').innerHTML= new Date().getFullYear()+"-"+new Date().getMonth()+"-"+new Date().getDate()+" "+new Date().toLocaleTimeString();     
	setInterval('document.getElementById("time").innerHTML=new Date().getFullYear()+"-"+new Date().getMonth()+"-"+new Date().getDate()+" "+new Date().toLocaleTimeString();',1000);  
</script>
<script>
	
</script>
</html>