import { moduleUrl } from '@this/plugins/function'

// resources/views/index.blade.php 文件里面定义的全局变量 baseUrl
// 内容大概是 http://xxxxx.com/api/
const window_base_url = (window.baseUrl || '');
// http://xxxxx.com/api 这里去掉最后一个 / 用来与 moduleUrl 的路径进行拼接
const baseUrl = window_base_url.endsWith('/') ? window_base_url.substring(0, window_base_url.length - 1) : window_base_url;

export default {

    /**
     * 模块化接口
     */

    "adminModules": baseUrl + moduleUrl('modules'), // 模块

};
