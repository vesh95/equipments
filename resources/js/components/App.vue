<template>
    <div id="app">
        <div class="container">
            <h1>Оборудование</h1>
            <p>
                <RouterLink to="/">Список</RouterLink>
                |
                <RouterLink to="/new">Добавить</RouterLink>
            </p>
        </div>
        <router-view></router-view>
    </div>
</template>
<script>
import {RouterLink} from 'vue-router'
import store from "../store";
import EquipmentClient from "../clients/EquipmentClient";
import EquipmentTypeClient from "../clients/EquipmentTypeClient";

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

        EquipmentTypeClient.fetchAll()
            .then((response) => store.commit('loadOptions', {
                    options: response.data.data
                })
            )
    }
}
</script>
