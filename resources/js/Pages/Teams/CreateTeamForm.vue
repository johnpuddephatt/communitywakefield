<template>
    <jet-form-section @submitted="createTeam">
        <template #title>
            Create a new team
        </template>

        <template #description>
            Create a new team to collaborate with others on projects.
        </template>

        <template #form>

            <div class="col-span-6">
                <jet-label value="Team Owner" />

                <div class="flex items-center mt-2">
                    <img class="w-12 h-12 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">

                    <div class="ml-4 leading-tight">
                        <div>{{ $page.props.user.name }}</div>
                        <div class="text-gray-700 text-sm">{{ $page.props.user.email }}</div>
                    </div>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Team Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="logo" value="Team logo" />
                <jet-croppie v-model="form.logo"></jet-croppie>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="info" value="Provide a short overview of what the organisation does" />
                <jet-textarea id="info" class="mt-1 block w-full" v-model="form.info" />
                <jet-input-error :message="form.errors.info" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="phone" value="Contact phone number" />
                <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" />
                <jet-input-error :message="form.errors.phone" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="Contact email" />
                <jet-input @blur.native="getEmailDomain" id="email" type="text" class="mt-1 block w-full" v-model="form.email" />
                <jet-input-error :message="form.errors.email" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="website" value="Website" />
                <jet-input id="website" type="text" class="mt-1 block w-full" v-model="form.website" />
                <jet-input-error :message="form.errors.website" class="mt-2" />
            </div>

            <div v-if="form.email" class="col-span-6 sm:col-span-4">
                <div class="flex items-center">
                    <jet-checkbox id="auto_join" :value="true" v-model="form.auto_join"/>
                    <jet-label class="ml-2" for="auto_join" :value="`Allow anyone with a matching email to join automatically`" />
                </div>
                <p v-if="emailDomain" class="ml-6 text-xs text-gray-700 mt-1 font-italic">Enable to allow anyone with an email ending <span class="bg-green-100 rounded-sm">@{{ emailDomain}}</span> to join this team automatically. Only enable this if the contact email above uses a domain that your organisation owns.</p>
                <jet-input-error :message="form.errors.auto_join" class="mt-2" />
            </div>

        </template>

        <template #actions>
            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetCroppie from '@/Jetstream/Croppie'
    import JetTextarea from '@/Jetstream/Textarea'
    import JetCheckbox from '@/Jetstream/Checkbox'

    export default {
        components: {
            JetButton,
            JetCheckbox,
            JetTextarea,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetCroppie
        },

        data() {
            return {
                emailDomain: null,
                form: this.$inertia.form({
                    name: '',
                    website: '',
                    logo: '',
                    email: '',
                    phone: '',
                    auto_join: false,
                    info: ''
                })
            }
        },

        methods: {
            createTeam() {
                this.form.transform((data) => ({
                    ...data,
                    auto_join: data.auto_join ? this.emailDomain : null
                })).post(route('teams.store'), {
                    errorBag: 'createTeam',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.$page.props.jetstream.flash = {
                            banner: 'Your new team has been created!',
                            bannerStyle: 'success'
                        }
                        this.isDirty = false;
                    }
                });
            },

            getEmailDomain() {
                this.emailDomain = this.form?.email.split('@')[1] ?? null
            }
        },
    }
</script>
