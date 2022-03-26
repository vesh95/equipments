import {createStore} from 'vuex'

const store = createStore({
    state() {
        return {
            equipments: [],
            options: [],
            pagination: {
                page: 1,
                totalPage: 1,
            }
        }
    },
    mutations: {
        loadEquipments(state, data) {
            state.equipments = data.equipments
        },
        loadOptions(state, data) {
            state.options = data.options
        },
        removeEquipments(state, data) {
            state.equipments = state.equipments
                .filter((value) => value.id !== data.id)
        },
        appendEquipments(state, data) {
            state.equipments = [...state.equipments, ...data.equipments]
        },
        updateEquipment(state, data) {
            const item = state.equipments.find((value) => value.id === data.id)
            Object.assign(item, data)
        },
        setPagination(state, data) {
            this.state.pagination = {
                page: data.page,
                totalPage: data.totalPage
            }
        }
    },
    getters: {
        equipmentTypeOptions(state) {
            return state.options
                .map((option) => {
                    return {
                        label: option.name,
                        value: option.id
                    }
                })
        }
    }
})

export default store
