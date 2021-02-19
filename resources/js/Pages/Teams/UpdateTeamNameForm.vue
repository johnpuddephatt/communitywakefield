<template>
<jet-form-section @submitted="updateTeamName">
    <template #title>
        Team Name
    </template>

    <template #description>
        The team's name and logo.
    </template>

    <template #form>

        <div class="col-span-6 sm:col-span-4">
            <input type="text" v-model="croppieOptions.backgroundColor" placeholder="color">

            <input type="file" @change="croppie" />
            <vue-croppie :style="`--background-color: ${ croppieOptions.backgroundColor }`" ref="croppieRef" :enableResize="false" :enableOrientation="true" :enforceBoundary="false" :boundary="{ width: croppieOptions.size.width + 50, height: croppieOptions.size.height + 50 }" :viewport="{width: croppieOptions.size.width, height: croppieOptions.size.height, 'type':'circle' }">
            </vue-croppie>

            <!-- <button @click="crop">Crop</button> -->
        </div>

        <div class="col-span-6 sm:col-span-4">
            <jet-label for="name" value="Team Name" />

            <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" :disabled="! permissions.canUpdateTeam" />

            <jet-input-error :message="form.errors.name" class="mt-2" />
        </div>
    </template>

    <template #actions v-if="permissions.canUpdateTeam">
        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
            Saved.
        </jet-action-message>

        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
            Save
        </jet-button>
    </template>
</jet-form-section>
</template>

<script>
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },

    props: ['team', 'permissions'],

    data() {
        return {
            croppieImage: '',
            cropped: null,

            croppieOptions: {
                format: 'jpeg',
                type: 'base64',
                backgroundColor: '#aa4400',
                size: {
                    width: 300,
                    height: 300
                },
            },
            form: this.$inertia.form({
                name: this.team.name,
            })
        }
    },

    methods: {
        updateTeamName() {
            this.form.put(route('teams.update', this.team), {
                errorBag: 'updateTeamName',
                preserveScroll: true
            });
        },
        croppie(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            var reader = new FileReader();
            reader.onload = e => {
                this.$refs.croppieRef.bind({
                    url: e.target.result
                });
            };
            reader.readAsDataURL(files[0]);
        },
        crop() {
            this.$refs.croppieRef.result(this.croppieOptions, output => {
                this.cropped = this.croppieImage = output;
            });
        }
    },
}
</script>
<style>
    .cr-boundary {
        height: auto;
        background-color: var(--background-color);
    }
</style>
