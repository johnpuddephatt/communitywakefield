<template>
  <app-layout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Volunteering opportunities
      </h2>
    </template>

    <template #actions>
      <!-- <jet-button :href="route('volunteering.create')">Create volunteering opportunity</jet-button> -->
    </template>

    <div class="flex flex-col">
      <!-- <div v-if="volunteerings.length" class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="min-w-full py-2 align-middle sm:px-6 lg:px-8">

                    <table class="min-w-full overflow-hidden border-b border-gray-200 divide-y divide-gray-200 shadow">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">
                                    <label class="form-checkbox">
                                        <input type="checkbox" v-model="selectAll" @click="select">
                                        <i class="form-icon"></i>
                                    </label>
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Name
                                </th>

                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Status
                                </th>

                                <th scope="col" class="relative px-6 py-3 pr-6">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">

                            <tr v-for="volunteering in volunteerings">
                                <td class="px-6 py-3 text-center">
                                    <label class="form-checkbox">
<input
                      :disabled="!canDelete(volunteering)"
                      type="checkbox"
                      :value="volunteering.id"
                      v-model="selected"
                      :class="{ 'opacity-20 cursor-not-allowed': !canDelete(volunteering) }"
                      :title="
                        !canDelete(volunteering)
                          ? 'You don’t have permission to delete this entry'
                          : ''
                      "
                    />                                        <i class="form-icon"></i>
                                    </label>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ volunteering.title }}
                                    </div>
                                    <div class="text-sm text-gray-500 text-ellipsis">
                                        <span v-if="volunteering.subteam">{{ volunteering.subteam.name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <template v-if="volunteering.status == 'Published'">
                                        <span v-if="past_expiry(volunteering.updated_at)" class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                            Expired
                                        </span>
                                        <span v-else-if="near_expiry(volunteering.updated_at)" class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full">
                                            Review now
                                        </span>
                                        <span v-else class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                            Published
                                        </span>
                                    </template>
                                    <span v-else class="inline-flex px-2 text-xs font-semibold leading-5 text-gray-800 bg-gray-100 rounded-full">
                                        {{ volunteering.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <inertia-link
                                      class="pr-3 text-indigo-600 hover:text-indigo-900"
                                      :href="route('volunteering.clone', { volunteering: volunteering.id })"
                                      >Clone</inertia-link
                                    >
                                    <a :href="route('volunteering.edit', volunteering.id)" class="pr-6 text-indigo-600 hover:text-indigo-900">Edit</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <div class="px-6 mx-8 my-2">
                    <jet-danger-button v-if="selected.length" @click.native="confirmEntriesDeletion">
                        Delete entries
                    </jet-danger-button>
                </div>

                
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

            <div v-if="!volunteerings.length" class="flex flex-col items-center justify-center flex-1 my-24">
                <svg class="absolute inset-0 w-full h-screen top-24" xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0" y="0" viewBox="0 0 491.9 442.086" xml:space="preserve" width="491.9" height="442.086">
                  <path d="M451.67 91.36l-9.92-4 9.93-3.98c5.93-2.37 10.53-6.9 12.96-12.76 2.39-5.76 2.37-12.09-.07-17.81-4.99-11.71-18.77-17.35-30.72-12.56l-12.65 5.07 5.09-12.64c4.81-11.94-.8-25.73-12.5-30.75-5.72-2.45-12.05-2.49-17.82-.11-5.86 2.42-10.4 7.01-12.79 12.94l-4 9.92-3.98-9.93c-2.37-5.93-6.9-10.53-12.76-12.97-5.77-2.4-12.09-2.37-17.81.07-11.72 4.99-17.35 18.77-12.56 30.72l5.06 12.65-12.64-5.09c-11.94-4.82-25.73.79-30.75 12.5-2.45 5.72-2.49 12.04-.1 17.81 2.42 5.86 7.02 10.4 12.94 12.79l9.92 4-9.93 3.98c-5.93 2.37-10.53 6.91-12.97 12.76-2.39 5.76-2.37 12.09.07 17.81 4.99 11.71 18.78 17.35 30.72 12.56l12.65-5.07-5.09 12.64c-4.81 11.94.8 25.73 12.5 30.75 5.72 2.45 12.04 2.49 17.82.1 5.86-2.42 10.4-7.02 12.79-12.94l4-9.92 3.98 9.93c2.37 5.93 6.91 10.54 12.76 12.97 2.86 1.18 5.85 1.78 8.83 1.78 3.05 0 6.09-.62 8.98-1.85 11.71-4.99 17.35-18.77 12.56-30.72l-5.06-12.65 12.64 5.09c11.93 4.81 25.73-.8 30.74-12.5 2.45-5.72 2.49-12.05.11-17.82-2.41-5.85-7.01-10.39-12.93-12.77z" id="path1696" opacity=".1" fill="#ff03e1"></path>
                  <path d="M132.42 201.66l2.73-2.27c13.06-10.9 32.97-5.56 38.84 10.41l1.22 3.33c2.13 5.81 8.12 9.27 14.22 8.21l3.5-.61c16.76-2.9 31.34 11.67 28.43 28.43l-.61 3.5c-1.06 6.1 2.4 12.09 8.21 14.22l3.33 1.22c15.97 5.86 21.3 25.78 10.41 38.84l-2.27 2.73a12.808 12.808 0 000 16.42l2.27 2.73c10.9 13.06 5.56 32.98-10.41 38.84l-3.33 1.22a12.803 12.803 0 00-8.21 14.22l.61 3.5c2.91 16.76-11.67 31.34-28.43 28.43l-3.5-.61c-6.1-1.06-12.09 2.4-14.22 8.21l-1.22 3.33c-5.86 15.97-25.78 21.3-38.84 10.41l-2.73-2.27a12.808 12.808 0 00-16.42 0l-2.73 2.27c-13.06 10.89-32.98 5.56-38.84-10.41l-1.22-3.33a12.814 12.814 0 00-14.22-8.21l-3.5.61c-16.76 2.91-31.34-11.67-28.43-28.43l.61-3.5c1.06-6.1-2.4-12.09-8.21-14.22l-3.33-1.22C.16 361.8-5.17 341.88 5.72 328.82l2.27-2.73a12.808 12.808 0 000-16.42l-2.27-2.73c-10.9-13.06-5.56-32.98 10.41-38.84l3.33-1.22c5.82-2.13 9.27-8.12 8.21-14.22l-.61-3.5c-2.91-16.76 11.67-31.34 28.43-28.43l3.5.61c6.1 1.06 12.09-2.4 14.22-8.21l1.22-3.33c5.86-15.97 25.78-21.31 38.84-10.41l2.73 2.27c4.75 3.96 11.66 3.96 16.42 0" id="path1701" opacity=".1" fill="#60e8aa"></path>
                </svg>
                <p class="relative mt-24 text-gray-400">No volunteering opportunities have been added to this team yet. <a class="text-navy" :href="route('volunteering.create')">Create a volunteering opportunity</a></p>
            </div>-->

      <div class="flex flex-col items-center justify-center flex-1 my-24">
        <!-- <svg class="absolute inset-0 w-full h-screen top-24" xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0" y="0" viewBox="0 0 491.9 442.086" xml:space="preserve" width="491.9" height="442.086">
                  <path d="M451.67 91.36l-9.92-4 9.93-3.98c5.93-2.37 10.53-6.9 12.96-12.76 2.39-5.76 2.37-12.09-.07-17.81-4.99-11.71-18.77-17.35-30.72-12.56l-12.65 5.07 5.09-12.64c4.81-11.94-.8-25.73-12.5-30.75-5.72-2.45-12.05-2.49-17.82-.11-5.86 2.42-10.4 7.01-12.79 12.94l-4 9.92-3.98-9.93c-2.37-5.93-6.9-10.53-12.76-12.97-5.77-2.4-12.09-2.37-17.81.07-11.72 4.99-17.35 18.77-12.56 30.72l5.06 12.65-12.64-5.09c-11.94-4.82-25.73.79-30.75 12.5-2.45 5.72-2.49 12.04-.1 17.81 2.42 5.86 7.02 10.4 12.94 12.79l9.92 4-9.93 3.98c-5.93 2.37-10.53 6.91-12.97 12.76-2.39 5.76-2.37 12.09.07 17.81 4.99 11.71 18.78 17.35 30.72 12.56l12.65-5.07-5.09 12.64c-4.81 11.94.8 25.73 12.5 30.75 5.72 2.45 12.04 2.49 17.82.1 5.86-2.42 10.4-7.02 12.79-12.94l4-9.92 3.98 9.93c2.37 5.93 6.91 10.54 12.76 12.97 2.86 1.18 5.85 1.78 8.83 1.78 3.05 0 6.09-.62 8.98-1.85 11.71-4.99 17.35-18.77 12.56-30.72l-5.06-12.65 12.64 5.09c11.93 4.81 25.73-.8 30.74-12.5 2.45-5.72 2.49-12.05.11-17.82-2.41-5.85-7.01-10.39-12.93-12.77z" id="path1696" opacity=".1" fill="#ff03e1"></path>
                  <path d="M132.42 201.66l2.73-2.27c13.06-10.9 32.97-5.56 38.84 10.41l1.22 3.33c2.13 5.81 8.12 9.27 14.22 8.21l3.5-.61c16.76-2.9 31.34 11.67 28.43 28.43l-.61 3.5c-1.06 6.1 2.4 12.09 8.21 14.22l3.33 1.22c15.97 5.86 21.3 25.78 10.41 38.84l-2.27 2.73a12.808 12.808 0 000 16.42l2.27 2.73c10.9 13.06 5.56 32.98-10.41 38.84l-3.33 1.22a12.803 12.803 0 00-8.21 14.22l.61 3.5c2.91 16.76-11.67 31.34-28.43 28.43l-3.5-.61c-6.1-1.06-12.09 2.4-14.22 8.21l-1.22 3.33c-5.86 15.97-25.78 21.3-38.84 10.41l-2.73-2.27a12.808 12.808 0 00-16.42 0l-2.73 2.27c-13.06 10.89-32.98 5.56-38.84-10.41l-1.22-3.33a12.814 12.814 0 00-14.22-8.21l-3.5.61c-16.76 2.91-31.34-11.67-28.43-28.43l.61-3.5c1.06-6.1-2.4-12.09-8.21-14.22l-3.33-1.22C.16 361.8-5.17 341.88 5.72 328.82l2.27-2.73a12.808 12.808 0 000-16.42l-2.27-2.73c-10.9-13.06-5.56-32.98 10.41-38.84l3.33-1.22c5.82-2.13 9.27-8.12 8.21-14.22l-.61-3.5c-2.91-16.76 11.67-31.34 28.43-28.43l3.5.61c6.1 1.06 12.09-2.4 14.22-8.21l1.22-3.33c5.86-15.97 25.78-21.31 38.84-10.41l2.73 2.27c4.75 3.96 11.66 3.96 16.42 0" id="path1701" opacity=".1" fill="#60e8aa"></path>
                </svg> -->
        <p class="relative max-w-2xl mt-24 mb-3 text-gray-700">
          It will soon be possible for you to manage your
          <a
            class="underline text-navy"
            target="_blank"
            href="https://volunteerwakefield.org/"
            >Volunteer Wakefield</a
          >
          opportunities directly from the Community Wakefield dashboard, meaning you’ll be
          able to do everything in one place.
        </p>
        <p class="relative max-w-2xl mb-3 text-gray-700">
          From the public’s point of view nothing will change; they’ll still be able to
          find opportunities through Volunteer Wakefield as normal, but the change should
          simplify things for organisations.
        </p>
        <p class="relative max-w-2xl text-gray-700">
          We’ll be in touch with all active users of Volunteer Wakefield to explain these
          changes in detail. For now, please continue to add your volunteering
          opportunities over on
          <a
            class="underline text-navy"
            target="_blank"
            href="https://volunteerwakefield.org/"
            >Volunteer Wakefield</a
          >
          as normal.
        </p>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal";
import JetDangerButton from "@/Jetstream/DangerButton";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
export default {
  props: {
    volunteerings: Array,
    permissions: Object,
  },
  components: {
    AppLayout,
    JetButton,
    JetDangerButton,
    JetConfirmationModal,
    JetSecondaryButton,
  },

  data() {
    return {
      selected: [],
      selectAll: false,

      confirmingEntriesDeletion: false,
      deleting: false,

      form: this.$inertia.form(
        {
          //
        },
        {
          bag: "deleteEntries",
        }
      ),
    };
  },
  methods: {
    select() {
      if (this.selectAll) {
        this.selected = [];
      } else {
        this.selected = this.volunteerings
          .filter((volunteering) => this.canDelete(volunteering))
          .map((volunteering) => volunteering.id);
      }
    },

    canDelete(volunteering) {
      return (
        volunteering.created_by == this.$page.props.user.id ||
        this.permissions.canDeleteTeamEntries
      );
    },

    days_past(date) {
      let now = new Date();
      let dateTime = new Date(date);
      return (now.getTime() - dateTime.getTime()) / (1000 * 3600 * 24);
    },

    past_expiry(date) {
      return this.days_past(date) > 90 ? true : false;
    },

    near_expiry(date) {
      return this.days_past(date) > 60 ? true : false;
    },

    confirmEntriesDeletion() {
      this.confirmingEntriesDeletion = true;
    },

    deleteEntries() {
      this.form.delete(route("volunteerings.destroy", this.selected.join("-")), {
        preserveScroll: true,
        onSuccess: () => {
          if (!this.form.hasErrors) {
            this.$page.props.jetstream.flash = {
              banner: "Entries deleted",
              bannerStyle: "success",
            };
            this.selected = [];
            this.confirmingEntriesDeletion = false;
          } else {
            this.$page.props.jetstream.flash = {
              banner: "Error deleting entries",
              bannerStyle: "danger",
            };
          }
        },
      });
    },
  },
};
</script>
