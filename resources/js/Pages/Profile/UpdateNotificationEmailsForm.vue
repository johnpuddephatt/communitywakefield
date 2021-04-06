<template>
    <jet-form-section @submitted="updateNotificationEmails">
        <template #title>
            Email notifications
        </template>

        <template #description>
            Choose when you want to notified by email.
        </template>

        <template #form>

            <div v-for="(value, key) in notification_emails" :key="key" class="col-span-6">
                <label class="flex items-center">
                    <jet-checkbox :value="key" v-model="form.notification_emails"/>
                    <span class="ml-2 text-sm text-gray-600">{{ value }}</span>
                </label>
            </div>

        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetCheckbox,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        props: ['user','notification_emails'],

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'PUT',
                    notification_emails: this.user.notification_emails ?? []
                }),
            }
        },

        methods: {
            updateNotificationEmails() {
                this.form.post(route('user-notification-emails.update'), {
                    errorBag: 'updateNotificationEmails',
                    preserveScroll: true,

                    onError: () => {
                        this.$page.props.jetstream.flash = {
                            banner: 'Your email notification preferences could not be updated.',
                            bannerStyle: 'danger'
                        }
                    },

                    onSuccess: () => {
                        this.$page.props.jetstream.flash = {
                            banner: 'Your email notification preferences have been updated.',
                            bannerStyle: 'success'
                        }
                        this.isDirty = false;
                    }
                });
            },
        },
    }
</script>
