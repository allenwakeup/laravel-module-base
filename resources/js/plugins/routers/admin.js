export default [
    // 模块化后台界面
    {
        path:"/Admin/goodcatch/m/base/index",name:"goodcatch_m_base_index",component:()=>import("@/views/Admin/index"),children:[
            {path:"/Admin/goodcatch/m/base/index",name:"goodcatch_m_base_default",component:()=>import("@/views/Admin/default")}, // 打开默认页面

            // 模块管理
            {path:"/Admin/goodcatch/m/base/modules",name:"goodcatch_m_base_admin_modules",component:()=>import("@/views/Admin/modules/index")},

            {path:"/Admin/goodcatch/m/base/modules/form/:id?",name:"goodcatch_m_base_admin_modules_form",component:()=>import("@/views/Admin/modules/form")},
        ]
    }
];
