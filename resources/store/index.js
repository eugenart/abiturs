import Vue from 'vue'
import Vuex from 'vuex'

import block from './block'
import section from './section'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        block,
        section
    }
})
