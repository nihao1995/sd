<?php include $this->admin_tpl('header', 'admin')?>
<link rel="stylesheet" href="<?php echo siteurl(get_siteid())?>/statics/layui/css/layui.css" />
<style type="text/css">
	.subnav,
	input[type="submit"] {
		display: none;
	}
	
	.table_form th {
		text-align: left;
	}
</style>
<div class="pad-lr-10">
	<fieldset>
		<legend>属性修改</legend>
		<form action="?m=goods&c=goods&a=edit_classify_value&id=<?php echo $classify_value['id']?>" method="post">
			<table class="table_form" width="100%">
				<tr>
					<th width="15%">属性名称</th>
					<td>
						<input type="text" name="classify_value[name]" autocomplete="off" value="<?php echo $classify_value['name']?>" />
					</td>
				</tr>
			</table>
			<input type="submit" id="dosubmit" name="dosubmit" />
		</form>
	</fieldset>
</div>
<script src="<?php echo siteurl(get_siteid())?>/statics/layui/layui.js"></script>