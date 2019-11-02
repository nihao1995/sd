<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
    $show_header = 1;
	include $this->admin_tpl('header','admin');
?>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js"></script>
<script src="https://unpkg.com/vue-select@3.0.0"></script>
<link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
<link rel="stylesheet" type="text/css" href="<?php echo APP_PATH?>statics/layui-v2.5.3/layui/css/layui.css">
<script type="text/javascript" src="<?php echo APP_PATH?>statics/js/ajax.js"></script>
<script src="<?php echo APP_PATH?>statics/layui-v2.5.3/layui/layui.all.js"></script>
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


</style>

<div  class="table-list" id="questionstype">
    <div class="subnav">
        <button class="layui-btn layui-btn-sm layui-btn-normal" @click="addType()">添加</button>
    </div>
    <table width="100%" class="layui-table">
        <thead>
            <tr>
                <th>分类ID</th>
                <th>类型</th>
                <th>号码</th>
                <th>添加时间</th>
                <th>管理操作</th>
            </tr>
        </thead>
        <tbody>
        <template v-for="item in itemGet" v-model="itemGet">
            <tr>
                <td>{{item.SEID}}</td>
                <td>
                    <template v-if="item.type==1">QQ</template> <template v-else-if="item.type==2">微信</template>
                </td>
                <td align="center">
                   {{item.val}}
                </td>
                <td>{{item.addtime}}</td>
                <td align="center">
                    <a class="btn btn-info btn-sm" @click="edit(item.SEID)">编辑</a>
                    <a class="btn btn-danger btn-sm" @click="del(item.SEID)">删除</a>
                </td>
            </tr>
        </template>
        </tbody>
    </table>
</div>
<script>
    var layer = layui.layer,
        form = layui.form,
        $ = layui.jquery,
        upload = layui.upload,
        table = layui.table;
    aj.post("index.php?m=zyshop&c=shopManage&a=getServerInfo&pc_hash=<?php echo $_GET["pc_hash"]?>",{},function(data){
        if(data.code=='1')
        {
            console.log(data);
            app = new Vue({
                el: '#questionstype',
                data: {
                    itemGet: data.data
                },
                methods:{
                    refresh:function(){
                        var that = this;
                        aj.post("index.php?m=zyshop&c=shopManage&a=getServerInfo&pc_hash=<?php echo $_GET["pc_hash"]?>",{},function(data) {
                            that.itemGet = data.data;
                        })
                    },
                    del:function(SSID){
                        var that = this;
                        layer.confirm('确定删除？', {icon: 3, title:'提示'}, function(index) {
                            aj.post("index.php?m=zyshop&c=shopManage&a=delService&pc_hash=<?php echo $_GET["pc_hash"]?>", {SEID: SSID}, function (data) {
                                that.refresh();
                            })
                        })
                    },
                    edit:function(SSID){
                        var that = this;
                        layer.open({
                            type: 2,
                            title: '编辑',
                            shadeClose: true,
                            shade: 0.8,
                            area: ['500px', '50%'],
                            content: 'index.php?m=zyshop&c=shopManage&a=serverEdit&pc_hash=<?php echo $_GET["pc_hash"]?>&SEID='+SSID, //iframe的url
                            end: function () {
                                console.log(1);
                                that.refresh();
                            }
                        });
                    },
                    addType:function(){
                        var that = this;
                        layer.open({
                            type: 2,
                            title: '添加',
                            shadeClose: true,
                            shade: 0.8,
                            area: ['500px', '50%'],
                            content: 'index.php?m=zyshop&c=shopManage&a=serverAdd&pc_hash=<?php echo $_GET["pc_hash"]?>', //iframe的url
                            end: function () {
                                console.log(1);
                                that.refresh();
                            }
                        });
                    },
                    photo:function(){
                        layer.photos({
                            photos: '.layer-photos-demo'
                            , anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
                        });
                    }
                },
                mounted:function () {
                    this.photo();
                }
            })
        }
        else
            layer.msg("加载失败 原因:"+data.message)
    } );
</script>