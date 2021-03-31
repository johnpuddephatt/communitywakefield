<template>
    <a :type="type" v-if="href" :href="href" class="inline-flex items-center justify-center px-6 py-3 bg-brand-red border border-transparent font-semibold text-sm text-white hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-600 transition ease-in-out duration-150">
        <slot></slot>
    </a>
    <button v-else :type="type" class="inline-flex items-center justify-center px-6 py-3 bg-brand-red border border-transparent font-semibold text-sm text-white hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-600 transition ease-in-out duration-150">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'button',
            },
            href: {
                type: String
            }
        }
    }
</script>
