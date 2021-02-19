<template>
    <div class="mb-8 md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <jet-section-title>
                    <template #title><slot name="title"></slot></template>
                    <template #description><slot name="description"></slot></template>
                </jet-section-title>
            </div>
        </div>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <slot name="form"></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import JetSectionTitle from './SectionTitle'
    export default {
        components: {
            JetSectionTitle,
        },

        computed: {
            hasActions() {
                return !! this.$slots.actions
            }
        }
    }
</script>
