<template>
    <div>
        <div class="l_box f_l">
            <h1 class="ar_title" v-html="article.ar_title"></h1>

            <div class="ar_sTitle">
                <span class="ar_column" v-html="article.column.col_name"></span>
                <span class="ar_editor" v-html="article.ar_editor"></span>
                <span class="time" v-html="article.created_at"></span>
            </div>

            <div class="ar_content" v-html="article.ar_content">

            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios"
    export default{
        data: function() {
            return {
                article: {}
            }
        },
        created () {
            // 发送异步请求，获取管理员列表信息
            axios.get('/home/article/articleInfo/'+this.$route.params.id).then(res => {
//                console.log(res)
                if(res['data']['result']){
                    this.article = res['data']['article']
                }
            })
        },
        mounted: function () {
        }

    }
</script>
<style>
    @import "/home/css/index.css";
    article {
        width: 86%;
    }
    .ar_title {
        text-align: center;
        font-family: "微软雅黑" ;
        font-style: normal;
        font-weight: 700;
        font-size: 28px;
        margin-bottom: 10px;
    }
    .ar_sTitle {
        text-align: center;
    }

    .ar_sTitle .ar_column {
        margin-right: 50px;
    }
    .ar_sTitle .time {
        margin-left: 50px;
    }
    .ar_content {
        margin-top: 25px;
    }
    p {
        margin-top: 10px;
    }

</style>