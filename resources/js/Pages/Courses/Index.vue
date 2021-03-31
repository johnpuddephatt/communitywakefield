<template>
<app-layout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Courses
        </h2>
    </template>

    <template #actions>
        <jet-button :href="route('course.create')">Create course</jet-button>
    </template>

    <div class="flex flex-col">
        <div v-if="courses.length" class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle min-w-full sm:px-6 lg:px-8">

                    <table class="shadow overflow-hidden border-b border-gray-200 min-w-full divide-y divide-gray-200">
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
                                    Status
                                </th>

                                <th scope="col" class="relative px-6 py-3 pr-6">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">

                            <tr v-for="course in courses">
                                <td class="px-6 py-3 text-center">
                                    <label class="form-checkbox">
                                        <input type="checkbox" :value="course.id" v-model="selected">
                                        <i class="form-icon"></i>
                                    </label>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ course.title }}
                                    </div>
                                    <div class="text-sm text-ellipsis text-gray-500">
                                        <span v-if="course.subteam">{{ course.subteam.name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <template v-if="course.status == 'Published'">
                                        <span v-if="past_expiry(course.updated_at)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Expired
                                        </span>
                                        <span v-else-if="near_expiry(course.updated_at)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Review now
                                        </span>
                                        <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Published
                                        </span>
                                    </template>
                                    <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ course.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a :href="route('course.edit', course.id)" class="text-indigo-600 hover:text-indigo-900 pr-6">Edit</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <div class="mx-8 my-2 px-6">
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

            <div v-if="!courses.length" class="my-24 flex-1 flex flex-col justify-center items-center">
                <svg class="absolute inset-0 top-24 w-full h-screen" xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0" y="0" viewBox="0 0 491.9 442.086" xml:space="preserve" width="491.9" height="442.086">
                  <path d="M451.67 91.36l-9.92-4 9.93-3.98c5.93-2.37 10.53-6.9 12.96-12.76 2.39-5.76 2.37-12.09-.07-17.81-4.99-11.71-18.77-17.35-30.72-12.56l-12.65 5.07 5.09-12.64c4.81-11.94-.8-25.73-12.5-30.75-5.72-2.45-12.05-2.49-17.82-.11-5.86 2.42-10.4 7.01-12.79 12.94l-4 9.92-3.98-9.93c-2.37-5.93-6.9-10.53-12.76-12.97-5.77-2.4-12.09-2.37-17.81.07-11.72 4.99-17.35 18.77-12.56 30.72l5.06 12.65-12.64-5.09c-11.94-4.82-25.73.79-30.75 12.5-2.45 5.72-2.49 12.04-.1 17.81 2.42 5.86 7.02 10.4 12.94 12.79l9.92 4-9.93 3.98c-5.93 2.37-10.53 6.91-12.97 12.76-2.39 5.76-2.37 12.09.07 17.81 4.99 11.71 18.78 17.35 30.72 12.56l12.65-5.07-5.09 12.64c-4.81 11.94.8 25.73 12.5 30.75 5.72 2.45 12.04 2.49 17.82.1 5.86-2.42 10.4-7.02 12.79-12.94l4-9.92 3.98 9.93c2.37 5.93 6.91 10.54 12.76 12.97 2.86 1.18 5.85 1.78 8.83 1.78 3.05 0 6.09-.62 8.98-1.85 11.71-4.99 17.35-18.77 12.56-30.72l-5.06-12.65 12.64 5.09c11.93 4.81 25.73-.8 30.74-12.5 2.45-5.72 2.49-12.05.11-17.82-2.41-5.85-7.01-10.39-12.93-12.77z" id="path1696" opacity=".1" fill="#ff03e1"></path>
                  <path d="M132.42 201.66l2.73-2.27c13.06-10.9 32.97-5.56 38.84 10.41l1.22 3.33c2.13 5.81 8.12 9.27 14.22 8.21l3.5-.61c16.76-2.9 31.34 11.67 28.43 28.43l-.61 3.5c-1.06 6.1 2.4 12.09 8.21 14.22l3.33 1.22c15.97 5.86 21.3 25.78 10.41 38.84l-2.27 2.73a12.808 12.808 0 000 16.42l2.27 2.73c10.9 13.06 5.56 32.98-10.41 38.84l-3.33 1.22a12.803 12.803 0 00-8.21 14.22l.61 3.5c2.91 16.76-11.67 31.34-28.43 28.43l-3.5-.61c-6.1-1.06-12.09 2.4-14.22 8.21l-1.22 3.33c-5.86 15.97-25.78 21.3-38.84 10.41l-2.73-2.27a12.808 12.808 0 00-16.42 0l-2.73 2.27c-13.06 10.89-32.98 5.56-38.84-10.41l-1.22-3.33a12.814 12.814 0 00-14.22-8.21l-3.5.61c-16.76 2.91-31.34-11.67-28.43-28.43l.61-3.5c1.06-6.1-2.4-12.09-8.21-14.22l-3.33-1.22C.16 361.8-5.17 341.88 5.72 328.82l2.27-2.73a12.808 12.808 0 000-16.42l-2.27-2.73c-10.9-13.06-5.56-32.98 10.41-38.84l3.33-1.22c5.82-2.13 9.27-8.12 8.21-14.22l-.61-3.5c-2.91-16.76 11.67-31.34 28.43-28.43l3.5.61c6.1 1.06 12.09-2.4 14.22-8.21l1.22-3.33c5.86-15.97 25.78-21.31 38.84-10.41l2.73 2.27c4.75 3.96 11.66 3.96 16.42 0" id="path1701" opacity=".1" fill="#60e8aa"></path>
                </svg>
                <p class="relative text-gray-400 mt-24">No courses have been added to this team yet. <a class="text-navy" :href="route('course.create')">Create an course</a></p>
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
        courses: Array,
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
            this.selected = this.selectAll ? [] : this.courses.map(o => o.id);
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
            this.form.delete(route('courses.destroy', this.selected.join('-')), {
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
