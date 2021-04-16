<template>
    <jet-form-section>
        <template #title>
            Join an existing organisation
        </template>

        <template #description>
            Request to join an organisation that already exists
        </template>

        <template #form>

            <div class="col-span-6 sm:col-span-6">
                <jet-label for="name" value="Organisation Name" />
                <jet-search @join-request="joinRequest" :options="teams" :selected="requests" label="name" id="name" class="mt-1" autofocus />
            </div>

        </template>

    </jet-form-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetSearch from '@/Jetstream/Search'

    export default {
        props: ['teams', 'requests'],
        components: {
            JetSearch,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
        },

        data() {
            return {
                joinRequestForm: this.$inertia.form(),
            }
        },

        methods: {
            joinRequest(teamID) {
                this.joinRequestForm.post(route('teams.request', teamID), {
                    errorBag: 'joinRequest',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.$page.props.jetstream.flash = {
                            banner: 'Your request to join this organisation has been sent. You’ll receive an email if it’s approved.',
                            bannerStyle: 'success'
                        }
                    }
                });
            }
        },
    }
</script>
