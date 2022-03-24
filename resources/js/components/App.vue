<template>
    <div class="container">
        <div class="row justify-content-center mt-1">
            <EquipmentForm v-on:appendEquipment="appendEquipments" :options="options"/>
        </div>
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

export default {
    components: {
        EquipmentForm
    },
    data() {
        return {
            equipments: [],
            options: [],
            filterList: {
                id: "",
                equipmentTypeId: null,
                serialNumber: "",
                note: "",
            },
        }
    },
    mounted() {
        self = this
        axios.get('/api/equipment').then((response) => {
            this.equipments = response.data.data
        })

        axios.get('/api/equipment/type').then((response) => {
            this.options = response.data.data.map((value) => {
                return {
                    'value': value.id,
                    'label': value.name,
                }
            })
        })
    },
    methods: {
        deleteEquipment: (id) => {
            axios.delete(`/api/equipment/${id}`).then(() => {
                self.$data.equipments = self.$data.equipments
                    .filter((value) => value.id !== id)
            })
        },
        appendEquipments(equipments) {
            this.equipments = [...this.equipments, ...equipments]
        },
    },
    computed: {
        filteredList() {
            return this.equipments
                .filter(equipment => this.filterList.id === "" || Number(this.filterList.id) === equipment.id)
                .filter(equipment => {
                    return this.filterList.equipmentTypeId === null
                        || this.filterList.equipmentTypeId === equipment.equipmentType.id
                })
                .filter(equipment => this.filterList.serialNumber === "" || this.filterList.serialNumber === equipment.serialNumber)
                .filter(equipment => this.filterList.note === "" || this.filterList.note === equipment.note)
        }
    }
}
</script>
