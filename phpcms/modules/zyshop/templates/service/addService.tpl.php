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

<form name="myform" id="myform" action="?m=zyshop&c=shopManage&a=serverAdd" method="post"  onsubmit="return pushData()">
<div class="pad-10">
<div class="common-form">
	<div id="div_setting_2" class="contentList">
    
    	<fieldset>
        <legend>基本信息</legend>
		<table width="100%" class="table_form">
			<tbody>
            <tr>
                <th style="width: 120px">账户</th>
                <td>
                    <input type="text" name="val" >
                </td>
            </tr>
                <tr> 
					<th>类别</th>
                    <td><select name="type">
                            <option value="1" >QQ</option>
                            <option value="2" >微信</option>
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
