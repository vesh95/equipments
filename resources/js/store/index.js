import { createStore } from 'vuex'

const store = createStore({
    state() {
        return {
            equipments: [],
            options: [],
        }
    },
    mutations: {
        loadEquipments (state, data) {
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
    },
})

export default store
