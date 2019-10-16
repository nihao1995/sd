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
	
	.image {
		float: left;
		height: 80px;
		min-width: 80px;
	}
	
	.image img {
		height: 80px;
	}
	
	.images {
		overflow: hidden;
		text-align: center;
		border-radius: 5px;
	}
	
	.images img {
		height: 80px;
	}
</style>
<div class="pad-lr-10">
	<fieldset>
		<legend>商品详情</legend>
		<form action="" method="post">
			<table class="table_form" width="100%">
				<tr>
					<th  width="15%">商品编号</th>
					<td>
						<?php echo $goods['id']?>
					</td>
				</tr>
				<tr>
					<th>用户编号</th>
					<td>
						<?php echo $goods['uid']?>
					</td>
				</tr>
				<tr>
					<th>商品模式</th>
					<td>
						<?php echo $goods['mode'] == 1?'普通商品':($goods['mode'] == 2?'拼团商品':'砍价商品')?>
					</td>
				</tr>
				<tr>
					<th>商品类型</th>
					<td>
						<?php echo $goods['free'] == 1?'免费商品':'付费商品'?>
					</td>
				</tr>
				<tr>
					<th>商品状态</th>
					<td>
						<?php echo $goods['sale'] == 1?'已上架':'未上架'?>
					</td>
				</tr>
				<tr>
					<th>商品标题</th>
					<td>
						<?php echo $goods['title']?>
					</td>
				</tr>
				<tr>
					<th>商品简介</th>
					<td>
						<?php echo $goods['content']?>
					</td>
				</tr>
				<tr>
					<th>课程视频</th>
					<td>
						<div id="video_box" class="layui-row layui-col-space5">
							<?php foreach ($movies as $movie):?>
							<div class="layui-col-xs3">
								<div class="video">
									<div>
										<img src="<?php echo $movie['thumb']?>" />
									</div>
									<marquee behavior="scroll" direction="left" scrollamount="6">
										<?php echo $movie['title']?>
									</marquee>
									<input type="hidden" value="<?php echo $movie['filename']?>" />
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
						<?php if ($classify['type'] != 2):?>
						<?php echo $classify['selected']['name']?>
						<?php endif;?>
						<?php if ($classify['type'] == 2):?>
						<?php echo implode(" ", $classify['selected_value'])?>
						<?php endif;?>
					</td>
				</tr>
				<?php endforeach;?>
				<tr>
					<th>店铺分类</th>
					<td>
						<?php echo $group?>
					</td>
				</tr>
				<tr>
					<th>缩略图</th>
					<td>
						<div class="image">
							<img src="<?php echo $goods['thumb']?>" />
						</div>
					</td>
				</tr>
				<tr>
					<th>详情图</th>
					<td>
						<div id="image_box" class="layui-row layui-col-space5">
							<?php foreach ($goods['thumblist'] as $thumb):?>
							<div class="layui-col-xs3">
								<div class="images">
									<img src="<?php echo $thumb?>" />
								</div>
							</div>
							<?php endforeach;?>
						</div>
					</td>
				</tr>
				<tr>
					<th>零售价</th>
					<td>
						<?php echo $goods['real_price']?>
					</td>
				</tr>
				<tr>
					<th>市场价</th>
					<td>
						<?php echo $goods['fake_price']?>
					</td>
				</tr>
				<?php if ($goods['mode'] == 2):?>
				<tr>
					<th>优惠类型</th>
					<td>
						<?php echo $goods['type'] == 1?'拼团价':'拼团折扣'?>
					</td>
				</tr>
				<tr>
					<th>拼团价</th>
					<td>
						<?php echo $goods['group_price']?>
					</td>
				</tr>
				<tr>
					<th>拼团折扣</th>
					<td>
						<?php echo $goods['discount']?>
					</td>
				</tr>
				<tr>
					<th>拼团人数</th>
					<td>
						<?php echo $goods['number']?>
					</td>
				</tr>
				<?php endif;?>
				<tr>
					<th>上传时间</th>
					<td>
						<?php echo date("Y-m-d h:i:s", $goods['uploadtime'])?>
					</td>
				</tr>
				<tr>
					<th>修改时间</th>
					<td>
						<?php echo date("Y-m-d h:i:s", $goods['updatetime'])?>
					</td>
				</tr>
				<tr>
					<th>商品销量</th>
					<td>
						<?php echo $goods['count']?>
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
		$(".video").click(function() {
			window.open($(this).find("input").val());
		});

		$(".image").click(function() {
			window.open($(this).find("img").attr("src"));
		});

		$(".images").click(function() {
			window.open($(this).find("img").attr("src"));
		});
	});
</script>