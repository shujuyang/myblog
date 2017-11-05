<template>
    <div>
        <div class="l_box f_l">

            <div class="topnews">
                <h2><b>文章</b>推荐 <span></span> </h2>
                <div v-for="article in articles" class="blogs">
                    <figure><img :src="article.img_path"></figure>
                    <ul>
                        <a :href='"#/articleInfo/"+article.ar_id'>
                            <h3>{{ article.ar_title }}</h3>
                            <p>{{ article.ar_desc }}</p>
                        </a>
                        <p class="autor">
                            <span class="lm f_l"><a href="/">{{ article.column.col_name }}</a></span>
                            <span class="dtime f_l">{{ article.created_at }}</span>
                            <a href=""><span class="viewnum f_r">浏览（459）</span></a>
                            <a href=""><span class="pingl f_r">评论</span></a>
                        </p>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios"
    export default{
        data: function() {
            return {
                articles : []
            }
        },
        created () {
            sendAxois(this)
        },
        watch: {
            '$route'(){
                // 发送异步请求，获取管理员列表信息
                sendAxois(this)
            }
        },
    }
    function sendAxois(that) {
        axios.get('/home/article/articleList/'+that.$route.params.column).then(res => {
            if(res['data']['result']){
                that.articles = res['data']['articles']
            }
        })
    }

</script>
<style>
    @import "/home/css/index.css";
</style>