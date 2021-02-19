<template>
    <button type="submit" class="block w-full px-6 py-2 text-sm leading-5 text-gray-700 text-left hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" v-if="as == 'button'">
        <slot></slot>
    </button>
    <inertia-link v-else :href="href" :class="classes" as="button">
        <slot></slot>
    </inertia-link>
</template>

<script>
    export default {
        props: ['href', 'active', 'as'],

        computed: {
            classes() {
                return this.active
                    ? 'bg-gray-200 rounded w-full inline-flex items-center px-3 pt-5 pb-4 font-semibold text-md leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out hover:text-gray-800 dark:hover:text-gray-200'
                    : 'rounded w-full inline-flex items-center px-3 pt-5 pb-4 font-semibold text-md leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out hover:text-gray-800 dark:hover:text-gray-200'
            }
        }
    }
</script>


class=""
