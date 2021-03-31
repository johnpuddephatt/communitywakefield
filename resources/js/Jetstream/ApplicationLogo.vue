<template>
    <div class="logo flex items-center leading-none lowercase font-black">
        Community
        <Jet-Application-Mark  :class="size == 'large' ? 'w-12 h-10 p-2' : 'w-6 h-6 p-1'"/>
        Wakefield
    </div>
</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark'

    export default {
        props: ['size'],
        components: {
            JetApplicationMark
        }
    }
</script>
