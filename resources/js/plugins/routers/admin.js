import { moduleUrl } from '@this/plugins/function'

export default [
// 核心模块
    {
        path: moduleUrl('index'), name:"admin_index", meta:{title: '模块首页', key:'home'}, component: () => import("@this/views/Admin/index"),children:[
            {path: moduleUrl('index'), name:"admin_default", meta:{title: '模块首页', key:'admin_default'}, component: () => import("@this/views/Admin/default")}, // 打开默认页面

            // 模块管理
            //***********地区管理*********
            {path: moduleUrl('modules'), name:"admin_modules", meta:{title: '系统模块', key:'admin_modules', form: 'admin_modules_form'}, component: () => import("@this/views/Admin/modules/index")},
            {path: moduleUrl('modules/form/:id?'), name:"admin_modules_form", meta:{title: '模块编辑', key:'admin_modules_form'}, component: () => import("@this/views/Admin/modules/form")},
            //***************************************
        ]},
];

