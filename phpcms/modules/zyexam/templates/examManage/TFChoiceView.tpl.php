<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>member_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo APP_PATH?>statics/layui-v2.5.3/layui/css/layui.css">
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js"></script>

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


    <input type="hidden" value=<?php echo $dataInfo["SCID"]?> name="SCID">
    <div class="pad-10">
        <div class="common-form">
            <div id="div_setting_2" class="contentList">
                <fieldset>
                    <legend>基本信息</legend>
                    <table  class="table_form">
                        <tbody>
                        <tr>
                            <th style="width: 120px">题目</th>
                            <td>
                                <?php echo $dataInfo["itemname"]?>
                            </td>
                        </tr>

                        <tr>
                            <th width="120">答案</th>
                            <td>
                                       <?php if($dataInfo["answer"]==1)echo "对"; else echo "错";?>
<!--                                <input type="text" name="info[price]" value="--><?php //echo $dataInfo["answer"]?><!--" class="input-text" id="price" size="15">-->
                            </td>
                        </tr>
                        <tr>
                            <th width="120">出处</th>
                            <td><?php echo $dataInfo["provenance"]?></td>
                        </tr>
                        <tr>
                            <th width="120">条目</th>
                            <td><?php echo $dataInfo["clause"]?></td>
                        </tr>
                        <tr>
                            <th width="120">类别</th>
                            <td><?php echo $dataInfo["category"]?></td>
                        </tr>
                        </tbody>
                    </table>
                </fieldset>
                <div class="bk15"></div>

            </div>


        </div>

    </div>
    </div>

<script>
    function zz()
    {
        var workType = $("#workType1").val();
        console.log(222);
        if(workType === '')
        {console.log(workType);
            parent.layer.msg("请选择工种");
            return false;
        }
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
        return true;
    }
    var workType = new Vue({
        el:"#workType",
        data:{
            options: [
                {"DBname": "glry", "name": "管理人员"},
                {"DBname": "khfwy", "name": "客户服务员"},
                {"DBname": "kyy", "name": "客户员"},
                {"DBname": "kyzby", "name": "客运值班员"},
                {"DBname": "spy", "name": "售票员"},
                {"DBname": "jhy", "name": "计划员"},
                {"DBname": "spzby", "name": "售票值班员"},
                {"DBname": "lcz", "name": "列车长"},
                {"DBname": "lcy", "name": "列车员"},
                {"DBname": "lczby", "name": "列车值班员"},
                {"DBname": "xly", "name": "行李员"},
                {"DBname": "xlzby", "name": "行李值班员"},
                {"DBname": "kfzky", "name": "客服综控员"},
                {"DBname": "gsy", "name": "给水员"},
                {"DBname": "ccz", "name": "餐车长"}
            ],//工种属性，先写死吧
            checked:<?php print_r($ret)?>,
        }
    })
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
</body>
</html>