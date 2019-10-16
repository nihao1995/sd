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
        data :"m=zymanage&c=videoManage&a=editvideoManageAjax",
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

<form name="myform" id="myform" action="?m=zymanage&c=videoManage&a=editvideoManageType" method="post"  onsubmit="return pushData()">
<input type="hidden" name="VTID" value="<?php echo $data['VTID']?>" class="input-text">
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
</html>
