<template>
<app-layout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Activities
        </h2>
    </template>

    <template #actions>
        <jet-button :href="route('activity.create')">Create activity</jet-button>
    </template>

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200">
                    <table v-if="activities.length" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">
                                    <label class="form-checkbox">
                                        <input type="checkbox" v-model="selectAll" @click="select">
                                        <i class="form-icon"></i>
                                    </label>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Team
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>

                                <th scope="col" class="relative px-6 py-3 pr-6">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">

                            <tr v-for="activity in activities">
                                <td class="px-6 py-3 text-center">
                                    <label class="form-checkbox">
                                        <input type="checkbox" :value="activity.id" v-model="selected">
                                        <i class="form-icon"></i>
                                    </label>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ activity.title }}
                                    </div>
                                    <div class="text-sm text-ellipsis text-gray-500">
                                        {{ activity.times }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span v-if="activity.subteam">{{ activity.subteam.name }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <template v-if="activity.status == 'Published'">
                                        <span v-if="past_expiry(activity.updated_at)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Expired
                                        </span>
                                        <span v-else-if="near_expiry(activity.updated_at)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Review now
                                        </span>
                                        <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Published
                                        </span>
                                    </template>
                                    <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ activity.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a :href="route('activity.edit', activity.id)" class="text-indigo-600 hover:text-indigo-900 pr-6">Edit</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-else>
                        Nothing to see here.
                    </div>
                </div>

                <div class="mx-6 my-3">
                    <jet-danger-button v-if="selected.length" @click.native="confirmEntriesDeletion">
                        Delete entries
                    </jet-danger-button>
                </div>

                <!-- Delete Team Confirmation Modal -->
                <jet-confirmation-modal :show="confirmingEntriesDeletion" @close="confirmingEntriesDeletion = false">
                    <template #title>
                        Delete Entries
                    </template>

                    <template #content>
                        Are you sure you want to delete these entries?
                    </template>

                    <template #footer>
                        <jet-secondary-button @click.native="confirmingEntriesDeletion = false">
                            Nevermind
                        </jet-secondary-button>

                        <jet-danger-button class="ml-2" @click.native="deleteEntries" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Delete Entries
                        </jet-danger-button>
                    </template>
                </jet-confirmation-modal>
            </div>
        </div>
    </div>
</app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import JetButton from '@/Jetstream/Button'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
export default {

    props: {
        activities: Array,
    },
    components: {
        AppLayout,
        JetButton,
        JetDangerButton,
        JetConfirmationModal,
        JetSecondaryButton
    },

    data() {
        return {
    		selected: [],
    		selectAll: false,

            confirmingEntriesDeletion: false,
            deleting: false,

            form: this.$inertia.form({
                //
            }, {
                bag: 'deleteEntries'
            })
        }
	},
	methods: {
		select() {
            this.selected = this.selectAll ? [] : this.activities.map(o => o.id);
		},

        days_past(date) {
            let now = new Date();
            let dateTime = new Date(date);
            return (now.getTime() - dateTime.getTime()) / (1000 * 3600 * 24)
        },

        past_expiry(date) {
            return this.days_past(date) > 90 ? true : false;
        },

        near_expiry(date) {
            return this.days_past(date) > 60 ? true : false;
        },

        confirmEntriesDeletion() {
            this.confirmingEntriesDeletion = true
        },

        deleteEntries() {
            this.form.delete(route('activities.destroy', this.selected.join('-')), {
                preserveScroll: true,
                onSuccess: () => {
                    if (! this.form.hasErrors ) {
                        this.$page.props.jetstream.flash = {
                            banner: 'Entries deleted',
                            bannerStyle: 'success'
                        }
                        this.selected = [];
                        this.confirmingEntriesDeletion = false;
                    }
                    else {
                        this.$page.props.jetstream.flash = {
                            banner: 'Error deleting entries',
                            bannerStyle: 'danger'
                        }
                    }
                }
            });
        },
	}
}
</script>
