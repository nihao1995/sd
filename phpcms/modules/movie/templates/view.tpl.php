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
	
	.image_box,
	.video_box {
		float: left;
		height: 80px;
		min-width: 80px;
		background-color: #F9F9F9;
	}
	
	.image_box img,
	.video_box video {
		height: 80px;
	}
</style>
<div class="pad-lr-10">
	<fieldset>
		<legend>视频查看</legend>
		<form action="" method="post">
			<table class="table_form" width="100%">
				<tr>
					<th width="15%">视频编号</th>
					<td>
						<?php echo $movie['id']?>
					</td>
				</tr>
				<tr>
					<th>用户编号</th>
					<td>
						<?php echo $movie['uid']?>
					</td>
				</tr>
				<tr>
					<th>视频标题</th>
					<td>
						<?php echo $movie['title']?>
					</td>
				</tr>
				<tr>
					<th>视频图片</th>
					<td>
						<div class="image_box">
							<img src="<?php echo $movie['thumb']?>" />
						</div>
					</td>
				</tr>
				<tr>
					<th>视频文件</th>
					<td>
						<div class="video_box">
							<video src="<?php echo $movie['filename']?>"></video>
						</div>
					</td>
				</tr>
				<tr>
					<th>上传时间</th>
					<td>
						<?php echo date("Y-m-d h:i:s", $movie['uploadtime'])?>
					</td>
				</tr>
				<tr>
					<th>修改时间</th>
					<td>
						<?php echo date("Y-m-d h:i:s", $movie['updatetime'])?>
					</td>
				</tr>
			</table>
			<input type="submit" id="dosubmit" name="dosubmit" />
		</form>
	</fieldset>
</div>
<script src="<?php echo siteurl(get_siteid())?>/statics/layui/layui.js"></script>
<script>
	layui.use(['jquery'], function() {
		var $ = layui.jquery;
		$(".image_box img").click(function() {
			window.open($(this).attr("src"));
		});
		$(".video_box video").click(function() {
			window.open($(this).attr("src"));
		});
	});
</script>