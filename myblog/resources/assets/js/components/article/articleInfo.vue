<template>
    <div>
        <div class="l_box f_l">

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
                if(res['data']['result']){
                    this.article = res['data']['article']
                }
            })
        },
        mounted: function () {
            console.log(this.article)
        }

    }
</script>
<style>
    @import "/home/css/index.css";
    article {
        width: 86%;
    }
</style>