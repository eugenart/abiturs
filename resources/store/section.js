export default {
    state: {
        sections: []
    },
    mutations: {
        ADD_SECTION(state, payload) {
            let needSection = null
            if (payload.infoblockID) {
                //needSection = state.sections.find(item => item.id === payload.infoblockID)
                state.sections.push(payload)
            } else {
                $.each(state.sections, function (key, value) {
                    if (!needSection) {
                        needSection = value.sectionsList.find(item => item.id === payload.sectionID)
                        needSection.folder.push(payload)
                    }
                })
            }

            //state.sections.push(payload)
        },

        EDIT_SECTION(state, payload) {
            let index = state.sections.findIndex(el => el.id === payload.id);
            Vue.set(state.sections, index, payload)
        },

        REMOVE_SECTION(state, payload) {
            let needSections = null
            if (!payload.sId) {
                needSections = $.grep(state.sections, function (item) {
                    return item.id !== payload.id
                });
                state.sections = needSections
            }
            // else {
            //     $.each(state.sections, function (key, value) {
            //         if (!needSection) {
            //             needSection = value.sectionsList.find(item => item.id === payload.sId)
            //             needSection.folder = $.grep(needSection.folder, function (item) {
            //                 return item.id !== payload.id
            //             })
            //         }
            //     })
            // }
        },

        SET_SECTIONS: (state, payload) => {
            state.sections = payload;
        }
    },
    actions: {
        SAVE_SECTION: async (context, payload) => {
            let {data} = await axios.post('/admin/section', {
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
                isFolder: payload.isFolder,
                realLink: payload.realLink
            });
            context.commit('ADD_SECTION', data.section)
        },

        UPDATE_SECTION: (context, payload) => {
            axios.post('/admin/section/' + payload.id, {
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
                isFolder: payload.isFolder,
                realLink: payload.realLink
            });
            context.commit('EDIT_SECTION', payload)
        },

        DELETE_SECTION:
            async (context, payload) => {
                await axios.delete('/admin/section/' + payload.id);
                context.commit('REMOVE_SECTION', payload)
            },

        GET_SECTIONS:
            async (context, payload) => {
                let {data} = await axios.get('/admin/sections');
                context.commit('SET_SECTIONS', data)
            }
    },
    getters: {
        SECTIONS: state => {
            return state.sections
        }
    }
}
