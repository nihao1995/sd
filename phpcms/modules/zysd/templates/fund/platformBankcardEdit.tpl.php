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
                <legend>平台银行卡配置</legend>
                <table  class="table_form">
                    <tbody>
                    <tr>
                        <th style="width: 120px">平台银行账户</th>
                        <td>
                            <i-input v-model="platform_bankcard_number"  placeholder="请输入" type="text" style="width: 300px"></i-input>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 120px">开户银行</th>
                        <td>
                            <i-input v-model="platform_bankcard_name"  placeholder="请输入" type="text" style="width: 300px"></i-input>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 120px">持卡人姓名</th>
                        <td>
                            <i-input v-model="platform_bankcard_keeper"  placeholder="请输入" type="text" style="width: 300px"></i-input>
<!--                            <i-switch v-model="status" size="large" @on-change="change">-->
<!--                                <span slot="open">On</span>-->
<!--                                <span slot="close">Off</span>-->
<!--                            </i-switch>-->
                        </td>
                    </tr>
                    </tbody>
                </table>
            </fieldset>
            <div class="bk15"></div>

        </div>
        <div style="text-align: center">
            <button class="layui-btn layui-btn-sm"   type="button" @click="upload">更新</button>
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
            platform_bankcard_number:"<?php echo $dataInfo['platform_bankcard_number']?>",
            platform_bankcard_name:"<?php echo $dataInfo['platform_bankcard_name'] ?>",
            platform_bankcard_keeper:"<?php echo $dataInfo['platform_bankcard_keeper'] ?>"
        },
        methods:{
            upload:function()
            {
                aj.post("index.php?m=zysd&c=zysd&a=edit_platform_bankcard&pc_hash=<?php echo $_GET["pc_hash"]?>",{platform_bankcard_number:this.platform_bankcard_number, platform_bankcard_name:this.platform_bankcard_name,platform_bankcard_keeper:this.platform_bankcard_keeper},function(data){
                    if(data.code == 200)
                    {
                        layer.msg(data.message);
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    }
                    else
                        layer.msg(data.message);
                });
            },
            change (status) {
                var that=this
                this.$Message.info('开关状态：' + status);
                console.log(that.status);
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