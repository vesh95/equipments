<template>
    <div class="container">
        <div class="form-group">
            <label for="serialNumber">S/N</label>
            <input
                id="serialNumber"
                class="form-control"
                v-model="formData.serialNumber"
            >
            <error-attribute :errors="errors.serialNumber" />
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
            <error-attribute :errors="errors.equipmentTypeId" />
        </div>
        <div class="form-group">
            <textarea class="form-control" v-model="formData.note">
            </textarea>
            <error-attribute :errors="errors.note" />
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
import ErrorAttribute from "./ErrorAttribute";

export default {
    components: {
        ErrorAttribute
    },

    data() {
        return {
            formData: {},
            errors: {},
        }
    },
    mounted() {
        axios.get(`/api/equipment/${this.$route.params.id}`)
            .then((response) => {
                this.formData = response.data.data
            })
        this.errors = {}
    },
    methods: {
        updateEquipments() {
            axios.patch(`/api/equipment/${this.formData.id}`, {
                equipmentTypeId: this.formData.equipmentTypeId,
                serialNumber: this.formData.serialNumber,
                note: this.formData.note
            })
                .then((response) => {
                    store.commit('updateEquipment', response.data.data)
                    router.push('/')
                })
                .catch((error) => {
                    this.errors = error.response.data
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
