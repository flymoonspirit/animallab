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
			.STYLE2 {color: #43860c; font-size: 12px; }

			a:link {font-size:12px; text-decoration:none; color:#43860c;}
			a:visited {font-size:12px; text-decoration:none; color:#43860c;}
			a:hover{font-size:12px; text-decoration:none; color:#FF0000;}
			-->
		</style>
		<script type="text/JavaScript">
			<!--
			function MM_preloadImages(){
				var d = document;
				if (d.images) {
					if (!d.MM_p)
						d.MM_p = new Array();
					var i, j = d.MM_p.length, a = MM_preloadImages.arguments;
					for ( i = 0; i < a.length; i++){
						if (a[i].indexOf("#") != 0) {
							d.MM_p[j] = new Image;
							d.MM_p[j++].src = a[i];
						}
					}
						
				}
			}

			function MM_swapImgRestore() {
				var i, x, a = document.MM_sr;
				for ( i = 0; a && i < a.length && ( x = a[i]) && x.oSrc; i++)
					x.src = x.oSrc;
			}

			function MM_findObj(n, d) {
				var p, i, x;
				if (!d)
					d = document;
				if (( p = n.indexOf("?")) > 0 && parent.frames.length) {
					d = parent.frames[n.substring(p + 1)].document;
					n = n.substring(0, p);
				}
				if (!( x = d[n]) && d.all)
					x = d.all[n];
				for ( i = 0; !x && i < d.forms.length; i++)
					x = d.forms[i][n];
				for ( i = 0; !x && d.layers && i < d.layers.length; i++)
					x = MM_findObj(n, d.layers[i].document);
				if (!x && d.getElementById)
					x = d.getElementById(n);
				return x;
			}

			function MM_swapImage(){
				var i, j = 0, x, a = MM_swapImage.arguments;
				document.MM_sr = new Array;
				for ( i = 0; i < (a.length - 2); i += 3)
					if (( x = MM_findObj(a[i])) != null) {
						document.MM_sr[j++] = x;
						if (!x.oSrc)
							x.oSrc = x.src;
						x.src = a[i + 2];
					}
			}

			//-->
		</script>
	</head>

	<body onload="MM_preloadImages('/animallab1.5/Application/Home/Public/image/admin/main_26_1.gif','/animallab1.5/Application/Home/Public/image/admin/main_29_1.gif','/animallab1.5/Application/Home/Public/image/admin/main_31_1.gif')">
		<table width="177" height="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed">
					<tr>
						<td height="26" background="/animallab1.5/Application/Home/Public/image/admin/main_21.gif">&nbsp;</td>
					</tr>
					<tr>
						<td height="80" style="background-image:url(/animallab1.5/Application/Home/Public/image/admin/main_23.gif); background-repeat:repeat-x;">
						<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td height="45">
								<div align="center">
									<a href="javascript:void(0)" onclick="manage(0);">
										<img src="/animallab1.5/Application/Home/Public/image/admin/main_26.gif" name="Image1" width="40" height="40" border="0" id="Image1" onmouseover="MM_swapImage('Image1','','/animallab1.5/Application/Home/Public/image/admin/main_26_1.gif',1)" onmouseout="MM_swapImgRestore()" />
									</a>
								</div></td>
								<td>
								<div align="center">
									<a href="javascript:void(0)" onclick="manage(1);">
										<img src="/animallab1.5/Application/Home/Public/image/admin/main_28.gif" name="Image2" width="40" height="40" border="0" id="Image2" onmouseover="MM_swapImage('Image2','','/animallab1.5/Application/Home/Public/image/admin/main_29_1.gif',1)" onmouseout="MM_swapImgRestore()" />
									</a>
								</div></td>
								<td>
								<div align="center">
									<a href="javascript:void(0)" onclick="manage(2);">
										<img src="/animallab1.5/Application/Home/Public/image/admin/main_31.gif" name="Image3" width="40" height="40" border="0" id="Image3" onmouseover="MM_swapImage('Image3','','/animallab1.5/Application/Home/Public/image/admin/main_31_1.gif',1)" onmouseout="MM_swapImgRestore()" />
									</a>
								</div></td>
							</tr>
							<tr>
								<td height="25">
								<div align="center" class="STYLE2">
									<a href="javascript:void(0)" onclick="manage(0);">
										系统管理
									</a>
								</div></td>
								<td>
								<div align="center" class="STYLE2">
									<a href="javascript:void(0)" onclick="manage(1);">
										人员管理
									</a>
								</div></td>
								<td>
								<div align="center" class="STYLE2">
									<a href="javascript:void(0)" onclick="manage(2);">
										数据管理
									</a>
								</div></td>
							</tr>
						</table></td>
					</tr>
					<tr>
						<td  style="line-height:4px; background:url(/animallab1.5/Application/Home/Public/image/admin/main_38.gif)">&nbsp;</td>
					</tr>
					<tr>
						<td id="menu_list"></td>
					</tr>
				</table></td>
			</tr>
		</table>
		<div id="menu_list1" style="display: none">
			{{#menuList}}
			<a href="javascript:getAnchor('{{type}}','{{action}}')">
			<div onmouseover="changeMenuCSS(0,this);" onmouseout="changeMenuCSS(1,this);" style="background-image: url(/animallab1.5/Application/Home/Public/image/admin/main_47.gif); height: 28px;line-height: 25px; font-size: 12px;font-weight: bold;color:#43860C; text-indent:10px;margin-top: 5px;">{{menu_name}}</div>
			</a>
			{{/menuList}}
		</div >
	</body>
	<script type="text/javascript" src="/animallab1.5/Application/Home/Public/js/jquery-1.11.1.js"></script>
	<script type="text/javascript" src="/animallab1.5/Application/Home/Public/mustache/mustache.js"></script>
	<script>
	$(function(){
		$.post('<?php echo U("Home/Menu/getMenu","","");?>',
		{type:2},
		function(data){
				var template = $('#menu_list1').html();
				var views = Mustache.render(template, data);
				$('#menu_list').html(views);
		});
	});
	
	function manage($type){
		$.post('<?php echo U("Home/Menu/getMenu","","");?>',
		{type:$type},
		function(data){
				var template = $('#menu_list1').html();
				var views = Mustache.render(template, data);
				$('#menu_list').html(views);
		});
	}
	
	function changeMenuCSS(type,obj){
		if(type == 0){
			$(obj).css("text-indent","18px");
			$(obj).css("color","#FFFFFF");
			$(obj).css("background","#78BF1B");
		}
		else if(type == 1){
			$(obj).css("text-indent","10px");
			$(obj).css("color","#43860C");
			$(obj).css("background","url(/animallab1.5/Application/Home/Public/image/admin/main_47.gif)");
		}
	}
	
	function getAnchor(type,str){
		if(type == '2'){
			var hash = '/animallab1.5/index.php/Home/Data/'+str;
		}else if(type == '1'){
			var hash = '/animallab1.5/index.php/Home/Mem/'+str;
		}else if(type == '0'){
			var hash = '/animallab1.5/index.php/Home/Sys/'+str;
		}
		 window.open(hash,'center');
	}
	
	</script>
</html>