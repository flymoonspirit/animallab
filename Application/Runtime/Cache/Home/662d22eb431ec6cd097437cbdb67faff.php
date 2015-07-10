<?php if (!defined('THINK_PATH')) exit();?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理平台</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	overflow:hidden;
}
.STYLE3 {color: #528311; font-size: 12px; }
.STYLE4 {
	color: #42870a;
	font-size: 12px;
}
-->
</style>
</head>

<body>
<form id="login_form">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#e5f6cf">&nbsp;</td>
  </tr>
  <tr>
    <td height="608" background="/animallab1.5/Application/Home/Public/image/login/login_03.gif"><table width="862" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="266" background="/animallab1.5/Application/Home/Public/image/login/login_04.gif">&nbsp;</td>
      </tr>
      <tr>
        <td height="95"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="424" height="95" background="/animallab1.5/Application/Home/Public/image/login/login_06.gif">&nbsp;</td>
            <td width="183" background="/animallab1.5/Application/Home/Public/image/login/login_07.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="21%" height="30"><div align="center"><span class="STYLE3">用户</span></div></td>
                <td width="79%" height="30"><input type="text" id="username" name="username"  style="height:18px; width:130px; border:solid 1px #cadcb2; font-size:12px; color:#81b432;"/></td>
              </tr>
              <tr>
                <td height="30"><div align="center"><span class="STYLE3">密码</span></div></td>
                <td height="30"><input id="password" name="password"  type="password"  style="height:18px; width:130px; border:solid 1px #cadcb2; font-size:12px; color:#81b432;"/></td>
              </tr>
              <tr>
                <td height="30">&nbsp;</td>
                <td height="30"><img src="/animallab1.5/Application/Home/Public/image/login/dl.gif" width="81" height="22" border="0" usemap="#Map"></td>
              </tr>
            </table></td>
            <td width="255" background="/animallab1.5/Application/Home/Public/image/login/login_08.gif">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="247" valign="top" background="/animallab1.5/Application/Home/Public/image/login/login_09.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="22%" height="30">&nbsp;</td>
            <td width="56%">&nbsp;</td>
            <td width="22%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="44%" height="20">&nbsp;</td>
                <td width="56%" class="STYLE4">版本 2014V1.0 </td>
              </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#a2d962">&nbsp;</td>
  </tr>
</table>
</form>
<map name="Map"><area id="login_image" shape="rect" coords="3,3,36,19" href="javascript:userLogin();"><area id="reset_image" shape="rect" coords="40,3,78,18" href="javascript:resetForm();"></map></body>
<script type="text/javascript"  src="/animallab1.5/Application/Home/Public/js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="/animallab1.5/Application/Home/Public/layer/layer.js"></script>
<script>
	//表单重置
	function resetForm(){
		$('#login_form')[0].reset();
	}

	//表单登录
	function userLogin(){
		$username = $('#username').val();
		$password = $('#password').val();
		
		if($username == "" || $username == null){
			layer.msg('用户名不能为空！', 1, 3);
			return ;
		}else if($password == "" || $password == null){
			layer.msg('密码不能为空！', 1, 3);
			return ;
		}else{
			$.post('<?php echo U("Home/Index/userLogin","","");?>',
			{username:$username,password:$password},
			function(data){
				if(data.status == '1'){
					window.location.href = "<?php echo U('Home/Index/index','','');?>";
				}else if(data.status == '2'){
					window.location.href = "<?php echo U('Home/Admin/admin','','');?>";
				}else{
					layer.msg('用户名或密码错误！', 1, 3);
					return ;
				}
			});
		}
		
	}
	
</script>
</html>