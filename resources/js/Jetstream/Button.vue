<template>
    <a v-if="href" :href="href" class="inline-flex items-center px-6 py-3 bg-blue-500 border border-transparent font-semibold text-sm text-white hover:bg-navy active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
        <slot></slot>
    </a>
    <button v-else :type="type" class="inline-flex items-center px-6 py-3 bg-blue-500 border border-transparent font-semibold text-sm text-white hover:bg-navy active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'submit',
            },
            href: {
                type: String
            }
        }
    }
</script>
