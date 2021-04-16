<template>
<app-layout>
    <template #header>
        <h2 v-if="event" class="font-semibold text-xl text-gray-800 leading-tight">Edit event</h2>
        <h2 v-else class="font-semibold text-xl text-gray-800 leading-tight">Create event</h2>
    </template>

    <template #actions>
        <div v-if="isDirty" class="mx-4 text-sm font-semibold"><span class="text-red-700 mr-1 text-3xl leading-none align-bottom">•</span><span class="align-text-bottom">Unsaved changes</span></div>
        <div v-else-if="(event && event.status == 'Draft')" class="mx-4 text-sm font-semibold"><span class="text-gray-500 mr-1 text-3xl leading-none align-bottom">•</span><span class="align-text-bottom">Saved as draft</span></div>
        <div v-else-if="event" class="mx-4 text-sm font-semibold">Expires on {{ add_days(event.updated_at, 90) }}</div>
        <jet-secondary-button v-if="isDirty && (!event || event.status == 'Draft')" @click.native="saveEntry(false)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save draft</jet-secondary-button>
        <jet-secondary-button v-else-if="!isDirty && event && event.status == 'Published'" @click.native="saveEntry(false)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Change to draft</jet-secondary-button>

        <jet-button v-if="isDirty && !event || (event && event.status == 'Draft')" class="ml-2" @click.native="saveEntry(true)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Publish</jet-button>
        <jet-button v-else-if="isDirty" class="ml-2" @click.native="saveEntry(true)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Publish changes</jet-button>
        <jet-button v-else-if="event" class="ml-2" @click.native="saveEntry(true)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Renew</jet-button>

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
                        Provide the name of your event, choose a category and provide a description.
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-6">
                            <jet-label for="title" value="Title" />
                            <jet-input id="title" type="text" class="mt-1 block w-full text-2xl" v-model="form.title" />
                            <jet-input-error :message="form.errors.title" class="mt-2" />
                        </div>

                        <div v-if="subteams.length" class="col-span-6 sm:col-span-6">
                            <jet-label for="subteam" value="Department" />
                            <jet-multiselect label="name" identifier="id" :options="subteams" id="subteam" class="mt-1 block w-full text-2xl" v-model="form.subteam_id" />
                            <jet-input-error :message="form.errors.subteam_id" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-6">
                            <jet-label for="categories" value="Categories" />
                            <jet-multiselect label="title" :multiple="true" identifier="id" :options="categories" id="categories" class="mt-1 block w-full text-2xl" v-model="form.categories" />
                            <jet-input-error :message="form.errors.categories" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <jet-label for="content" value="Description" />
                            <jet-tip-tap id="content" v-model="form.content" />
                            <jet-input-error :message="form.errors.content" class="mt-2" />
                        </div>

                    </template>
                </jet-fieldset>

                <jet-fieldset>
                    <template #title>
                        Contact details
                    </template>

                    <template #description>
                        Provide contact details for your event. These are optional but will be shown publicly on the listing if provided.
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
                        Time &amp; cost
                    </template>

                    <template #description>
                        Let people know when your event takes place, as well as the cost if applicable.
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
                            <jet-label for="cost" value="Cost" />
                            <jet-input id="cost" type="text" class="mt-1 block w-full" v-model="form.cost" />
                            <jet-input-error :message="form.errors.cost" class="mt-2" />
                        </div>
                    </template>
                </jet-fieldset>

                <jet-fieldset>
                    <template #title>
                        Location
                    </template>

                    <template #description>
                        Provide the location of your event. Letting people know how to get there can be helpful.
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
                        Booking information
                    </template>

                    <template #description>
                        If applicable, let people know how they can book this event.
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="booking_link" value="Booking link" />
                            <jet-input id="booking_link" type="text" class="mt-1 block w-full" v-model="form.booking_link" />
                            <jet-input-error :message="form.errors.booking_link" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="booking_instructions" value="Booking instructions" />
                            <jet-textarea id="booking_instructions" class="mt-1 block w-full" v-model="form.booking_instructions" />
                            <jet-input-error :message="form.errors.booking_instructions" class="mt-2" />
                        </div>
                    </template>
                </jet-fieldset>

                <jet-fieldset>
                    <template #title>
                        Guidance
                    </template>

                    <template #description>
                        Provide details on who this event is suitable for and what to bring.
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-6">
                            <jet-label for="accessibility" value="Who is your event accessible to?" />
                            <jet-multiselect :multiple="true" :expand="true" label="title" identifier="id" :options="accessibilities" id="accessibility" class="mt-1 block w-full text-2xl" v-model="form.accessibilities" />
                            <jet-input-error :message="form.errors.accessibility" class="mt-2" />
                        </div>
                        <div class="col-span-2 sm:col-span-2">
                            <jet-label for="minimum_age" value="Minimum age" />
                            <jet-input id="minimum_age" type="number" class="mt-1 block w-full" v-model="form.minimum_age" />
                            <jet-input-error :message="form.errors.minimum_age" class="mt-2" />
                        </div>
                        <div class="col-span-2 sm:col-span-2">
                            <jet-label for="maximum_age" value="Maximum age" />
                            <jet-input id="maximum_age" type="number" class="mt-1 block w-full" v-model="form.maximum_age" />
                            <jet-input-error :message="form.errors.maximum_age" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="what_to_bring" value="What to bring" />
                            <jet-textarea id="what_to_bring" class="mt-1 block w-full" v-model="form.what_to_bring" />
                            <jet-input-error :message="form.errors.what_to_bring" class="mt-2" />
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

                <jet-button class="ml-2" @click.native="saveEvent" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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
        event: Object,
        categories: Array,
        accessibilities: Array,
        subteams: Array,
        team: Object,
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
                team_id: this.event?.team_id ?? this.$page.props.user.current_team_id,
                subteam_id: this.event?.subteam_id ?? null,

                categories: this.event?.categories ?? [],
                status: this.event?.status ?? 'Draft',
                title: this.event?.title ?? null,
                content: this.event?.content ?? null,
                phone: this.event ? this.event.phone : this.team.phone,
                email: this.event ? this.event.email : this.team.email,

                start_date: this.event?.start_date ?? null,
                end_date: this.event?.end_date ?? null,
                cost: this.event?.cost ?? null,

                address: this.event?.address ?? '',
                postcode: this.event?.postcode ?? '',
                latitude: this.event?.latitude ?? '',
                longitude: this.event?.longitude ?? '',
                from_home: this.event?.from_home ?? '',
                directions: this.event?.directions ?? '',

                booking_link: this.event?.booking_link ?? '',
                booking_instructions: this.event?.booking_instructions ?? '',

                minimum_age: this.event?.minimum_age ?? '',
                maximum_age: this.event?.maximum_age ?? '',
                what_to_bring: this.event?.what_to_bring ?? '',
                accessibilities: this.event?.accessibilities ?? []
            })
        }
    },
    watch: {
        form: {
         handler(val){
             console.log('so dirty');
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

            if(this.event) {
                this.form.put(route('event.update', this.event.id), {
                    preserveScroll: true,
                    resetOnSuccess: false,
                    bag: 'addEvent',

                    onFinish: () => console.log('onFinish'),
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
                this.form.post(route('event.store'), {
                    preserveScroll: true,
                    onFinish: () => console.log('onFinish'),
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
