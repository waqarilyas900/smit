<template>
    <div class="flex  py-8 px-8">
        <div class="w-5/12">
            <div class="mb-4">
                <h6 class="font-bold text-lg">About section Faqs</h6>
                <span class=" text-gray-500 ">Add & change About section faqs content here</span>
            </div>
            <!-- Admin -->
            <button class="btn btn-primary px-6 py-2" @click.prevent="addAboutFaq">
                <span class="mr-2">+ Add</span>
                <span class="hidden md:inline">About Section Faq</span>
            </button>

        </div>
        <!--Table Rows -->
        <div class="w-7/12 rounded-lg border overflow-x-auto">
            <table v-if="$page.props.aboutFaqs.length">
                <thead class="head">
                    <tr>
                        <th>Id</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Action</th>
                    </tr>

                </thead>
                <tbody>
                    <tr v-for="(row, index) in $page.props.aboutFaqs" :key="index">
                        <td>{{row.id}}</td>
                        <td>{{row.title?.en}}</td>
                        <td>{{row.value?.en}}</td>

                        <td class="flex">
                            <div>
                                <jet-button class="btn btn-success mr-2" title="Edit" @click="editAboutFaq(index)" v-if="$page.props.can.updateAppearances">
                                    <i class="ti-pencil-alt"></i>
                                </jet-button>

                                <jet-danger-button title="Delete" @click="deleteResource(route('about-faqs.delete', row.id))" v-if="$page.props.can.deleteAppearances">
                                    <i class="ti-trash"></i>
                                </jet-danger-button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="flex justify-center items-center text-gray-800 h-32" v-else>
                <span class="font-semibold">No Faqs Added</span>
            </div>
        </div>

        <!-- Add Country modal -->
        <jet-dialog-modal :show="showDialog" @close="closeModal">
            <template #title>Add Rider Faq</template>

            <template #content>

                <!-- Qusetion -->
                <form-group class="border-b">
                    <jet-label class="md:w-1/4 mt-2" for="title" value="Qusetion (en)" required />
                    <div class="w-full mt-1">
                        <jet-input v-model="form.title.en" id="title" type="text" class="w-full" autocomplete="title" />
                        <jet-input-error :message="form.errors.title" class="mt-2" />
                    </div>
                </form-group>

                <!-- Qusetion -->
                <form-group class="border-b">
                    <jet-label class="md:w-1/4 mt-2" for="title" value="Qusetion (ar)" required />
                    <div class="w-full mt-1">
                        <jet-input v-model="form.title.ar" id="title" type="text" class="w-full" autocomplete="title" />
                        <jet-input-error :message="form.errors.title" class="mt-2" />
                    </div>
                </form-group>

                <!-- Answer -->
                <form-group class="border-b">
                    <jet-label class="md:w-1/4 mt-2" for="value" value="Answer (en)" required />
                    <div class="w-full mt-1">
                        <jet-text-input v-model="form.value.en" id="value" type="text" class="mt-1 block w-full" autocomplete="value" />
                        <jet-input-error class="mt-2" />
                    </div>
                </form-group>

                <!-- Answer -->
                <form-group class="border-b">
                    <jet-label class="md:w-1/4 mt-2" for="value" value="Answer (ar)" required />
                    <div class="w-full mt-1">
                        <jet-text-input v-model="form.value.ar" id="value" type="text" class="mt-1 block w-full" autocomplete="value" />
                        <jet-input-error class="mt-2" />
                    </div>
                </form-group>

            </template>

            <template #footer>
                <button class="" @click="closeModal">Cancel</button>
                <button class="ml-2 btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="save">Save</button>
            </template>
        </jet-dialog-modal>

    </div>
</template>

<script>
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetButton from "@/Jetstream/Button.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetImageInput from "@/Jetstream/ImageInput.vue";
export default {
    name: "about-faqs",

    props: {
        query: Object,
    },

    components: {
        Link,
        JetButton,
        JetDangerButton,
        JetDialogModal,
        JetButton,
        JetInput,
        JetInputError,
        JetLabel,
        FormGroup,
        JetTextInput,
        JetImageInput,
    },

    data() {
        return {
            form: this.$inertia.form({
                id: null,
                title: { en: null, ar: null },
                value: { en: null, ar: null },
            }),

            showDialog: false,
            edit: false,
        };
    },

    methods: {
        addAboutFaq() {
            this.edit = false;
            this.form.reset();
            this.showDialog = true;
        },
        save() {
            if (this.edit) {
                this.form.post(route("about-faqs.update", this.form.id), {
                    onSuccess: () => {
                        this.edit = false;
                        this.closeModal();
                        this.form.reset();
                    },
                });
            } else {
                this.form.post(route("about-faqs.create"), {
                    onSuccess: () => {
                        this.closeModal();
                        this.form.reset();
                    },
                });
            }
        },

        closeModal() {
            this.showDialog = false;
        },

        editAboutFaq(index) {
            this.showDialog = true;
            this.edit = true;
            this.form.id = this.$page.props.aboutFaqs[index].id;
            this.form.title = { en: this.$page.props.aboutFaqs[index].title?.en, ar: this.$page.props.aboutFaqs[index].title?.ar };
            this.form.value = { en: this.$page.props.aboutFaqs[index].value?.en, ar: this.$page.props.aboutFaqs[index].value?.ar };
        },
    },
};
</script>

<style lang="scss" scoped>
.head {
    @apply bg-gray-50;
}

tr:nth-child(even) {
    @apply bg-gray-50;
}
</style>
