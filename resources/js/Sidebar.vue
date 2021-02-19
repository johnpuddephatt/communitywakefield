<template>
    <aside class="w-72 flex-shrink-0 z-20 bg-gray-100 border-r dark:bg-gray-800 py-4 overflow-y-auto text-gray-800 dark:text-gray-400 flex flex-col">

        <a class="logo flex items-center justify-center leading-none my-3 mx-6 text-xl lowercase font-bold text-gray-700 dark:text-gray-200" href="#">
            Community
            <svg class="w-3 h-3 mx-1" xmlns="http://www.w3.org/2000/svg" width="701.507" height="867.222" viewBox="0 0 185.607 229.452">
              <path d="M22.5 206.952l140.607-92.226h0M22.5 22.5l140.607 92.226h0" fill="none" stroke="#8963f1" stroke-width="55" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Wakefield
        </a>

        <!-- User Dropdown -->
        <div class="mx-2 relative">
            <jet-dropdown align="left" width="64">
                <template #trigger>
                    <button class="focus:bg-gray-200 rounded hover:bg-gray-200 px-2 py-3 w-full mt-10 flex text-md border-2 border-transparent items-center focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                        <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                        <div class="text-left leading-tight mx-2 font-semibold overflow-hidden">
                            <span class="block overflow-ellipsis text-gray-600 overflow-hidden">{{ $page.props.user.name }}</span>
                            <span class="block text-xs text-gray-500 overflow-ellipsis overflow-hidden">{{ $page.props.user.email }}</span>
                        </div>
                        <svg class="ml-auto w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                        </svg>
                    </button>
                </template>

                <template #content>
                    <!-- Account Management -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Manage Account
                    </div>

                    <jet-dropdown-link :href="route('profile.show')">
                        Profile
                    </jet-dropdown-link>

                    <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                        API Tokens
                    </jet-dropdown-link>

                    <div class="border-t border-gray-100"></div>

                    <!-- Authentication -->
                    <form @submit.prevent="logout">
                        <jet-dropdown-link as="button">
                            Logout
                        </jet-dropdown-link>
                    </form>
                </template>
            </jet-dropdown>
        </div>

        <ul class="mt-2 mx-2">
            <li class="relative">
                <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="ml-4">Dashboard</span>
                </jet-nav-link>
            </li>

            <li class="relative">
                <jet-nav-link :href="route('activities.show')" :active="route().current('activities.show')">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span class="ml-4 font-semibold">Activities</span>
                </jet-nav-link>
            </li>

            <li class="relative">
                <jet-nav-link :href="route('policy.show')" :active="route().current('policy.show')">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span class="ml-4">Services</span>
                </jet-nav-link>
            </li>

            <li class="relative">
                <jet-nav-link :href="route('policy.show')" :active="route().current('policy.show')">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    <span class="ml-4">Volunteering</span>
                </jet-nav-link>
            </li>
        </ul>

        <div v-if="$page.props.jetstream.hasTeamFeatures" class="border-t border-gray-100 mt-auto mb-2">

            <!-- Team Switcher -->
            <div class="flex tracking-wider items-center font-semibold px-6 py-4 text-sm uppercase text-gray-500">
                Teams

                <inertia-link class="ml-auto tracking-normal font-sm normal-case text-xs font-normal" :href="route('teams.create')" v-if="$page.props.jetstream.canCreateTeams">
                    Create New Team
                </inertia-link>
            </div>

            <template v-for="team in $page.props.user.all_teams">
                <form @submit.prevent="switchToTeam(team)" :key="team.id">
                    <div class="flex items-center">
                        <jet-nav-link as="button" class="flex items-center">
                            <svg v-if="team.id == $page.props.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div class="font-semibold text-gray-600">{{ team.name }}</div>
                        </jet-nav-link>
                        <inertia-link class="ml-auto mr-6 text-gray-500 text-xs" :href="route('teams.show', team.id)">
                            Edit
                        </inertia-link>
                    </div>
                </form>
            </template>
        </div>
    </aside>
</template>

<script>
    import JetNavLink from '@/Jetstream/NavLink'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'

    export default {
        components: {
            JetNavLink,
            JetDropdown,
            JetDropdownLink
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    }
</script>

<style>
.logo {

}
</style>
