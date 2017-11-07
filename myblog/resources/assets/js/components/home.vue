<template>
    <div>
        <header>
            <div class="logo f_l">
                <a href="/" style="font-size: 25px;">
                    数据杨的技术分享
                </a>
            </div>
            <nav id="topnav" class="f_r">
                <ul>
                    <a href="/" target="_self">首页</a>
                    <a href="#/articleList/PHP" target="_self">PHP</a>
                    <a href="#/articleList/Linux" target="_self">Linux</a>
                    <a href="#/articleList/MySQL" target="_self">MySQL</a>
                    <a href="#/articleList/JS" target="_self">JS</a>
                    <a href="#/articleList/message" target="_self">message</a>
                </ul>
            </nav>
        </header>
        <article>
            <router-view></router-view>
            <div class="r_box f_r">
                <div class="tit01">
                    <h3>关注我</h3>
                    <div class="gzwm">
                        <ul>
                            <li><a class="xlwb" href="https://weibo.com/6364460030/profile?topnav=1&wvr=6&is_all=1" target="_blank">新浪微博</a></li>
                            <li><a class="txwb" href="https://github.com/shujuyang" target="_blank">github</a></li>
                        </ul>
                    </div>
                </div>
                <!--tit01 end-->
                <div class="ad300x100"> <img src="home/images/ad300x100.jpg"> </div>
                <div class="moreSelect" id="lp_right_select">
                    <div class="ms-top">
                        <ul class="hd" id="tab">
                            <li class="cur"><a href="/">点击排行</a></li>
                            <!--<li><a href="/">最新文章</a></li>-->
                        </ul>
                    </div>
                    <div class="ms-main" id="ms-main">
                        <div style="display: block;" class="bd bd-news" >
                            <ul>
                                <li v-for="article in articlesView">
                                    <a :href='"http://www.shujuyang.cn/#/articleInfo/"+article.ar_id' target="_blank">
                                        {{ article.ar_title }}
                                    </a></li>

                            </ul>
                        </div>
                        <div  class="bd bd-news">

                        </div>
                    </div>
                    <!--ms-main end -->
                </div>
                <!--切换卡 moreSelect end -->

                <div class="cloud">
                    <h3>标签云</h3>
                    <ul>
                        <li><a href="/">个人博客</a></li>
                        <li><a href="/">web开发</a></li>
                        <li><a href="/">前端设计</a></li>
                        <li><a href="/">Html</a></li>
                        <li><a href="/">CSS3</a></li>
                        <li><a href="/">Html5+css3</a></li>
                        <li><a href="/">百度</a></li>
                        <li><a href="/">Javasript</a></li>
                        <li><a href="/">web开发</a></li>
                        <li><a href="/">前端设计</a></li>
                        <li><a href="/">Html</a></li>
                        <li><a href="/">CSS3</a></li>
                        <li><a href="/">Html5+css3</a></li>
                        <li><a href="/">百度</a></li>
                    </ul>
                </div>
                <div class="tuwen">
                    <h3>图文推荐</h3>
                    <ul>
                        <ul>
                            <li v-for="article in articlesNew">
                                <a :href='"http://www.shujuyang.cn/#/articleInfo/"+article.ar_id' target="_blank">
                                    {{ article.ar_title }}
                                </a></li>

                        </ul>
                    </ul>
                </div>
                <div class="ad"> <img src="home/images/03.jpg"> </div>
                <div class="links">
                    <h3><span>[<a href="/">申请友情链接</a>]</span>友情链接</h3>
                    <ul>

                    </ul>
                </div>
            </div>
            <!--r_box end -->
        </article>
        <footer>
            <p class="ft-copyright">杨舒杰的博客 	 &nbsp;&nbsp;&nbsp;&nbsp; 京ICP备17042742号-1</p>
            <div id="tbox"> <a id="togbook" href="/#/articleList/message"></a> <a id="gotop" href="#"></a> </div>
        </footer>

    </div>

</template>

<script>
    import axios from "axios"

    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?57459f06d3a3d8d8254e519fe1b95f15";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
    export default{
        data: function() {
            return {
                articlesView:[],
                articlesNew: []
            }
        },
        created: function() {
          axios.get('/index.php/home/article/getArticlesByView').then(res=>{
              if(res['data']['result']){
                  this.articlesView = res['data']['articlesView']
              }
          });

          axios.get('/index.php/home/article/getArticlesByNew').then(res=>{
              if(res['data']['result']){
                  this.articlesNew = res['data']['articlesView']
              }
          });
        },
        mounted: function () {

        }

    }

</script>
<style>
    @import "/home/css/base.css";
</style>