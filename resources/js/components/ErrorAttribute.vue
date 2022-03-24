<template>
    <ul class="text-danger" v-if="errors?.length" v-for="errorMessage in errors">
        <li>
            <small>{{ errorMessage }}</small>
        </li>
    </ul>
</template>
<script>
export default {
    props: {
        errors: Array
    },
}
</script>
<style>
    ul {
        margin: 0;
        padding: 0;
    }
</style>
