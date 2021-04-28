<template>
    <div v-if="value" class="border border-gray-300 overflow-hidden">

        <vue-croppie @update="crop" :style="`--background-color: ${ croppieOptions.backgroundColor }`" ref="croppieRef" :enableResize="false" :enableOrientation="true" :enforceBoundary="false" :boundary="{ width: croppieOptions.size.width, height: croppieOptions.size.height }" :viewport="{width: croppieOptions.size.width, height: croppieOptions.size.height, 'type':'circle' }">
        </vue-croppie>

        <div class="flex mx-6 items-center">
            <label class="text-sm" for="custom_color">Background color</label>
            <div class="w-6 h-6 ml-2 rounded-full border-2 bg-black" @click="croppieOptions.backgroundColor = '#000000'"></div>
            <div class="w-6 h-6 ml-2 rounded-full border-2" @click="croppieOptions.backgroundColor = '#ffffff'"></div>
            <input id="custom_color" class="ml-2" type="color" v-model="croppieOptions.backgroundColor" placeholder="color">


        </div>
        <div class="overflow-hidden border-t relative mt-4">
            <jet-secondary-button class="w-full border-none text-center">Select another image</jet-secondary-button>
            <input class="cursor-pointer absolute block opacity-0 inset-0" id="logo" type="file" accept="image/png, image/jpeg" @change="fileUploaded" />
        </div>
    </div>


    <div v-else class="overflow-hidden relative mt-4 mb-4">
        <jet-secondary-button>Select an image</jet-secondary-button>
        <input class="cursor-pointer absolute block opacity-0 inset-0" id="logo" type="file" @change="fileUploaded" />
    </div>

</template>

<script>
import JetButton from '@/Jetstream/Button'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        props: {
            value: {
                type: String,
                default: null,
            },
        },

        components: {
            JetButton,
            JetSecondaryButton
        },

        data() {
            return {
                croppieOptions: {
                    format: 'jpeg',
                    circle: false,
                    type: 'base64',
                    zoom: 3,
                    backgroundColor: '#ffffff',
                    size: {
                        width: 250,
                        height: 250
                    },
                },
            }
        },

        mounted() {
            if(this.value) {

                this.$nextTick( () => {
                    this.$refs.croppieRef.bind({
                        url: this.value,
                        zoom: 1
                    });
               });
           }
        },

        methods: {
            fileUploaded(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length) return;
                var reader = new FileReader();
                reader.onload = e => {
                    this.$emit('input', e.target.result);
                    this.$nextTick( () => {
                        this.$refs.croppieRef.bind({
                            url: e.target.result
                        });
                    });
                };
                reader.readAsDataURL(files[0]);
            },
            crop() {
                this.$refs.croppieRef.result(this.croppieOptions, output => {
                    this.$emit('input', output);
                });
            }
        }

    }
</script>
<style>
    .croppie-container {
        /* width: auto;
        height: auto; */
    }

    .cr-boundary {
        width: 100% !important;
        height: auto;
        background-color: var(--background-color);
    }
</style>
