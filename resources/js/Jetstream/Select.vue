<template>
    <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm" @change="$emit('input', $event.target.value)" ref="select">
        <option v-for="option in options" :value="option" :selected="option == value">{{ option}} </option>
    </select>
</template>

<script>
    export default {
        props: ['value', 'options'],

        methods: {
            focus() {
                this.$refs.select.focus()
            }
        }
    }
</script>
