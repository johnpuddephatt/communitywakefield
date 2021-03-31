<template>
<app-layout>
    <template #header>
        <h2 v-if="volunteering" class="font-semibold text-xl text-gray-800 leading-tight">Edit volunteering opportunity</h2>
        <h2 v-else class="font-semibold text-xl text-gray-800 leading-tight">Create volunteering opportunity</h2>
    </template>

    <template #actions>
        <div v-if="isDirty" class="mx-4 text-sm font-semibold"><span class="text-red-700 mr-1 text-3xl leading-none align-bottom">•</span><span class="align-text-bottom">Unsaved changes</span></div>
        <div v-else-if="(volunteering && volunteering.status == 'Draft')" class="mx-4 text-sm font-semibold"><span class="text-gray-500 mr-1 text-3xl leading-none align-bottom">•</span><span class="align-text-bottom">Saved as draft</span></div>
        <div v-else-if="volunteering" class="mx-4 text-sm font-semibold">Expires on {{ add_days(volunteering.updated_at, 90) }}</div>
        <jet-secondary-button v-if="isDirty && (!volunteering || volunteering.status == 'Draft')" @click.native="saveEntry(false)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save draft</jet-secondary-button>
        <jet-secondary-button v-else-if="!isDirty && volunteering && volunteering.status == 'Published'" @click.native="saveEntry(false)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Change to draft</jet-secondary-button>

        <jet-button v-if="isDirty && !volunteering || (volunteering && volunteering.status == 'Draft')" class="ml-2" @click.native="saveEntry(true)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Publish</jet-button>
        <jet-button v-else-if="isDirty" class="ml-2" @click.native="saveEntry(true)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Publish changes</jet-button>
        <jet-button v-else-if="volunteering" class="ml-2" @click.native="saveEntry(true)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Renew</jet-button>

        <jet-button v-if="1 == 2" class="ml-2" @click.native="confirmingRenewal = true" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Renew for 90 days</jet-button>
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
                            <jet-label for="categories" value="Categories" />
                            <jet-multiselect label="title" :multiple="true" identifier="id" :options="categories" id="categories" class="mt-1 block w-full text-2xl" v-model="form.categories" />
                            <jet-input-error :message="form.errors.categories" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <jet-label for="title" value="Title" />
                            <jet-input id="title" type="text" class="mt-1 block w-full text-2xl" v-model="form.title" />
                            <jet-input-error :message="form.errors.title" class="mt-2" />
                        </div>
                        <div v-if="subteams.length" class="col-span-6 sm:col-span-6">
                            <jet-label for="subteam" value="Subteam" />
                            <jet-multiselect label="name" identifier="id" :options="subteams" id="subteam" class="mt-1 block w-full text-2xl" v-model="form.subteam_id" />
                            <jet-input-error :message="form.errors.subteam_id" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <jet-label for="content" value="Description" />
                            <jet-tip-tap id="content" v-model="form.content" />
                            <jet-input-error :message="form.errors.content" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <jet-label for="suitabilities" value="Who is your volunteering opportunity suitable for?" />
                            <jet-multiselect :multiple="true" :expand="true" label="title" identifier="id" :options="suitabilities" id="suitabilities" class="mt-1 block w-full text-2xl" v-model="form.suitabilities" />
                            <jet-input-error :message="form.errors.suitabilities" class="mt-2" />
                        </div>
                    </template>
                </jet-fieldset>

                <jet-fieldset>
                    <template #title>
                        Contact details
                    </template>

                    <template #description>
                        Description
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="phone" value="Phone" />
                            <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" />
                            <jet-input-error :message="form.errors.phone" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="email" value="Email" />
                            <jet-input id="email" type="text" class="mt-1 block w-full" v-model="form.email" />
                            <jet-input-error :message="form.errors.email" class="mt-2" />
                        </div>
                    </template>
                </jet-fieldset>

                <jet-fieldset>
                    <template #title>
                        Times
                    </template>

                    <template #description>
                        Description
                    </template>

                    <template #form>

                        <div class="col-span-3 sm:col-span-2">
                            <jet-label for="start_date" value="Start date" />
                            <jet-input id="start_date" type="date" class="mt-1 block w-full" v-model="form.start_date" />
                            <jet-input-error :message="form.errors.start_date" class="mt-2" />
                        </div>
                        <div class="col-span-3 sm:col-span-2">
                            <jet-label for="end_date" value="End date" />
                            <jet-input id="end_date" type="date" class="mt-1 block w-full" v-model="form.end_date" />
                            <jet-input-error :message="form.errors.end_date" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="hours" value="Hours" />
                            <jet-input id="hours" type="text" class="mt-1 block w-full" v-model="form.hours" />
                            <jet-input-error :message="form.errors.hours" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="frequency" value="Frequency" />
                            <jet-select id="frequency" type="text" class="mt-1 block w-full" v-model="form.frequency" :options="[null, 'One-off','Fixed period','Ongoing']"/>
                            <jet-input-error :message="form.errors.frequency" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="deadline" value="Deadline" />
                            <jet-input id="deadline" type="date" class="mt-1 block w-full" v-model="form.deadline" />
                            <jet-input-error :message="form.errors.deadline" class="mt-2" />
                        </div>
                    </template>
                </jet-fieldset>

                <jet-fieldset>
                    <template #title>
                        Location
                    </template>

                    <template #description>
                        Description
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="address" value="Address" />
                            <vue-google-autocomplete
                                id="address"
                                :value="form.address"
                                @placechanged="getAddressData"
                                country="uk"
                                :boundaries="{lat: 53.6757588,lng:-1.58027,radius:16000 }"
                            >
                            </vue-google-autocomplete>
                            <jet-input-error :message="form.errors.address" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <div class="flex items-center">
                                <jet-checkbox id="from_home" :value="true" v-model="form.from_home"/>
                                <jet-label class="ml-2" for="from_home" value="From home?" />
                            </div>
                            <jet-input-error :message="form.errors.from_home" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="directions" value="Directions" />
                            <jet-textarea id="directions" class="mt-1 block w-full" v-model="form.directions" />
                            <jet-input-error :message="form.errors.directions" class="mt-2" />
                        </div>
                    </template>
                </jet-fieldset>

                <jet-fieldset>
                    <template #title>
                        Guidance
                    </template>

                    <template #description>
                        Description
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="places" value="Places available" />
                            <jet-input id="places" type="number" class="mt-1 block w-full" v-model="form.places" />
                            <jet-input-error :message="form.errors.places" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <jet-label for="accessibility" value="Who is your volunteering opportunity accessible to?" />
                            <jet-multiselect :multiple="true" :expand="true" label="title" identifier="id" :options="accessibilities" id="accessibility" class="mt-1 block w-full text-2xl" v-model="form.accessibilities" />
                            <jet-input-error :message="form.errors.accessibility" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <jet-label for="requirements" value="Requirements" />
                            <jet-multiselect :multiple="true" :expand="true" :options="requirements" id="requirements" class="mt-1 block w-full text-2xl" v-model="form.requirements" />
                            <jet-input-error :message="form.errors.requirements" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <jet-label for="skills_needed" value="Skills needed" />
                            <jet-multiselect :multiple="true" :expand="true" :options="skills" id="skills_needed" class="mt-1 block w-full text-2xl" v-model="form.skills_needed" />
                            <jet-input-error :message="form.errors.skills_needed" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <jet-label for="skills_gained" value="Skills gained" />
                            <jet-multiselect :multiple="true" :expand="true" :options="skills" id="skills_gained" class="mt-1 block w-full text-2xl" v-model="form.skills_gained" />
                            <jet-input-error :message="form.errors.skills_gained" class="mt-2" />
                        </div>
                        <div class="col-span-3 sm:col-span-2">
                            <jet-label for="minimum_age" value="Minimum age" />
                            <jet-input id="minimum_age" type="number" class="mt-1 block w-full" v-model="form.minimum_age" />
                            <jet-input-error :message="form.errors.minimum_age" class="mt-2" />
                        </div>
                        <div class="col-span-3 sm:col-span-2">
                            <jet-label for="maximum_age" value="Maximum age" />
                            <jet-input id="maximum_age" type="number" class="mt-1 block w-full" v-model="form.maximum_age" />
                            <jet-input-error :message="form.errors.maximum_age" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="what_to_bring" value="What to bring" />
                            <jet-textarea id="what_to_bring" class="mt-1 block w-full" v-model="form.what_to_bring" />
                            <jet-input-error :message="form.errors.what_to_bring" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="expenses" value="Expenses policy" />
                            <jet-textarea id="expenses" class="mt-1 block w-full" v-model="form.expenses" />
                            <jet-input-error :message="form.errors.expenses" class="mt-2" />
                        </div>
                    </template>

                </jet-fieldset>

            </form>

        </div>
        <jet-confirmation-modal :show="confirmingRenewal" @close="confirmingRenewal = false">
            <template #title>
                Confirm renewal
            </template>

            <template #content>
                Have you checked this entry is accurate and up-to-date?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="confirmingRenewal = false">
                    Go back
                </jet-secondary-button>

                <jet-button class="ml-2" @click.native="saveVolunteering" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Confirm renewal
                </jet-button>
            </template>
        </jet-confirmation-modal>
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
        volunteering: Object,
        categories: Array,
        accessibilities: Array,
        suitabilities: Array,
        requirements: Array,
        subteams: Array,
        team: Object,
        skills: Array
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
            isDirty: false,
            confirmingRenewal: false,
            form: this.$inertia.form({
                team_id: this.volunteering?.team_id ?? this.$page.props.user.current_team_id,
                subteam_id: this.volunteering?.subteam_id ?? null,
                status: this.volunteering?.status ?? 'Draft',

                categories: this.volunteering?.categories ?? [],
                title: this.volunteering?.title ?? null,
                content: this.volunteering?.content ?? null,
                suitabilities: this.volunteering?.suitabilities ?? [],

                phone: this.volunteering ? this.volunteering.phone : this.team.phone,
                email: this.volunteering ? this.volunteering.email : this.team.email,
                cost: this.volunteering?.cost ?? null,

                start_date: this.volunteering?.start_date ?? null,
                end_date: this.volunteering?.end_date ?? null,
                frequency: this.volunteering?.frequency ?? null,
                hours: this.volunteering?.hours ?? null,
                deadline: this.volunteering?.deadline ?? null,

                address: this.volunteering?.address ?? '',
                postcode: this.volunteering?.postcode ?? '',
                latitude: this.volunteering?.latitude ?? '',
                longitude: this.volunteering?.longitude ?? '',
                from_home: this.volunteering?.from_home ?? '',
                directions: this.volunteering?.directions ?? '',

                places: this.volunteering?.places ?? '',
                minimum_age: this.volunteering?.minimum_age ?? '',
                maximum_age: this.volunteering?.maximum_age ?? '',
                what_to_bring: this.volunteering?.what_to_bring ?? '',
                expenses: this.volunteering?.expenses ?? '',
                requirements: this.volunteering?.requirements ?? [],
                skills_needed: this.volunteering?.skills_needed ?? [],
                skills_gained: this.volunteering?.skills_gained ?? [],
                accessibilities: this.volunteering?.accessibilities ?? []
            })
        }
    },
    watch: {
        form: {
         handler(val){
            if(!this.isDirty)
                this.isDirty = true;
         },
         deep: true
      }
    },
    methods: {
        add_days(date, number) {
            let dateTime = new Date(date);
            let futureDate = new Date(dateTime.setDate(dateTime.getDate() + number));
            return futureDate.toLocaleDateString('en-UK', { year: 'numeric', month: 'long', day: 'numeric' });
        },
        getAddressData(addressData, placeResultData, id) {
            this.form.address = placeResultData.formatted_address;
            this.form.postcode = addressData.postal_code;
            this.form.latitude = addressData.latitude;
            this.form.longitude = addressData.longitude;
        },
        saveEntry(publish) {
            this.form.status = (publish == true) ? 'Published' : 'Draft';

            if(this.volunteering) {
                this.form.put(route('volunteering.update', this.volunteering.id), {
                    preserveScroll: true,
                    resetOnSuccess: false,
                    bag: 'addVolunteering',

                    onError: () => {
                        this.$page.props.jetstream.flash = {
                            banner: this.form.hasErrors ? 'Entry could not be updated. See below for errors.' : 'Entry could not be updated',
                            bannerStyle: 'danger'
                        }
                    },

                    onSuccess: () => {
                        this.$page.props.jetstream.flash = {
                            banner: 'Entry updated!',
                            bannerStyle: 'success'
                        }
                        this.isDirty = false;
                    }
                })
            }
            else {
                this.form.post(route('volunteering.store'), {
                    preserveScroll: true,

                    onError: () => {
                        this.$page.props.jetstream.flash = {
                            banner: this.form.hasErrors ? 'Entry could not be created. See below for errors.' : 'Entry could not be updated',
                            bannerStyle: 'danger'
                        }
                    },

                    onSuccess: () => {
                        this.$page.props.jetstream.flash = {
                            banner: 'Entry created!',
                            bannerStyle: 'success'
                        }
                        this.isDirty = false;
                    }
                });
            }
        }
    }
}
</script>
