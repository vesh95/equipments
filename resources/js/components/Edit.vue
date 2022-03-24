<template>
    <div class="container">
        <div class="form-group">
            <label for="serialNumber">S/N</label>
            <input
                id="serialNumber"
                class="form-control"
                v-model="formData.serialNumber"
            >
        </div>
        <div class="form-group">
            <select class="form-control" v-model="formData.equipmentTypeId">
                <option
                    :value="option.value"
                    v-for="option in options"
                >
                    {{ option.label }}
                </option>
            </select>
        </div>
        <div class="form-group">
            <textarea class="form-control" v-model="formData.note">
            </textarea>
        </div>

        <div class="action-group">
            <button
                class="btn btn-outline-success"
                @click="updateEquipments"
            >
                Редактировать
            </button>
        </div>
    </div>
</template>
<script>
import store from "../store";
import router from "../router";

export default {
    data() {
        return {
            formData: {}
        }
    },
    mounted() {
        this.formData = Object.create(this.$store.state.equipments.find((value) => {
            return value.id === Number(this.$route.params.id)
        }))
    },
    methods: {
        updateEquipments() {
            axios.patch(`api/equipment/${this.formData.id}`, {
                equipmentTypeId: this.formData.equipmentTypeId,
                serialNumber: this.formData.serialNumber,
                note: this.formData.note
            })
            .then((response) => {
                store.commit('updateEquipment', response.data.data)
                router.push('/')
            })
        }
    },
    computed: {
        options() {
            return this.$store.state.options
        }
    }
}
</script>
