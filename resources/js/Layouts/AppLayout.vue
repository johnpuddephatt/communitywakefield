<template>
    <div>
        <jet-banner />
        <div class="flex h-screen">

            <sidebar />
            <div class="relative flex-grow h-screen bg-gradient-to-b from-indigo-50 to-white overflow-y-auto" :class="{'h-screen-with-banner': this.$page.props.jetstream.flash}">

                <!-- Page Heading -->
                <header class="bg-white shadow flex flex-row items-center sticky top-0 z-50">

                    <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="max-w-7xl mx-auto mr-auto py-6 px-4 sm:pl-6 lg:pl-8 md:ml-0">
                        <slot name="header"></slot>
                    </div>

                    <slot name="actions" class="mx-2"></slot>

                    <div class="ml-4 mr-8 relative">
                        <!-- Notifications Dropdown -->
                        <jet-dropdown align="right" width="60">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button title="Notifications" type="button" class="inline-flex items-center px-3 py-3 rounded-full border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                      </svg>
                                    </button>
                                </span>
                            </template>

                            <template class="px-0" #content>
                                <div v-for="notification in $page.props.notifications" class="border-b w-60 px-4 py-2 text-xs">
                                    <p>{{ notification.data.title }}</p>
                                    <inertia-link class="text-blue-800 text-right" v-if="notification.data.action" :href="notification.data.action.url">{{notification.data.action.text}}</inertia-link>
                                </div>
                                <div v-if="!$page.props.notifications.length" class="w-60 px-4 py-6 text-sm">
                                    No notifications to show you!
                                </div>
                            </template>
                        </jet-dropdown>
                    </div>

                </header>

                <!-- Page Content -->
                <main>
                    <slot></slot>
                </main>

                <!-- Modal Portal -->
                <portal-target name="modal" multiple>
                </portal-target>
            </div>
        </div>
    </div>
</template>

<script>
    import Sidebar from '@/Sidebar'
    import JetApplicationMark from '@/Jetstream/ApplicationMark'
    import JetBanner from '@/Jetstream/Banner'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'

    export default {
        components: {
            Sidebar,
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

    }
</script>
