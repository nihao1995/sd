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
<div id="app" style="padding: 1rem">
    <h1 style="color: black">{{itemGet.title}}</h1><br>
    {{itemGet.addtime}}<br>
    <span v-html="itemGet.editorValue"></span>
</div>
<script>
    aj.post("index.php?m=zysd&c=api&a=notice_detail&pc_hash=<?php echo $_GET["pc_hash"]?>",{aid:'<?php echo $_GET['ID']?>'},function(data){
        if(data.code == 200)
        {
            var app = new Vue({
                el: '#app',
                data: {
                    itemGet: data.data[0],
                }
            })
        }
        else
            layer.msg(data.message);
    });
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
</body>
</html>