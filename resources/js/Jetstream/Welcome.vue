<template>
    <div>
        <div class="p-6 py-12 sm:px-20 bg-white border-b border-gray-200">
            <Jet-Application-Logo size="large" class="text-blue-700 text-3xl"/>

            <div class="mt-1 text-2xl">
                Welcome to your dashboard!
            </div>

            <div class="mt-6 text-gray-500">
                From this dashboard you can manage all your organisation’s services, activities, opportunities and events. You can create and manage multiple organisations, invite other team members to manage listings with you, and create departments within your organisation.
            </div>
        </div>

        <div v-if="!Object.keys($page.props.user.all_teams).length" class="p-6 sm:px-20 bg-fuschia">
            <h2 class="font-semibold text-lg mb-1">Getting started</h2>
            <p class="text-sm">Before adding your listings, you’ll need to create or join an organisation</p>
            <a :href="route('teams.join')" class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                <div>Create or join an organisation</div>

                <div class="ml-1 text-indigo-500">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </div>
            </a>
        </div>

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
            <div class="p-6">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-brand-green-bright"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="/docs">Documentation</a></div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-sm text-gray-500">
                        We’ve put together information to help you and your organisations get the most out of Community Wakefield. Our documentation is designed to help you if you run into problems, as well as to be a useful training resource for members of your team.
                    </div>

                    <a href="/docs">
                        <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                <div>Explore the documentation</div>

                                <div class="ml-1 text-indigo-500">
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-brand-green-bright"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">Be reminded to update your listings</div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-sm text-gray-500">
                        We know members of the public find it frustrating when information they find online is innaccurate or out of date. Community Wakefield helps you keep your listings current by reminding you when it’s time to review them.
                    </div>

                    <a href="https://laracasts.com">
                        <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                <div>Manage your notification settings</div>

                                <div class="ml-1 text-indigo-500">
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-brand-green-bright"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">Manage everything in one place</div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-sm text-gray-500">
                        Community Wakefield makes it easy for multiple members of your organisation to manage listings, and allows you to manage listings for multiple organisations from one account. Create departments within your organisations to manage listings belonging to different teams in your organisation.
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 md:border-l">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-brand-green-bright"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">Display your listings on your own website</div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-sm text-gray-500">
                        Later this year we’re planning to roll out functionality that allows you to list information from Community Wakefield on your own website. That means you can add details of what you offer in once place and know it’s kept up to date everywhere.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo'

    export default {
        components: {
            JetApplicationLogo,
        },
    }
</script>
