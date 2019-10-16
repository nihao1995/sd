<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_header = 1;
include $this->admin_tpl('header','admin');
?>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js"></script>
<script src="https://unpkg.com/vue-select@3.0.0"></script>
<link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
<link rel="stylesheet" href="//unpkg.com/iview/dist/styles/iview.css">
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
        width: 15%;
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
        <v-select :options="categoryoptions" :placeholder="categoryplaceholder" :multiple="false" :taggable="true"
                  :close-on-select="true"  label="titlename" @input="getEID"
        ></v-select>
        注：双击所在行查看签名
    </div>
    <div class='selectVue'>
        <template>
            <i-Button type="primary" size="large" @click="exportData(1)"><Icon type="ios-download-outline"></Icon> 导出源数据</i-Button>
            <i-Button type="primary" size="large" @click="exportData(2)"><Icon type="ios-download-outline"></Icon> 导出排序后的数据</i-Button>
            <p>&nbsp;   </p>
            <i-Table :columns="columns8" :data="data7" size="small" ref="table" @on-row-dblclick="tableClick"></i-Table>
        </template>
    </div>



</div>
</div>

<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>

<script>
    Vue.component("v-select", VueSelect.VueSelect);

    var layer = layui.layer,
        form = layui.form,
        $ = layui.jquery,
        upload = layui.upload,
        table = layui.table;
    var app12 = '2';


    app = new Vue({
        el: '#singleChoice',
        data:{
            categoryoptions:<?php empty($examAll)?[]:print_r($examAll)?>,
            categoryplaceholder:'选择考试场次',
            category:'',//用户选择的分类
//                    pagestart:data.data.pageStart,//显示的起始也
//                    pagenums:data.data.pagenums,//显示的最大页
//                    page:1,//当前页数
//                    pagecount:data.data.pageCount,//后台得到的总页数
//                    itemname:'', //题目筛选
//                    itemGet:data.data.data,
            EID:'',
            value4: false,
            pStyle: {
                fontSize: '16px',
                color: 'rgba(0,0,0,0.85)',
                lineHeight: '24px',
                display: 'block',
                marginBottom: '16px'
            },
            src:'',
            columns8: [
                {
                    "title": "姓名",
                    "key": "nickname",
                    "sortable": false,
                    "width": '300px'
                },
                {
                    "title": "考试标题",
                    "key": "titlename",
                    "width": 200,
                    "sortable": false
                },
                {
                    "title": "题目数",
                    "key": "questionCount",
                    "width": 200,
                    "sortable": false
                },
                {
                    "title": "答对数",
                    "key": "rightCount",
                    "width": 200,
                    "sortable": true
                },
                {
                    "title": "答错数",
                    "key": "errorCount",
                    "width": 200,
                    "sortable": true
                },
                {
                    "title": "分数",
                    "key": "examResults",
                    "width": 200,
                    "sortable": true
                },
                {
                    "title": "开始考试时间",
                    "key": "startTime",
                    "width": 200,
                    "sortable": false
                },
                {
                    "title": "结束时间",
                    "key": "EndTime",
                    "width": 200,
                    "sortable": false
                },
            ],
            data7: []
        },
        methods:{
            getEID:function(values){
                this.EID = values===null?'':values.EID;
                this.getData();
            },
            getData:function(){
                var that = this;
                aj.post("index.php?m=zyexam&c=examManage&a=getGrade&pc_hash=<?php echo $_GET["pc_hash"]?>",{  EID:this.EID},function(data){
                    console.log(data);
                    if(data.data.examResults === null)
                        that.data7 = [];
                    that.data7 = data.data.examResults;
                })
            },
            exportData: function (type) {
                if (type === 1) {
                    this.$refs.table.exportCsv({
                        filename: '成绩'
                    });
                } else if (type === 2) {
                    this.$refs.table.exportCsv({
                        filename: '排序后的成绩',
                        original: false
                    });
                }
            },
            tableClick:function(data, index)
            {
                console.log(data);
                console.log(index);
//                layer.photos({
//                    anim: 5,
//                    src:"\'"+data.signature+"\'"
//                })
                image_priview(data.signature)
            }

        }
    })
</script>
</body>

