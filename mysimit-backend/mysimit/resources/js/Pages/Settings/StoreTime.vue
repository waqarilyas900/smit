<template>
    <div class="" >
        <form @submit.prevent="save">

            <!-- Country Name-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="prepration" value="Prepration Time" required />
                <div class="w-full mt-1">
                    <jet-input v-model="form.prepration"  type="number" class="w-full" autocomplete="prepration" />
                    <!-- <jet-select v-model="form.prepration" class="w-full" :options="hours"></jet-select> -->
                    <p class="desc mt-3">Specify the amount of minutes to block for prep time on the orders</p>
                    <jet-input-error :message="form.errors.prepration" class="mt-2" />
                </div>
            </form-group>

             <!--Code-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="open" value="Open Time" required />
                <div class="w-full mt-1">
                    <jet-input :disabled="form.twentyfourhours == 'yes'" v-model="form.open" id="open" type="time" class="w-full" format="hh:mm" autocomplete="code" />
                    <jet-input-error :message="form.errors.open" class="mt-2" />
                </div>
            </form-group>

                <!--Symbol-->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="close" value="Close Time" required />
                <div class="w-full mt-1">
                    <jet-input :disabled="form.twentyfourhours == 'yes'" v-model="form.close" id="close" type="time" class="w-full" format="hh:mm" autocomplete="symbol" />
                    <jet-input-error :message="form.errors.close" class="mt-2" />
                </div>
            </form-group>
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="TimeSlots" value="Time Slots" required />
                <div class="w-full mt-1">
                    <div v-for="(slot, index) in timeSlots" :key="index" class="flex items-center mb-4">
                    <input
                        :id="'slot-' + index"
                        type="checkbox"
                        :name="'slot-' + index"
                        :value="slot"
                        v-model="form.hours"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label :for="'slot-' + index" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ slot }}</label>
                    </div>
                </div>
            </form-group>
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="twentyfourhours" value="24 Hours Open" required />
                <div class="w-full mt-1">
                    <div class="flex">
                        <div class="flex items-center mr-4">
                            <input id="inline-radio" type="radio" value="yes" v-model="form.twentyfourhours" name="twentyfourhours" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="inline-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yes</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="inline-radio" type="radio" value="no" v-model="form.twentyfourhours" name="twentyfourhours" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="inline-radio" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">No</label>
                        </div>
                    </div>
                    <!-- <jet-input  v-model="form.twentyfourhours"  value="yes" type="radio" class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-opacity-50 focus:ring-primary-200 rounded-full shadow-sm"  autocomplete="twentyfourhours" />
                    <jet-input  v-model="form.twentyfourhours"  value="no" type="radio" class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-opacity-50 focus:ring-primary-200 rounded-full shadow-sm"  autocomplete="twentyfourhours" />
                    <jet-input-error :message="form.errors.twentyfourhours" class="mt-2" /> -->
                </div>
            </form-group>

            <div class="footer">
                <Link :href="route('dashboard')" class="xs:mr-4">Cancel</Link>
                <jet-button class="px-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" v-if="$page.props.can.updateSettings">Save</jet-button>
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
import JetSelect from "@/Jetstream/Select.vue";

export default {
    name: "currency-settings",

    components: {
        Link,
        JetInput,
        JetInputError,
        JetLabel,
        JetTextInput,
        FormGroup,
        JetButton,
        JetSelect,
    },

    data() {
        return {
            timeSlots: [
                '12:00am-1:00am',
                '1:00am-2:00am',
                '2:00am-3:00am',
                '3:00am-4:00am',
                '4:00am-5:00am',
                '5:00am-6:00am',
                '6:00am-7:00am',
                '7:00am-8:00am',
                '8:00am-9:00am',
                '9:00am-10:00am',
                '10:00am-11:00am',
                '11:00am-12:00pm',
                '12:00pm-1:00pm',
                '1:00pm-2:00pm',
                '2:00pm-3:00pm',
                '3:00pm-4:00pm',
                '4:00pm-5:00pm',
                '5:00pm-6:00pm',
                '6:00pm-7:00pm',
                '7:00pm-8:00pm',
                '8:00pm-9:00pm',
                '9:00pm-10:00pm',
                '10:00pm-11:00pm',
                '11:00pm-12:00am',
            ],
            selectedSlots: [],
            form: this.$inertia.form({
                open: this.$page.props.storetime?.data?.open,
                close: this.$page.props.storetime?.data?.close,
                twentyfourhours: this.$page.props.storetime?.data?.twentyfourhours,
                hours: this.$page.props.storetime?.data?.hours,
                //hours: [],
                prepration:this.$page.props.storetime?.data?.prepration,
            }),
            //hours: [{id:1,name:0},{id:2,name:1},{id:3,name:2},{id:4,name:3},{id:5,name:4},{id:6,name:5},]
        };
    },

    methods: {
        save() {
            this.form.post(route("settings.storetime"));
        },
    },
};
</script>

<style lang="scss" scoped>
.footer {
    @apply flex flex-col-reverse xs:flex-row xs:items-center xs:justify-end px-4 py-5 bg-gray-50 text-center sm:px-6 shadow rounded-bl-primary rounded-br-primary w-full overflow-hidden;
}
</style>
