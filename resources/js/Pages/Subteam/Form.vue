<template>
<app-layout>
    <template #header>
        <h2 v-if="subteam" class="font-semibold text-xl text-gray-800 leading-tight">Edit subteam</h2>
        <h2 v-else class="font-semibold text-xl text-gray-800 leading-tight">Create subteam</h2>
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
                        Description
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-6">
                            <jet-label for="name" value="Name" />
                            <jet-input id="name" type="text" class="mt-1 block w-full text-2xl" v-model="form.name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
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
                name: this.subteam?.name ?? null,
            })
        }
    },
    watch: {
    },
    methods: {
        saveEntry() {
            if(this.activity) {
                this.form.put(route('subteam.update', this.activity.id), {
                    preserveScroll: true,
                    resetOnSuccess: false,
                    bag: 'updateSubteam',

                    onSuccess: () => {
                        if (! this.form.hasErrors ) {
                            this.$page.props.jetstream.flash = {
                                banner: 'Entry updated!',
                                bannerStyle: 'success'
                            }
                            this.form.isDirty = false;
                        }
                        else {
                            this.$page.props.jetstream.flash = {
                                banner: 'Error updating entry',
                                bannerStyle: 'danger'
                            }
                        }
                    }
                })
            }
            else {
                this.form.post(route('subteam.store', this.team.id), {
                    preserveScroll: true,
                    bag: 'storeSubteam',
                    onSuccess: () => {
                        if (! this.form.hasErrors ) {
                            this.$page.props.jetstream.flash = {
                                banner: 'Entry created',
                                bannerStyle: 'success'
                            }
                            this.form.isDirty = false;
                        }
                        else {
                            this.$page.props.jetstream.flash = {
                                banner: 'Error creating entry',
                                bannerStyle: 'danger'
                            }
                        }
                    }
                });
            }
        }
    }
}
</script>
