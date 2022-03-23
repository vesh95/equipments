<template>
    <div class="container">
        <div class="row justify-content-center mt-1">
            <EquipmentForm v-on:appendEquipment="appendEquipments" :options="options"/>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3" v-for="equipment in equipments">
                    <div class="card-header">
                        {{ equipment.serialNumber }}
                        {{ equipment.equipmentType.name }}

                    </div>
                    <div class="card-body">
                        {{ equipment.note || '(Без заметок)' }}
                    </div>
                    <div class="card-footer">
                        <button
                            class="btn btn-danger"
                            v-on:click="deleteEquipment(equipment.id)"
                        >
                            Удалить
                        </button>
                    </div>
                </div>
            </div>
        </div>
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
        }
    }
}
</script>
