<template>
    <div>
        <div class="l_box f_l">
            <div class="banner">
                <div id="slide-holder">
                    <div id="slide-runner"> <a href="/" target="_blank"><img id="slide-img-1" src="home/images/a1.jpg"  alt="" /></a> <a href="/" target="_blank"><img id="slide-img-2" src="home/images/a2.jpg"  alt="" /></a> <a href="/" target="_blank"><img id="slide-img-3" src="home/images/a3.jpg"  alt="" /></a> <a href="/" target="_blank"><img id="slide-img-4" src="home/images/a4.jpg"  alt="" /></a>
                        <div id="slide-controls">
                            <p id="slide-client" class="text"><strong></strong><span></span></p>
                            <p id="slide-desc" class="text"></p>
                            <p id="slide-nav"></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- banner代码 结束 -->
            <div class="topnews">
                <h2><span><a href="/" target="_blank">栏目标题</a><a href="/" target="_blank">栏目标题</a><a href="/" target="_blank">栏目标题</a></span><b>文章</b>推荐</h2>
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
    import axios from 'axios'

    export default{
        data: function(){
            return {
                articles: []
            }
        },
        created () {
            // 发送异步请求，获取管理员列表信息
            axios.get('/home/index/articleList',{
                params: {

                }
            }).then(res => {
                if(res['data']['result']){
                    this.articles = res['data']['articles']
                }
            })
        },
        mounted: function () {

        }

    }

</script>
<style>
    @import "/home/css/index.css";
</style>