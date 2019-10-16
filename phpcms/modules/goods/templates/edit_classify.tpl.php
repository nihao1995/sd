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
		<legend>分类修改</legend>
		<form action="?m=goods&c=goods&a=edit_classify&id=<?php echo $classify['id']?>" method="post">
			<table class="table_form" width="100%">
				<tr>
					<th width="15%">分类名称</th>
					<td>
						<input type="text" name="classify[name]" autocomplete="off" value="<?php echo $classify['name']?>" />
					</td>
				</tr>
				<tr>
					<th width="15%">分类类型</th>
					<td>
						<input type="radio" name="classify[type]" value="1" checked="checked" /><span>选择框</span>
						<input type="radio" name="classify[type]" value="2" /><span>多选框</span>
						<input type="radio" name="classify[type]" value="3" /><span>单选框</span>
					</td>
				</tr>
				<tr>
					<th width="15%">是否必填</th>
					<td>
						<input type="radio" name="classify[vital]" value="1" checked="checked" /><span>是</span>
						<input type="radio" name="classify[vital]" value="-1" /><span>否</span>
					</td>
				</tr>
			</table>
			<input type="submit" id="dosubmit" name="dosubmit" />
		</form>
	</fieldset>
</div>
<script src="<?php echo siteurl(get_siteid())?>/statics/layui/layui.js"></script>
<script>
	layui.use('jquery', function() {
		var $ = layui.jquery;
		$("input[type='radio'][name='classify[type]'][value='<?php echo $classify['type']?>']").attr("checked", "checked");
		$("input[type='radio'][name='classify[vital]'][value='<?php echo $classify['vital']?>']").attr("checked", "checked");
	});
</script>