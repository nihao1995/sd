<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
$show_header = 1;
	include $this->admin_tpl('header','admin');
?>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-select@3.0.0"></script>
    <link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
    <link rel="stylesheet" type="text/css" href="<?php echo APP_PATH?>statics/vue/iview.css">
    <link rel="stylesheet" type="text/css" href="<?php echo APP_PATH?>statics/layui-v2.5.3/layui/css/layui.css">
    <script type="text/javascript" src="<?php echo APP_PATH?>statics/js/ajax.js"></script>
    <script src="<?php echo APP_PATH?>statics/layui-v2.5.3/layui/layui.all.js"></script>
    <script type="text/javascript" src="<?php echo APP_PATH?>statics/vue/iview.min.js"></script>
	<style>
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
        .v-select{
            width: 10%;
            display: inline-block
        }
        .selectVue{
            text-align: center;
            /*margin: auto;*/
            margin-bottom: 20px;
            border: 1px solid #d9d9d9;
            padding: 10px 0;
            /*background: #fffced;*/
        }
        .selectVue .selectSpan{
            display: inline-block;
            width: 50px;
        }
        .selectVue .itemInput{
            padding: 14px 0 14px;
            /*height: auto;*/
            text-align: center;
            background: none;
            border: 1px solid rgba(60,60,60,.26);
            border-radius: 4px;
            white-space: normal;
            vertical-align: top;
            /*border:1px solid transparent;*/
            /*border-left:none;*/
            /*outline: none;*/
            /*margin:4px 0 0 ;*/
            /*padding: 0 7px;*/
            /*max-width: 100%;/*/
            /*flex-grow:1;*/

        }
        td{
            min-width:60px;
        }
        .demo-drawer-profile{
            font-size: 14px;
        }
        .demo-drawer-profile .ivu-col{
            margin-bottom: 12px;
        }
        [v-cloak]{
            display: none;
        }
	</style>

<div style="border: 1px solid transparent"></div>
<div class="pad-lr-10">
</div>

<div id="singleChoice">
    <div class="subnav">
        <button class="layui-btn layui-btn-sm layui-btn-normal" @click="add()">添加</button>
    </div>
    <div class='selectVue'>
        <span class="selectSpan">标题:</span>
        <input type="text" v-model="title" class="itemInput">
        <span >发布时间:</span>
        <Date-Picker  type="daterange" placeholder="请选择时间" formate="yyyy-mm-dd" @on-change="changeTime" style="width: 200px" ></Date-Picker>
        <button class="layui-btn layui-btn-sm layui-btn-radius layui-btn-primary" @click="seach" >搜索</button>
    </div>
    <Checkbox-Group v-model="IDI">
    <table class="layui-table">
        <thead>
        <tr>
            <th><Checkbox
                        :indeterminate="indeterminate"
                        :value="checkAll"
                        @click.prevent.native="handleCheckAll"><span></span></Checkbox></th>
            <th>ID</th>
            <th>标题</th>
            <th>公告类型</th>
            <th>发布人</th>
            <th>添加时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>

            <template v-for="item in itemGet" v-model="itemGet">
             <tr>
                 <td><Checkbox :label="item.aid"><span></span></Checkbox></td>
                 <td>{{item.aid}}</td>
                 <td>{{item.title}}</td>
                 <td>{{item.notice_type_name}}</td>
                 <td>{{item.username}}</td>
                 <td>{{item.addtime}}</td>
                 <td><span v-html="replace_status(item.passed)"></span></td>
                 <td align="center">
                     <template v-if="item.status==0">
                         <i-button type="info" @click="pass(item.aid)" >通过</i-button>
                         <i-button type="error" @click="reject(item.aid)" >驳回</i-button>
                     </template>

                     <i-button @click="view(item.aid)" >预览</i-button>
                     <i-button type="info" @click="edit(item.aid)" >编辑</i-button>
                     <i-button type="error"  @click="del(item.aid)">删除</i-button>
<!--                     <Date-Picker  type="daterange" placement="bottom-end" placeholder="Select date" style="width: 200px"></Date-Picker>-->
                 </td>
             </tr>
            </template>

        </tbody>
    </table>
    </Checkbox-Group>
    <i-button @click="delid" type="error" size="small" style="float:left; margin-left: 10px">批量删除</i-button>
    <page :pagestart="pagestart" :pagenums="pagenums" :page="page" :pagecount="pagecount" @changepage="changepage">

    </page>
</div>
</div>



<script>
    Vue.component("v-select", VueSelect.VueSelect);
    Vue.component("page",{
        props:{
            pagestart:{
                type:Number,
                default:function(){
                    return 1;
                }
            },
            pagenums:{
                type:Number,
                default:function(){
                    return 20;
                }
            },
            page:{
                type:Number,
                default:function(){
                    return 1;
                }
            },
            pagecount:{
                type:Number
            }
        },
        data:function(){
            return {
                insertpage: this.page
            }
        },
        template:'<div class="page">\
                            <div>\
                                <span @click="pageChange(page-1)">上一页</span>\
                                <template  v-for="n in pagenums" v-if="n>=pagestart" > <span :class="tavcls(n)" @click="pageChange(n)">{{n}}</span></template>\
                                <span @click="pageChange(page+1)">下一页</span>\
                                <span>共{{pagecount}}页</span>\
                                <input type="text" v-model="insertpage" value="insertpage">\
                                <span @click="pageChange(insertpage)">跳转</span>\
                            </div>\
                        </div>',
        methods:{
            tavcls:function(num){
                return {
                    "page-on": num === this.page
                }
            },
            pageChange:function(num){
                num = Number(num);
                num = num <=1? 1:num;
                num = num >=this.pagecount? this.pagecount: num;
                this.$emit("changepage", num);
                //this.$emit("on-click", num);
            }
        }
    });
    var layer = layui.layer,
        form = layui.form,
        $ = layui.jquery,
        upload = layui.upload,
        table = layui.table;
    var app12 = '2';

    aj.post("index.php?m=zysd&c=zysd&a=notice_list&pc_hash=<?php echo $_GET["pc_hash"]?>",{page:'1'},function(data){
        if(data.code=='200')
        {
            console.log(data.data);
            app = new Vue({
                el: '#singleChoice',
                data:{
                    pagestart:data.data.pageStart,//显示的起始也
                    pagenums:data.data.pagenums,//显示的最大页
                    page:1,//当前页数
                    pagecount:data.data.pageCount,//后台得到的总页数
                    itemGet:data.data.data,
                    time:'', //时间筛选
                    title:'',//标题筛选
                    value4: false,
                    pStyle: {
                        fontSize: '16px',
                        color: 'rgba(0,0,0,0.85)',
                        lineHeight: '24px',
                        display: 'block',
                        marginBottom: '16px'
                    },
                    src:'',
                    IDI:[],
                    indeterminate:true,
                    checkAll:false,
                },
                methods:{
                    handleCheckAll:function () {
                        if (this.indeterminate) {
                            this.checkAll = false;
                        } else {
                            this.checkAll = !this.checkAll;
                        }
                        this.indeterminate = false;
                        if (this.checkAll) {
                            var cd = [];
                            for(var i in this.itemGet)
                                cd.push(this.itemGet[i].aid)
                            this.IDI = cd;
                        } else {
                            this.IDI = [];
                        }
                    },
                    changepage:function(num){
                        this.page = num;
                    },
                    getData:function(page){
                        var that = this;
                        console.log(this.time);
                        aj.post("index.php?m=zysd&c=zysd&a=notice_list&pc_hash=<?php echo $_GET["pc_hash"]?>",{page:page, title:this.title, time:this.time},function(data){
                            console.log(data);
                            that.page = page;
                            that.pagestart=data.data.pageStart;//显示的起始也
                            that.pagenums=data.data.pagenums;//显示的最大页
                            that.pagecount=data.data.pageCount;//后台得到的总页数
                            that.itemGet=data.data.data;
                            that.$nextTick(function() {
                                that.photo();
                            });
                        })
                    },
                    seach:function () {
                        this.getData(1)
                    },
                    del:function(ID){
                        var that = this;
                        layer.confirm('确定删除？', {icon: 3, title:'提示'}, function(index){
                            //do something
                            aj.post("index.php?m=zysd&c=zysd&a=del_notice&pc_hash=<?php echo $_GET["pc_hash"]?>",{aid:ID},function(data){
                                if(data.code == 200)
                                    that.getData(that.page);
                                else
                                    layer.msg(data.message);
                            });
                            layer.close(index);
                        });

                    },
                    pass:function(ID){
                        var that = this;
                        layer.confirm('确定通过？', {icon: 1, title:'提示'}, function(index){
                            //do something
                            aj.post("index.php?m=zysd&c=zysd&a=fund_pass&pc_hash=<?php echo $_GET["pc_hash"]?>",{aid:ID},function(data){
                                if(data.code == 200)
                                    that.getData(that.page);
                                else
                                    layer.msg(data.message);
                            });
                            layer.close(index);
                        });
                    },
                    reject:function(ID){
                        var that = this;
                        layer.confirm('确定驳回？', {icon: 2, title:'提示'}, function(index){
                            //do something
                            aj.post("index.php?m=zysd&c=zysd&a=fund_dismiss&pc_hash=<?php echo $_GET["pc_hash"]?>",{aid:ID},function(data){
                                if(data.code == 200)
                                    that.getData(that.page);
                                else
                                    layer.msg(data.message);
                            });
                            layer.close(index);
                        });
                    },
                    replace_status:function(status){
                        switch (status){
                            case '1':return "<span style='color: green'>发布</span>";
                            case '0':return "<span style='color: red'>未发布</span>";
                        }
                    },
                    photo:function(){
                        layer.photos({
                            photos: '.layer-photos-demo'
                            , anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
                        });
                    },
                    showvideo:function(src){
                        this.src=src;
                        this.value4 = true;
                    },
                    getVTID:function(value)
                    {
                        this.VTID = value.VTID;
                    },
                    add:function(){
                        var that = this;
                        layer.open({
                            type: 2,
                            title: '添加',
                            shadeClose: true,
                            shade: 0.8,
                            area: ['800px', '80%'],
                            content: 'index.php?m=zysd&c=zysd&a=add_notice&pc_hash=<?php echo $_GET["pc_hash"]?>', //iframe的url
                            end: function () {
                                that.getData(that.page);
                            }
                        });
                    },
                    edit:function(ID)
                    {
                        var that = this;
                        layer.open({
                            type: 2,
                            title: '添加',
                            shadeClose: true,
                            shade: 0.8,
                            area: ['800px', '80%'],
                            content: 'index.php?m=zysd&c=zysd&a=edit_notice&pc_hash=<?php echo $_GET["pc_hash"]?>&ID='+ID,
                            end: function () {
                                that.getData(that.page);
                            }
                        });
                    },
                    view:function(data)
                    {
                        layer.open({
                            type: 2,
                            title: '编辑',
                            shadeClose: true,
                            shade: 0.8,
                            area: ['400px', '70%'],
                            content: 'index.php?m=zysd&c=zysd&a=manage_view&type=1&userid='+data +'&pc_hash=<?php echo $_GET["pc_hash"]?>', //iframe的url
                        });
                    },
                    delid:function()
                    {
                        if(this.IDI.length === 0)
                        {
                            layer.msg("请选择删除的选项");
                            return;
                        }
                        var that = this;
                        layer.confirm('确定删除？', {icon: 3, title:'提示'}, function(index){
                            //do something
                            aj.post("index.php?m=zysd&c=zysd&a=del_notice&pc_hash=<?php echo $_GET["pc_hash"]?>",{aid:that.IDI},function(data){
                                if(data.code == 200) {
                                    that.getData(that.page);
                                    that.IDI = [];
                                    that.checkAll = false;
                                }
                                else
                                    layer.msg(data.message);
                            });
                            layer.close(index);
                        });
                    },
                    changeTime:function(date)
                    {
                        this.time = date;
                    }

                },
                watch:{
                    page:function(){
                        console.log(this.page);
                        this.getData(this.page)
                    }//监听page
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
</body>

