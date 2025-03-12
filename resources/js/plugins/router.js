import Vue from 'vue'
import Router from 'vue-router'
import admin from './routers/admin' // 后台路由

Vue.use(Router)

export default new Router({
    mode:'history',
    routes: [
        ...admin,
        {path: '/Admin/index',name: 'homepage',component: () => import('@this/views/Error/404')},
        {path: '/Admin/goodcatch/m/base/*', name: '404', component: () => import('@/views/Error/404')},
        {path: '/Admin/goodcatch/m/*', name: 'modules', component: () => import('@this/views/Error/404')},
    ]
})