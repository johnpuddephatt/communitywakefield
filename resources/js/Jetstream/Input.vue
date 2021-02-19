<template>
    <input
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        :value="value"
        @input="$emit('input', $event.target.value)"
        ref="input"
        :pattern="type == 'date' ? '\d{4}-\d{2}-\d{2}' : false"
        :placeholder="type == 'date' ? 'yyyy-mm-dd  ' : ''"
        :type="type">
</template>

<script>
    export default {
        props: ['value', 'type'],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    }
</script>
