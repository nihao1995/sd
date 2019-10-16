<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_header = 1;
include $this->admin_tpl('header', 'admin');
?>
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

<div class="pad-10" id="app" >
    <div class="common-form">
        <div id="div_setting_2" class="contentList" >
            <fieldset style="text-align: center">
                <legend>PK匹配设置</legend>
                <table  class="table_form" style="display: inline-block">
                    <tbody>
                    <tr>
                        <th style="width: 120px">单选的数量</th>
                        <td>
                            <i-Input v-model="singleChoiceCount" placeholder="请输入数字"  type="number" />
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 120px">多选的数量</th>
                        <td>
                            <i-Input v-model="multipleChoiceCount" placeholder="请输入数字" type="number" />
                        </td>
                    </tr>
                    <tr >
                        <th style="width: 120px">排序的数量</th>
                        <td>
                            <i-Input v-model="rankChoiceCount" placeholder="请输入数字" type="number" />
                        </td>
                    </tr>
                    <tr >
                        <th style="width: 120px">判断的数量</th>
                        <td>
                            <i-Input v-model="trueOrFalseChoiceCount" placeholder="请输入数字" type="number" />
                        </td>
                    </tr>
                    <tr >
                        <th style="width: 120px">时间限定</th>
                        <td>
                            <Time-Picker :value="pkTime" format="HH:mm:ss" type="time" placeholder="Select time" style="width: 168px" @on-change="timeChange"></Time-Picker>
                        </td>
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
    var layer = layui.layer,
        form = layui.form,
        $ = layui.jquery,
        upload = layui.upload,
        table = layui.table;
    window.parent.app12 = new Vue({
        el:"#app",
        data:{
            singleChoiceCount:0,
            multipleChoiceCount:0,
            trueOrFalseChoiceCount:0,
            rankChoiceCount:0,
            pkTime:'00:00:00'
        },
        methods:{
            timeChange:function(index)
            {
                this.pkTime = index;
            },
            upload:function () {
                aj.post("index.php?m=zymanage&c=pkMatching&a=uploadConfig&pc_hash=<?php echo $_GET["pc_hash"]?>",{singleChoiceCount:this.singleChoiceCount, multipleChoiceCount:this.multipleChoiceCount, trueOrFalseChoiceCount:this.trueOrFalseChoiceCount, pkTime:this.pkTime, rankChoiceCount:this.rankChoiceCount},function(data) {
                    layer.msg(data.message);
                } )
            }
        },
        mounted:function(){
            var that = this;
            aj.post("index.php?m=zymanage&c=pkMatching&a=getConfig&pc_hash=<?php echo $_GET["pc_hash"]?>",{},function(data){
                //that.categoryoptions = data.data.category;
                that.singleChoiceCount=data.data.singleChoiceCount;
                that.multipleChoiceCount=data.data.multipleChoiceCount;
                that.trueOrFalseChoiceCount=data.data.trueOrFalseChoiceCount;
                that.rankChoiceCount=data.data.rankChoiceCount;
                that.pkTime=data.data.pkTime;
            });
        }
    })
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
</body>
</html>