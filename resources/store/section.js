export default {
    state: {
        sections: [],
        blocksections: []
    },
    mutations: {
        ADD_SECTION(state, payload) {
            state.sections.push(payload)
        },

        EDIT_SECTION(state, payload) {
            let index = state.sections.findIndex(el => el.id === payload.id)
            Vue.set(state.sections, index, payload)
        },

        REMOVE_SECTION(state, index) {
            state.sections = $.grep(state.sections, function (item) {
                return item.id != id
            })
        },

        SET_SECTIONS: (state, payload) => {
            state.sections = payload;
        },

        SET_BLOCK_SECTIONS: (state, id) => {
            state.blocksections = state.sections.filter(section => section.infoblockID === id);
            console.log(state.sections)
            console.log(state.blocksections)
        }
    },
    actions: {
        SAVE_SECTION: async (context, payload) => {
            let {data} = await axios.post('/section', {
                name: payload.name,
                url: payload.url,
                description: payload.description,
                sectionID: payload.sectionID,
                infoblockID: payload.infoblockID,
                startPage: payload.startPage,
                startPagePriority: payload.startPagePriority,
                activityFrom: payload.activityFrom,
                activityTo: payload.activityTo,
                activity: payload.activity,
            });
            context.commit('ADD_SECTION', data.section)
        },

        UPDATE_SECTION: (context, payload) => {
            axios.put('/section/' + payload.id, {
                name: payload.name,
                url: payload.url,
                description: payload.description,
                sectionID: payload.sectionID,
                infoblockID: payload.infoblockID,
                startPage: payload.startPage,
                startPagePriority: payload.startPagePriority,
                activityFrom: payload.activityFrom,
                activityTo: payload.activityTo,
                activity: payload.activity,
            });
            context.commit('EDIT_SECTION', payload)
        },

        DELETE_SECTION:
            async (context, payload, index) => {
                await axios.delete('/section/' + payload);
                context.commit('REMOVE_SECTION', index)
            },

        GET_SECTIONS:
            async (context, payload) => {
                let {data} = await axios.get('/sections');
                context.commit('SET_SECTIONS', data)
            },
        GET_INFOBLOCK_SECTIONS:
            async (context, id) => {
                context.commit('SET_BLOCK_SECTIONS', id)
            }
    },
    getters: {
        SECTIONS: state => {
            return state.sections
        },
        BLOCKSECTIONS: state => {
            return state.blocksections
        }
    }
}
