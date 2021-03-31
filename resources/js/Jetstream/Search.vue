<template>
<div class="relative">
    <jet-input class="w-full" type="text" placeholder="Start typing to search..." v-model="search" />

    <div v-if="search && search.length >= 3" class="bg-gray-100 mt-4 max-h-72 overflow-y-auto">
        <div class="py-2 px-4 border-b flex items-center" v-for="option in filteredOptions">
            {{ option.name }} <jet-button type="button" @click.native="$emit('join-request', option.id)" class="ml-auto">Request to join</jet-button>
        </div>
        <div class="p-4" v-if="!filteredOptions.length">
            No results found.
        </div>
    </div>
</div>
</template>

<script>
import JetInput from '@/Jetstream/Input'
import JetButton from '@/Jetstream/Button'

export default {
    components: {
        JetInput,
        JetButton
    },
    props: {
        options: Array,
        selected: Array,
        value: null,
        label: {
            type: String,
            default: 'label'
        },
        identifier: {
            type: String,
            default: 'id'
        },
    },
    computed: {
        filteredOptions() {
            return this.options.filter(option => {
                return (!this.selected.some((request)=> request.team_id == option.id)) && (option[this.label].toLowerCase().replace(/\W/g, '').indexOf(this.search.toLowerCase().replace(/\W/g, '')) != -1);
            })
        }
    },
    data() {
        return {
            search: null
        }
    },
    watch: {
    },
    methods: {
    },
    mounted() {
    },
}
</script>
