<template>
    <div id="app">
        <h1>Оборудование</h1>
        <p>
            <RouterLink to="/">Список</RouterLink>
            |
            <RouterLink to="/new">Добавить</RouterLink>
        </p>
        <!-- route outlet -->
        <!-- component matched by the route will render here -->
        <router-view></router-view>
    </div>
</template>
<script>
import {RouterLink} from 'vue-router'
import store from "../store";
import EquipmentClient from "../clients/EquipmentClient";

export default {
    components: {
        RouterLink
    },
    mounted() {
        EquipmentClient.fetchAll()
            .then((response) => {
                store.commit('loadEquipments', {
                    equipments: response.data.data
                })
            })

        axios.get('/api/equipment/type').then((response) => {
            const options = response.data.data.map((value) => {
                return {
                    'value': value.id,
                    'label': value.name,
                }
            })

            store.commit('loadOptions', {options})
        })
    }
}
</script>
