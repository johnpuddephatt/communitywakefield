<template>
    <jet-action-section>
        <template #title>
            Delete Organisation
        </template>

        <template #description>
            Permanently delete this organisation.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Once an organisation is deleted, all of its resources and data will be permanently deleted. Before deleting this organisation, please download any data or information that you wish to retain.
            </div>

            <div class="mt-5">
                <jet-danger-button @click.native="confirmTeamDeletion">
                    Delete Organisation
                </jet-danger-button>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <jet-confirmation-modal :show="confirmingTeamDeletion" @close="confirmingTeamDeletion = false">
                <template #title>
                    Delete Organisation
                </template>

                <template #content>
                    Are you sure you want to delete this organisation? Once an organisation is deleted, all of its resources and data will be permanently deleted.
                </template>

                <template #footer>
                    <jet-secondary-button @click.native="confirmingTeamDeletion = false">
                        Nevermind
                    </jet-secondary-button>

                    <jet-danger-button class="ml-2" @click.native="deleteTeam" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Organisation
                    </jet-danger-button>
                </template>
            </jet-confirmation-modal>
        </template>
    </jet-action-section>
</template>

<script>
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        props: ['team'],

        components: {
            JetActionSection,
            JetConfirmationModal,
            JetDangerButton,
            JetSecondaryButton,
        },

        data() {
            return {
                confirmingTeamDeletion: false,
                deleting: false,

                form: this.$inertia.form()
            }
        },

        methods: {
            confirmTeamDeletion() {
                this.confirmingTeamDeletion = true
            },

            deleteTeam() {
                this.form.delete(route('teams.destroy', this.team), {
                    errorBag: 'deleteTeam'
                });
            },
        },
    }
</script>
