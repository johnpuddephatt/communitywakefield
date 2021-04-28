<template>
<app-layout>
    <template #header>
        <h2 v-if="subteam" class="font-semibold text-xl text-gray-800 leading-tight">Edit department</h2>
        <h2 v-else class="font-semibold text-xl text-gray-800 leading-tight">Create department</h2>
    </template>

    <template #actions>
        <jet-button class="ml-2" @click.native="saveEntry(true)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save</jet-button>
    </template>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <form @submit.prevent="form.post('/login')">

                <jet-fieldset>
                    <template #title>
                        Overview
                    </template>

                    <template #description>
                        Provide the name and optionally a description for this department. You might want to let people know what its responsibilities are.
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-6">
                            <jet-label for="name" value="Name" />
                            <jet-input id="name" type="text" class="mt-1 block w-full text-2xl" v-model="form.name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="info" value="Provide a short overview of what the department does" />
                            <jet-textarea id="info" class="mt-1 block w-full" v-model="form.info" />
                            <jet-input-error :message="form.errors.info" class="mt-2" />
                        </div>
                    </template>
                </jet-fieldset>
            </form>
        </div>
    </div>
</app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import JetButton from '@/Jetstream/Button'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetInput from '@/Jetstream/Input'
import JetCheckbox from '@/Jetstream/Checkbox'
import JetSelect from '@/Jetstream/Select'
import JetTextarea from '@/Jetstream/Textarea'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import VueGoogleAutocomplete from '@/Jetstream/GoogleAutocomplete'
import JetTipTap from '@/Jetstream/TipTap'
import JetFieldset from '@/Jetstream/Fieldset'
import JetMultiselect from '@/Jetstream/MultiSelect'

export default {

    props: {
        team: Object,
        subteam: Object
    },
    components: {
        AppLayout,
        JetButton,
        JetSelect,
        JetInput,
        JetCheckbox,
        JetFieldset,
        JetInputError,
        JetLabel,
        JetSectionBorder,
        JetConfirmationModal,
        JetTextarea,
        JetTipTap,
        JetSecondaryButton,
        JetMultiselect,
        VueGoogleAutocomplete
    },
    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                name: this.subteam?.name ?? null,
                info: this.subteam?.info ?? null
            })
        }
    },
    watch: {
    },
    methods: {
        saveEntry() {
            this.form.post(route('subteam.update', {team: this.team.id, subteam: this.subteam.id }), {
                preserveScroll: true,
                resetOnSuccess: false,
                bag: 'updateSubteam',

                onSuccess: () => {
                    if (! this.form.hasErrors ) {
                        this.$page.props.jetstream.flash = {
                            banner: 'Department updated!',
                            bannerStyle: 'success'
                        }
                    }
                    else {
                        this.$page.props.jetstream.flash = {
                            banner: 'Error updating department',
                            bannerStyle: 'danger'
                        }
                    }
                }
            })
        }
    }
}
</script>
