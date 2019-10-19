<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
    $show_header = 1;
	include $this->admin_tpl('header','admin');
?>
	<style>
		.btn { display: inline-block; padding: 0px 5px; margin-bottom: 0; font-size: 12px; font-weight: 400; line-height: 1.32857143; text-align: center; white-space: nowrap; vertical-align: middle; -ms-touch-action: manipulation; touch-action: manipulation; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px; margin-left: 5px;}
		.btn-info { background-image: -webkit-linear-gradient(top,#5bc0de 0,#2aabd2 100%); background-image: -o-linear-gradient(top,#5bc0de 0,#2aabd2 100%); background-image: -webkit-gradient(linear,left top,left bottom,from(#5bc0de),to(#2aabd2)); background-image: linear-gradient(to bottom,#5bc0de 0,#2aabd2 100%); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5bc0de', endColorstr='#ff2aabd2', GradientType=0); filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); background-repeat: repeat-x; border-color: #28a4c9;}
		.btn-info { color: #fff; background-color: #5bc0de; border-color: #46b8da;}

		.btn-danger { background-image: -webkit-linear-gradient(top,#d9534f 0,#c12e2a 100%); background-image: -o-linear-gradient(top,#d9534f 0,#c12e2a 100%); background-image: -webkit-gradient(linear,left top,left bottom,from(#d9534f),to(#c12e2a)); background-image: linear-gradient(to bottom,#d9534f 0,#c12e2a 100%); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffd9534f', endColorstr='#ffc12e2a', GradientType=0); filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); background-repeat: repeat-x; border-color: #b92c28;}
		.btn-danger { color: #fff; background-color: #d9534f; border-color: #d43f3a;}

		.btn-success { background-image: -webkit-linear-gradient(top,#5cb85c 0,#419641 100%); background-image: -o-linear-gradient(top,#5cb85c 0,#419641 100%); background-image: -webkit-gradient(linear,left top,left bottom,from(#5cb85c),to(#419641)); background-image: linear-gradient(to bottom,#5cb85c 0,#419641 100%); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5cb85c', endColorstr='#ff419641', GradientType=0); filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); background-repeat: repeat-x; border-color: #3e8f3e;}
		.btn-success { color: #fff; background-color: #5cb85c; border-color: #4cae4c;}
		a:hover{ text-decoration: none; }
        .page{
            text-align: right;
        }
        .page div{
            display: inline-block;
            text-align: right;
            border-radius: 5px;
            padding: 0;
            display: inline-block;
            list-style: none;
            border: 1px solid #ddd;
            color: #337ab7;
        }
        .page span{
            display: inline-block;
            line-height: 35px;
            padding: 0 15px;
            border-left: 1px solid #ddd;
            margin-right: -5px;
            cursor:pointer;
        }
        .page span:first-of-type{
            border-style: none;
            cursor:pointer;
        }
        .page-on{
            background-color: #337ab7;
            color: #fff;

        }
	</style>

<div style="border: 1px solid transparent"></div>
<div class="pad-lr-10">
<div class="subnav">

</div>

<form name="searchform" action="" method="get" id="sbt">

<input type="hidden" value="zyfx" name="m">
<input type="hidden" value="fxBack" name="c">
<input type="hidden" value="fxRecord" name="a">
<input type="hidden" value="" name="page" id="page">
<div class="explain-col search-form">
<?php echo '用户名:'?>  <input type="text" value="<?php echo $_GET['nickname']?>" class="input-text" name="nickname">
<?php echo '手机号:'?>  <input type="text" value="<?php echo $_GET['mobile']?>" class="input-text" name="mobile">
<?php echo '订单号:'?>  <input type="text" value="<?php echo $_GET['trade_no']?>" class="input-text" name="trade_no">
<?php echo '支付类型:'?>
<select name="type" >
    <option value="">请选择</option>
    <option value="1" <?php if ($_GET['type']==1) {?>selected<?php }?> >余额</option>
    <option value="2" <?php if ($_GET['type']==2) {?>selected<?php }?> >支付宝</option>
    <option value="3" <?php if ($_GET['type']==3) {?>selected<?php }?> >微信</option>
</select>
<?php echo '注册日期:'?>
<?php echo form::date('start_addtime',$_GET['start_addtime'])?>
<?php echo L('to')?>
<?php echo form::date('end_addtime',$_GET['end_addtime'])?>
<input type="submit" value=<?php echo L(search);?> class="button" name="dosubmit" >

<?php if($fatherId != ""){?>
    <input class="button" type="button" onclick="back(this)" name=<?php echo $fatherId?> value="返回">
<?php }?>


</div>
</form>
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
            <th align="center"><strong>用户id</strong></th>
            <th align="center"><strong>用户名称</strong></th>
            <th align="center"><strong>订单号</strong></th>
            <th align="center"><strong>支付方式</strong></th>
            <th align="center"><strong>手机</strong></th>
            <th align="center"><strong>升级日期</strong></th>
		</tr>
	</thead>
	<tbody>

			<?php $n=1; foreach($data AS $row) { ?>
			<tr>
			<td align="center" width="35"><input type="checkbox" name="id[]" value="<?php echo $row['userid']?>"></td>
			<td align="center"><?php echo $row['userid'];?></td>
			<td align="center"><?php echo $row["nickname"];?></td>
			<td align="center"><?php echo $row["trade_no"];?></td>
			<td align="center"><?php if($row['type']==1) echo "余额"; elseif($row['type']==2) echo "支付宝";elseif($row['type']==3) echo "微信";?></td>
            <td align="center"><?php echo $row["mobile"];?></td>
            <td align="center"><?php echo $row["addtime"];?></td>
<!--            <td align="center">--><?php //if($row["putaway"] == "1"){?>
<!--                <img src="--><?php //echo IMG_PATH?><!--/right.png" />-->
<!--                --><?php //}else {?>
<!--                    <img src="--><?php //echo IMG_PATH?><!--/wrong.png" />-->
<!--                --><?php //}?>
<!--            </td>-->

			<?php $n++;}unset($n); ?>

	</tbody>
</table>
    <div>

        <!-- 页码 -->
        <div class="page">
            <div>
                <span onclick=pagesubmit(<?php echo $page-1<=0?1:$page-1;?>)>上一页</span>
                <?php for($i=1 ; $i < $pagenums+1; $i++) { ?>
                    <?php if($i == $page){?>
                        <span  class="page-on"  onclick=pagesubmit(<?php echo $i;?>);><?php echo $i;?></span>
                    <?php }else{?>
                        <span onclick=pagesubmit(<?php echo $i;?>)><?php echo $i;?></span>
                    <?php }?>
                <?php } ?>
                <span onclick=pagesubmit(<?php echo $page+1>=$pagenums?$pagenums:$page+1;?>)>下一页</span>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
<!--
function checkuid() {
	var ids='';
	$("input[name='id[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'<?php echo L('请先选择记录')?>',lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}
function view_pid(userid) {
    window.top.art.dialog({
            id:'view_pid',
            iframe:'?m=zyfx&c=fxBack&a=memberView&userid='+userid,
            title:'用户信息',
            width:'600',
            height:'500',
            lock:true
        },
        function(){
            window.top.art.dialog({id:'view_pid'}).close()
        });
    void(0);
}
function view_team(userid) {
    window.top.art.dialog({
            id:'view_team',
            iframe:'?m=zyfx&c=fxBack&a=teamView&userid='+userid,
            title:'用户信息',
            width:'600',
            height:'500',
            lock:true
        },
        function(){
            window.top.art.dialog({id:'view_team'}).close()
        });
    void(0);
}
function pagesubmit(page){
    $("#page").val(page);
    $("#sbt").submit();
};
//-->
</script>

