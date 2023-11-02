<template>
    <div class="">
        <form @submit.prevent="save">
            <!-- Title-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="name" value="Title (en)" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.en.title" id="title" type="text" class="w-full" autocomplete="title" />
                    <jet-input-error :message="form.errors.title" class="mt-2" />
                </div>
            </form-group>

            <!-- Title-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="name" value="Title (ar)" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.ar.title" id="title" type="text" class="w-full" autocomplete="title" />
                    <jet-input-error :message="form.errors.title" class="mt-2" />
                </div>
            </form-group>

            <!-- Poster -->
            <form-group class="border-b">
                <jet-label for="poster" class="md:w-1/4 mt-2" value="Poster" />
                <div class="w-full mt-1">
                    <jet-image-input :url="$page.props.contactPageHero?.primaryMediaUrl" v-model="form.poster"></jet-image-input>
                    <jet-input-error :message="form.errors.poster" class="mt-2" />
                </div>
            </form-group>

            <div class="footer">
                <Link :href="route('dashboard')" class="xs:mr-4">Cancel</Link>
                <jet-button class="px-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" v-if="$page.props.can.updateAppearances">Save</jet-button>
            </div>
        </form>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetButton from "@/Jetstream/Button.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
import JetImageInput from "@/Jetstream/ImageInput.vue";
export default {
    title: "contactPageHero",

    components: {
        Link,
        JetInput,
        JetInputError,
        JetLabel,
        JetTextInput,
        FormGroup,
        JetButton,
        JetImageInput,
    },

    data() {
        return {
            // form: this.$inertia.form({
            //     title: this.$page.props.contactPageHero?.data?.title,
            //     poster: null,
            // }),
            form: this.$inertia.form({
                en:{title: this.$page.props.contactPageHero?.data?.en?.title},
                ar:{title: this.$page.props.contactPageHero?.data?.ar?.title},
                poster: null,
            }),
        };
    },

    methods: {
        save() {
            this.form.post(route("appearance.contact.hero"));
        },
    },
};
</script>

<style lang="scss" scoped>
.footer {
    @apply flex flex-col-reverse xs:flex-row xs:items-center xs:justify-end px-4 py-5 bg-gray-50 text-center sm:px-6 shadow rounded-bl-primary rounded-br-primary w-full overflow-hidden;
}
</style>
