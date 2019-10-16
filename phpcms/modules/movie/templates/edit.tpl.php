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
		<legend>视频修改</legend>
		<form action="?m=movie&c=movie&a=edit&id=<?php echo $movie['id']?>" method="post" enctype="multipart/form-data">
			<table class="table_form" width="100%">
				<tr>
					<th width="15%">视频标题</th>
					<td>
						<input type="text" name="movie[title]" autocomplete="off" value="<?php echo $movie['title']?>" />
					</td>
				</tr>
				<tr>
					<th width="15%">视频图片</th>
					<td>
						<div class="image_box">
							<img src="<?php echo $movie['thumb']?>" />
							<input type="hidden" name="movie[thumb]" value="<?php echo $movie['thumb']?>" />
						</div>
					</td>
				</tr>
				<tr>
					<th width="15%">视频文件</th>
					<td>
						<div class="video_box">
							<video src="<?php echo $movie['filename']?>"></video>
							<input type="hidden" name="movie[filename]" value="<?php echo $movie['filename']?>" />
						</div>
					</td>
				</tr>
			</table>
			<input type="submit" id="dosubmit" name="dosubmit" />
		</form>
	</fieldset>
</div>
<script src="<?php echo siteurl(get_siteid())?>/statics/layui/layui.js"></script>
<script>
	layui.use(['jquery', 'upload', 'layer'], function() {
		var $ = layui.jquery;
		var layer = layui.layer;
		var upload = layui.upload;
		/*图片上传*/
		upload.render({
			elem: ".image_box",
			url: "?m=movie&c=movie&a=upload&pc_hash=<?php echo $_SESSION['pc_hash']?>",
			size: 2 * 1024,
			accept: "images",
			acceptMime: "image/*",
			done: function(res) {
				$(".image_box img").attr("src", res.filename);
				$(".image_box input").val(res.filename);
				layer.closeAll("loading");
				alert("图片上传成功");
			},
			error: function() {
				layer.closeAll("loading");
				alert("图片上传失败");
			}
		});
		/*视频上传*/
		upload.render({
			elem: ".video_box",
			url: "?m=movie&c=movie&a=upload&pc_hash=<?php echo $_SESSION['pc_hash']?>",
			size: 200 * 1024,
			accept: "video",
			acceptMime: "video/*",
			done: function(res) {
				$(".video_box video").attr("src", res.filename);
				$(".video_box input").val(res.filename);
				layer.closeAll("loading");
				alert("视频上传成功");
			},
			error: function() {
				layer.closeAll("loading");
				alert("视频上传失败");
			}
		});
		/*加载动画*/
		$(".layui-upload-file").on("change", function() {
			layer.load(1);
		});
	});
</script>