<template>
    <div>
        <div v-if="userPermissions.canAddTeamMembers">
            <jet-section-border />

            <!-- Add Team Member -->
            <jet-action-section>
                <template #title>
                    Organisation Join Requests
                </template>

                <template #description>
                    Requests to join your organisation will be shown here.
                </template>

                <template #content>
                    <div class="flex items-center justify-between" v-for="request in teamRequests" :key="request.id">
                        <div class="flex items-center">
                            <img class="w-8 h-8 rounded-full" :src="request.user.profile_photo_url" :alt="request.user.name">
                            <div class="ml-4 leading-tight">
                                <div>{{ request.user.name }}</div>
                                <div class="text-gray-700 text-sm">{{ request.user.email }}</div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <button @click="approveTeamRequest(request.id)" class="ml-2 text-sm text-gray-400 underline">
                                Approve request
                            </button>
                        </div>
                    </div>
                </template>

            </jet-action-section>
        </div>
    </div>
</template>

<script>
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetButton from '@/Jetstream/Button'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetSectionBorder from '@/Jetstream/SectionBorder'

    export default {
        components: {
            JetActionMessage,
            JetActionSection,
            JetButton,
            JetConfirmationModal,
            JetDangerButton,
            JetDialogModal,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
            JetSectionBorder,
        },

        props: [
            'team',
            'teamRequests',
            'userPermissions'
        ],

        data() {
            return {
                approveTeamRequestForm: this.$inertia.form(),
            }
        },

        methods: {
            approveTeamRequest(id) {
                this.approveTeamRequestForm.post(route('teams.approveRequest', {team: this.team, teamRequest: id}), {
                    errorBag: 'approveTeamRequest',
                    preserveScroll: true,
                    onSuccess: () => this.$page.props.jetstream.flash = {
                        banner: 'The request to join your organisation has been approved.',
                        bannerStyle: 'success'
                    }
                });
            },
        },
    }
</script>
