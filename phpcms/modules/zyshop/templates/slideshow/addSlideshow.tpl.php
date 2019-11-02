<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>member_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo APP_PATH?>statics/layui-v2.5.3/layui/css/layui.css">


<style type="text/css">
.table_form th{text-align: left;}
</style>

<form name="myform" id="myform" action="?m=zyshop&c=shopManage&a=addSlideshow" method="post"  onsubmit="return pushData()">
<div class="pad-10">
<div class="common-form">
	<div id="div_setting_2" class="contentList">
    
    	<fieldset>
        <legend>基本信息</legend>
		<table width="100%" class="table_form">
			<tbody>
            <tr>
                <th style="width: 120px">轮播图</th>
                <td>
                    <div style="width: 161px; text-align: center;">
                        <div class='upload-pic img-wrap'><input type='hidden' name='thumb' id='thumb' required="" value=''>
                            <a href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb',thumb_images,'1,jpg|jpeg|gif|png|bmp,1,,,0','content','6','<?php echo $authkey;?>');return false;">
                                <img src='statics/images/icon/upload-pic.png' id='thumb_preview' width='135' height='113' style='cursor:hand; margin-left: 13px;' /></a><!-- <input type="button" style="width: 66px;" class="button" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁切图片"> --><input type="button" style="width: 66px;" class="button" onclick="$('#thumb_preview').attr('src','statics/images/icon/upload-pic.png');$('#thumb').val(' ');return false;" value="取消图片"><script type="text/javascript">function crop_cut_thumb(id){
                                    if (id=='') { alert('请先上传缩略图');return false;}
                                    window.top.art.dialog({title:'裁切图片', id:'crop', iframe:'index.php?m=content&c=content&a=public_crop&module=content&catid='+0+'&picurl='+encodeURIComponent(id)+'&input=thumb&preview=thumb_preview', width:'680px', height:'480px'}, 	function(){var d = window.top.art.dialog({id:'crop'}).data.iframe;
                                        d.uploadfile();return false;}, function(){window.top.art.dialog({id:'crop'}).close()});
                                };</script>
                        </div>
                    </div>
                </td>
            </tr>
                <tr> 
					<th>是否显示到导航</th>
                    <td><select name="isshow">
                            <option value="1" >显示</option>
                            <option value="0" >不显示</option>
                    </select></td>
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
</body>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
</html>
