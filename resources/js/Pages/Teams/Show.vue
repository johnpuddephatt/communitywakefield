<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Organisation Settings
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <update-team-name-form :team="team" :permissions="permissions" />

                <subteam-manager class="mt-10 sm:mt-0"
                    :team="team"
                    :subteams="team.subteams"
                    :available-roles="availableRoles"
                    :user-permissions="permissions" />

                <team-request-manager v-if="teamRequests.length" class="mt-10 sm:mt-0"
                    :team="team"
                    :user-permissions="permissions"
                    :team-requests="teamRequests" />

                <team-member-manager class="mt-10 sm:mt-0"
                    :team="team"
                    :available-roles="availableRoles"
                    :user-permissions="permissions" />

                <template v-if="permissions.canDeleteTeam && ! team.personal_team">
                    <jet-section-border />

                    <delete-team-form class="mt-10 sm:mt-0" :team="team" />
                </template>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import TeamMemberManager from './TeamMemberManager'
    import SubteamManager from './SubteamManager'
    import TeamRequestManager from './TeamRequestManager'
    import AppLayout from '@/Layouts/AppLayout'
    import DeleteTeamForm from './DeleteTeamForm'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import UpdateTeamNameForm from './UpdateTeamNameForm'

    export default {
        props: [
            'team',
            'availableRoles',
            'permissions',
            'teamRequests'
        ],

        components: {
            AppLayout,
            DeleteTeamForm,
            JetSectionBorder,
            SubteamManager,
            TeamMemberManager,
            TeamRequestManager,
            UpdateTeamNameForm,
        },
    }
</script>
