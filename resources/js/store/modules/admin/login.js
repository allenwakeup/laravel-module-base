import {STORE_ADMIN, TOKEN, IS_LOGIN, USER_INFO} from '@/plugins/constant'
import {MUT_LOGIN, MUT_LOGOUT} from '@/store/mutation-types'
import {moduleStorageHelpers} from '@/plugins/function'

const {writeStorage, readStorage, removeStorage} = moduleStorageHelpers(STORE_ADMIN)

// initial state
const state = {
    isLogin: false,
    userInfo: {}
}

// getters
const getters = {
    userInfo: state => Object.keys(state.userInfo).length > 0 ? state.userInfo : (readStorage (USER_INFO) || {}),
    isLogin: state => state.isLogin || readStorage (IS_LOGIN)
}

// actions
const actions = {
    logout({commit}){
        commit(MUT_LOGOUT);
        removeStorage(TOKEN)
        removeStorage(USER_INFO)
        removeStorage(IS_LOGIN)
    }
}

// mutations
const mutations = {
    [MUT_LOGOUT](state){
        state.isLogin = false;
        state.userInfo = {};
        removeStorage(TOKEN)
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
