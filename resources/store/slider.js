export default {
    state: {
        slides: [],
    },
    mutations: {
        ADD_SLIDE(state, payload) {
            state.blocks.push(payload)
        },

        EDIT_SLIDE(state, payload) {
            let index = state.slides.findIndex(el => el.id === payload.id)
            Vue.set(state.slides, index, payload)
        },

        REMOVE_SLIDE(state, id) {
            state.slides = $.grep(state.slides, function (item) {
                return item.id !== id
            })
        },

        SET_SLIDES: (state, payload) => {
            state.slides = payload;
        }
    },
    actions: {
        SAVE_SLIDE: async (context, payload) => {
            let formData = new FormData();
            formData.append('name', payload.name);
            formData.append('url', payload.url);
            formData.append('activityFrom', payload.activityFrom);
            formData.append('activityTo', payload.activityTo);
            formData.append('activity', payload.activity);
            formData.append('image', payload.image);
            let {data} = await axios.post('/slider', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })

            context.commit('ADD_SLIDE', data.slide)

        },

        UPDATE_SLIDE: async (context, payload) => {
            let formData = new FormData();
            formData.append('name', payload.name);
            formData.append('url', payload.url);
            formData.append('activityFrom', payload.activityFrom ? payload.activityFrom : '');
            formData.append('activityTo', payload.activityTo ? payload.activityTo : '');
            formData.append('activity', payload.activity);
            formData.append('image', payload.image);
            let {data} = await axios.post('/slider/' + payload.id, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            console.log(data.slide)
            context.commit('EDIT_SLIDE', data.slide)
        },

        DELETE_SLIDE:
            async (context, payload, index) => {
                await axios.delete('/infoblock/' + payload);
                context.commit('REMOVE_BLOCK', payload)
            },

        GET_SLIDES:
            async (context, payload) => {
                let {data} = await axios.get('/slider');
                context.commit('SET_SLIDES', data)
            }
    },
    getters: {
        SLIDES: state => {
            return state.slides
        }
    }
}
