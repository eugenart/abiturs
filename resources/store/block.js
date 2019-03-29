export default {
    state: {
        blocks: [],
    },
    mutations: {
        ADD_BLOCK(state, payload) {
            state.blocks.push(payload)
        },

        EDIT_BLOCK(state, payload) {
            let block = state.blocks.find(block => block.id === payload.id);
            block = payload
        },

        REMOVE_BLOCK(state, index) {
            state.blocks.splice(index, 1)
        },

        SET_BLOCKS: (state, payload) => {
            state.blocks = payload;
        }
    },
    actions: {
        SAVE_BLOCK: async (context, payload) => {

            let {data} = await axios.post('/infoblock', {
                name: payload.name,
                url: payload.url,
                menu: payload.menu,
                menuPriority: payload.menuPriority,
                startPage: payload.startPage,
                startPagePriority: payload.startPagePriority,
                activityFrom: payload.activityFrom,
                activityTo: payload.activityTo,
                activity: payload.activity,
            });
            context.commit('ADD_BLOCK', data.infoblock)
        },

        UPDATE_BLOCK: (context, payload) => {
            axios.put('/infoblock/' + payload.id, {
                name: payload.name,
                url: payload.url,
                menu: payload.menu,
                menuPriority: payload.menuPriority,
                startPage: payload.startPage,
                startPagePriority: payload.startPagePriority,
                activityFrom: payload.activityFrom,
                activityTo: payload.activityTo,
                activity: payload.activity
            });
            context.commit('EDIT_BLOCK', payload)
        },

        DELETE_BLOCK:
            async (context, payload, index) => {
                await axios.delete('/infoblock/' + payload);
                context.commit('REMOVE_BLOCK', index)
            },

        GET_BLOCKS:
            async (context, payload) => {
                let {data} = await axios.get('/infoblocks');
                context.commit('SET_BLOCKS', data)
            }
    },
    getters: {
        BLOCKS: state => {
            return state.blocks
        }
    }
}
