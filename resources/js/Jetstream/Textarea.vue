<template>
    <textarea
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm"
        @input="$emit('input', $event.target.value)"
        ref="input" >{{ value }}</textarea>
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
