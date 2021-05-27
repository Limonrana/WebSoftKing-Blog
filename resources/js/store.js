import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        deleteModalObj : {
            data : null,
        },
        user: false,
        userPermission: null
    },
    getters: {
        getUserPermission(state) {
            return state.userPermission
        }

    },
    mutations: {
        setUpdateUser(state, data){
            state.user = data
        },
        setPermission(state, data) {
            state.userPermission = data
        }
    },
    actions: {
        changeCounterAction({commit}, data){
            commit('changeTheCounter', data)
        }
    }
})
