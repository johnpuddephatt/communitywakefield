<template>
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-center bg-badges-splash bg-cover lg:bg-cover-width">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden">
            <slot name="logo" />
            <slot />
        </div>
    </div>
</template>
