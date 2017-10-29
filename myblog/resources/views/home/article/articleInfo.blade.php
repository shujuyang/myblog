<!doctype html>
<html>
<head>
    <meta charset="gb2312">
    <title>杨舒杰个人博客</title>
    <meta name="keywords" content="杨舒杰的个人博客，个人博客，技术分享" />
    <meta name="description" content="杨舒杰的个人博客，个人博客，技术分享" />
    <link href="/home/css/base.css" rel="stylesheet">
    <link href="/home/css/index.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="home/js/modernizr.js"></script>
    <![endif]-->
</head>
<body>
<header>
    <div class="logo f_l"> <a href="/" style="font-size: 25px;">数据杨的技术分享</a> </div>
    <nav id="topnav" class="f_r">
        <ul>
            <a href="/" target="_self">首页</a>
            <a href="/home/articleList/PHP" target="_self">PHP</a>
            <a href="/home/articleList/linux" target="_self">linux</a>
            <a href="/home/articleList/mysql" target="_self">mysql</a>
            <a href="/home/articleList/js" target="_self">js</a>
            <a href="/home/articleList/message" target="_self">留言</a>
        </ul>
        <script src="/home/js/nav.js"></script>
    </nav>
</header>
<article  style="width:86%;">
    <div class="l_box f_l">


    </div>
    <div class="r_box f_r">
        <div class="tit01">
            <h3>关注我</h3>
            <div class="gzwm">
                <ul>
                    <li><a class="xlwb" href="#" target="_blank">新浪微博</a></li>
                    <li><a class="txwb" href="#" target="_blank">腾讯微博</a></li>
                    <li><a class="rss" href="portal.php?mod=rss" target="_blank">RSS</a></li>
                    <li><a class="wx" href="mailto:admin@admin.com">邮箱</a></li>
                </ul>
            </div>
        </div>
        <!--tit01 end-->
        <div class="ad300x100"> <img src="/home/images/ad300x100.jpg"> </div>
        <div class="moreSelect" id="lp_right_select">
            <script>
                window.onload = function ()
                {
                    var oLi = document.getElementById("tab").getElementsByTagName("li");
                    var oUl = document.getElementById("ms-main").getElementsByTagName("div");

                    for(var i = 0; i < oLi.length; i++)
                    {
                        oLi[i].index = i;
                        oLi[i].onmouseover = function ()
                        {
                            for(var n = 0; n < oLi.length; n++) oLi[n].className="";
                            this.className = "cur";
                            for(var n = 0; n < oUl.length; n++) oUl[n].style.display = "none";
                            oUl[this.index].style.display = "block"
                        }
                    }
                }
            </script>
            <div class="ms-top">
                <ul class="hd" id="tab">
                    <li class="cur"><a href="/">点击排行</a></li>
                    <li><a href="/">最新文章</a></li>
                    <li><a href="/">站长推荐</a></li>
                </ul>
            </div>
            <div class="ms-main" id="ms-main">
                <div style="display: block;" class="bd bd-news" >
                    <ul>
                        <li><a href="/" target="_blank">住在手机里的朋友</a></li>
                        <li><a href="/" target="_blank">教你怎样用欠费手机拨打电话</a></li>
                        <li><a href="/" target="_blank">原来以为，一个人的勇敢是，删掉他的手机号码...</a></li>
                        <li><a href="/" target="_blank">手机的16个惊人小秘密，据说99.999%的人都不知</a></li>
                        <li><a href="/" target="_blank">你面对的是生活而不是手机</a></li>
                        <li><a href="/" target="_blank">豪雅手机正式发布! 在法国全手工打造的奢侈品</a></li>
                    </ul>
                </div>
                <div  class="bd bd-news">
                    <ul>
                        <li><a href="/" target="_blank">原来以为，一个人的勇敢是，删掉他的手机号码...</a></li>
                        <li><a href="/" target="_blank">手机的16个惊人小秘密，据说99.999%的人都不知</a></li>
                        <li><a href="/" target="_blank">住在手机里的朋友</a></li>
                        <li><a href="/" target="_blank">教你怎样用欠费手机拨打电话</a></li>
                        <li><a href="/" target="_blank">你面对的是生活而不是手机</a></li>
                        <li><a href="/" target="_blank">豪雅手机正式发布! 在法国全手工打造的奢侈品</a></li>
                    </ul>
                </div>
                <div class="bd bd-news">
                    <ul>
                        <li><a href="/" target="_blank">手机的16个惊人小秘密，据说99.999%的人都不知</a></li>
                        <li><a href="/" target="_blank">你面对的是生活而不是手机</a></li>
                        <li><a href="/" target="_blank">住在手机里的朋友</a></li>
                        <li><a href="/" target="_blank">豪雅手机正式发布! 在法国全手工打造的奢侈品</a></li>
                        <li><a href="/" target="_blank">教你怎样用欠费手机拨打电话</a></li>
                        <li><a href="/" target="_blank">原来以为，一个人的勇敢是，删掉他的手机号码...</a></li>
                    </ul>
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
                <li><a href="/"><img src="/home/images/01.jpg"><b>住在手机里的朋友</b></a>
                    <p><span class="tulanmu"><a href="/">手机配件</a></span><span class="tutime">2015-02-15</span></p>
                </li>
                <li><a href="/"><img src="/home/images/02.jpg"><b>教你怎样用欠费手机拨打电话</b></a>
                    <p><span class="tulanmu"><a href="/">手机配件</a></span><span class="tutime">2015-02-15</span></p>
                </li>
                <li><a href="/" title="手机的16个惊人小秘密，据说99.999%的人都不知"><img src="/home/images/03.jpg"><b>手机的16个惊人小秘密，据说...</b></a>
                    <p><span class="tulanmu"><a href="/">手机配件</a></span><span class="tutime">2015-02-15</span></p>
                </li>
                <li><a href="/"><img src="/home/images/06.jpg"><b>住在手机里的朋友</b></a>
                    <p><span class="tulanmu"><a href="/">手机配件</a></span><span class="tutime">2015-02-15</span></p>
                </li>
                <li><a href="/"><img src="/home/images/04.jpg"><b>教你怎样用欠费手机拨打电话</b></a>
                    <p><span class="tulanmu"><a href="/">手机配件</a></span><span class="tutime">2015-02-15</span></p>
                </li>
            </ul>
        </div>
        <div class="ad"> <img src="/home/images/03.jpg"> </div>
        <div class="links">
            <h3><span>[<a href="/">申请友情链接</a>]</span>友情链接</h3>
            <ul>

            </ul>
        </div>
    </div>
    <!--r_box end -->
</article>
<footer>
    <p class="ft-copyright"></p>
    <div id="tbox"> <a id="togbook" href="/"></a> <a id="gotop" href="javascript:void(0)"></a> </div>
</footer>
</body>
<script type="text/javascript" src="/home/js/jquery.min.js"></script>
</html>
