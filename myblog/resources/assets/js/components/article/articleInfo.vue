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

            <!--高速版-->
            <div id="SOHUCS"></div>
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
            axios.get('/index.php/home/article/articleInfo/'+this.$route.params.id).then(res => {
//                console.log(res)
                if(res['data']['result']){
                    this.article = res['data']['article']
                }
            })
        },
        mounted: function () {

        },
        updated: function () {
            (function() {
                //鐣呰█婊ら噸
                if (window.changyan !== undefined || window.cyan !== undefined) {
                    return;
                }
                var createNs = function() {
                    if (window.changyan !== undefined) {
                        return;
                    } else {
                        window.changyan = {};
                        window.changyan.api = {};
                        window.changyan.api.config = function(conf) {
                            window.changyan.api.tmpIsvPageConfig = conf;
                        };
                        window.changyan.api.ready = function(fn) {
                            window.changyan.api.tmpHandles = window.changyan.api.tmpHandles || [];
                            window.changyan.api.tmpHandles.push(fn);
                        };
                        window.changyan.ready = function(fn) {
                            if (window.changyan.rendered) {
                                fn && fn();
                            } else {
                                window.changyan.tmpHandles = window.changyan.tmpHandles || [];
                                window.changyan.tmpHandles.push(fn);
                            }
                        }
                    }
                };

                var createMobileNs = function() {
                    if (window.cyan) {
                        return;
                    }
                    window.cyan = {};
                    window.cyan.api = {};
                    window.cyan.api.ready = function(fn) {
                        window.cyan.api.tmpHandles = window.cyan.api.tmpHandles || [];
                        window.cyan.api.tmpHandles.push(fn);
                    };
                };
                var loadVersionJs = function() {
                    var loadJs = function(src, fun) {
                        var head = document.getElementsByTagName('head')[0] || document.head || document.documentElement;

                        var script = document.createElement('script');
                        script.setAttribute('type', 'text/javascript');
                        script.setAttribute('charset', 'UTF-8');
                        script.setAttribute('src', src);

                        if (typeof fun === 'function') {
                            if (window.attachEvent) {
                                script.onreadystatechange = function() {
                                    var r = script.readyState;
                                    if (r === 'loaded' || r === 'complete') {
                                        script.onreadystatechange = null;
                                        fun();
                                    }
                                };
                            } else {
                                script.onload = fun;
                            }
                        }

                        head.appendChild(script);
                    };

                    var ver = + new Date() + window.Math.random().toFixed(16);
                    var url = 'https://changyan.itc.cn/upload/version-v4.js?' + ver;
                    loadJs(url);
                };
                createNs();
                createMobileNs();
                loadVersionJs();
            }());

            window.changyan.api.config({
                appid: 'cytiS4EqY',
                conf: 'prod_4693edfec6629e9fcd455d075093a19e'
            });
        }

    }

//"http://changyan.sohu.com/upload/changyan.js"
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