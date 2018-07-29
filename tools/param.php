<?php
	$forum = array(
		'291'=>'车辆交易',
		'161'=>'求职招聘',
		'142'=>'房屋租赁',
		'680'=>'房屋求租',
		'305'=>'房屋交易',
		'681'=>'房屋求购',
		'681'=>'房屋求购',
		'304'=>'二手市场',
		'304'=>'二手市场'
	);
	$show = array(
		'text'=>'文本框',
		'select'=>'下拉单选',
		'checkbox'=>'多选框'
	
	);
	$con = mysql_connect("localhost","root","XZ9abRF4");
	mysql_select_db("yeeyico_new");
	mysql_query("set names gbk");
	$id = intval($_GET['id']);
	if($id>0){
		mysql_query("delete from tools_forum_filter where id=".$id);
	}
	if($_POST['doadd']){
		$fid = intval($_POST['fid']);
		$label = intval($_POST['label']);
		$name = intval($_POST['name']);
		$showtype = intval($_POST['showtype']);
		$value = intval($_POST['value']);
		$sql = "insert into tools_forum_filter(fid,label,name,showtype,value) values('".$fid."','".$label."','".$name."','".$showtype."','".$value."')";
		mysql_query($sql);
	}

	$result = mysql_query("select * from tools_forum_filter order by fid asc,id asc");
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
		<style type='text/css'>
			*{font-size:12px;}
			table{width:1000px;background:#c0c0c0;margin:50px;}
			td,th{padding:5px;background:#f5f5f5}
			input{border:1px solid #c0c0c0;height:25px;line-height:25px;}
			#data{color:red;height:250px;}
		</style>
	</head>
	<body>
		
		<table cellspacing=1 cellpadding=0>
			<tr>
				<th width="50px">编号</th>
				<th>板块</th>
				<th>参数</th>
				<th>参数名字</th>
				<th>类型</th>
				<th>值</th>
				<th>管理</th>
			</tr>
			<?php
				while($row = mysql_fetch_assoc($result)){
				extract($row);
				?>
				<tr>
					<td><?=$id?></td>
					<td><?=$forum[$fid]?></td>
					<td><?=$label?></td>
					<td><?=$name?></td>
					<td><?=$show[$showtype]?></td>
					<td><?=$value?></td>
					<td><a href='param.php?id=<?=$id?>'>删除</a></td>
				</tr>
				<?php
				}
			?>
			
			<form action='param.php' method='post' target='_blank'>
			<tr>
				<td>&nbsp;</td>
				<td><select name='fid'>
					<?php
					foreach($forum as $k=>$v){
						echo '<option value="'.$k.'">'.$v.'</option>';
					}
					?>
				</select></td>
				<td><input type='text' name='label' /></td>
				<td><input type='text' name='name' /></td>
				<td><select name='fid'>
					<?php
					foreach($showtype as $k=>$v){
						echo '<option value="'.$k.'">'.$v.'</option>';
					}
					?>
				</select></td>
				<td><input type='text' name="value" style='width:750px'/></td>
				<td><input type='submit' name='doadd' value='添加' /></td>
			</tr>
			</form>
		</table>
		
		
	</body>
</html>