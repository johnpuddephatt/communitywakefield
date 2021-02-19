<template>
    <inertia-link v-if="href" :href="href" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
        <slot></slot>
    </inertia-link>
    <button v-else type="submit" class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 text-left hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: ['href']
    }
</script>
