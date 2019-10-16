<?php include $this->admin_tpl('header', 'admin')?>
<link rel="stylesheet" href="<?php echo siteurl(get_siteid())?>/statics/layui/css/layui.css" />
<style type="text/css">
	.subnav {
		display: none;
	}
	
	.search-form {
		margin-top: 10px;
	}
	
	a.layui-btn {
		margin-bottom: 10px;
	}
	
	a.layui-btn:last-child {
		margin-bottom: 0;
	}
	
	.layui-table th,
	.layui-table td {
		text-align: center;
	}
	
	form input[name="id"],
	form input[name="uid"] {
		width: 100px;
	}
	
	form input[name="uploadtime"],
	form input[name="updatetime"] {
		width: 180px;
	}
</style>
<div class="pad-lr-10">
	<div class="explain-col search-form">
		<form action="?m=goods&c=goods&a=init" method="post">
			<span>商品编号</span>
			<input type="text" name="id" value="<?php echo $_POST['id']?>" autocomplete="off" />
			<span>用户编号</span>
			<input type="text" name="uid" value="<?php echo $_POST['uid']?>" autocomplete="off" />
			<span>商品标题</span>
			<input type="text" name="title" value="<?php echo $_POST['title']?>" autocomplete="off" />
			<span>上传时间</span>
			<input type="text" name="uploadtime" value="<?php echo $_POST['uploadtime']?>" autocomplete="off" />
			<span>修改时间</span>
			<input type="text" name="updatetime" value="<?php echo $_POST['updatetime']?>" autocomplete="off" />
			<input type="submit" value="搜索" class="layui-btn layui-btn-xs" />
		</form>
	</div>
	<div class="table-list">
		<table class="layui-table" lay-size="sm">
			<colgroup>
				<col width="7.5%" />
				<col width="7.5%" />
				<col width="15%" />
				<col width="15%" />
				<col width="12.5%" />
				<col width="12.5%" />
				<col width="7.5%" />
				<col width="7.5%" />
				<col width="7.5%" />
				<col width="7.5%" />
			</colgroup>
			<thead>
				<tr>
					<th>商品编号</th>
					<th>用户编号</th>
					<th>商品标题</th>
					<th>商品图片</th>
					<th>上传时间</th>
					<th>修改时间</th>
					<th>市场价</th>
					<th>零售价</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($goodss as $goods):?>
				<tr>
					<td>
						<?php echo $goods['id']?>
					</td>
					<td>
						<?php echo $goods['uid']?>
					</td>
					<td>
						<?php echo $goods['title']?>
					</td>
					<td>
						<img src="<?php echo $goods['thumb']?>" />
					</td>
					<td>
						<?php echo date("Y-m-d h:i:s", $goods['uploadtime'])?>
					</td>
					<td>
						<?php echo date("Y-m-d h:i:s", $goods['updatetime'])?>
					</td>
					<td>
						<?php echo $goods['fake_price']?>
					</td>
					<td>
						<?php echo $goods['real_price']?>
					</td>
					<td>
						<?php echo $goods['sale'] == 1?'已上架':'未上架'?>
					</td>
					<td>
						<?php if($goods['sale'] == -1):?>
						<a href="?m=goods&c=goods&a=status&id=<?php echo $goods['id']?>&status=1" onclick="return confirm('确认上架?')" class="layui-btn layui-btn-xs">上架</a><br />
						<?php endif;?>
						<?php if($goods['sale'] == 1):?>
						<a href="?m=goods&c=goods&a=status&id=<?php echo $goods['id']?>&status=-1" onclick="return confirm('确认下架?')" class="layui-btn layui-btn-xs">下架</a><br />
						<?php endif;?>
						<a href="JavaScript:;" onclick="edit(<?php echo $goods['id']?>)" class="layui-btn layui-btn-xs layui-btn-warm">修改</a><br />
						<a href="JavaScript:;" onclick="view(<?php echo $goods['id']?>)" class="layui-btn layui-btn-xs layui-btn-normal">查看</a><br />
						<a href="?m=goods&c=goods&a=delete&id=<?php echo $goods['id']?>" onclick="return confirm('确认删除?')" class="layui-btn layui-btn-xs layui-btn-danger">删除</a>
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
	layui.use(['jquery', 'laydate'], function() {
		var $ = layui.jquery;
		var laydate = layui.laydate;
		laydate.render({
			elem: "input[name='uploadtime']",
			range: true
		});
		laydate.render({
			elem: "input[name='updatetime']",
			range: true
		});
	});
</script>
<script>
	function edit(id) {
		window.top.art.dialog({
			id: 'edit',
			iframe: '?m=goods&c=goods&a=edit&id=' + id,
			title: '商品修改',
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

	function view(id) {
		window.top.art.dialog({
			id: 'view',
			iframe: '?m=goods&c=goods&a=view&id=' + id,
			title: '商品详情',
			width: '500',
			height: '500'
		}, function() {
			var d = window.top.art.dialog({
				id: 'view'
			}).data.iframe;
			var form = d.document.getElementById('dosubmit');
			form.click();
			return false;
		}, function() {
			window.top.art.dialog({
				id: 'view'
			}).close()
		});
		void(0);
	}
</script>