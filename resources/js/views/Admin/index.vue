<template>

    <a-layout class="admin_index_main">

        <!-- 菜单 start -->
        <a-layout-sider v-if="!subMenu" class="admin_menu" width="180" v-model="collapsed" :trigger="null" collapsible>
            <div class="base_shadow admin_menu_title"><img class="logo" :src="collapsed ? '/dist/images/system_logo_mini.png' : '/dist/images/system_logo.png'" alt="logo"><div :class="collapsed?'hiddens':'shows'"><a-badge :offset="[18,0]"><span class="version" slot="count">{{version}}</span><span class="name">{{ appName }}</span></a-badge></div></div>
            <a-menu mode="inline" :inline-indent="10" theme="dark" :default-selected-keys="defaultSelectedKeys" :open-keys.sync="defaultOpenKeys">
                <a-menu-item @click="to_nav('/Admin/index', 0)"><a-font class="afont menu_icon" type="icon-gc-home" /><span>首页</span></a-menu-item>
                <a-sub-menu v-if="v.is_type >= 100" v-for="v in menus" :key="v.id + ''">
                    <span slot="title"><a-font class="afont menu_icon" :type="v.icon||'icon-gc-home'" /><span :title="v.name">{{v.name}}</span></span>
                    <template v-for="vo in (v.children||[])">
                        <a-menu-item v-if="$isEmpty(vo.children) || vo.children.length===0" :key="vo.id + ''"  @click="to_nav(vo.link, vo.id)" :title="vo.name"><a-font class="afont menu_icon" v-if="!!vo.icon" :type="vo.icon" />{{vo.name}}</a-menu-item>
                        <a-sub-menu v-else :key="vo.id + ''">
                            <span slot="title"><a-font class="afont menu_icon" v-if="!!vo.icon" :type="vo.icon" /><span :title="vo.name">{{vo.name}}</span></span>
                            <a-menu-item  @click="to_nav(vo2.link, vo2.id)" v-for="vo2 in (vo.children||[])" :key="vo2.id + ''" :title="vo2.name"><a-font class="afont menu_icon" v-if="!!vo2.icon" :type="vo2.icon" ></a-font><a-tooltip placement="right" :title="vo2.name">{{vo2.name}}</a-tooltip></a-menu-item>
                        </a-sub-menu>
                    </template>
                </a-sub-menu>
            </a-menu>
        </a-layout-sider>
        <!-- 菜单 end -->

        <!-- 右侧内容 start -->
        <a-layout class="admin_right_content" ref="content_view">
            <a-layout-header :class="subMenu?'admin_right_top mobile':(collapsed?'admin_right_top small':'admin_right_top')">
                <div v-if="subMenu" class="admin_menu_title item_left float_left"><img style="margin-top:-6px;margin-right:10px" width="30px" height="30px" src="/dist/images/system_logo.png" alt="logo"></div>
                <a-icon class="base_font_size item_left primary-color-reverse" :type="collapsed ? 'menu-unfold' : 'menu-fold'" @click="toggleCollapsed"/>
                <div class="top-menu">

                        <span v-if="topMenus.length > 1" @mouseleave="showAllMenu = false">
                            <a-icon class="base_font_size item_left primary-color-reverse" type="appstore" @mouseover="showAllMenu = true"  />
                            <transition name="el-zoom-in-top">
                                <DropdownCategory :data-source="allMenus"
                                                  :open="showAllMenu"
                                                  v-show="showAllMenu"
                                                  :name="PREFS_USER_MENU_HISTORY"
                                                  @close="showAllMenu = false"
                                                  @change="menu => to_nav(menu.link, menu.id)" /></transition>
                        </span>

                    <a-menu v-if="topMenus.length > 0" mode="horizontal">
                        <a-menu-item @click="to_nav(t.link, t.id)" v-for="t in topMenus" :key="t.id" :title="t.name" class="primary-color-reverse"><a-font class="afont menu_icon" v-if="!!t.icon" :type="t.icon" />{{t.name}}</a-menu-item>
                    </a-menu>
                </div>
                <div class="item_right">
                    <div class="menu_right_content">
                        <div class="quick_btns">
                            <fullscreen class="quick_btn"/>
                            <notification class="quick_btn"/>
                        </div>
                        <a-dropdown class="dropdown_right" overlayClassName="person_menu">
                            <div class="admin_top_person" @click="e => e.preventDefault()">
                                <a-icon  v-show="isBusy" type="loading" class="icon-busy" />
                                <a-badge :dot="notification > 0">
                                    <a-avatar v-show="!isBusy" class="avatar" size="small" icon="user" :src="userInfo.avatar"/>
                                </a-badge>
                                <a-icon class="dropdown_right_arrow primary-color-reverse" type="down" />
                            </div>
                            <a-menu slot="overlay">
                                <a-menu-item key="0" @click="to_nav('/Admin/index', 0)">
                                    <div class="name">{{userInfo.nickname}}</div>
                                    <div class="account">{{userInfo.username}}</div>
                                </a-menu-item>
                                <a-menu-item key="1" @click="logout">
                                    <a-icon style="color:red" type="logout" />
                                    <span style="color:red">退出系统</span>
                                </a-menu-item>
                            </a-menu>
                        </a-dropdown>

                    </div>

                </div>
                <div class="clear"></div>
                <a-progress v-if="isBusy"
                            class="progress-bar"
                            :show-info="false"
                            :stroke-width="5"
                            :stroke-color="{
                        from: '#108ee9',
                        to: '#87d068',
                    }"
                            :percent="progressBar.percent"
                            status="active"
                />
            </a-layout-header>

            <!-- 主体内容 -->
            <a-layout-content>
                <router-tab :class="subMenu?'admin_content_view clear_m':'admin_content_view'" />
            </a-layout-content>
        </a-layout>
        <!-- 右侧内容 end -->

        <!-- 手机菜单 start -->
        <a-drawer :body-style="{ padding: 0, height: '100%' }" placement="left" :closable="false" :visible="drawerShow" @close="onClose">
            <div class="admin_menu mobile">
                <div class="admin_menu_title"><img src="/dist/images/system_logo.png" alt="logo"><div :class="'shows'">{{ appName }}</div></div>
                <a-menu mode="inline">
                    <a-menu-item @click="to_nav('/Admin/index')"><a-font class="afont menu_icon" type="icon-gc-home" /><span>首页</span></a-menu-item>
                    <a-sub-menu v-for="v in menus" :key="v.id">
                        <span slot="title"><a-font class="afont menu_icon" :type="v.icon||'icon-gc-home'" /><span>{{v.name}}</span></span>
                        <template v-for="vo in (v.children||[])">
                            <a-menu-item v-if="$isEmpty(vo.children) || vo.children.length===0" :key="vo.id"  @click="to_nav(vo.link)"><a-font class="afont menu_icon" v-if="!!vo.icon" :type="vo.icon" />{{vo.name}}</a-menu-item>
                            <a-sub-menu v-else :key="vo.id">
                                <span slot="title"><a-font class="afont menu_icon" v-if="!!vo.icon" :type="vo.icon" /><span>{{vo.name}}</span></span>
                                <a-menu-item  @click="to_nav(vo2.link)" v-for="vo2 in (vo.children||[])" :key="vo2.id"><a-font class="afont menu_icon" v-if="!!vo2.icon" :type="vo2.icon" />{{vo2.name}}</a-menu-item>
                            </a-sub-menu>
                        </template>
                    </a-sub-menu>
                </a-menu>
            </div>
        </a-drawer>
        <!-- 手机菜单 end -->
    </a-layout>



</template>

<script>

import Fullscreen from '@/components/fullscreen'
import DropdownCategory from '@/components/dropdowncategory'
import Notification from '@/components/notification'
import { createNamespacedHelpers } from 'vuex'
import { STORE_ADMIN_LOGIN, STORE_ADMIN_COMMON, PREFS_USER_THEME_COLOR, PREFS_USER_MENU_HISTORY } from '@/plugins/constant'
import { getMenuPathById, changeThemeColor } from '@/plugins/function'

const adminLoginStore = createNamespacedHelpers(STORE_ADMIN_LOGIN)
const adminCommonStore = createNamespacedHelpers(STORE_ADMIN_COMMON)

export default {
    components: { Fullscreen, Notification, DropdownCategory },
    props: {},
    data() {
        return {
            PREFS_USER_MENU_HISTORY,
            appName: '',
            version: 'v1.0',
            isAdminDefault:false, // 默认页面
            collapsed:false,
            subMenu:false,
            drawerShow:false,
            screenWidth: document.body.clientWidth, // 屏幕宽度
            menus:[],
            allMenus:[],
            isRefresh:true,
            defaultOpenKeys: [],
            progressBar: {
                percent: 0,
                interval: -1
            },
            topMenus: [],
            showAllMenu:false,
        };
    },
    provide () {
        return {
            reload: this.reload
        }
    },
    watch: {
        isBusy(oldVal, newVal ){
            if(newVal){
                this.progressBar.percent = 0;
                this.clearProgressInterval();
            }
            if(oldVal){
                this.progressBar.interval = window.setInterval(() => {
                    this.progressBar.percent = Math.min(100, this.progressBar.percent + Math.ceil(Math.random()*10));
                    if(this.progressBar.percent === 100){
                        window.setTimeout(() => {
                            // 5秒钟后 强制关闭
                            this.clearProgressInterval();
                            // 重置状态
                            this.setTopBusy(false);
                        }, 5000)
                    }
                }, 1000)
            }
        }
    },
    computed:{
        ...adminLoginStore.mapGetters([
            'isLogin',
            'userInfo'
        ]),
        ...adminCommonStore.mapGetters([
            'pref',
            'isBusy',
            'notification'
        ]),
        ...adminCommonStore.mapGetters({
            userPref: 'pref',
            sysSize: 'size',
        }),

        defaultSelectedKeys() {
            return this.pref.menu && this.pref.menu.selected && this.pref.menu.selected.length > 0 ? this.pref.menu.selected : []
        }
    },
    methods: {
        ...adminLoginStore.mapActions({
            storeLogout: 'logout'
        }),
        ...adminCommonStore.mapActions({
            selectMenu: 'selectMenu',
            selectMenuImmediately: 'selectMenuImmediately',
            setTopBusy: 'gettingBusy',
            setWidth: 'setWidth',
            setHeight: 'setHeight',
            setNotificationCount: 'setNotification',
            setUserPrefs: 'setPref', // 设置用户偏好
            setUserPrefsImmediately: 'setPrefImmediately', // 设置用户偏好（直接写入）
        }),
        // 记录历史菜单
        rememberMenu(id, immediately = false) {
            const { userPref } = this;
            const pref = userPref[PREFS_USER_MENU_HISTORY] ?? {};
            const prop = `_${id}`;
            if(pref.hasOwnProperty(prop)) {
                pref[prop] ++;
            } else {
                pref[prop] = 1;
            }
            userPref[PREFS_USER_MENU_HISTORY] = pref;
            if(immediately) {
                this.setUserPrefsImmediately(userPref);
            } else {
                this.setUserPrefs(userPref);
            }

        },
        // 收缩菜单
        toggleCollapsed() {
            this.collapsed = !this.collapsed;
            if(this.subMenu){
                this.drawerShow = !this.drawerShow;
            }
        },
        onClose() {
            this.drawerShow = false;
        },
        get_menus(){
            this.setTopBusy(true);
            this.$get(this.$api.adminMenus).then(res=>{
                if(res.code === 200){
                    this.allMenus = res.data;
                    if(window.menuType){
                        const menus = res.data.filter(menu => menu.is_type === window.menuType);
                        if(menus && menus.length > 0){
                            this.menus = menus[0].children;
                        }
                    }else{
                        this.menus = res.data;
                    }

                    this.topMenus = res.data.filter(menu => menu.is_type > 100);

                    if(this.pref.menu){
                        if(!this.$isEmpty(this.pref.menu.route)){
                            if(this.$route.path !== this.pref.menu.route){
                                this.setTopBusy(false);
                                const pref_selected_menu_id = this.pref.menu.selected || [];

                                this.to_nav(this.pref.menu.route, pref_selected_menu_id.length > 0 ? parseInt(pref_selected_menu_id [pref_selected_menu_id.length -1]): null)
                            }
                        }
                        if(this.pref.menu.selected && this.pref.menu.selected.length > 0){
                            this.defaultOpenKeys = this.pref.menu.selected;
                        }
                    }
                }
                this.setTopBusy(false);
            }, e => this.setTopBusy(false));
        },
        to_nav(path, id){

            const that = this;
            this.$hasRoute(this.$router, {path})
                .then(resolved_routes => {
                    const selectedMenu = getMenuPathById(that.menus, id);
                    if(resolved_routes && resolved_routes.filter(item=>['404', 'homepage', 'modules'].includes(item.name)).length > 0){
                        if(that.pref.menu && that.pref.menu.route !== path) {
                            that.rememberMenu(id, true);
                            that.selectMenuImmediately({
                                selected: selectedMenu,
                                route: path
                            })
                        }
                        console.log(selectedMenu)
                        window.location.href = path;
                    } else {
                        that.reload();
                        that.rememberMenu(id);
                        that.selectMenu({
                            selected: selectedMenu,
                            route: path
                        })
                        that.$router.push(path);
                    }
                    this.defaultOpenKeys = !! selectedMenu && selectedMenu.length > 0 ? selectedMenu : [];
                })

        },
        clearProgressInterval(){
            if(this.progressBar.interval > 0){
                window.clearInterval(this.progressBar.interval)
            }
        },
        // 判断是否宽度小于多少
        onScreenWidth(){
            if(this.screenWidth<=950 && this.screenWidth>=576){
                this.collapsed = true;
                this.subMenu = false;
                this.drawerShow = false;
            }else if(this.screenWidth<576){
                this.collapsed = true;
                this.subMenu = true;
            }else{
                this.collapsed = false;
                this.subMenu = false
                this.drawerShow = false;
            }
        },
        reload () {
            this.isRefresh= false
            this.$nextTick(function () {
                this.isRefresh= true
            })
        },
        // 数据库消息通知
        getUnreadNotificationsCount() {
            this.$get(this.$api.adminNotifications, {data_type: 'unread'}).then(res=>{
                if(res.code === 200 && !!res.data && res.data > 0){
                    this.setNotificationCount(res.data);
                }
            });
        },
        // 退出后台
        logout(){
            const vm = this;
            vm.setTopBusy(true);
            this.$get(this.$api.adminLogout).then(res=>{
                this.$message.success(res.msg);

                vm.storeLogout();
                setTimeout(function() {window.location.href = '/Admin/login';}, 1000);

            })
        },

        theme() {
            const modifyVars = this.userPref [PREFS_USER_THEME_COLOR];

            if(!!modifyVars) {
                changeThemeColor(modifyVars);
            }
        }

    },
    created() {
        this.appName = !!window.app_name ? window.app_name : '';

        this.get_menus();
        // console.log(this.$route.name)
        if(this.$route.name === 'admin_default'){
            this.isAdminDefault = true;
        }else{
            this.isAdminDefault = false;
        }

        this.getUnreadNotificationsCount();

        this.theme();
    },
    mounted() {
        let _this = this
        this.onScreenWidth();
        window.onresize = () => {
            return (() => {
                window.screenWidth = document.body.clientWidth;
                _this.screenWidth = window.screenWidth
                _this.onScreenWidth();
                this.setWidth(document.body.clientWidth);
                this.setHeight(document.body.clientHeight);
            })()
        }
        this.setWidth(document.body.clientWidth);
        this.setHeight(document.body.clientHeight);
    },
    beforeRouteUpdate (to, from, next) {
        // console.log(to,from);
        if(to.name === 'admin_default'){
            this.isAdminDefault = true;
        }else{
            this.isAdminDefault = false;
        }
        next();
    },
    beforeDestroy() {
        this.clearProgressInterval();
    }
};
</script>
<style lang="less" scoped>
.admin_index_main{
    height: 100%;
}
.admin_right_content{
    width: 100%;
    // transform: scale3d(1, 1, 1);
    // -ms-transform: scale3d(1, 1, 1);
    // -moz-transform: scale3d(1, 1, 1);
    // -webkit-transform: scale3d(1, 1, 1);
    position: relative;
    background: #efefef;
    scroll-behavior: smooth;
    &:after{
        display: block;
        clear: both;
        content:'';
    }

    .admin_right_top{
        justify-content: space-between;
        padding: 0 0;
        box-sizing: border-box;
        line-height: 36px;
        height: 36px;
        width: 100%;
        display: flex;
        // width: calc(~"100% - '180px'");
        //width: e("calc(width - 90)");
        z-index: 99;
        //background: @primary-color;
        border-bottom: 1px solid #efefef;

        &.small{
            /*width: calc(100% - 82px);*/
        }
        &.mobile{
            width: 100%;
        }
        .item_left{
            line-height: 40px;
            //color: @text-color-inverse;
            width: 50px;
        }
        .item_right{

            width: 148px;
            min-width: 148px;
            margin-right: 5px;
            .menu_right_content{
                .quick_btns {
                    line-height: 40px;
                    display: inline-block;
                    .quick_btn{
                        margin: 0 7px;

                    }
                }
                .dropdown_right {

                    display: inline-block;
                    margin-left: 7px;
                }
            }


            .admin_top_person{
                cursor: pointer;
                .avatar{margin-top: -4px;margin-right: 4px;}
                .icon-busy {
                    margin-top: -4px;
                    margin-right: 4px;
                    font-size: 1.5em;
                    color: #13c2c2;


                }
                .dropdown_right_arrow {
                    transition: all ease-in 200ms;
                    opacity: .1;
                }
            }
            .admin_top_person:hover .dropdown_right_arrow {
                opacity: .9;
                //color: @text-color-inverse;
            }


        }
        .top-menu{
            width: 100%;
            .ant-menu-horizontal {
                line-height: 34px;
                background: transparent;
                box-shadow: none;
                display: inline-block;
                .ant-menu-item {
                    padding: 0 10px;
                    .anticon {
                        margin-right: 3px;
                    }
                };
                .ant-menu-item-active, .ant-menu-item:hover {
                    color: inherit;
                }
            }
        }

        .progress-bar{
            position:absolute;
            line-height: 0;
            margin-top: -5px;
        }

    }
    .admin_content_view{
        position: relative;
        margin: -12px 2px 0 2px;
        padding: 7px;
        background: #fff;
        // overflow: initial;
        border-radius: 4px;
        // height: calc(100vh - 64px);
        border:1px solid #e7eaec!important;
        &:after{
            content:'';
            clear:both;
            display: block;
        }
        &.clear_m{
            margin: 72px 0 22px 0;;
        }
    }
    .admin_content_view2{
        position: relative;
        margin: 45px 0 0 0;
        padding: 12px 0;
        // overflow: initial;
        height: auto;
        &:after{
            content:'';
            clear:both;
            display: block;
        }
        &.clear_m{
            margin: 72px 0 22px 0;;
        }
    }
}
.admin_menu{
    max-width: 230px;
    min-height: 100%;

    .ant-menu-item {
        height: 30px;
        line-height: 30px;
    }
    .afont {
        font-size: 14px;
        margin-right: 7px;
    }
    .ant-menu-submenu ::v-deep .ant-menu-submenu-title {
        height: 30px;
        line-height: 30px;
    }
    .menu_icon{
        color:#fff!important;
    }
    &.mobile{
        width: 100%;
        max-width:100%;
    }
    .admin_menu_title{

        color:#fff;

        //background: #231f1f;
        //border-bottom: 2px solid #3d4f5e;
        text-align: center;

        .name {
            font-size: 20px;
            margin-left: -32px;
        }

        .version {
            font-style: italic;
            color: #cad5ca;
            font-size: 5px;
            border-radius: 9px;
            border: 1px solid #cad5ca;
            padding: 1px 3px;
        }

        img{
            height: 35px;
            padding: 5px 0;

        }
        div{

            &.hiddens{
                display: none;
            }
            &.shows{
                color:#fff;
                font-size: 20px;
                line-height: 80px;
                //background: #231f1f;
                box-shadow: 0 5px 5px rgba(69, 68, 68, 0.45) inset;
            }
        }
    }

    //.ant-menu-item.ant-menu-item-selected {
    //    background: #409EFF;
    //
    //}

}

.icon-busy ::v-deep .anticon-spin {
    animation: loadingCircle 0.3s infinite linear;
    -webkit-animation: loadingCircle 0.3s infinite linear;
    -moz-animation: loadingCircle 0.3s infinite linear;
}
.person_menu {
    div.name {
        font-size: 1.2em;
        font-weight: bold;
        margin: 10px 10px 5px 10px;
    }

    div.account {
        font-size: 1em;
        padding: 0 50px 10px 10px;
    }
}
</style>
