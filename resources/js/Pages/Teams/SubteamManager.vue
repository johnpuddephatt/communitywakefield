<template>
    <div>
        <div v-if="userPermissions.canManageSubteams">
            <jet-section-border />

            <!-- Add Team Member -->
            <jet-form-section @submitted="addSubteam">
                <template #title>
                    Add a department
                </template>

                <template #description>
                    Add a new department to your organisation.
                </template>

                <template #form>
                    <div class="col-span-6">
                        <div class="max-w-xl text-sm text-gray-600">
                            Please provide the name of the department you would like to add to this organisation.
                        </div>
                    </div>

                    <!-- Subteam name -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="name" value="Name" />
                        <jet-input id="name" type="text" class="mt-1 block w-full" v-model="addSubteamForm.name" />
                        <jet-input-error :message="addSubteamForm.errors.name" class="mt-2" />
                    </div>


                </template>

                <template #actions>
                    <jet-action-message :on="addSubteamForm.recentlySuccessful" class="mr-3">
                        Added.
                    </jet-action-message>

                    <jet-button :class="{ 'opacity-25': addSubteamForm.processing }" :disabled="addSubteamForm.processing">
                        Add
                    </jet-button>
                </template>
            </jet-form-section>
        </div>


        <div v-if="team.subteams.length > 0">
            <jet-section-border />

            <!-- Manage Subteams -->
            <jet-action-section class="mt-10 sm:mt-0">
                <template #title>
                    Departments
                </template>

                <template #description>
                    All of the departments that are part of this organisation.
                </template>

                <!-- Subteam List -->
                <template #content>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between" v-for="subteam in subteams" :key="subteam.id">
                            <div class="flex items-center">
                                <div class="ml-4">{{ subteam.name }}</div>
                            </div>

                            <div class="flex items-center">
                                <!-- Edit Subteam -->
                                <a :href="route('subteam.edit', [team, subteam.id])" class="cursor-pointer ml-6 text-sm text-gray-500">Edit</a>
                                <!-- Remove Subteam -->
                                <button class="cursor-pointer ml-6 text-sm text-red-500"
                                                    @click="confirmSubteamRemoval(subteam)"
                                                    v-if="userPermissions.canManageSubteams">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </jet-action-section>
        </div>

        <!-- Remove Subteam Confirmation Modal -->
        <jet-confirmation-modal :show="subteamBeingRemoved" @close="subteamBeingRemoved = null">
            <template #title>
                Remove department
            </template>

            <template #content>
                Are you sure you would like to remove this department from the organisation?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="subteamBeingRemoved = null">
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="removeSubteam" :class="{ 'opacity-25': removeSubteamForm.processing }" :disabled="removeSubteamForm.processing">
                    Remove
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>
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
            'subteams',
            'availableRoles',
            'userPermissions'
        ],

        data() {
            return {
                addSubteamForm: this.$inertia.form({
                    name: ''
                }),

                removeSubteamForm: this.$inertia.form(),
                confirmingLeavingTeam: false,
                subteamBeingRemoved: null
            }
        },

        methods: {
            addSubteam() {
                this.addSubteamForm.post(route('subteam.store', this.team), {
                    errorBag: 'addSubteam',
                    preserveScroll: true,
                    onSuccess: () => this.addSubteamForm.reset(),
                });
            },

            confirmSubteamRemoval(subteam) {
                this.subteamBeingRemoved = subteam
            },

            removeSubteam() {
                this.removeSubteamForm.delete(route('subteam.destroy', [this.team, this.subteamBeingRemoved]), {
                    errorBag: 'removeSubteam',
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => (this.subteamBeingRemoved = null),
                })
            }
        },
    }
</script>
