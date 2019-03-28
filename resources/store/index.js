import Vue from 'vue'
import Vuex from 'vuex'

import block from './block'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        block
    }
})
