/*
*  这里来进行路由配置
*  1.引入包
*  2.Vue.use
*  3.配置路由
*  4.将 new 出的路由实例，关联 new Vue({router:路由实例})
* */
// 1.引包
import Vue from 'vue'
import VueRouter from 'vue-router'
import Index from './components/index/index.vue'
import Home from './components/home.vue'
import ArticleInfo from './components/article/articleInfo.vue'
import ArticleList from './components/article/articleList.vue'

// 2.Vue.use()
Vue.use(VueRouter)

// 3.配置路由
var router = new VueRouter({
    routes: [
        // {name:'',path:'',component: A}
        // 这里rediret 表示跳转，如果地址栏中锚点值是 #/ 就立即自动跳转到#/admin

        {path:'/',redirect:{name:'index'}},
        {name:'home',path:'/home',component:Home,
            children: [
                // 如果children 中的组件呈现到页面中，那么Admin 组件也一定呈现知道页面上
                {name:'index',path:'/index',component:Index},
                {name:'articleInfo',path:'/articleInfo/:id',component:ArticleInfo},
                {name:'articleList',path:'/articleList/:column',component:ArticleList}
            ]
        },
    ]
})

// 暴露router
export default router