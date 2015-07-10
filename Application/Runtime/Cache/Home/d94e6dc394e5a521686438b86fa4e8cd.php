<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>指标配置</title>
		<link rel="stylesheet" type="text/css" href="/animallab1.5/Application/Home/Public/jquery-easyui/themes/default/easyui.css">
		<link rel="stylesheet" type="text/css" href="/animallab1.5/Application/Home/Public/jquery-easyui/themes/icon.css">
		<script type="text/javascript" src="/animallab1.5/Application/Home/Public/js/jquery-1.11.1.js"></script>
		<script type="text/javascript" src="/animallab1.5/Application/Home/Public/jquery-easyui/jquery.easyui.min.js"></script>
		<style>
		.modify-w{
			width: 90%;
			margin:0% auto;
			padding: 0%;
			margin-bottom: 10px;
			height: auto;
			font-family: "微软雅黑";
			font-size: 13px;
		}
		
		.modify-w label{
			line-height: 20px;
		}
		
		.modify-w input{
			border: 1px solid #95B8E7;
			width: 100%;
			height: 20px;
		}
		
		.modify-w textarea{
			border: 1px solid #95B8E7;
			width: 100%;
			height: 35px;
			
		}
		
		#modify-btn{
			font-family: "微软雅黑";
			font-size: 13px;
		}
	
	</style>
	</head>
	<body class="easyui-layout" fit="true">
		<div data-options="region:'center',border:false">
			<table  id="dg" title="动物指标列表" toolbar="#toolbar" style="width: 100%; height: 100%;"></table>
		</div>
		<!-- easyUI的工具条 -->
		<div id="toolbar">
			<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="location.reload();">刷新</a>
			<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-back" plain="true" onclick="history.go(-1);">后退</a>
		</div>
		<script type="text/javascript">
			$(function() {
				$('#dg').treegrid({
					url : "<?php echo U('Home/Data/getAllIndex','','');?>",
					singleSelect : true,
					fit : true,
					fitCloumns: true,
					collapsible : true,
					method : 'get',
					rownumbers : true,
					idField : 'index_id',
					treeField : 'index_name',
					onBeforeLoad:function(row,param){
						if(!row){
							param.id = '-1';
						}
					},
					columns : [[{
						field : 'index_name',
						title : '指标名称',
						width : 250
					}, {
						field : 'unit',
						title : '指标单位',
						sortable : true,
						width : 100
					}, {
						field : 'remark',
						title : '备注',
						width : 200
					}, {
						field : 'is_able',
						title : '是否使用',
						width : 150,
						formatter:function(val,row){
							if(val == 0){
								return '<span>未使用，  <span><a href="javascript:void(0)" onclick="openIndex(\''+row.index_id+'\',\''+val+'\',this)">启用</a></span></span>';
							}else{
								return '<span>使用中，  <span><a href="javascript:void(0)" onclick="closeIndex(\''+row.index_id+'\',\''+val+'\',this)">禁用</a></span></span>';
							}
						}
					}, {
						field : 'index_id',
						title : '操作',
						width : 150,
						formatter:function(val,row){
							return '<a id="edit'+val+'" href="javascript:void(0)" onclick="editIndex(\''+val+'\',\''+row.index_name+'\',\''+row.remark+'\',\''+row.unit+'\')">编辑</a>';
						}
					}]],
				});
			});
		</script>
		<div id="w1" class="easyui-window" class="easyui-window" title="修改一级指标" data-options="modal:true,closed:true" style="width:300px;height:217px;padding:10px;">
			<input id="fid" name="fid" value="" type="hidden"/>
			<div class="modify-w">
				<label for="name">指标名称：</label>
				<input id="name" name="name" value="" type="text"/>
			</div>
			<div class="modify-w">
				<label for="remark">备注：</label><br />
				<textarea id="remark" name="remark"></textarea>
			</div>
			<div class="modify-w">
				<a id="modify-btn" href="javascript:void(0)"  class="easyui-linkbutton" onclick="modifyIndex('f');">&nbsp;确&nbsp;定&nbsp;</a>
			</div>
		</div>
		<div id="w2" class="easyui-window" class="easyui-window" title="修改二级指标" data-options="modal:true,closed:true" style="width:300px;height:272px;padding:10px;">
			<input id="sid" name="sid" value="" type="hidden"/>
			<div class="modify-w">
				<label for="name">指标名称：</label>
				<input  id="name" name="name" value="" type="text"/>
			</div>
			<div class="modify-w">
				<label for="unit">指标单位：</label>
				<input id="unit" name="unit" value="" type="text" />
			</div>
			<div class="modify-w">
				<label for="remark">备注：</label>
				<textarea id="remark" name="remark"></textarea>
			</div>
			<div class="modify-w">
				<a id="modify-btn" href="javascript:void(0)"  class="easyui-linkbutton" onclick="modifyIndex('s');">&nbsp;确&nbsp;定&nbsp;</a>
			</div>
		</div>
	</body>
	<script>
		function modifyIndex(type){
			if(type == 'f'){
				$index_id = $('#w1 #fid').val();
				$name = $('#w1 #name').val();
				$remark = $('#w1 #remark').val();
				$.post('<?php echo U("Home/Data/modifyIndex","","");?>',
					{index_id:$index_id,name:$name,remark:$remark},
					function(data){
						if(data.status == '1'){
							window.location.reload();
						}
				});
			}
			if(type == 's'){
				$index_id = $('#w2 #sid').val();
				$name = $('#w2 #name').val();
				$remark = $('#w2 #remark').val();
				$unit = $('#w2 #unit').val();
				$.post('<?php echo U("Home/Data/modifyIndex","","");?>',
					{index_id:$index_id,name:$name,remark:$remark,unit:$unit},
					function(data){
						if(data.status == '1'){
							window.location.reload();
						}
				});
			}
		}
	
	
		function editIndex(index_id,index_name,remark,unit){
			if(remark == 'null' ){
				remark = '';
			}
			if(unit == 'null' ){
				unit = '';
			}
			$rs = index_id.split('_');
			if($rs[0] == 'f'){
				$('#w1 #name').val(index_name);
				$('#w1 #remark').html(remark);
				$('#w1 #fid').val(index_id);
				$('#w1').window('open');
				$('#w1 #name').focus();
			}
			if($rs[0] == 's'){
				$('#w2 #name').val(index_name);
				$('#w2 #unit').val(unit);
				$('#w2 #remark').html(remark);
				$('#w2 #sid').val(index_id);
				$('#w2').window('open');
				$('#w2 #name').focus();
			}
		}
		
		function openIndex(index_id,is_able,obj){
			$.post('<?php echo U("Home/Data/setIndex","","");?>',
				{index_id:index_id,is_able:is_able,op:'open'},
				function(data){
					$html = '使用中，  <span><a href="javascript:void(0)" onclick="closeIndex(\''+index_id+'\',\''+data.is_able+'\',this)">禁用</a></span>';
					$(obj).parent('span').parent('span').html($html);
			});
		}
		
		function closeIndex(index_id,is_able,obj){
			$.post('<?php echo U("Home/Data/setIndex","","");?>',
				{index_id:index_id,is_able:is_able,op:'close'},
				function(data){
					$html = '未使用，  <span><a href="javascript:void(0)" onclick="openIndex(\''+index_id+'\',\''+data.is_able+'\',this)">启用</a></span>';
					$(obj).parent('span').parent('span').html($html);
			});
		}
	</script>
</html>