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
                    <tr>
                        <th style="width: 120px">文件类型</th>
                        <td>
                            <v-select :options="categoryoptions" :placeholder="categoryplaceholder" :multiple="false" :taggable="true"
                                      :close-on-select="true"  label="typename" @input="getFTID"
                            ></v-select>
                        </td>
                    </tr>
                    <tr >
                        <th style="width: 120px">文件地址</th>
                        <th>
                            <template>
                                <Transfer
                                        :data="fileData"
                                        :list-style="listStyle"
                                        :target-keys="fileKeys"
                                        @on-change="fileChange">
                                </Transfer>
                            </template>
                        </th>
                    </tr>
                    <tr >
                        <th style="width: 120px">视频地址</th>
                        <th>
                            <template>
                            <Transfer
                                    :data="videoData"
                                    :list-style="listStyle"
                                    :target-keys="videoKeys"
                                    @on-change="videoChange">
                            </Transfer>
                            </template>
                        </th>
                    </tr>
                    <tr >
                        <th style="width: 120px">单选题选择</th>
                        <th>
                            <Transfer
                                    filterable
                                    :data="singleChoiceData"
                                    :target-keys="singleChoiceKeys"
                                    :list-style="choiceStyle"
                                    @on-change="singleChoiceChange">
                            </Transfer>
                        </th>
                    </tr>
                    <tr >
                        <th style="width: 120px">多选题选择</th>
                        <th>
                            <Transfer
                                    filterable
                                    :data="multipleChoiceData"
                                    :target-keys="multipleChoiceKeys"
                                    :list-style="choiceStyle"
                                    @on-change="multipleChoiceChange">
                            </Transfer>
                        </th>
                    </tr>
                    <tr >
                        <th style="width: 120px">排序题选择</th>
                        <th>
                            <Transfer
                                    filterable
                                    :data="rankChoiceData"
                                    :target-keys="rankChoiceKeys"
                                    :list-style="choiceStyle"
                                    @on-change="rankChoiceChange">
                            </Transfer>
                        </th>
                    </tr>
                    <tr >
                        <th style="width: 120px">判断题选择</th>
                        <th>
                            <Transfer
                                    filterable
                                    :data="trueorfalseChoiceData"
                                    :target-keys="trueorfalseChoiceKeys"
                                    :list-style="choiceStyle"
                                    @on-change="trueorfalseChoiceChange">
                            </Transfer>
                        </th>
                    </tr>
                    <tr >
                        <th style="width: 120px">是否是精英课程</th>
                        <th>
                            <v-select :options="iseliteData"  :multiple="false" :taggable="true"
                                      :close-on-select="true"  label="typename" @input="getelite"
                            ></v-select>
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
            dataList:[],
            videoData: [ ],
            videoKeys: [],
            fileData:[],
            fileKeys:[],
            singleChoiceData:[],
            singleChoiceKeys:[],
            multipleChoiceData:[],
            multipleChoiceKeys:[],
            rankChoiceData:[],
            rankChoiceKeys:[],
            trueorfalseChoiceData:[],
            trueorfalseChoiceKeys:[],
            iseliteData:[
                {
                    typename:"是",
                    id:1
                 },
                {
                    typename:"不是",
                    id:0
                }
            ],
            iselite:0,
            listStyle: {
                width: '500px',
                height: '300px'
            },
            choiceStyle:{
                width: '500px',
                height: '500px'
            }

        },
        methods:{
            remove:function(file, fileList){
                console.log(file.name);
                for(index in this.dataList)
                {
                    if(this.dataList[index].name === file.name)
                        delete this.dataList[index];
                }
            },
            getelite:function(value)
            {
              this.iselite = value.id;
            },
            success:function(response, file, fileList){
                this.dataList.push(response.data);
                console.log(response);
            },
            getTransfer:function(data, type='V'){
                var returnData = [];
                for(var index in data)
                {
                    switch (type)
                    {
                        case "V":returnData.push({"key":data[index].VID, "label": data[index].content, "disabled": false});break;
                        case "F":returnData.push({"key":data[index].FID, "label": data[index].titlename, "disabled": false});break;
                        case "S":returnData.push({"key":data[index].SCID, "label": data[index].itemname, "disabled": false});break;
                        case "M":returnData.push({"key":data[index].MCID, "label": data[index].itemname, "disabled": false});break;
                        case "T":returnData.push({"key":data[index].TFCID, "label": data[index].itemname, "disabled": false});break;
                        case "R":returnData.push({"key":data[index].RCID, "label": data[index].itemname, "disabled": false});break;
                    }
                }
                return returnData;
            },
            getFTID:function(values){
                this.VFTID = values.VFTID;
                this.category = values.typename;
                console.log(values.typename);
                var that = this;
                aj.post("index.php?m=zymanage&c=studyPlan&a=getFileAndVideo&pc_hash=<?php echo $_GET["pc_hash"]?>",{ VFTID:this.VFTID, category:this.category},function(data){
                    console.log(data);
//                    console.log(that.getTransfer(data.data.videoData));
                    that.videoData = that.getTransfer(data.data.videoData);
                    that.fileData = that.getTransfer(data.data.fileData, "F");
                    that.multipleChoiceData = that.getTransfer(data.data.multiplechoice, "M");
                    that.trueorfalseChoiceData = that.getTransfer(data.data.trueorfalsechoice, "T");
                    that.rankChoiceData = that.getTransfer(data.data.rankchoice, "R");
                    that.singleChoiceData = that.getTransfer(data.data.singlechoice,"S");
                    that.videoKeys = [];
                    that.fileKeys = [];
                    that.singleChoiceKeys = [];
                    that.multipleChoiceKeys = [];
                    that.trueorfalseChoiceKeys = [];
                    that.rankChoiceKeys = [];
//                    console.log(that.getTransfer(data.data.fileData, "F"));
                });
            },
            upload:function()
            {
                aj.post("index.php?m=zymanage&c=studyPlan&a=addStudyPlan&pc_hash=<?php echo $_GET["pc_hash"]?>",{titlename:this.titlename, VFTID:this.VFTID, FID:this.fileKeys, VID:this.videoKeys, iselite:this.iselite, category:this.category, SCID:this.singleChoiceKeys,RCID:this.rankChoiceKeys, MCID:this.multipleChoiceKeys , TFCID:this.trueorfalseChoiceKeys},function(data){
                    if(data.code == 1)
                    {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    }
                    else
                        layer.msg("有数据未填写");
                });
            },
            fileChange: function(newTargetKeys, direction, moveKeys) {
                this.fileKeys = newTargetKeys;
            },
            videoChange: function(newTargetKeys, direction, moveKeys) {
                this.videoKeys = newTargetKeys;
            },
            render4:function(item) {
                return item.label;
            },
            singleChoiceChange:function(newTargetKeys, direction, moveKeys){
                this.singleChoiceKeys = newTargetKeys;
            },
            multipleChoiceChange:function(newTargetKeys, direction, moveKeys){
                this.multipleChoiceKeys = newTargetKeys;
            },
            trueorfalseChoiceChange:function (newTargetKeys, direction, moveKeys) {
                this.trueorfalseChoiceKeys = newTargetKeys;
            },
            rankChoiceChange:function (newTargetKeys, direction, moveKeys) {
                this.rankChoiceKeys = newTargetKeys;
            },
        },
        mounted:function(){
            var that = this;
            aj.post("index.php?m=zymanage&c=fileManage&a=getData&pc_hash=<?php echo $_GET["pc_hash"]?>",{page:1},function(data){
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