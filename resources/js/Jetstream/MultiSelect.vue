<template>
<div v-click-outside="closeDropdown" class="relative">

    <div v-if="!expand" class="cursor-pointer relative w-full h-12 border border-gray-300 bg-white pl-3 pr-10 py-2 text-left sm:text-sm sm:leading-5" :class="isOpen ? 'z-30 border-indigo-300 ring ring-indigo-200 ring-opacity-50' : ''">
        <div v-if="multiple" class="flex items-center space-x-2">
            <span v-for="v in value" class="relative block truncate flex-shrink px-2 py-1 pr-6 border rounded-full text-blue-800 bg-blue-100">
                <span class="">{{ isSimple ? options.find(o => o === v) : options.find(o => o[identifier] === v)[label] }}</span>
                <button class="absolute top-1 right-2 block font-semibold" aria-label="close" @click.prevent="unselect(v)">×</button>
            </span>
            <input readonly :tabindex="isOpen ? (-1) : ''" class="w-0 flex-grow flex-shrink h-8 border-0 p-0 focus:ring-0" type="text" @focus="openDropdown" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label" />
        </div>
        <div v-else class="flex items-center space-x-2">
            <input :tabindex="isOpen ? (-1) : ''" readonly :value="value ? (isSimple ? options.find(o => o === value) : options.find(o => o[identifier] === value)[label]) : ''" @focus="openDropdown" class="relative block truncate flex-grow px-2 py-1 pr-6 border-0 p-0 focus:ring-0 focus:outline-none">
        </div>


        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </span>

    </div>

    <div v-show="isOpen || expand" ref="dropdown" :class="expand ? 'cursor-pointer relative w-full h-32 overflow-y-auto border border-gray-300 bg-white text-left sm:text-sm sm:leading-5' : 'z-30 absolute mt-1 w-full bg-white shadow-lg max-h-56 py-1 text-base leading-6 shadow-xs overflow-auto focus:outline-none sm:text-sm sm:leading-5'">
        <button @keydown.tab.exact="checkIfShouldClose(key)" @keydown.shift.tab="checkIfShouldCloseReverse(key)" @click.prevent="toggle(option)" role="option" v-for="(option, key) in options" v-bind:key="isSimple ? option : option[identifier]" class="w-full text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9  cursor-pointer hover:text-white hover:bg-indigo-600 focus:outline-none focus:text-white focus:bg-indigo-600 flex items-center space-x-3">
            <span class="block truncate" v-bind:class="{ 'font-normal' : !isSelected(option) , 'font-semibold' : isSelected(option)}">
                {{ isSimple ? option : option[label] }}
            </span>

            <span v-show="isSelected(option)" class="absolute inset-y-0 right-0 flex items-center pr-4">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </span>
        </button>
    </div>
</div>
</template>

<script>
import ClickOutside from 'vue-click-outside'

export default {
    name: 'MultiSelect',
    props: {
        options: Array,
        expand: Boolean,
        multiple: Boolean,
        value: null,
        label: {
            type: String,
            default: null
        },
        identifier: {
            type: String,
            default: null
        },
    },
    data() {
        return {
            'isOpen': false,
            'current': null,
        }
    },
    computed: {
        isSimple: function() {
            return (this.label || this.identifier) ? false : true
        }
    },
    watch: {
       value: function (value) {
           this.$emit('input', value)
       }
    },
    methods: {
        checkIfShouldClose(key) {
            if(key + 1 == this.options.length) {
                this.closeDropdown();
            }
        },
        checkIfShouldCloseReverse(key) {
            if(key == 0) {
                setTimeout(()=>{
                    this.closeDropdown();
                }, 200);
            }
        },
        isSelected(value) {
            if(this.value) {
                if(this.multiple) {
                    if(this.isSimple) {
                        return this.value.includes(value);
                    }
                    else {
                        return this.value.includes(value[this.identifier]);
                    }
                }
                else {
                    if(this.isSimple) {
                        return this.value == value;
                    }
                    else {
                        return this.value == value[this.identifier];
                    }
                }
            }
        },
        closeDropdown() {
            this.isOpen = false;
        },
        openDropdown() {
            this.isOpen = true;
        },
        toggle(value) {
            event.target.blur();
            if (!this.isSelected(value)) {
                this.select(value)
            }
            else {
                this.unselect(value)
            }

        },
        select(value) {
            let newValue = null;

            if(this.multiple) {
                if (typeof value === 'object' && value !== null) {
                    newValue = this.value;
                    if(this.isSimple) {
                        newValue.push(value || 'id');
                    }
                    else {
                        newValue.push(value[this.identifier || 'id']);
                    }
                } else {
                    newValue = this.value;
                    newValue.push(value);
                }
            }
            else {
                if (typeof value === 'object' && value !== null) {
                    if(this.isSimple) {
                        newValue = value;
                    }
                    else {
                        newValue = value[this.identifier || 'id'];
                    }
                } else {
                    newValue = value;
                }
                this.closeDropdown();
            }
            this.$emit('input', newValue)
        },
        unselect(value) {
            if(this.multiple) {
                let newValue = this.value;
                if (typeof value === 'object' && value !== null) {
                    if(this.isSimple) {
                        newValue.splice(this.value.indexOf(value), 1)
                    }
                    else {
                        newValue.splice(this.value.indexOf(value[this.identifier || 'id']), 1)
                    }
                } else {
                    newValue.splice(this.value.indexOf(value), 1)
                }
                this.$emit('input', newValue);

            }
            else {
                this.$emit('input', null)
            }
        }
    },
    mounted() {
        if(this.multiple == true && this.value == null) {
            this.$emit('input', [])
        }
    },
    directives: {
        ClickOutside
    }
}
</script>
