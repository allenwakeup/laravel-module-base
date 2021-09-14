import Vue from 'vue'
import Vuex from 'vuex'

import common from '@/store/modules/admin/common'
import login from '@/store/modules/admin/login'


Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        common,
        login
    },
    strict: false,
})