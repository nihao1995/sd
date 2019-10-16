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
		<form action="?m=movie&c=movie&a=init" method="post">
			<span>视频编号</span>
			<input type="text" name="id" value="<?php echo $_POST['id']?>" autocomplete="off" />
			<span>用户编号</span>
			<input type="text" name="uid" value="<?php echo $_POST['uid']?>" autocomplete="off" />
			<span>视频标题</span>
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
				<col width="10%" />
				<col width="10%" />
				<col width="20%" />
				<col width="15%" />
				<col width="15%" />
				<col width="15%" />
				<col width="15%" />
			</colgroup>
			<thead>
				<tr>
					<th>视频编号</th>
					<th>用户编号</th>
					<th>视频标题</th>
					<th>视频图片</th>
					<th>上传时间</th>
					<th>修改时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($movies as $movie):?>
				<tr>
					<td>
						<?php echo $movie['id']?>
					</td>
					<td>
						<?php echo $movie['uid']?>
					</td>
					<td>
						<?php echo $movie['title']?>
					</td>
					<td>
						<img src="<?php echo $movie['thumb']?>" />
					</td>
					<td>
						<?php echo date("Y-m-d h:i:s", $movie['uploadtime'])?>
					</td>
					<td>
						<?php echo date("Y-m-d h:i:s", $movie['updatetime'])?>
					</td>
					<td>
						<a href="JavaScript:;" class="layui-btn layui-btn-xs" onclick="edit(<?php echo $movie['id']?>)">修改</a><br />
						<a href="JavaScript:;" class="layui-btn layui-btn-xs layui-btn-normal" onclick="view(<?php echo $movie['id']?>)">查看</a><br />
						<a href="?m=movie&c=movie&a=delete&id=<?php echo $movie['id']?>" class="layui-btn layui-btn-xs layui-btn-danger" onclick="return confirm('确认删除?')">删除</a>
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
			iframe: '?m=movie&c=movie&a=edit&id=' + id,
			title: '视频修改',
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
			iframe: '?m=movie&c=movie&a=view&id=' + id,
			title: '视频详情',
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