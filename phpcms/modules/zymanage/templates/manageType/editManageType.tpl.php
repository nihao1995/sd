<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>member_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo APP_PATH?>statics/layui-v2.5.3/layui/css/layui.css">
<script type="text/javascript">
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#typename").formValidator({empty:false,onshow:"不能为空11。"}).inputValidator({min:2,max:20,onerror:"名称应该为2-20位之间"}).ajaxValidator({
        type : "get",
        url : "",
        data :"m=zymanage&c=studyPlan&a=editManageAjax",
        datatype : "html",
        async:'false',
        success : function(s){
            console.log(s);
            /*if(data!= '')*/
            if(s == 1)
            {
                return true;
            }
            else
            {
                return false;
            }
        },
        buttons: $("#dosubmit"),
        onerror : "<?php echo L('该名称已存在')?>",
        onwait : "<?php echo L('checking')?>"

      }).defaultPassed();
	});
</script>


<style type="text/css">
.table_form th{text-align: left;}
</style>

<form name="myform" id="myform" action="?m=zymanage&c=studyPlan&a=editManageType" method="post"  onsubmit="return pushData()">
<input type="hidden" name="VFTID" value="<?php echo $data['VFTID']?>" class="input-text">
<div class="pad-10">
<div class="common-form">
	<div id="div_setting_2" class="contentList">
    
    	<fieldset>
        <legend>基本信息</legend>
		<table width="100%" class="table_form">
			<tbody>
				<tr> 
					<th width="120">分类名称</th>
					<td><input required type="text" name="typename" value="<?php echo $data['typename']?>" class="input-text" id="typename" size="15"></td>
				</tr>
                <tr> 
					<th>是否显示到导航</th>
                    <td><select name="typeshow">
                            <option value="0" <?php if($data["typeshow"] == "0") echo "selected"?>>不显示</option>
                            <option value="1" <?php if($data["typeshow"] == "1") echo "selected"?>>显示</option>
                    </select></td>
				</tr>
                <tr>
                    <th>排序</th>
                    <td><input required type="text" name="sort" value="<?php echo $data['sort']?>" class="input-text" id="typename" size="15"></td>
                </tr>
                <tr>
                    <th style="width: 120px">缩略图</th>
                    <td>
                        <div style="width: 161px; text-align: center;">
                            <div class='upload-pic img-wrap'><input type='hidden' name='thumb' id='thumb' required="" value='<?php echo $data["thumb"]?>'>
                                <a href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb',thumb_images,'1,jpg|jpeg|gif|png|bmp,1,,,0','content','6','<?php echo $authkey;?>');return false;">
                                    <img src='<?php if($data['thumb']) { echo $data['thumb']; } else { echo "statics/images/icon/upload-pic.png"; } ?>' id='thumb_preview' width='135' height='113' style='cursor:hand; margin-left: 13px;' /></a><!-- <input type="button" style="width: 66px;" class="button" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁切图片"> --><input type="button" style="width: 66px;" class="button" onclick="$('#thumb_preview').attr('src','statics/images/icon/upload-pic.png');$('#thumb').val(' ');return false;" value="取消图片"><script type="text/javascript">function crop_cut_thumb(id){
                                        if (id=='') { alert('请先上传缩略图');return false;}
                                        window.top.art.dialog({title:'裁切图片', id:'crop', iframe:'index.php?m=content&c=content&a=public_crop&module=content&catid='+0+'&picurl='+encodeURIComponent(id)+'&input=thumb&preview=thumb_preview', width:'680px', height:'480px'}, 	function(){var d = window.top.art.dialog({id:'crop'}).data.iframe;
                                            d.uploadfile();return false;}, function(){window.top.art.dialog({id:'crop'}).close()});
                                    };</script>
                            </div>
                        </div>
                    </td>
                </tr>
			</tbody>
		</table>
        </fieldset>
        <div class="bk15"></div>
        
	</div>
    <div style="text-align: center"><button class="layui-btn layui-btn-sm" id="dosubmit" type="submit"  >确认</button>
    </div>

</div>

</div>
</div>
</form>
    <script>
        function pushData(){
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
            return true;
        }
    </script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
</body>
</html>
