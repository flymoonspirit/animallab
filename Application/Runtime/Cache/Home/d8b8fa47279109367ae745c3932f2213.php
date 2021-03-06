<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="/animallab1.5/Application/Home/Public/jquery-easyui/themes/default/easyui.css"/>
		<link rel="stylesheet" type="text/css" href="/animallab1.5/Application/Home/Public/jquery-easyui/themes/icon.css"/>
		<script type="text/javascript" src="/animallab1.5/Application/Home/Public/js/jquery-1.11.1.js"></script>
		<script type="text/javascript" src="/animallab1.5/Application/Home/Public/jquery-easyui/jquery.easyui.min.js"></script>
		<title>EXCEL导入基因数据</title>
		<style>
			body {
				margin: 0% auto;
				padding: 0%;
			}
			#content {
				margin: 0% auto;
				padding: 0%;
				width: 100%;
				height: 100%;
				top: 0px;
				left: 0px;
				bottom: 0px;
				position: fixed;
				min-height: 500px;
				background: url(/animallab1.5/Application/Home/Public/image/data/ex_bg.jpg);
				background-size: 100% 100%;
				overflow: hidden;
				border: 1px groove #84F708;
			}

			#main {
				margin: 0% auto;
				margin-top: 10px;
				padding: 0%;
				width: 90%;
				height: 96%;
				min-height: 450px;
				border: 1px solid #CFCFCF;
				border-radius: 5px;
				box-shadow: 0 2px 6px #EEE;
				font-family: "微软雅黑";
				background: white;
			}

			#func {
				margin: 0% auto;
				padding: 0%;
				margin-top: 15px;
				width: 90%;
				height: 150px;
				border: 1px solid #CCC;
				-moz-border-radius-bottomleft: 5px;
				-webkit-border-bottom-left-radius: 5px;
				-khtml-border-bottom-left-radius: 5px;
				border-bottom-left-radius: 5px;
				-moz-border-radius-bottomright: 5px;
				-webkit-border-bottom-right-radius: 5px;
				-khtml-border-bottom-right-radius: 5px;
				border-bottom-right-radius: 5px;
			}
			
			#remark{
				margin: 0% auto;
				padding: 0%;
				width: 90%;
				height: 38px;
				line-height: 38px;
				font-size: 12px;
				font-family: '微软雅黑';
				color:#F34148;
			}

			#using_help {
				margin: 0% auto;
				padding: 0%;
				margin-top: 8px;
				width: 90%;
				height: auto;
			}

			.help {
				margin-bottom: 10px;
				font-family: "微软雅黑";
				color: #348E00;
			}
			
			
			form{
				margin:12px;
				font-size: 15px;
			}
			
			input.file{
			    vertical-align:middle;
			    position:relative;
			    left:-230px;
			    filter:alpha(opacity=0);
			    opacity:0;
				z-index:1;
				width:230px;
				height: 32px;
			}

			form input.viewfile {
				z-index:99;
				border:1px solid #ccc;
				padding:2px;
				width:200px;
				height: 24px;
				vertical-align:middle;
				color:#999;
			}

			form p span {
				float:left;
			}

			form label.bottom {
				border:1px solid #348E00;
				background:#348E00;
				color:#fff;
				height:29px;
				line-height:29px;
				display:block;
				width:70px;
				text-align:center;
				cursor:pointer;
				float:left;
				position:relative;
				top:0px;
			}

			form input.submit {
				height: 36px;
				background:#380;
				color:#fff;
				cursor:pointer;
				display: inline-block;
				outline: none;
				cursor: pointer;
				text-align: center;
				text-decoration: none;
				font: 14px/100% Arial, Helvetica, sans-serif;
				padding: .5em 2em .55em;
				text-shadow: 0 1px 1px rgba(0,0,0,.3);
				-webkit-border-radius: .5em; 
				-moz-border-radius: .5em;
				border-radius: .5em;
				-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
				-moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
				box-shadow: 0 1px 2px rgba(0,0,0,.2);
				margin-right: 20px;
			}
			
			form input.submit:active{
				position: relative;
				top: 1px;
			}

			p.clear {
				clear:left;
				margin-top:30px;
			}

		</style>

	</head>
	<body>
		<div id="content">
			<div id="main">
				<div id="using_help">
					<h4 style="text-align: center;color: #348E00;">如何使用Excel导入数据？</h4>
					<hr style="border: 1px dashed rgba(0, 0, 0, 0.13)"/>

					<div class="help">
						第一步：点击下载按钮，下载Excel模板。
					</div>
					<div class="help">
						第二步：在Excel模板中填写数据。
					</div>
					<div class="help">
						第三步：点击导入按钮，导入Excel（请勿改变excel模板的名称）。
					</div>
				</div>
				<div id="func">
					<div>
						<form id="upExForm" action="<?php echo U('Home/UpGene/insertData','','');?>" method="post" name="upfiles" enctype="multipart/form-data">
							<p>
								<span> 
									<label for="viewfile" style="color: #348E00;">Excel数据源：</label>
									<input type="text" name="viewfile" id="viewfile" class="viewfile" />
								</span>
								<label for="upload" class="bottom">查找文件</label>
								<input type="file"  name="upfile"  accept=".xls,.xlsx"  onchange="document.getElementById('viewfile').value=this.value;" class="file" />
							</p>
							<p class="clear">
								<input id="importExcel" class="submit" type="button" value="导入数据" />
								<input id="downExcel" class="submit" type="button" value="下载单值模板" />
								
							</p>
						</form>
					</div>
				</div>
				<div id="remark">
				注：单值模板名应为：geneIndex.xls 
			</div>
			</div>
		</div>
	</body>
	<script>
		$('#downExcel').click(function(){
			$url = "<?php echo U('Home/UpGene/downExcelTpl','','');?>";
			window.location.href=$url;
		});
		
		$('#downMExcel').click(function(){
			$url = "<?php echo U('Home/Data/downMExcelTpl','','');?>";
			window.location.href=$url;
		});
		
		$('#importExcel').click(function(){
			$upfile = $('#viewfile').val().trim();
			if($upfile == "" || $upfile == null){
				$.messager.alert('警告','你没有选择文件');
				return false;
			}else{
				$('#upExForm').submit()
			}
		});
	</script>
</html>