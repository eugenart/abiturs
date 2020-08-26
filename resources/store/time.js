export default {
    state: {
        times: [],
    },
    mutations: {

        EDIT_TIME(state, payload) {
            let index = state.times.findIndex(el => el.id === payload.id)
            Vue.set(state.times, index, payload)
        },

        SET_TIMES: (state, payload) => {
            state.times = payload;
        }
    },
    actions: {
        UPDATE_TIME: async (context, payload) => {
            let formData = new FormData();
            formData.append('name_file', payload.name_file);
            formData.append('date_update', payload.date_update);
            let {data} = await axios.post('/admin/times/' + payload.id, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            context.commit('EDIT_TIME', data.times)
        },

        GET_TIMES:
            async (context, payload) => {
                let {data} = await axios.get('/admin/times');
                context.commit('SET_TIMES', data)
            }
    },
    getters: {
        TIMES: state => {
            return state.times
        }
    }
}
