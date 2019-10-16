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
<!--<script src="//unpkg.com/iview/dist/iview.min.js"></script>-->
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
        width: 50%;
        display: inline-block
    }
</style>

<div class="pad-10" id="app">
    <div class="common-form">
        <div id="div_setting_2" class="contentList">
            <fieldset>
                <legend>添加考试</legend>
                <table  class="table_form">
                    <tbody>
                    <tr>
                        <th style="width: 120px">考试标题</th>
                        <td>
                            <textarea  required v-model="titlename" id="" cols="70" rows="2" maxlength="200" onchange="this.value=this.value.substring(0, 200)" onkeydown="this.value=this.value.substring(0, 200)" onkeyup="this.value=this.value.substring(0, 200)"></textarea>
                        </td>
                    </tr>
                    <tr >
                        <th style="width: 120px">考试会员</th>
                        <th>
                            <Transfer
                                    filterable
                                    :data="memberData"
                                    :target-keys="memberKeys"
                                    :list-style="listStyle"
                                    @on-change="memberChange">
                            </Transfer>
                        </th>
                    </tr>
                    <tr >
                        <th style="width: 120px">单选题选择</th>
                        <th>
                            <Transfer
                                    filterable
                                    :data="singleChoiceData"
                                    :target-keys="singleChoiceKeys"
                                    :list-style="listStyle"
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
                                    :list-style="listStyle"
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
                                    :list-style="listStyle"
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
                                    :list-style="listStyle"
                                    @on-change="trueorfalseChoiceChange">
                            </Transfer>
                        </th>
                    </tr>
                    <tr >
                        <th style="width: 120px">考试时间</th>
                        <th>
                            <template>
                                <Date-Picker :value="dateValue" @on-change="dateChange" type="datetimerange" format="yyyy-MM-dd HH:mm:ss" placeholder="Select date and time(Excluding seconds)" style="width: 300px"></Date-Picker>
<!--                            <DatePicker type="datetimerange" format="yyyy-MM-dd HH:mm" placeholder="Select date and time(Excluding seconds)" style="width: 300px"></DatePicker>-->
                            </template>
                        </th>
                    </tr>
                    <tr >
                        <th style="width: 120px">考试时长</th>
                        <th>
                            <template>
                                <Time-Picker :value="pkTime" format="HH:mm:ss" type="time" placeholder="Select time" style="width: 168px" @on-change="timeChange"></Time-Picker>
                                <!--                            <DatePicker type="datetimerange" format="yyyy-MM-dd HH:mm" placeholder="Select date and time(Excluding seconds)" style="width: 300px"></DatePicker>-->
                            </template>
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
            EID:'<?php echo $dataInfo["EID"]?>',
            VFTID:'',
            titlename: '<?php echo $dataInfo["titlename"]?>',
            visible: false,
            uploadList: [],
            dataList:[],
            singleChoiceData:[],
            singleChoiceKeys:<?php if(!empty($dataInfo["SCID"])) echo $dataInfo["SCID"]; else echo"[]"?>,
            multipleChoiceData:[],
            multipleChoiceKeys:<?php if(!empty($dataInfo["MCID"])) echo $dataInfo["MCID"]; else echo"[]"?>,
            trueorfalseChoiceData:[],
            trueorfalseChoiceKeys:<?php if(!empty($dataInfo["TFCID"])) echo $dataInfo["TFCID"]; else echo"[]"?>,
            rankChoiceData:[],
            rankChoiceKeys:<?php if(!empty($dataInfo["RCID"])) echo $dataInfo["RCID"]; else echo"[]"?>,
            memberData:[],
            memberKeys:<?php if(!empty($dataInfo["member"])) echo $dataInfo["member"]; else echo"[]"?>,
            dateStart:'<?php echo $dataInfo["dateStart"]?>',
            dateEnd:'<?php echo $dataInfo["dateEnd"]?>',
            selected:'',
            dateValue: ['<?php echo $dataInfo["dateStart"]?>', '<?php echo $dataInfo["dateEnd"]?>'],
            pkTime:'<?php echo $dataInfo["examTime"]?>',
            listStyle: {
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
            success:function(response, file, fileList){
                this.dataList.push(response.data);
                console.log(response);
            },
            timeChange:function(index)
            {
                this.pkTime = index;
            },
            getTransfer:function(data, type='S'){
                var returnData = [];
                for(var index in data)
                {
                    switch (type)
                    {
                        case "S":returnData.push({"key":data[index].SCID, "label": data[index].itemname, "disabled": false});break;
                        case "M":returnData.push({"key":data[index].MCID, "label": data[index].itemname, "disabled": false});break;
                        case "T":returnData.push({"key":data[index].TFCID, "label": data[index].itemname, "disabled": false});break;
                        case "ME":returnData.push({"key":data[index].userid, "label": data[index].nickname, "disabled": false});break;
                        case "R":returnData.push({"key":data[index].RCID, "label": data[index].itemname, "disabled": false});break;
                    }
                }
                return returnData;
            },
            upload:function()
            {
                aj.post("index.php?m=zyexam&c=examManage&a=editExam&pc_hash=<?php echo $_GET["pc_hash"]?>",{ titlename:this.titlename,RCID:this.rankChoiceKeys, SCID:this.singleChoiceKeys, MCID:this.multipleChoiceKeys , TFCID:this.trueorfalseChoiceKeys, dateStart:this.dateStart, dateEnd:this.dateEnd, member:this.memberKeys, EID:this.EID,examTime:this.pkTime},function(data){
                    if(data.code == 1)
                    {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    }
                    else
                        layer.msg("有数据未填写");
                });
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
            memberChange:function (newTargetKeys, direction, moveKeys){
                this.memberKeys = newTargetKeys;
            },
            dateChange:function(date, time){
                this.dateStart = date[0];
                this.dateEnd = date[1];
            }
        },
        mounted:function(){
            var that = this;
            aj.post("index.php?m=zyexam&c=examManage&a=getChoice&pc_hash=<?php echo $_GET["pc_hash"]?>",{},function(data){
                if(data.code == 1)
                {
                    that.singleChoiceData = that.getTransfer(data.data.singlechoice);
//                       console.log(data.data.singleChoiceData);
//                       console.log(that.singleChoiceData);
                    that.memberData = that.getTransfer(data.data.member, "ME");
                    that.multipleChoiceData = that.getTransfer(data.data.multiplechoice, "M");
                    that.trueorfalseChoiceData = that.getTransfer(data.data.trueorfalsechoice, "T");
                    that.rankChoiceData = that.getTransfer(data.data.rankchoice, "R");
                }
                else
                    layer.msg("有数据未填写");
            });
        }
    })
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
</body>
</html>