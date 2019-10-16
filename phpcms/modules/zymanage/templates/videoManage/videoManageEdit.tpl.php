<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>member_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo APP_PATH?>statics/layui-v2.5.3/layui/css/layui.css">
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo APP_PATH?>statics/layui-v2.5.3/layui/css/layui.css">
<script src="https://unpkg.com/vue-select@3.0.0"></script>
<link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
<link rel="stylesheet" href="//unpkg.com/iview/dist/styles/iview.css">
<link rel="stylesheet" type="text/css" href="<?php echo APP_PATH?>statics/layui-v2.5.3/layui/css/layui.css">
<script type="text/javascript" src="<?php echo APP_PATH?>statics/js/ajax.js"></script>
<script src="<?php echo APP_PATH?>statics/layui-v2.5.3/layui/layui.all.js"></script>
<script type="text/javascript" src="<?php echo APP_PATH?>statics/vue/iview.min.js"></script>

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
</style>

<form name="myform" id="myform" action="?m=zymanage&c=videoManage&a=editVideoManage" method="post" onsubmit="pushData()">
    <input type="hidden" value=<?php echo $dataInfo["VID"]?> name="VID">
    <div class="pad-10">
        <div class="common-form">
            <div id="div_setting_2" class="contentList">
                <fieldset>
                    <legend>基本信息</legend>
                    <table  class="table_form">
                        <tbody>
                        <tr>
                            <th style="width: 120px">视频标题</th>
                            <td>
                                <textarea name="info[titlename]" id="" cols="70" rows="2" maxlength="200" onchange="this.value=this.value.substring(0, 200)" onkeydown="this.value=this.value.substring(0, 200)" onkeyup="this.value=this.value.substring(0, 200)"><?php echo $dataInfo["titlename"]?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 120px">视频内容</th>
                            <td>
                                <textarea name="info[content]" id="" cols="70" rows="3 " maxlength="200" onchange="this.value=this.value.substring(0, 200)" onkeydown="this.value=this.value.substring(0, 200)" onkeyup="this.value=this.value.substring(0, 200)"><?php echo $dataInfo["content"]?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 120px">图片</th>
                            <td>
                                <div style="width: 161px; text-align: center;">
                                    <div class='upload-pic img-wrap'><input type='hidden' name='thumb' id='thumb' required="" value='<?php echo $dataInfo["photo"]?>'>
                                        <a href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb',thumb_images,'1,jpg|jpeg|gif|png|bmp,1,,,0','content','6','<?php echo $authkey;?>');return false;">
                                            <img src='<?php if($dataInfo['photo']) { echo $dataInfo['photo']; } else { echo "statics/images/icon/upload-pic.png"; } ?>' id='thumb_preview' width='135' height='113' style='cursor:hand; margin-left: 13px;' /></a><!-- <input type="button" style="width: 66px;" class="button" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁切图片"> --><input type="button" style="width: 66px;" class="button" onclick="$('#thumb_preview').attr('src','statics/images/icon/upload-pic.png');$('#thumb').val(' ');return false;" value="取消图片"><script type="text/javascript">function crop_cut_thumb(id){
                                                if (id=='') { alert('请先上传缩略图');return false;}
                                                window.top.art.dialog({title:'裁切图片', id:'crop', iframe:'index.php?m=content&c=content&a=public_crop&module=content&catid='+0+'&picurl='+encodeURIComponent(id)+'&input=thumb&preview=thumb_preview', width:'680px', height:'480px'}, 	function(){var d = window.top.art.dialog({id:'crop'}).data.iframe;
                                                    d.uploadfile();return false;}, function(){window.top.art.dialog({id:'crop'}).close()});
                                            };</script>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="app">
                            <template >
                                <th style="width: 120px">视频地址</th>
                                <th>
                                    <Upload :format="['mp4']" :on-format-error="format" :max-size="20480" :before-upload="Bupload"  :on-exceeded-size="exceeded" :default-file-list="uploadList"  :on-success="success" :on-remove="remove" action="index.php?m=zymanage&c=fileManage&a=upFile&pc_hash=<?php echo $_GET["pc_hash"]?>" >
                                        <i-Button icon="ios-cloud-upload-outline">Upload files</i-Button>
                                    </Upload>
                                    <input  type="hidden" name="info[videoAddr]" v-model="videoAddr" style="width:80%"   >
                                    <template v-if="videoAddr!==''">
                                        <video  width="300" height="200" controls :src="videoAddr"></video>
                                    </template>
                                </th>
                            </template>
                        </tr>

                        <tr>
                            <th width="120">类别</th>
                            <th>
                            <select name="info[VFTID]">
                                <?php foreach($category as $key=>$value){?>
                                    <option value=<?php echo $value["VFTID"]?> <?php if($dataInfo["VFTID"]== $value["VFTID"]) echo "selected"?>><?php echo $value["typename"]?></option>
                                <?php }?>
                            </select>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </fieldset>
                <div class="bk15"></div>

            </div>
            <div style="text-align: center">
                <button class="layui-btn layui-btn-sm"   type="submit"  >确认</button>
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
    var layer = layui.layer,
        form = layui.form,
        $ = layui.jquery,
        upload = layui.upload,
        table = layui.table;
    window.parent.app12 = new Vue({
        el: "#app",
        data: {
            categoryplaceholder: '选择分类',
            categoryoptions: [],
            category: '',
            VFTID: '',
            titlename: '',
            visible: false,
            uploadList: [{"name":"<?php echo $dataInfo["titlename"]?>", "url":"<?php echo $dataInfo["videoAddr"]?>"}],
            dataList: [],
            videoAddr: '<?php echo $dataInfo["videoAddr"]?>'
        },
        methods: {
            remove: function (file, fileList) {
                this.videoAddr = '';
            },
            success: function (response, file, fileList) {
                console.log(response.data);
                this.videoAddr = response.data.url;
            },
            getFTID: function (values) {
                this.VFTID = values.VFTID;
            },
            exceeded: function (file, fileList) {
                layer.msg('文件过大')
            },
            Bupload: function () {
                if (this.videoAddr !== '') {
                    layer.msg("只能上传一个文件");
                    return false;
                }
            },
            format:function(){
                layer.msg("上传文件类型错误");
            }
        }
    })
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
</body>
</html>