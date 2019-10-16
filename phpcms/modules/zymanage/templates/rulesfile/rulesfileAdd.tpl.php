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

<div class="pad-10" id="app">
    <div class="common-form">
        <div id="div_setting_2" class="contentList">
            <fieldset>
                <legend>基本信息</legend>
                <table  class="table_form">
                    <tbody>
                    <tr>
                        <th style="width: 120px">文件标题</th>
                        <td>
                            <textarea  required v-model="titlename" id="" cols="70" rows="2" maxlength="200" onchange="this.value=this.value.substring(0, 200)" onkeydown="this.value=this.value.substring(0, 200)" onkeyup="this.value=this.value.substring(0, 200)"></textarea>
                        </td>
                    </tr>
                    <tr >
                        <th style="width: 120px">文件地址</th>
                        <th>
                            <Upload :max-size="20480"  :on-exceeded-size="exceeded" :default-file-list="uploadList" multiple :on-success="success" :on-remove="remove" action="index.php?m=zymanage&c=fileManage&a=upFile&pc_hash=<?php echo $_GET["pc_hash"]?>" >
                               <i-Button icon="ios-cloud-upload-outline">Upload files</i-Button>
                           </Upload>
                        </th>
                    </tr>
                    </tbody>
                </table>
            </fieldset>
            <div class="bk15"></div>

        </div>
        <div style="text-align: center">
            <button class="layui-btn layui-btn-sm"   type="button" @click="upload">确认</button>
        </div>

    </div>

</div>
<script>
    Vue.component("v-select", VueSelect.VueSelect);
    function pushData(){

        return true;
    }
    var layer = layui.layer,
        form = layui.form,
        $ = layui.jquery,
        upload = layui.upload,
        table = layui.table;
    window.parent.app12 = new Vue({
        el:"#app",
        data:{
            categoryplaceholder:'选择分类',
            categoryoptions:[],
            category:'',
            VFTID:'',
            titlename: '',
            visible: false,
            uploadList: [],
            dataList:[]
        },
        methods:{
            remove:function(file, fileList){
                console.log(file.name);
                for(index in this.dataList)
                {
                    if(this.dataList[index].name === file.name)
                        this.dataList.splice(index,1);
                }
            },
            success:function(response, file, fileList){
                this.dataList.push(response.data);
                console.log(response);
            },
            getFTID:function(values){
                this.VFTID = values.VFTID;
            },
            exceeded:function(file, fileList)
            {
                layer.msg('文件过大')
            },
            upload:function()
            {
                aj.post("index.php?m=zymanage&c=rules&a=addFileManage&pc_hash=<?php echo $_GET["pc_hash"]?>",{titlename:this.titlename, fileAddr:this.dataList},function(data){
                    if(data.code == 1)
                    {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    }
                    else
                        layer.msg("有数据未填写");
                });
            }
        },
        mounted:function(){
            var that = this;
            aj.post("index.php?m=zymanage&c=rules&a=getData&pc_hash=<?php echo $_GET["pc_hash"]?>",{page:1},function(data){
                that.categoryoptions = data.data.category;
                console.log(that);
            });
        }
    })
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
</body>
</html>