<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_header = 1;
include $this->admin_tpl('header', 'admin');
?>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js"></script>
<!--<script src="https://unpkg.com/vue-select@3.0.0"></script>-->
<!--<link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">-->
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
<style scoped>
    .demo-badge{
        width: 42px;
        height: 42px;
        background: #eee;
        border-radius: 6px;
        display: inline-block;
    }
</style>

<div class="pad-10" id="app">
    <div class="common-form">
        <div id="div_setting_2" class="contentList">
            <fieldset>
                <legend>商品添加</legend>
                <table  class="table_form">
                    <tbody>
                    <tr>
                        <th style="width: 120px">商品标题</th>
                        <td>
                            <textarea  required v-model="titlename" id="" cols="70" rows="2" maxlength="200" onchange="this.value=this.value.substring(0, 200)" onkeydown="this.value=this.value.substring(0, 200)" onkeyup="this.value=this.value.substring(0, 200)"></textarea>

                        </td>
                    </tr>
                    <tr>
                        <th style="width: 120px">商品描述</th>
                        <td>
                            <textarea  required v-model="description" id="" cols="70" rows="2" maxlength="200" onchange="this.value=this.value.substring(0, 200)" onkeydown="this.value=this.value.substring(0, 200)" onkeyup="this.value=this.value.substring(0, 200)"></textarea>

                        </td>
                    </tr>
                    <tr>
                        <th style="width: 120px">商品图片</th>
                        <td>

                            <div style="width: 161px; text-align: center;">
                                <div class='upload-pic img-wrap'><input type='hidden' name='info[photourl]' id='thumb' required="" v-model="thumb">
                                    <a href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb',thumb_images,'1,jpg|jpeg|gif|png|bmp,1,,,0','content','6','<?php echo $authkey;?>');return false;">
                                        <img src='statics/images/icon/upload-pic.png' id='thumb_preview' width='135' height='113' style='cursor:hand; margin-left: 13px;' /></a><!-- <input type="button" style="width: 66px;" class="button" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁切图片"> --><input type="button" style="width: 66px;" class="button" onclick="$('#thumb_preview').attr('src','statics/images/icon/upload-pic.png');$('#thumb').val(' ');return false;" value="取消图片">
                                </div>
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <th style="width: 120px">商品详情图</th>
                        <td><input name="goodsimg" type="hidden" value="1">

                           <div class='onShow' id='nameTip'>您最多可以同时上传 <font color='red'>50</font> 张</div></center><div id="goodsimg" class="picList"></div>

                            <div class="bk10"></div>
                            <div class='picBut cu'><a href='javascript:void(0);' @click="uploadMoreImg()"/> 选择图片 </a></div>
                            <div style="clear: both"></div>
                            <div style="display: inline-block">
                                <template v-for="(item,index) in img">
                                    <li style="position: relative;margin: 15px 15px 10px 0;display: inline-block"  @click="del_img(index)">
                                        <Badge text="X">
                                            <img :src="item" width='60' height='60' style='cursor:hand; margin-left: 13px;'/>
                                        </Badge>

                                    </li>

                                </template>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <th style="width: 120px">商品价格</th>
                        <td>
                            <i-input v-model="money"  placeholder="请输入价格" type="number" style="width: 300px"></i-input>

                        </td>
                    </tr>
                    <tr>
                        <th style="width: 120px">商品奖励金</th>
                        <td>
                            <i-input v-model="awardMoney"  placeholder="请输入金额" type="number" style="width: 300px"></i-input>

                        </td>
                    </tr>
                    <tr>
                        <th style="width: 120px">商品佣金</th>
                        <td>
                            <li>上一级会员佣金：{{money * fxC[1] / 100}}元</li>
                            <li>上二级会员佣金：{{money * fxC[2] / 100}}元</li>
                            <li>上三级会员佣金：{{money * fxC[3] / 100}}元</li>
                        </td>
<!--                        <i-Time :time="time1">-->
                    </tr>
                    <tr>
                        <th style="width: 120px">任务总数</th>
                        <td>
                            <i-input v-model="num"  placeholder="请输入数量" type="number" style="width: 300px"></i-input>

                        </td>
                    </tr>
                    <tr >
                        <th style="width: 120px">截止时间</th>
                        <th>
                            <template>
                                <Date-Picker type="datetime" placeholder="选择截止日期" format="yyyy-MM-dd HH:mm:ss" style="width: 300px" @on-change="dateChange"></Date-Picker>
<!--                                <Date-Picker @on-change="dateChange" type="datetimerange" format="yyyy-MM-dd HH:mm:ss" placeholder="Select date and time(Excluding seconds)" style="width: 300px"></Date-Picker>-->
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
    // Vue.component("v-select", VueSelect.VueSelect);
    var layer = layui.layer,
        form = layui.form,
        $ = layui.jquery,
        upload = layui.upload,
        table = layui.table;
    window.parent.app12 = new Vue({
        el:"#app",
        data:{
            titlename:"",
            description:"",
            money:"",
            img:[],
            thumb:"",
            num:"",
            endtime:"",
            awardMoney:"",
            fxC:<?php echo $fxC["awardNumber"]?>
            // time1:(new Date()).getTime() + 60*3*1000
        },
        methods:{
            upload:function()
            {
                aj.post("index.php?m=zyshop&c=shopManage&a=addShop&pc_hash=<?php echo $_GET["pc_hash"]?>",{titlename:this.titlename, description:this.description,money:this.money, thumbs:this.img , thumb:this.thumb, num:this.num, endtime:this.endtime, awardMoney:this.awardMoney},function(data){
                    if(data.code == 200)
                    {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    }
                    else
                        layer.msg("有数据未填写");
                });
            },
            dateChange:function(date, time){ //获取结束时间
                this.endtime = date;
            },
            uploadMoreImg:function()//cms自带的图片上传，集成到vue中
            {
                flashupload('goodsimg_images', '附件上传',this,change_images_vue,'50,gif|jpg|jpeg|png|bmp,0','content','0','<?php echo $authkeys;?>') ;
            },
            del_img:function(index) //删除图片的
            {
                console.log(index);
                this.img.splice(index, 1);
            }

        },

    })
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>

<script type="text/javascript">
    function crop_cut_thumb(id){
        if (id=='') { alert('请先上传缩略图');return false;}
        window.top.art.dialog({title:'裁切图片', id:'crop', iframe:'index.php?m=content&c=content&a=public_crop&module=content&catid='+0+'&picurl='+encodeURIComponent(id)+'&input=thumb&preview=thumb_preview', width:'680px', height:'480px'}, 	function(){var d = window.top.art.dialog({id:'crop'}).data.iframe;
            d.uploadfile();return false;}, function(){window.top.art.dialog({id:'crop'}).close()});
    };
</script>
</body>
</html>