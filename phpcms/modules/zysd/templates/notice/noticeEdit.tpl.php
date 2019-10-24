<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_header = 1;
include $this->admin_tpl('header', 'admin');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>member_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js"></script>
<script src="https://unpkg.com/vue-select@3.0.0"></script>
<link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
<link rel="stylesheet" href="//unpkg.com/iview/dist/styles/iview.css">
<!--<link rel="stylesheet" type="text/css" href="--><?php //echo APP_PATH?><!--statics/vue/iview.css">-->
<link rel="stylesheet" type="text/css" href="<?php echo APP_PATH?>statics/layui-v2.5.3/layui/css/layui.css">
<script type="text/javascript" src="<?php echo APP_PATH?>statics/js/ajax.js"></script>
<script src="<?php echo APP_PATH?>statics/layui-v2.5.3/layui/layui.all.js"></script>
<script type="text/javascript" src="<?php echo APP_PATH?>statics/vue/iview.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://at.alicdn.com/t/font_1257402_xy7e5911m7.css">
<script type="text/javascript" src="<?php echo APP_PATH?>statics/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="<?php echo APP_PATH?>statics/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="<?php echo APP_PATH?>statics/lang/zh-cn/zh-cn.js"></script>

<style>
    #workType p:nth-child(even),#option p:nth-child(odd){
        float: left;
        width:50%;
    }
    #workType p:nth-child(even),#option p:nth-child(even){
        float: right;
        width:50%;
    }
</style>

<style type="text/css">
    .table_form th{text-align: left;}
    .v-select{
        width: 30%;
        display: inline-block
    }
</style>
<form id="myform" action="?m=zysd&c=zysd&a=add_notice" method="post" onsubmit="return zz()">
    <input type="hidden" name="aid" value="<?php echo $dataInfo2["aid"]?>">

    <div class="pad-10">
    <div class="common-form">
        <div id="div_setting_2" class="contentList">
            <fieldset>
                <legend>基本信息</legend>
                <table  class="table_form">
                    <tbody>
                    <tr>
                        <th style="width: 120px">标题</th>
                        <td>
                            <textarea  required name="title" id="" cols="70" rows="2" maxlength="80" onchange="this.value=this.value.substring(0, 200)" onkeydown="this.value=this.value.substring(0, 200)" onkeyup="this.value=this.value.substring(0, 200)"><?php echo $dataInfo2['title'];?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 120px">
                            文本编辑
                        </th>
                        <th style="width: 1000px">
                            <div id="editor11"  style="width:100%; height:500px;"></div>
                        </th>
                    </tr>
                    <tr>
                        <th style="width: 120px">公告类型</th>
                        <td>
                            <?php echo form::select($dataInfo, $dataInfo2['siteid'], 'name="siteid" id="siteid" onchange="load_file_list(this.value)"')?>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 120px">是否发布</th>
                        <td>
                            <input name="passed" type="radio" value="1" <?php if($dataInfo2['passed']==1){echo "checked"; }  ?> >&nbsp;是&nbsp;&nbsp;<input name="passed" type="radio" value="0" <?php if($dataInfo2['passed']==0){echo "checked"; }  ?>>&nbsp;否
                        </td>
                    </tr>
                    </tbody>
                </table>
            </fieldset>
            <div class="bk15"></div>

        </div>
        <div style="text-align: center">
            <button class="layui-btn layui-btn-sm"   type="button" onclick="pushData()" >确认</button>
        </div>

    </div>

</div>
</form>
<script>
//    Vue.component("v-select", VueSelect.VueSelect);
    function pushData(){
        var formdom=$("[name]");
        console.log(formdom);
        var d={};
        $.each(formdom,function(index,val) {
            if(val.checked !== undefined){
                if(val.checked===true){
                    d[val.name]=val.value;
                }else {
                    if(val.type!="radio"){
                        d[val.name]=val.value;
                    }
                }
            }else{
                d[val.name]=val.value;
            }
        });
        console.log(d);
        aj.post("index.php?m=zysd&c=zysd&a=edit_notice&pc_hash=<?php echo $_GET["pc_hash"]?>",d,function(data){
            if(data.code == 200)
            {
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
            }
            else
                layer.msg(data.message);
        });
        return true;
    }
    function zz()
    {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
        return true;
    }
    var layer = layui.layer,
        form = layui.form,
        $ = layui.jquery,
        upload = layui.upload,
        table = layui.table;
    var ue = UE.getEditor('editor11');
    var str = '<?php echo $dataInfo2["editorValue"]?>';
    add(str);
    function add(str){
        setTimeout(function (){
            ue.execCommand('insertHtml', str)
        },500);
    }
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
</body>
</html>