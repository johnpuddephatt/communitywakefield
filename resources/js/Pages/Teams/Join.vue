<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Join or create a team
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <join-team-form :teams="teams" :requests="requests"/>
                    <jet-section-border />

                <team-requests-form v-if="requests.length" :requests="requests" class="mt-10 sm:mt-0" />
                <jet-section-border v-if="requests.length" />

                <create-team-form class="mt-10 sm:mt-0" />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import CreateTeamForm from './CreateTeamForm'
    import TeamRequestsForm from './TeamRequestsForm'
    import JoinTeamForm from './JoinTeamForm'
    import JetSectionBorder from '@/Jetstream/SectionBorder'

    export default {

        props: [
            'teams',
            'requests'
        ],

        components: {
            AppLayout,
            CreateTeamForm,
            JoinTeamForm,
            TeamRequestsForm,
            JetSectionBorder
        },
    }
</script>
