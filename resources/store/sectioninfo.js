export default {
    state: {
        sectionsinfo: []
    },

    mutations: {
        ADD_SECTIONSINFO(state, payload) {
            state.sectioninfo.push(payload)
        },

        SET_SECTIONSINFO: (state, payload) => {
            state.sectioninfo = payload;
        }
    },

    actions: {
        SAVE_BLOCK: async (context, payload) => {
            let formData = new FormData();
            formData.append('name', payload.name);
            formData.append('url', payload.url);
            formData.append('menu', payload.menu);
            formData.append('menuPriority', payload.menuPriority);
            formData.append('startPage', payload.startPage);
            formData.append('startPagePriority', payload.startPagePriority);
            formData.append('activityFrom', payload.activityFrom);
            formData.append('activityTo', payload.activityTo);
            formData.append('activity', payload.activity);
            formData.append('image', payload.image);
            let {data} = await axios.post('/infoblock', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })

            context.commit('ADD_BLOCK', data.infoblock)

        },
        GET_SECTIONSINFO:
            async (context, payload) => {
                let {data} = await axios.get('/section-content');
                context.commit('SET_SECTIONSINFO', data)
            }
    },

    getters: {
        SECTIONSINFO: state => {
            return state.sectioninfo
        }
    }
}
