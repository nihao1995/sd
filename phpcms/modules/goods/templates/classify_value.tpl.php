<?php include $this->admin_tpl('header', 'admin')?>
<link rel="stylesheet" href="<?php echo siteurl(get_siteid())?>/statics/layui/css/layui.css" />
<style type="text/css">
	.subnav {
		display: none;
	}
	
	.layui-table th,
	.layui-table td {
		text-align: center;
	}
</style>
<div class="pad-lr-10">
	<div class="table-list">
		<table class="layui-table" lay-size="sm">
			<colgroup>
				<col width="50%" />
				<col width="50%" />
			</colgroup>
			<thead>
				<tr>
					<th>属性名称</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($classify_values as $classify_value):?>
				<tr>
					<td>
						<?php echo $classify_value['name']?>
					</td>
					<td align="center">
						<a href="JavaScript::" onclick="edit(<?php echo $classify_value['id']?>)" class="layui-btn layui-btn-xs layui-btn-warm">修改</a>
						<a href="?m=goods&c=goods&a=delete_classify_value&id=<?php echo $classify_value['id']?>&cid=<?php echo $cid?>" onclick="return confirm('确认删除?')" class="layui-btn layui-btn-xs layui-btn-danger">删除</a>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
		<div id="pages">
			<?php echo $pages?>
		</div>
	</div>
</div>
<script src="<?php echo siteurl(get_siteid())?>/statics/layui/layui.js"></script>
<script>
	function edit(id) {
		window.top.art.dialog({
			id: 'edit',
			iframe: '?m=goods&c=goods&a=edit_classify_value&id=' + id,
			title: '属性修改',
			width: '500',
			height: '500'
		}, function() {
			var d = window.top.art.dialog({
				id: 'edit'
			}).data.iframe;
			var form = d.document.getElementById('dosubmit');
			form.click();
			return false;
		}, function() {
			window.top.art.dialog({
				id: 'edit'
			}).close()
		});
		void(0);
	}
</script>