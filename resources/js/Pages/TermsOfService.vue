<template>
    <div class="font-sans text-gray-900 antialiased bg-center bg-badges-splash bg-cover lg:bg-cover-width">
        <div class="pt-4">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                <div>
                    <jet-authentication-card-logo />
                </div>

                <div v-html="terms" class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden prose">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'

export default {
    props: ['terms'],

    components: {
        JetAuthenticationCardLogo,
    },
}
</script>
