<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
    $show_header = 1;
	include $this->admin_tpl('header','admin');
?>
<!--树形图css和js导入-->
<!--<link rel="stylesheet" type="text/css" href="--><?php //echo APP_PATH?><!--statics/zTree_v3/css/zTreeStyle/zTreeStyle.css">-->
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo APP_PATH?>statics/zTree_v3/css/metroStyle/metroStyle.css">
<script type="text/javascript" src="<?php echo APP_PATH?>statics/zTree_v3/js/jquery.ztree.core.js"></script>
<script type="text/javascript" src="<?php echo APP_PATH?>statics/zTree_v3/js/jquery.ztree.excheck.js"></script>
<script type="text/javascript" src="<?php echo APP_PATH?>statics/js/ajax.js"></script>
<!--<script type="text/javascript" src="--><?php //echo APP_PATH?><!--statics/zTree_v3/js/jquery.ztree.all.js"></script>-->
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script type="text/javascript" src="<?php echo APP_PATH?>statics/zTree_v3/js/jquery.ztree.exedit.js"></script>
<script type="text/javascript" src="<?php echo APP_PATH?>statics/vue/iview.min.js"></script>
<!--<link rel="stylesheet" type="text/css" href="--><?php //echo APP_PATH?><!--statics/vue/iview.css">-->
<link rel="stylesheet" href="//unpkg.com/iview/dist/styles/iview.css">
<link rel="stylesheet" type="text/css" href="<?php echo APP_PATH?>statics/layui-v2.5.3/layui/css/layui.css">
<script src="<?php echo APP_PATH?>statics/layui-v2.5.3/layui/layui.all.js"></script>
<script src="https://unpkg.com/vue-select@3.0.0"></script>
<link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">

<style>
    .btn { display: inline-block; padding: 0px 5px; margin-bottom: 0; font-size: 12px; font-weight: 400; line-height: 1.32857143; text-align: center; white-space: nowrap; vertical-align: middle; -ms-touch-action: manipulation; touch-action: manipulation; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px; margin-left: 5px;}
    .btn-info { background-image: -webkit-linear-gradient(top,#5bc0de 0,#2aabd2 100%); background-image: -o-linear-gradient(top,#5bc0de 0,#2aabd2 100%); background-image: -webkit-gradient(linear,left top,left bottom,from(#5bc0de),to(#2aabd2)); background-image: linear-gradient(to bottom,#5bc0de 0,#2aabd2 100%); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5bc0de', endColorstr='#ff2aabd2', GradientType=0); filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); background-repeat: repeat-x; border-color: #28a4c9;}
    .btn-info { color: #fff; background-color: #5bc0de; border-color: #46b8da;}

    .btn-danger { background-image: -webkit-linear-gradient(top,#d9534f 0,#c12e2a 100%); background-image: -o-linear-gradient(top,#d9534f 0,#c12e2a 100%); background-image: -webkit-gradient(linear,left top,left bottom,from(#d9534f),to(#c12e2a)); background-image: linear-gradient(to bottom,#d9534f 0,#c12e2a 100%); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffd9534f', endColorstr='#ffc12e2a', GradientType=0); filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); background-repeat: repeat-x; border-color: #b92c28;}
    .btn-danger { color: #fff; background-color: #d9534f; border-color: #d43f3a;}

    .btn-success { background-image: -webkit-linear-gradient(top,#5cb85c 0,#419641 100%); background-image: -o-linear-gradient(top,#5cb85c 0,#419641 100%); background-image: -webkit-gradient(linear,left top,left bottom,from(#5cb85c),to(#419641)); background-image: linear-gradient(to bottom,#5cb85c 0,#419641 100%); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5cb85c', endColorstr='#ff419641', GradientType=0); filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); background-repeat: repeat-x; border-color: #3e8f3e;}
    .btn-success { color: #fff; background-color: #5cb85c; border-color: #4cae4c;}
    a:hover{ text-decoration: none; }
    .page{
        text-align: right;
    }
    .ztree *{
        font-size: 16px;
    }
    .page div{
        display: inline-block;
        text-align: right;
        border-radius: 5px;
        padding: 0;
        display: inline-block;
        list-style: none;
        border: 1px solid #ddd;
        color: #337ab7;
    }
    .page span{
        display: inline-block;
        line-height: 35px;
        padding: 0 15px;
        border-left: 1px solid #ddd;
        margin-right: -5px;
        cursor:pointer;
    }
    .page span:first-of-type{
        border-style: none;
        cursor:pointer;
    }
    .page-on{
        background-color: #337ab7;
        color: #fff;

    }

    .header_box{
        height: 50px;
    }
    .header_box .box{
        margin-left: 20px;
    }
    .header_box .submit{
        padding:5px;
        background-color: #2aabd2;
        color: white;
        font-size: 14px;
    }
    .body_box{
        border: 1px solid transparent;
    }
    .body_box thead{
        border-radius: 4px;
        background-color: #eef3f7;
        vertical-align: middle;
        display: table-header-group;
    }
    .body_box thead tr{
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
        font-size:20px;
        font-weight: normal;
    }
    [v-cloak]{
        display: none;
    }

</style>

<!--<div class="subnav">-->
<!--    <div class="content-menu ib-a blue line-x">-->
<!--        <a class="add fb" href="javascript:window.top.art.dialog({id:'add',iframe:'?m=zymanage&c=memberFun&a=typeAdd',title:'添加商品分类', width:'800', height:'500', lock:true}, function(){var d = window.top.art.dialog({id:'add'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;},function(){window.top.art.dialog({id:'add'}).close()});void(0);">-->
<!--        <em>添加商品分类</em></a>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="layui-container">-->
    <div class="layui-row layui-col-space10" id="departmentTree">
        <div class="layui-col-md8">
            <div class="pad-10">
                <fieldset>
                    <legend style=" display: inline-block; float:left;">部门树形图</legend>
                    <div class="bk15"></div>
                    <div id="test1"></div>
                    <div>
                        <ul id="treeDemo" class="ztree"></ul>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="layui-col-md4">
            <div class="layui-row">
                <div class="pad-10 ">
                    <fieldset>
                        <legend style=" display: inline-block; float:left;">操作</legend>
                        <div class="bk15"></div>
                        <button class="layui-btn" style="width: 31%" onclick="expand(true)">展开所有 </button>
                        <button class="layui-btn" style="width: 31%" onclick="expand(false)">收起所有 </button>
                        <button class="layui-btn" style="width: 31%" onclick="addNewNode()">增加头节点 </button>
                    </fieldset>
                </div>
            </div>
                <div class="layui-row">
                    <div class="pad-10" style="overflow: visible">
                        <fieldset>
                            <legend style=" display: inline-block; float:left;">管理人添加</legend>
<!--                            <div class="bk15"></div>-->
<!--                            规格名：-->
<!--                            <input type="text" name="title" id="spcName" required lay-verify="required" placeholder="请输入规格名" autocomplete="off" class="layui-input" style="width: 30%; display: inline;">-->
<!--                            是否显示：-->
<!--                            <select name="isshow" lay-verify="" id="spcShow"  class="layui-select">-->
<!--                                <option value="">是否显示？</option>-->
<!--                                <option value="1">是</option>-->
<!--                                <option value="2">否</option>-->
<!--                            </select>-->
<!--                            <input type="hidden" id="show_typeid" value=""/>-->
<!--                            <button class="layui-btn" style="margin-left: 30px;" onclick="addSpc()">添加</button>-->
                            <div class="bk15"></div>
                            人员名：
                            <v-select :options="cityList" :placeholder="categoryplaceholder" :multiple="false" :taggable="false" style="z-index:999;width: 30%; display: inline-block;"
                                      :close-on-select="true"  label="nickname" v-model="choiceMemberID"
                            ></v-select>
                            工号：
                            <template v-if="choiceMemberID"><span v-cloak>{{choiceMemberID.job_number}}</span></template>
                            <button class="layui-btn" style="margin-left: 30px;" @click="addSpc()">添加</button>
                        </fieldset>
                    </div>
                </div>
                <div class="layui-row">
                    <div  class="pad-10 ">
                        <fieldset>
                            <legend style=" display: inline-block; float:left;">管理人查询</legend>
                            <div class="bk15"></div>
                            <table class="layui-table">
                                <colgroup>
                                    <col width="150">
                                    <col width="200">
                                    <col>
                                </colgroup>
                                <thead>
                                <tr>
                                    <th>姓名</th>
                                    <th>工号</th>
                                    <th>添加时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody id="specTable">

                                </tbody>
                            </table>
                        </fieldset>
                    </div>
                </div>
<!--            <div class="layui-row">
                <div class="pad-10 ">
                    <fieldset>
                        <legend style=" display: inline-block; float:left;">商品节点分类图</legend>
                        <div class="bk15"></div>

                        <div style="text-align: center">
                        <a href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb',thumb_images,'1,jpg|jpeg|gif|png|bmp,1,,,0','content','6','<?php echo $authkey;?>');return false;">
                            <img src="statics/images/member/nophoto.gif" id='thumb_preview' name="info[photo]" height="200" width="200" onerror="this.src='statics/images/member/nophoto.gif'">
                            <input type="hidden" name="thumb" id="thumb" value=""/>
                            <input type="hidden" id="typeid" value=""/>
                        </a>
                        <button class="layui-btn" onclick="uploadImg()">上传 </button>
                        </div>

                    </fieldset>
                </div>
            </div>-->
        </div>

    </div>

<script>
    ;
    ! function () {
        var layer = layui.layer,
            form = layui.form,
            $ = layui.jquery,
            upload = layui.upload,
            table = layui.table;
    }();
    var setting = {
        view: {
            addHoverDom: addHoverDom,//光标放在上面发生的事（添加节点也在这里触发）
            removeHoverDom: removeHoverDom,
            selectedMulti: false, //在复制的时候，是否允许选中多个节点，true为支持，按下ctrl键生效，false不支持
        },
        edit: {
            drag:{
                isCopy:true,
                isMove:true,
                inner:true,
                prev:false,
                next:false
            },
            enable: true,
            editNameSelectAll: true,
            showLine:true,
            showRemoveBtn: true,
            showRenameBtn: true,

        },

        data: {
            simpleData: {
                enable: true
            }
        },
        callback: {
//            beforeDrag: beforeDrag, //拖拽之前1
//            beforeDrop: beforeDrop, //拖拽成功之前发生
//            beforeDragOpen: beforeDragOpen,
//            onDrag: onDrag,//拖拽之前2
            beforeRemove: beforeRemove,//节点删除之前
//            beforeEditName: beforeEditName,//编辑之前
//            beforeRename: beforeRename,//节点改名之前
            onRemove: onRemove,//节点删除之后
            onRename: onRename,//节点改名之后
            onDrop: onDrop,//拖拽成功之后发生
            onExpand: onExpand,//展开节点
            onClick: onClick
        }
    };
    //*************************暂时注释掉，可能以后要用
//    function beforeDrop(treeId, treeNodes, targetNode, moveType, isCopy) {
//        console.log("拖拽之后发生1");
//        console.log(treeNodes);
//        className = (className === "dark" ? "":"dark");
//        showLog("[ "+getTime()+" beforeDrop ]&nbsp;&nbsp;&nbsp;&nbsp; moveType:" + moveType);
//        showLog("target: " + (targetNode ? targetNode.name : "root") + "  -- is "+ (isCopy==null? "cancel" : isCopy ? "copy" : "move"));
//        return true;
//    }
//    function onDrag(event, treeId, treeNodes) {
//        console.log("拖拽之前发生2");
//        className = (className === "dark" ? "":"dark");
//        showLog("[ "+getTime()+" onDrag ]&nbsp;&nbsp;&nbsp;&nbsp; drag: " + treeNodes.length + " nodes." );
//    }
//    function beforeDrag(treeId, treeNodes) {
//        console.log("拖拽之后发生1");
//        className = (className === "dark" ? "":"dark");
//        showLog("[ "+getTime()+" beforeDrag ]&nbsp;&nbsp;&nbsp;&nbsp; drag: " + treeNodes.length + " nodes." );
//        for (var i=0,l=treeNodes.length; i<l; i++) {
//            if (treeNodes[i].drag === false) {
//                curDragNodes = null;
//                return false;
//            } else if (treeNodes[i].parentTId && treeNodes[i].getParentNode().childDrag === false) {
//                curDragNodes = null;
//                return false;
//            }
//        }
//        curDragNodes = treeNodes;
//        return true;
//    }
//    function dropPrev(treeId, nodes, targetNode) {
//        var pNode = targetNode.getParentNode();
//        if (pNode && pNode.dropInner === false) {
//            return false;
//        } else {
//            for (var i=0,l=curDragNodes.length; i<l; i++) {
//                var curPNode = curDragNodes[i].getParentNode();
//                if (curPNode && curPNode !== targetNode.getParentNode() && curPNode.childOuter === false) {
//                    return false;
//                }
//            }
//        }
//        return true;
//    }
//    function dropInner(treeId, nodes, targetNode) {
//        if (targetNode && targetNode.dropInner === false) {
//            return false;
//        } else {
//            for (var i=0,l=curDragNodes.length; i<l; i++) {
//                if (!targetNode && curDragNodes[i].dropRoot === false) {
//                    return false;
//                } else if (curDragNodes[i].parentTId && curDragNodes[i].getParentNode() !== targetNode && curDragNodes[i].getParentNode().childOuter === false) {
//                    return false;
//                }
//            }
//        }
//        return true;
//    }
//    function dropNext(treeId, nodes, targetNode) {
//        var pNode = targetNode.getParentNode();
//        if (pNode && pNode.dropInner === false) {
//            return false;
//        } else {
//            for (var i=0,l=curDragNodes.length; i<l; i++) {
//                var curPNode = curDragNodes[i].getParentNode();
//                if (curPNode && curPNode !== targetNode.getParentNode() && curPNode.childOuter === false) {
//                    return false;
//                }
//            }
//        }
//        return true;
//    }
//    function beforeDragOpen(treeId, treeNode) {
//        autoExpandNode = treeNode;
//        return true;
//    }
//    function beforeEditName(treeId, treeNode) {
//        className = (className === "dark" ? "":"dark");
//        showLog("[ "+getTime()+" beforeEditName ]&nbsp;&nbsp;&nbsp;&nbsp; " + treeNode.name);
//        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
//        console.log(treeNode);
//        zTree.selectNode(treeNode);
//        setTimeout(function() {
//            if (confirm("进入节点 -- " + treeNode.name + " 的编辑状态吗？")) {
//                setTimeout(function() {
//                    zTree.editName(treeNode);
//                }, 0);
//            }
//        }, 0);
//        return false;
//    }
    //**********************************************************************

    var log, className = "dark", curDragNodes, autoExpandNode;
    function onDrop(event, treeId, treeNodes, targetNode, moveType, isCopy) {  //拖拽的代码
        console.log("拖拽之后发生2");
        className = (className === "dark" ? "":"dark");
        console.log(treeNodes);
        if(treeNodes[0].pId == null)
            treeNodes[0].pId = 0;
        aj.post("index.php?m=zymanage&c=memberFun&a=changepArgAjax&pc_hash=<?php echo $_GET["pc_hash"]?>",{DID:treeNodes[0].id, pId:treeNodes[0].pId}, function (data) {
            if(data.code == '1')
            {
                showLog("[ "+getTime()+" onDrop ]&nbsp;&nbsp;&nbsp;&nbsp; moveType:" + moveType);
                showLog("target: " + (targetNode ? targetNode.name : "root") + "  -- is "+ (isCopy==null? "cancel" : isCopy ? "copy" : "move"))
            }
        });
    }
    function onExpand(event, treeId, treeNode) {
        if (treeNode === autoExpandNode) {
            className = (className === "dark" ? "":"dark");
            showLog("[ "+getTime()+" onExpand ]&nbsp;&nbsp;&nbsp;&nbsp;" + treeNode.name);
        }
    }
//    var log, className = "dark";

    function beforeRemove(treeId, treeNode) {
        className = (className === "dark" ? "":"dark");
        showLog("[ "+getTime()+" beforeRemove ]&nbsp;&nbsp;&nbsp;&nbsp; " + treeNode.name);
        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
        zTree.selectNode(treeNode);
        return confirm("确认删除 节点 -- " + treeNode.name + " 吗？它下面的子节点也会随之删除");
    }
    function onRemove(e, treeId, treeNode) {
//        console.log("删除节点");
        var id = new Array();
        getChirdID(id, treeNode);
        console.log(id);
//        console.log(treeNode);
        aj.post("index.php?m=zymanage&c=memberFun&a=delAjax&pc_hash=<?php echo $_GET["pc_hash"]?>",{DID:id}, function (data) {
        });
        showLog("[ "+getTime()+" onRemove ]&nbsp;&nbsp;&nbsp;&nbsp; " + treeNode.name);
    }
    function getChirdID(id, treeNode)
    {
        id.push(treeNode.id);
        if(!(typeof(treeNode.children) ==  "undefined"))
        {
            for(var x in treeNode.children)
            {
                getChirdID(id, treeNode.children[x]);
            }
        }

    }
    function uploadImg()
    {
        var thumbPath = $('#thumb').val();
        var id = $('#DID').val();
        console.log(thumbPath);
        aj.post("index.php?m=zymanage&c=memberFun&a=changepArgAjax&pc_hash=<?php echo $_GET["pc_hash"]?>", {DID:id, typeImg:thumbPath}, function(data){
            if (data.code == '1') {
              layer.msg("上传成功");
                var zTree = $.fn.zTree.getZTreeObj("treeDemo");
                var treeNode = zTree.getNodeByParam("id", id);
                treeNode.typeImg = thumbPath;
                zTree.updateNode(treeNode);
            }
        });
    }
    function addSpc(userid)
    {
        console.log(userid);
        return ;
        var DID = $("#show_DID").attr('value');
        if(DID == "")
        {
            layer.msg("请选择类型");return;
        }
        var specName = $("#spcName").attr('value');
        if(spcName == "")
        {
            layer.msg("请输入名称");return;
        }
        var specShow = $("#spcShow").attr('value');
        if(spcShow == "")
        {
            layer.msg("选择是否显示");return;
        }
        aj.post("index.php?m=zymanage&c=memberFun&a=addSpecAjax&pc_hash=<?php echo $_GET["pc_hash"]?>", {DID:DID, specName:specName, isShow:specShow}, function(data){
            if(data.code == '1')
            {
                layer.msg("添加成功");
                getSpec(DID);
            }
            else
                layer.msg(data.message);
        });
    }
    function getSpec(DID)
    {
        console.log(123)
        aj.post("index.php?m=zymanage&c=memberFun&a=getSpecAjax&pc_hash=<?php echo $_GET["pc_hash"]?>", {DID:DID}, function(data){
            $("#specTable tr").remove();
            console.log(data.data);
            department.cityList = data.data.memberInfo;
            department.choiceMemberID = '';
            department.DID = DID;
            department.memberMange = [];
            for(var i in data.data.isManagement)
            {
                department.memberMange.push(data.data.isManagement[i].userid);
                //var isshow = data.data[i].isShow == '1'? "是": "否";
                var info = "<tr><td class='c1'>"+data.data.isManagement[i].nickname +"</td><td class='c1'>"+data.data.isManagement[i].job_number +"</td>  <td>"+data.data.isManagement[i].addtime +"</td><td>    <a class=\"layui-btn layui-btn-danger layui-btn-xs\" onclick='delSpc("+data.data.isManagement[i].MGLID+", "+DID+")' >删除</a></td> </tr>"
                console.log(info);
                $("#specTable").append(info);
            }
//            changeData();
        });
    }
    function delSpc(MGLID, DID)
    {
        layer.confirm("确定删除吗？", {icon:3, title:'提示'}, function(index){
           aj.post("index.php?m=zymanage&c=memberFun&a=delSpecAjax&pc_hash=<?php echo $_GET["pc_hash"]?>", {MGLID:MGLID}, function(data){
               if (data.code == '1') {
                    layer.msg("删除成功");
                   getSpec(DID);
               }
               else
                   layer.msg(data.message);
               layer.close(index);
            })
        });
    }
    function onClick(event, id, treeNode)
    {
        $("#thumb_preview").attr('src', treeNode.typeImg);
        $("#thumb").attr('value',  treeNode.typeImg);
        $("#typeid").attr('value',  treeNode.id);
        $("#show_typeid").attr('value',  treeNode.id);
        getSpec(treeNode.id);
        console.log(treeNode.id+"被选中");
    }
    function beforeRename(treeId, treeNode, newName, isCancel) {
        className = (className === "dark" ? "":"dark");
        showLog((isCancel ? "<span style='color:red'>":"") + "[ "+getTime()+" beforeRename ]&nbsp;&nbsp;&nbsp;&nbsp; " + treeNode.name + (isCancel ? "</span>":""));
        if (newName.length == 0) {
            setTimeout(function() {
                var zTree = $.fn.zTree.getZTreeObj("treeDemo");
                zTree.cancelEditName();
                alert("节点名称不能为空.");
            }, 0);
            return false;
        }
        return true;
    }
    function onRename(e, treeId, treeNode, isCancel) {
        aj.post("index.php?m=zymanage&c=memberFun&a=changepArgAjax&pc_hash=<?php echo $_GET["pc_hash"]?>", {DID:treeNode.id, workshop:treeNode.name}, function(data){
            if (data.code == '1') {
                showLog((isCancel ? "<span style='color:red'>":"") + "[ "+getTime()+" onRename ]&nbsp;&nbsp;&nbsp;&nbsp; " + treeNode.name + (isCancel ? "</span>":""));
            }
        });

    }
    function showLog(str) {
        if (!log) log = $("#log");
        log.append("<li class='"+className+"'>"+str+"</li>");
        if(log.children("li").length > 8) {
            log.get(0).removeChild(log.children("li")[0]);
        }
    }
    function getTime() {
        var now= new Date(),
            h=now.getHours(),
            m=now.getMinutes(),
            s=now.getSeconds(),
            ms=now.getMilliseconds();
        return (h+":"+m+":"+s+ " " +ms);
    }
    function addHoverDom(treeId, treeNode) {
        var sObj = $("#" + treeNode.tId + "_span");
        if (treeNode.editNameFlag || ($("#addBtn_"+treeNode.tId).length>0) || $("#showBtn_"+treeNode.tId).length>0) return;
        var showType = treeNode.isshow == '1'? "show": "onshow";
        var addStr = "<span class='button "+showType+"' id='showBtn_" + treeNode.tId
            + "' title='show node' onfocus='this.blur();'></span>";
        sObj.after(addStr);
        sObj = $("#showBtn_" + treeNode.tId);
        addStr = "<span class='button add' id='addBtn_" + treeNode.tId
            + "' title='add node' onfocus='this.blur();'></span>";
        sObj.after(addStr);
        var btn = $("#addBtn_"+treeNode.tId);
        var showbtn = $("#showBtn_"+treeNode.tId);
        if (btn) btn.bind("click", function(){      //添加新栏目时候发生（以完成）
            layer.prompt({title:"请输入节点名字"},function(value, index, elem){
                console.log(treeNode);
                aj.post("index.php?m=zymanage&c=memberFun&a=addTypeAjax&pc_hash=<?php echo $_GET["pc_hash"]?>",{workshop:value, pId:treeNode.id}, function (data) {
                    if(data.code == '1')
                    {
                        console.log(data);
                        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
                        zTree.addNodes(treeNode, {id:data.data, pId:treeNode.id, name:value, isshow:1});
                        return false;
                    }
                    else
                        layer.msg(data.message);
                });
                layer.close(index);
            });
        });
        if (showbtn) showbtn.bind("click", function(){  //是否显示（暂时没有想到怎么做）
            //console.log(treeNode);
//            var zTree = $.fn.zTree.getZTreeObj("treeDemo");
//            zTree.addNodes(treeNode, {id:(100 + newCount), pId:treeNode.id, name:"new node" + (newCount++)});
//            console.log(zTree);
            var showType = treeNode.isshow == "1"? "2": "1";
            aj.post("index.php?m=zymanage&c=memberFun&a=changepArgAjax&pc_hash=<?php echo $_GET["pc_hash"]?>", {DID:treeNode.id, isshow:showType}, function(data){
                if (data.code == '1') {
                    var showType = treeNode.isshow == "1"? "2": "1";
                    treeNode.isshow = showType;
                    switch (showType)
                    {
                        case "1": $("#showBtn_"+treeNode.tId).attr("class", "button show"); break;
                        case "2": $("#showBtn_"+treeNode.tId).attr("class", "button onshow"); break;
                    }
                }
            });
            return false;
        });
    };
    function removeHoverDom(treeId, treeNode) {
        $("#addBtn_"+treeNode.tId).unbind().remove();
        $("#showBtn_"+treeNode.tId).unbind().remove();
    };
    function selectAll() {
        console.log("节点选中");
        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
        zTree.setting.edit.editNameSelectAll =  $("#selectAll").attr("checked");
    }
    function expand(bool) {
        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
        zTree.expandAll(bool);
    }
    function addNewNode()
    {
        layer.prompt({title:"请输入节点名字"},function(value, index, elem) {
            aj.post("index.php?m=zymanage&c=memberFun&a=addTypeAjax&pc_hash=<?php echo $_GET["pc_hash"]?>", {
                workshop: value,
                pId: 0
            }, function (data) {

                if (data.code == '1') {
                    var zTree = $.fn.zTree.getZTreeObj("treeDemo");
                    zTree.addNodes(null, {id: data.data, pId: 0, name: value, isshow: 1});
                }
                else
                    layer.msg(data.message);
            });
            layer.close(index);
        });
    }
    $(document).ready(function(){
        aj.get("index.php?m=zymanage&c=memberFun&a=getDepartMent&pc_hash=<?php echo $_GET["pc_hash"]?>",{}, function (data) {
            $.fn.zTree.init($("#treeDemo"), setting, data.data);
            $("#selectAll").bind("click", selectAll);
        });
    });
    Vue.component("v-select", VueSelect.VueSelect);
    var department = new Vue({
        el:"#departmentTree",
        data:{
            choiceMemberID:'',
            cityList:[],
            categoryplaceholder:"选择管理人员",
            DID:0,
            memberMange:[]
        },
        methods:{
            showIDCard :function(value)
            {
                console.log(value);
            },
            addSpc:function ()
            {
                if(this.choiceMemberID == '')
                {
                    layer.msg("请选择人员");
                    return;
                }
                if(this.memberMange.indexOf(this.choiceMemberID.userid) != -1)
                {
                    layer.msg("该用户已经添加为管理员");
                    return;
                }
                var that = this;
                aj.post("index.php?m=zymanage&c=memberFun&a=addSpecAjax&pc_hash=<?php echo $_GET["pc_hash"]?>", {DID:this.DID, userid:this.choiceMemberID.userid}, function(data){
                    if(data.code == '1')
                    {
                        layer.msg("添加成功");
                        getSpec(that.DID);
                    }
                    else
                        layer.msg(data.message);
                });
            }
        }
    })
</script>
