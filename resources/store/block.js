export default {
    state: {
        blocks: [],
    },
    mutations: {
        ADD_BLOCK(state, payload) {
            state.blocks.push(payload)
        },

        EDIT_BLOCK(state, payload) {
            let index = state.blocks.findIndex(el => el.id === payload.id)
            Vue.set(state.blocks, index, payload)
        },

        REMOVE_BLOCK(state, id) {
            //state.blocks.splice(index, 1)
            state.blocks = $.grep(state.blocks, function (item) {
                return item.id !== id
            })
        },

        SET_BLOCKS: (state, payload) => {
            state.blocks = payload;
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
            $.each(payload.news, function (k, v) {
                formData.append('news[]', v);
            })
            formData.append('image', payload.image)
            let {data} = await axios.post('/admin/infoblock', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            context.commit('ADD_BLOCK', data.infoblock)

        },

        UPDATE_BLOCK: async (context, payload) => {
            let formData = new FormData();
            formData.append('name', payload.name);
            formData.append('url', payload.url);
            formData.append('menu', payload.menu);
            formData.append('menuPriority', (payload.menuPriority));
            formData.append('startPage', payload.startPage);
            formData.append('startPagePriority', payload.startPagePriority);
            formData.append('activityFrom', payload.activityFrom ? payload.activityFrom : '');
            formData.append('activityTo', payload.activityTo ? payload.activityTo : '');
            formData.append('activity', payload.activity);
            formData.append('image', payload.image);
            $.each(payload.news, function (k, v) {
                formData.append('news[]', v);
            })
            let {data} = await axios.post('/admin/infoblock/' + payload.id, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            context.commit('EDIT_BLOCK', data.infoblock)
        },

        DELETE_BLOCK:
            async (context, payload, index) => {
                await axios.delete('/admin/infoblock/' + payload);
                context.commit('REMOVE_BLOCK', payload)
            },

        GET_BLOCKS:
            async (context, payload) => {
                let {data} = await axios.get('/admin/infoblocks');
                context.commit('SET_BLOCKS', data)
            },
        COPY_BLOCK:
            async (context, payload) => {
                // let {data} = await axios.get('/admin/infoblocks/', {
                //     params: {
                //         copy_id: payload
                //     }
                // });
                let {data} = await axios.post('/admin/infoblock/copy/' + payload, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                console.log(payload)
                console.log(data.infoblock)

               context.commit('ADD_BLOCK', data.infoblock);
            }

    },
    getters: {
        BLOCKS: state => {
            return state.blocks
        }
    }
}
