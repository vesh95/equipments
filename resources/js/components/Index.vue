<template>
    <div class="container">
        <h2>Оборудование</h2>
        <table class="table">
            <tr>
                <td>
                    <input v-model="filterList.id" class="form-control">
                </td>
                <td>
                    <select v-model="filterList.equipmentTypeId" class="form-control">
                        <option :value="null"></option>
                        <option
                            v-for="option in options"
                            :value="option.value"
                        >
                            {{ option.label }}
                        </option>
                    </select>
                </td>
                <td>
                    <input v-model="filterList.serialNumber" class="form-control">
                </td>
                <td>
                    <input v-model="filterList.note" class="form-control">
                </td>
                <th></th>
            </tr>
            <tr>
                <th>ID</th>
                <th>Тип оборудования</th>
                <th>S/N</th>
                <th>Примечание</th>
                <th></th>
            </tr>
            <tr v-for="equipment in filteredList">
                <td>{{ equipment.id }}</td>
                <td>{{ equipment.equipmentType.name }}</td>
                <td>{{ equipment.serialNumber }}</td>
                <td>{{ equipment.note }}</td>
                <td>
                    <button
                        class="btn btn-sm btn-danger"
                        v-on:click="deleteEquipment(equipment.id)"
                    >
                        Удалить
                    </button>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
import EquipmentForm from './EquipmentForm';
import store from "../store";

export default {
    components: {
        EquipmentForm
    },
    data() {
        return {
            filterList: {
                id: "",
                equipmentTypeId: null,
                serialNumber: "",
                note: "",
            },
        }
    },
    mounted() {
    },
    methods: {
        deleteEquipment: (id) => {
            axios.delete(`/api/equipment/${id}`).then(() => {
                store.commit('removeEquipments', {id})
            })
        },
    },
    computed: {
        filteredList() {
            return this.$store.state.equipments
                .filter(equipment => this.filterList.id === "" || Number(this.filterList.id) === equipment.id)
                .filter(equipment => {
                    return this.filterList.equipmentTypeId === null
                        || this.filterList.equipmentTypeId === equipment.equipmentType.id
                })
                .filter(equipment => this.filterList.serialNumber === "" || this.filterList.serialNumber === equipment.serialNumber)
                .filter(equipment => this.filterList.note === "" || this.filterList.note === equipment.note)
        },
        options() {
            return this.$store.state.options
        }
    }
}
</script>
