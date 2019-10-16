<!DOCTYPE html>
<html lang="zh">

	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<title>Document</title>
		<link rel="stylesheet" href="<?php echo siteurl(get_siteid())?>/statics/layui/css/layui.css" />
		<style type="text/css">
			body {
				width: 450px;
			}
			
			body::-webkit-scrollbar {
				display: none;
			}
			
			.layui-row {
				padding: 10px 10px 5px 10px;
			}
			
			.video {
				overflow: hidden;
				text-align: center;
			}
			
			.video div {
				overflow: hidden;
				border-radius: 10px;
			}
			
			.video div img {
				height: 80px;
			}
			
			.video marquee {
				font-size: 12px;
				line-height: 20px;
			}
			
			.video marquee.active {
				color: #f40;
				font-weight: bold;
			}
		</style>
	</head>

	<body>
		<div class="layui-row layui-col-space10">
			<?php foreach ($movies as $movie):?>
			<div class="layui-col-xs3">
				<div class="video">
					<div>
						<img src="<?php echo $movie['thumb']?>" />
					</div>
					<marquee behavior="scroll" direction="left" scrollamount="6">
						<?php echo $movie['title']?>
					</marquee>
					<input type="hidden" name="id" value="<?php echo $movie['id']?>" />
				</div>
			</div>
			<?php endforeach;?>
			<input type="hidden" name="movie[id]" />
			<input type="hidden" name="movie[title]" />
			<input type="hidden" name="movie[thumb]" />
		</div>
	</body>
	<script src="<?php echo siteurl(get_siteid())?>/statics/layui/layui.js"></script>
	<script src="<?php echo siteurl(get_siteid())?>/statics/layui/jquery-3.4.1.min.js"></script>
	<script>
		layui.use('jquery', function() {
			var $ = layui.jquery;
			$(".layui-col-xs3").click(function() {
				$("input[name='movie[id]']").val($(this).find("input[name='id']").val());
				$("input[name='movie[title]']").val($(this).find("img").attr("src"));
				$("input[name='movie[thumb]']").val($(this).find("marquee").text());
				$("marquee").removeClass("active");
				$(this).find("marquee").addClass("active");
			});
		});
		var data = function() {
			var data = {
				'id': $.trim($("input[name='movie[id]']").val()),
				'title': $.trim($("input[name='movie[title]']").val()),
				'thumb': $.trim($("input[name='movie[thumb]']").val())
			};
			return data;
		}
	</script>

</html>