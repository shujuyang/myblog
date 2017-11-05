import axios from 'axios'

/**对axios发请求进行统一配置 */
// create得到的返回值就是一个新的axios,这个axios里的配置就是create中的参数
const myAxios = axios.create({
    // url: '/xx', 用myAxios发请求默认请求地址 就是 /xx
    // method: 'post', 加了这个属性，后，可以用myAxios来发请求，默认发的就是post请求,
    transformRequest: [function (data) {
        // 这里的参数data是用myAxios对象发请求时的data参数
        // 这个函数的返回值，就是要发给后端的最终的数据
        // return '小明'
        // 我们要将data转换为formData的格式，再返回
        // data: {name: 1, age: 2} // name=1&age=2

        // let str = ''
        // for (let key in data) {
        //   // 请求的参数中多个&没有关系
        //   str += key + '=' + data[key] + '&' // name=1&,   name=1&age=2&
        // }

        let arr = []
        for (let key in data) {
            arr.push(key + '=' + data[key])  // ['name=1'], ['name=1', 'age=2']
        }
        return arr.join('&')  // 'name=1&age=2'
        // 以后如果希望发的请求的数据格式是formData格式，就使用 my-axios.js
        // 不需要引入axios这个包了
    }]
})

// 暴露这个对象
export default myAxios