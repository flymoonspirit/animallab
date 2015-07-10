<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MDB - Gene page</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<link href="/animallab1.5/Application/Home/Public/css/Strain_showStrain.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 7]>
	<link href="/animallab1.5/Application/Home/Public/css/Index_index_ie.css" rel="stylesheet" type="text/css" />
<![endif]-->

<style>


		.table{
			width:auto;
			border:1px solid green;
			cellspacing:1px;
			background:green;
			height: auto;
			
		}
		.table td{
			width:auto;
			background:white;
			align:center;
			word-break : break-all;
			min-width:50px;
			color:black;
			
		}
	body{
	  background: #E7E7E7;
	}
	
	#next-div{
		position: fixed;
		bottom: 0px;
		right: 60px;
		width: 180px;
		height: 150px;
	}
	
	#next-div img{
		width:150px;
		height: 100px;
		
	}
	
	.select-img{
		display: none;
	}

</style>

</head>

<body style="">
  <!-- header -->
  <div id="header">
    <div class="row-1">
    	<div class="container">
      	<h1><a >Xiao's<span>Lab</span></a></h1>
        <a href="#" class="rss"><img src="/animallab1.5/Application/Home/Public/image/index/rss.jpg" alt="" /></a>
      </div>
    </div>
    <div class="row-2">
    	<div class="container">
      	<!-- .nav -->
      	<ul class="nav">
          <li class="first"><a href="<?php echo U('Home/Index/index','','');?>" >Home</a></li>
          <li><a href="<?php echo U('Home/Survey/showSurvey','','');?>" >Survey</a></li>
          <li><a href="<?php echo U('Home/Strain/showStrain','','');?>" >Strain</a></li>
          <li ><a href="<?php echo U('Home/Gene/showGene','','');?>" class="current">Gene</a></li>
          <li id="search-li" style="background: none;"><input id="searchcontent" name="searchcontent" type="text"/><input id="search-btn" type="button" value="GO"/></li>
        </ul>
      	<!-- /.nav -->
      </div>
    </div>
  </div>
  
  
  <!-- content -->
	 <div style="width: auto;margin:0 auto;height: auto;">
	 	<table class='table'>
			<?php if(is_array($index)): foreach($index as $key=>$k): ?><td><strong><?php echo ($k["name"]); ?></strong></td><?php endforeach; endif; ?>
		 	<?php if(is_array($data)): foreach($data as $key=>$v): ?><tr>
		 			
		 				<td><?php echo ($v["index_1"]); ?></td>
		 				<td><?php echo ($v["index_2"]); ?></td>
		 				<td><?php echo ($v["index_3"]); ?></td>
		 				<td><?php echo ($v["index_4"]); ?></td>
		 				<td><?php echo ($v["index_5"]); ?></td>
		 				<td><?php echo ($v["index_6"]); ?></td>
		 				<td><?php echo ($v["index_7"]); ?></td>
		 				<td><?php echo ($v["index_8"]); ?></td>
		 				<td><?php echo ($v["index_9"]); ?></td>
		 				<td><?php echo ($v["index_10"]); ?></td>
		 				<td><?php echo ($v["index_11"]); ?></td>
		 				<td><?php echo ($v["index_12"]); ?></td>
		 				<td><?php echo ($v["index_13"]); ?></td>
		 				<td><?php echo ($v["index_14"]); ?></td>
		 				<td><?php echo ($v["index_15"]); ?></td>
		 				<td><?php echo ($v["index_16"]); ?></td>
		 				<td><?php echo ($v["index_17"]); ?></td>
		 				<td><?php echo ($v["index_18"]); ?></td>
		 				<td><?php echo ($v["index_19"]); ?></td>
		 				<td><?php echo ($v["index_20"]); ?></td>
		 				<td><?php echo ($v["index_21"]); ?></td>
		 				<td><?php echo ($v["index_22"]); ?></td>
		 				<td><?php echo ($v["index_23"]); ?></td>
		 				<td><?php echo ($v["index_24"]); ?></td>
		 				<td><?php echo ($v["index_25"]); ?></td>
		 				<td><?php echo ($v["index_26"]); ?></td>
		 				<td><?php echo ($v["index_27"]); ?></td>
		 				<td><?php echo ($v["index_28"]); ?></td>
		 				<td><?php echo ($v["index_29"]); ?></td>
		 				<td><?php echo ($v["index_30"]); ?></td>
		 				<td><?php echo ($v["index_31"]); ?></td>
		 				<td><?php echo ($v["index_32"]); ?></td>
		 				<td><?php echo ($v["index_33"]); ?></td>
		 				<td><?php echo ($v["index_34"]); ?></td>
		 				<td><?php echo ($v["index_35"]); ?></td>
		 				<td><?php echo ($v["index_36"]); ?></td>
		 				<td><?php echo ($v["index_37"]); ?></td>
		 				<td><?php echo ($v["index_38"]); ?></td>
		 				<td><?php echo ($v["index_39"]); ?></td>
		 				<td><?php echo ($v["index_40"]); ?></td>
		 			
		 		</tr><?php endforeach; endif; ?>
	 	</table>
	 </div>
  
  <!-- footer -->
  <div id="footer">
  	<div class="container">
      <div class="indent">
      <div class="v">	Fly&nbsp;Moon &copy; 2014&nbsp;v1.0&nbsp;&nbsp;&nbsp;<?php echo (date('Y-m-d g:i a',time())); ?></div>
      </div>
    </div>
  </div>
</body>
</html>