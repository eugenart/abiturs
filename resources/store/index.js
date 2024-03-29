import Vue from 'vue'
import Vuex from 'vuex'

import block from './block'
import section from './section'
import slider from './slider'
import time from './time'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        block,
        section,
        slider,
        time
    }
})
