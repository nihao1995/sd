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
    <div class='selectVue'>
        <span class="selectSpan">姓名:</span>
        <input type="text" v-model="itemname" class="itemInput">
        <button class="layui-btn layui-btn-sm layui-btn-radius layui-btn-primary" @click="seach" >搜索</button>
    </div>
    <table class="layui-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>1号匹配者</th>
            <th>成绩</th>
            <th>2号匹配者</th>
            <th>成绩</th>
            <th>添加时间</th>
            <th>获胜者</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            <template v-for="item in itemGet" v-model="itemGet">
             <tr>
                 <td>{{item.PKRID}}</td>
                 <td>
                     {{item.nickname0}}
                     <span  @click="view((JSON.parse(item.userid))[0])"><img src="<?php echo IMG_PATH?>admin_img/detail.png"></span>
                 </td>
                 <td>
                     {{item.grade0}}
                 </td>
                 <td>
                     {{item.nickname1}}
                     <span  @click="view((JSON.parse(item.userid))[1])"><img src="<?php echo IMG_PATH?>admin_img/detail.png"></span>
                 </td>
                 <td>{{item.grade1}}</td>
                 <td>{{item.addtime}}</td>
                 <td>
                     <template v-if="item.grade0 > item.grade1">
                        {{item.nickname0}}
                     </template>
                     <template v-else-if="item.grade0 < item.grade1">
                         {{item.nickname1}}
                     </template>
                     <template v-else>
                         平局
                     </template>
                 </td>
                 <td align="center">
                     <i-button type="error"  @click="del(item.PKRID)" style="margin-top: 3px;">删除</i-button>
                 </td>
             </tr>
            </template>
        </tbody>
    </table>
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

    aj.post("index.php?m=zymanage&c=pkMatching&a=getPKData&pc_hash=<?php echo $_GET["pc_hash"]?>",{ page:'1'},function(data){
        console.log(data);
        if(data.code=='1')
        {
            app = new Vue({
                el: '#singleChoice',
                data:{
                    pagestart:data.data.pageStart,//显示的起始也
                    pagenums:data.data.pagenums,//显示的最大页
                    page:1,//当前页数
                    pagecount:data.data.pageCount,//后台得到的总页数
                    itemname:'', //题目筛选
                    itemGet:data.data.data,
                    PKRID:''
                },
                methods:{
                    DBnameAdd:function (values) {
                        this.DBname = values.map(function(obj){
                            return obj.DBname
                        })
                    },
                    changepage:function(num){
                        this.page = num;
                    },
                    getData:function(page){
                        var that = this;
                        aj.post("index.php?m=zymanage&c=pkMatching&a=getPKData&pc_hash=<?php echo $_GET["pc_hash"]?>",{ page:page, nickname:this.itemname},function(data){
//                            console.log(data.data.pageStart);
                            that.page = page;
                            that.pagestart=data.data.pageStart;//显示的起始也
                            that.pagenums=data.data.pagenums;//显示的最大页
                            that.pagecount=data.data.pageCount;//后台得到的总页数
                            that.itemGet=data.data.data;
                        })
                    },
                    seach:function () {
                        this.getData(1)
                    },
                    del:function(PKRID){
                        var that = this;
                        layer.confirm('确定删除？', {icon: 3, title:'提示'}, function(index){
                            //do something
                            aj.post("index.php?m=zymanage&c=pkMatching&a=del&pc_hash=<?php echo $_GET["pc_hash"]?>",{type:"zysinglechoice", PKRID:PKRID},function(data){
                                if(data.code == 1)
                                    that.getData(that.page);
                                else
                                    layer.msg(data.message);
                            });
                            layer.close(index);
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
                            content: 'index.php?m=zymember&c=zymember&a=manage_view&type=1&userid='+data +'&pc_hash=<?php echo $_GET["pc_hash"]?>', //iframe的url
                        });
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

