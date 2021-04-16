<template>
    <jet-action-section @submitted="createTeam">
        <template #title>
            Pending requests
        </template>

        <template #description>
            Your pending requests to join an existing organisation
        </template>

        <template #content>

            <div class="flex py-4 items-center justify-between" v-for="request in requests" :key="request.id">
                <div class="flex items-center">
                    <div class="ml-4 leading-tight">
                        <div>{{ request.team.name }}</div>
                    </div>
                </div>
            </div>

        </template>

    </jet-action-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetCroppie from '@/Jetstream/Croppie'

    export default {

        props: ['requests'],

        components: {
            JetButton,
            JetActionSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetCroppie
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    logo: ''
                })
            }
        },

        methods: {
            createTeam() {
                this.form.post(route('teams.store'), {
                    errorBag: 'createTeam',
                    preserveScroll: true
                });
            },
        },
    }
</script>
