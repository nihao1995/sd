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
		<legend>属性添加</legend>
		<form action="?m=goods&c=goods&a=add_classify_value" method="post">
			<table class="table_form" width="100%">
				<tr>
					<th width="15%">属性名称</th>
					<td>
						<input type="text" name="classify_value[name]" autocomplete="off" />
					</td>
				</tr>
			</table>
			<input type="hidden" name="classify_value[cid]" value="<?php echo $_GET['id']?>" />
			<input type="submit" id="dosubmit" name="dosubmit" />
		</form>
	</fieldset>
</div>
<script src="<?php echo siteurl(get_siteid())?>/statics/layui/layui.js"></script>