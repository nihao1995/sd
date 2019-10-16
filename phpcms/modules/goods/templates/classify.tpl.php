<?php include $this->admin_tpl('header', 'admin')?>
<link rel="stylesheet" href="<?php echo siteurl(get_siteid())?>/statics/layui/css/layui.css" />
<style type="text/css">
	a.layui-btn:nth-child(4),
	a.layui-btn:nth-child(5) {
		margin-bottom: 0 !important;
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
				<col width="25%" />
				<col width="25%" />
				<col width="25%" />
				<col width="25%" />
			</colgroup>
			<thead>
				<tr>
					<th>分类名称</th>
					<th>分类类型</th>
					<th>是否必填</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($classifys as $classify):?>
				<tr>
					<td>
						<?php echo $classify['name']?>
					</td>
					<td>
						<?php echo $classify['type'] == 1?'选择框':($classify['type'] == 2?'多选框':'单选框')?>
					</td>
					<td>
						<?php echo $classify['vital'] == 1?'是':'否'?>
					</td>
					<td align="center">
						<div class="layui-btn-container">
							<a href="?m=goods&c=goods&a=classify_value&cid=<?php echo $classify['id']?>" class="layui-btn layui-btn-xs">查看属性</a>
							<a href="JavaScript:;" onclick="append(<?php echo $classify['id']?>)" class="layui-btn layui-btn-xs layui-btn-normal">添加属性</a><br />
							<a href="JavaScript::" onclick="edit(<?php echo $classify['id']?>)" class="layui-btn layui-btn-xs layui-btn-warm">修改分类</a>
							<a href="?m=goods&c=goods&a=delete_classify&id=<?php echo $classify['id']?>" onclick="return confirm('确认删除?')" class="layui-btn layui-btn-xs layui-btn-danger">删除分类</a>
						</div>
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
			iframe: '?m=goods&c=goods&a=edit_classify&id=' + id,
			title: '分类修改',
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

	function append(id) {
		window.top.art.dialog({
			id: 'append',
			iframe: '?m=goods&c=goods&a=add_classify_value&id=' + id,
			title: '属性添加',
			width: '500',
			height: '500'
		}, function() {
			var d = window.top.art.dialog({
				id: 'append'
			}).data.iframe;
			var form = d.document.getElementById('dosubmit');
			form.click();
			return false;
		}, function() {
			window.top.art.dialog({
				id: 'append'
			}).close()
		});
		void(0);
	}
</script>