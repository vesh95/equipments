<template>
    <div class="container">
        <div class="col-12">
            <div class="form-group">
                <label for="model" class="form-label">Модель</label>
                <select id="model" class="form-control" v-model="formData.equipmentTypeId">
                    <option :value="null"></option>
                    <option v-for="option in options" :key="option.value" :value="option.value">
                        {{ option.label }}
                    </option>
                </select>
                <ErrorAttribute :errors="equipmentTypeErrors"/>
            </div>
            <textarea v-model="formData.note" class="form-control">
            </textarea>
            <h3 class="mt-2">Серийные номера</h3>
            <div class="form-group"
                 v-for="(_, key) in formData.serialNumbers"
            >
                <input
                    :key="key"
                    v-model="formData.serialNumbers[key]"
                    class="form-control"
                >
                <ErrorAttribute :errors="serialNumbersErrors[key]"/>
                <button class="btn btn-link" @click="removeSerial(key)">Удалить</button>
            </div>
            <button class="btn btn-outline-primary mb-2 mt-1" @click="addSerial()">
                Добавить S/N
            </button>
            <div class="invalid-serial" v-if="invalidSerials.length">
                Невалидные SN
                <table class="table">
                    <tr>
                        <th>Id</th>
                        <th>Тип оборудования</th>
                        <th>Маска SN</th>
                        <th>Значение</th>
                    </tr>
                    <tr v-for="serial in invalidSerials">
                        <th>{{ serial.typeId }}</th>
                        <th>{{ serial.name }}</th>
                        <th>{{ serial.mask }}</th>
                        <th>{{ serial.value }}</th>
                    </tr>
                </table>
            </div>
            <div class="action-group mt-2">
                <button class="btn btn-success" @click="sendEquipment">Добавить</button>
            </div>
        </div>
    </div>
</template>
<script>
import store from "../store";
import EquipmentClient from "../clients/EquipmentClient";
import ErrorAttribute from "./ErrorAttribute";

export default {
    name: 'EquipmentForm',
    components: {
        ErrorAttribute
    },
    data: () => {
        return {
            formData: {
                equipmentTypeId: null,
                serialNumbers: [],
                note: null
            },
            errors: null,
            invalidSerials: [],
        }
    },
    methods: {
        addSerial() {
            this.formData.serialNumbers.push('')
        },
        removeSerial(id) {
            this.formData.serialNumbers.splice(id, 1)
        },
        sendEquipment() {
            EquipmentClient.create(this.formData)
                .then((response) => {
                    this.errors = null
                    const responseData = response.data
                    this.invalidSerials = responseData.invalidSerials
                    store.commit('appendEquipments', {equipments: responseData.equipments})
                    this.formData = {
                        equipmentTypeId: null,
                        serialNumbers: [],
                        note: null
                    }
                })
                .catch((error) => {
                    this.errors = this.flattenErrors(error.response.data.errors)
                })
        },
        flattenErrors(errors) {
            let flatten = []
            for (let key in errors) {
                flatten = [...flatten, ...errors[key]]
            }

            return flatten
        }
    },
    computed: {
        options() {
            return this.$store.getters.equipmentTypeOptions
        },
        equipmentTypeErrors() {
            let errors = []
            if (this.formData.equipmentTypeId == null) {
                errors.push('Выберете тип оборудования')
            }

            if (this.errors?.equipmentTypeId?.length) {
                errors.push(this.errors.equipmentTypeId)
            }

            return errors
        },
        serialNumbersErrors() {
            let errors = []
            this.formData.serialNumbers.map((value, key) => {
                if (value === "") {
                    errors[key] = ['Номер не должен быть пустым']
                }
            })

            return errors
        },
    }
}
</script>
