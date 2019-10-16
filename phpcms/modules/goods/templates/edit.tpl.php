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
	
	.video {
		overflow: hidden;
		text-align: center;
		position: relative;
	}
	
	.video i {
		position: absolute;
		right: 5px;
		top: 5px;
		color: red;
		font-weight: bold;
	}
	
	.video div {
		overflow: hidden;
		border-radius: 5px;
	}
	
	.video div img {
		height: 80px;
	}
	
	.video p {
		overflow: hidden;
		line-height: 20px;
		white-space: nowrap;
		text-overflow: ellipsis;
	}
	
	.video marquee {
		line-height: 20px;
	}
	
	button.layui-btn {
		margin-bottom: 5px;
	}
	
	.image {
		float: left;
		height: 80px;
		min-width: 80px;
		background-color: #F9F9F9;
	}
	
	.image img {
		height: 80px;
	}
	
	.images {
		overflow: hidden;
		text-align: center;
		border-radius: 5px;
		position: relative;
	}
	
	.images i {
		position: absolute;
		right: 5px;
		top: 5px;
		color: red;
		font-weight: bold;
	}
	
	.images img {
		height: 80px;
	}
</style>
<div class="pad-lr-10">
	<fieldset>
		<legend>商品修改</legend>
		<form action="?m=goods&c=goods&a=edit&id=<?php echo $goods['id']?>" method="post">
			<table class="table_form" width="100%">
				<tr>
					<th width="15%">商品模式</th>
					<td>
						<input type="radio" name="goods[mode]" value="1" />普通商品
						<input type="radio" name="goods[mode]" value="2" />拼团商品
						<input type="radio" name="goods[mode]" value="3" />砍价商品
					</td>
				</tr>
				<tr>
					<th>商品类型</th>
					<td>
						<input type="radio" name="goods[free]" value="1" />免费商品
						<input type="radio" name="goods[free]" value="-1" />付费商品
					</td>
				</tr>
				<tr>
					<th>商品状态</th>
					<td>
						<input type="radio" name="goods[sale]" value="1" />上架商品
						<input type="radio" name="goods[sale]" value="-1" />下架商品
					</td>
				</tr>
				<tr>
					<th>商品标题</th>
					<td>
						<input type="text" name="goods[title]" autocomplete="off" value="<?php echo $goods['title']?>" />
					</td>
				</tr>
				<tr>
					<th>商品简介</th>
					<td>
						<textarea name="goods[content]" rows="5" cols="24"><?php echo $goods['content']?></textarea>
					</td>
				</tr>
				<tr>
					<th>课程视频</th>
					<td>
						<button id="video_btn" type="button" class="layui-btn layui-btn-xs">添加视频</button>
						<div id="video_box" class="layui-row layui-col-space5">
							<?php foreach ($movies as $movie):?>
							<div class="layui-col-xs3">
								<div class="video">
									<i class="layui-icon layui-icon-close"></i>
									<div>
										<img src="<?php echo $movie['thumb']?>" />
									</div>
									<marquee behavior="scroll" direction="left" scrollamount="6">
										<?php echo $movie['title']?>
									</marquee>
									<input type="hidden" name="movie[]" value="<?php echo $movie['id']?>" />
								</div>
							</div>
							<?php endforeach;?>
						</div>
					</td>
				</tr>
				<?php foreach ($classifys as $classify):?>
				<tr>
					<th>
						<?php echo $classify['name']?>
					</th>
					<td>
						<?php if ($classify['type'] == 1):?>
						<select name="classify[<?php echo $classify['id']?>]">
							<?php foreach ($classify['value'] as $value):?>
							<option value="<?php echo $value['id']?>">
								<?php echo $value['name']?>
							</option>
							<?php endforeach;?>
						</select>
						<?php endif;?>
						<?php if ($classify['type'] == 2):?>
						<?php foreach ($classify['value'] as $value):?>
						<input type="checkbox" name="classify[<?php echo $classify['id']?>][]" value="<?php echo $value['id']?>" />
						<?php echo $value['name']?>
						<?php endforeach;?>
						<?php endif;?>
						<?php if ($classify['type'] == 3):?>
						<?php foreach ($classify['value'] as $value):?>
						<input type="radio" name="classify[<?php echo $classify['id']?>]" value="<?php echo $value['id']?>" />
						<?php echo $value['name']?>
						<?php endforeach;?>
						<?php endif;?>
					</td>
				</tr>
				<?php endforeach;?>
				<tr>
					<th>店铺分类</th>
					<td>
						<select name="group">
							<?php foreach ($groups as $group):?>
							<option value="<?php echo $group['id']?> - 0"><?php echo $group['name']?></option>
							<?php foreach ($group['classify'] as $classify):?>
							<option value="<?php echo $group['id']?> - <?php echo $classify['id']?>">|--<?php echo $classify['name']?></option>
							<?php endforeach;?>
							<?php endforeach;?>
						</select>
					</td>
				</tr>
				<tr>
					<th>缩略图</th>
					<td>
						<div class="image">
							<img src="<?php echo $goods['thumb']?>" />
							<input type="hidden" name="goods[thumb]" value="<?php echo $goods['thumb']?>" />
						</div>
					</td>
				</tr>
				<tr>
					<th>详情图</th>
					<td>
						<button id="image_btn" type="button" class="layui-btn layui-btn-xs">添加图片</button>
						<div id="image_box" class="layui-row layui-col-space5">
							<?php foreach ($goods['thumblist'] as $thumb):?>
							<div class="layui-col-xs3">
								<div class="images">
									<i class="layui-icon layui-icon-close"></i>
									<img src="<?php echo $thumb?>" />
									<input type="hidden" name="goods[thumblist][]" value="<?php echo $thumb?>" />
								</div>
							</div>
							<?php endforeach;?>
						</div>
					</td>
				</tr>
				<tr>
					<th>零售价</th>
					<td>
						<input type="text" name="goods[real_price]" value="<?php echo $goods['real_price']?>" />
					</td>
				</tr>
				<tr>
					<th>市场价</th>
					<td>
						<input type="text" name="goods[fake_price]" value="<?php echo $goods['fake_price']?>" />
					</td>
				</tr>
				<?php if ($goods['mode'] == 2):?>
				<tr>
					<th>优惠类型</th>
					<td>
						<input type="radio" name="goods[type]" value="1" />拼团价
						<input type="radio" name="goods[type]" value="2" />拼团折扣
					</td>
				</tr>
				<tr>
					<th>拼团价</th>
					<td>
						<input type="text" name="goods[group_price]" value="<?php echo $goods['group_price']?>" />
					</td>
				</tr>
				<tr>
					<th>拼团折扣</th>
					<td>
						<input type="text" name="goods[discount]" value="<?php echo $goods['discount']?>" />
					</td>
				</tr>
				<tr>
					<th>拼团人数</th>
					<td>
						<input type="text" name="goods[number]" value="<?php echo $goods['number']?>" />
					</td>
				</tr>
				<?php endif;?>
			</table>
			<input type="submit" id="dosubmit" name="dosubmit" />
		</form>
	</fieldset>
</div>
<script src="<?php echo siteurl(get_siteid())?>/statics/layui/layui.js"></script>
<script>
	layui.use(['jquery', 'layer', 'upload'], function() {
		var $ = layui.jquery;
		var layer = layui.layer;
		var upload = layui.upload;
		
		/*视频添加*/
		$("#video_btn").click(function() {
			layer.open({
				type: 2,
				title: "添加视频",
				content: "?m=goods&c=goods&a=video&uid=<?php echo $goods['uid']?>&pc_hash=<?php echo $_SESSION['pc_hash']?>",
				area: ['450px', '450px'],
				btn: ['确定', '取消'],
				yes: function(index, layero) {
					/*获取数据*/
					var id = window["layui-layer-iframe" + index].data().id;
					var title = window["layui-layer-iframe" + index].data().title;
					var thumb = window["layui-layer-iframe" + index].data().thumb;
					/*获取父节点*/
					var video_box = $("#video_box");
					/*创建子节点*/
					var video = $('<div class="layui-col-xs3"><div class="video"><i class="layui-icon layui-icon-close"></i><div><img src="' + title + '" /></div><marquee behavior="scroll" direction="left" scrollamount="6">' + thumb + '</marquee><input type="hidden" name="movie[]" value="' + id + '" /></div></div>');
					/*附加子节点*/
					video_box.append(video);
					/*关闭弹层*/
					layer.closeAll();
				}
			});
		});
		/*上传缩略图*/
		upload.render({
			elem: ".image",
			url: "?m=goods&c=goods&a=upload&pc_hash=<?php echo $_SESSION['pc_hash']?>",
			size: 2 * 1024,
			accept: "images",
			acceptMime: "image/*",
			done: function(res) {
				$(".image img").attr("src", res.filename);
				$(".image input").val(res.filename);
				layer.closeAll("loading");
				alert("图片上传成功");
			},
			error: function() {
				layer.closeAll("loading");
				alert("图片上传失败");
			}
		});
		/*上传详情图*/
		upload.render({
			elem: "#image_btn",
			url: "?m=goods&c=goods&a=upload&pc_hash=<?php echo $_SESSION['pc_hash']?>",
			size: 2 * 1024,
			accept: "images",
			acceptMime: "image/*",
			done: function(res) {
				/*获取父节点*/
				var image_box = $("#image_box");
				/*创建子节点*/
				var images = $('<div class="layui-col-xs3"><div class="images"><i class="layui-icon layui-icon-close"></i><img src="' + res.filename + '" /><input type="hidden" name="goods[thumblist][]" value="' + res.filename + '" /></div></div>');
				/*附加子节点*/
				image_box.append(images);
				layer.closeAll("loading");
				alert("图片上传成功");
			},
			error: function() {
				layer.closeAll("loading");
				alert("图片上传失败");
			}
		});
		/*加载动画*/
		$(".layui-upload-file").on("change", function() {
			layer.load(1);
		});

		/*商品信息选中*/
		$("input[name='goods[mode]'][value='<?php echo $goods['mode']?>']").prop("checked", true);
		$("input[name='goods[free]'][value='<?php echo $goods['free']?>']").prop("checked", true);
		$("input[name='goods[sale]'][value='<?php echo $goods['sale']?>']").prop("checked", true);

		/*分类信息选中*/
		<?php foreach ($classifys as $classify):?>
		/*选择框*/
		<?php if ($classify['type'] == 1):?>
		$("[name='classify[<?php echo $classify['id']?>]']").val("<?php echo $classify['selected']['id']?>");
		<?php endif;?>
		/*多选框*/
		<?php if ($classify['type'] == 2):?>
		<?php foreach ($classify['selected'] as $value):?>
		$("[name='classify[<?php echo $classify['id']?>][]'][value='<?php echo $value['id']?>']").prop("checked", true);
		<?php endforeach;?>
		<?php endif;?>
		<?php if ($classify['type'] == 3):?>
		$("[name='classify[<?php echo $classify['id']?>]'][value='<?php echo $classify['selected']['id']?>']").prop("checked", true);
		<?php endif;?>
		<?php endforeach;?>

		/*视频删除-委托*/
		$("#video_box").delegate("#video_box i", "click", function() {
			$(this).parent().parent().remove();
		});

		/*图片删除-委托*/
		$("#image_box").delegate("#image_box i", "click", function() {
			$(this).parent().parent().remove();
		});

		/*监听商品模式*/
		$("input[name='goods[mode]']").on("change", function() {
			if($("input[name='goods[mode]'][value='2']").prop("checked")) {
				var parent = $("table");
				var children = $(
					'<tr>' +
					'<th>优惠类型</th>' +
					'<td>' +
					'<input type="radio" name="goods[type]" value="1" checked/>拼团价' +
					'<input type="radio" name="goods[type]" value="2" />拼团折扣' +
					'</td>' +
					'</tr>' +
					'<tr>' +
					'<th>拼团价</th>' +
					'<td>' +
					'<input type="text" name="goods[group_price]" class="input-text" />' +
					'</td>' +
					'</tr>' +
					'<tr>' +
					'<th>拼团折扣</th>' +
					'<td>' +
					'<input type="text" name="goods[discount]" class="input-text" />' +
					'</td>' +
					'</tr>' +
					'<tr>' +
					'<th>拼团人数</th>' +
					'<td>' +
					'<input type="text" name="goods[number]" class="input-text" />' +
					'</td>' +
					'</tr>'
				);
				parent.append(children);
			} else {
				$("input[name='goods[group_price]']").parent().parent().remove();
				$("input[name='goods[discount]']").parent().parent().remove();
				$("input[name='goods[number]']").parent().parent().remove();
				$("input[name='goods[type]']").parent().parent().remove();
			}
		});

		$("input[name='goods[type]'][value='<?php echo $goods['type']?>']").prop("checked", true);
		
		$("[name='group']").val("<?php echo $str?>");
	});
</script>