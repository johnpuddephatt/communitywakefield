<template>
    <div class="bg-spruce mb-4 py-5 px-3">
            <div class="flex items-center justify-between flex-wrap">
              <div class="w-0 flex-1 flex items-flex-start">
                <span class="flex p-2 mb-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </span>
                <p class="text-xs font-medium text-white">
                  <slot></slot>
                </p>
              </div>
            </div>
    </div>
</template>

<script>
    export default {
        props: [],

        computed: {

        }
    }
</script>
