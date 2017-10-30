// 引入vue
import Vue from 'vue'
import App from './App.vue'
import router from './router.js'
import '../home/js/jquery.min'
// <script src="home/js/nav.js"></script>
//import 'ueditor/zh-cn.js'

// 引用样式
// css
// js

var vm = new Vue({
    el: '#app',
    // 实例的模板的几种方式之一
    router,
    render: function(createElement) {
        // return createElement (组件对象)
        // App组件中的模板最终会替换 index.blade.php 中的 #app 这个原色
        return createElement(App)
    }
})