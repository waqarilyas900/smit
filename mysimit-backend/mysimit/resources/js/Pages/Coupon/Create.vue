<template> 
	<form-view @submitted="save('coupons.store')" title="Create Coupon" :breadcrumb="breadcrumb">
		<template #form>

            <!-- Name -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="coupon" value="Coupon" required />
				<div class="w-full mt-1">
					<jet-input v-model="form.coupon" id="coupon" type="text" class="w-full" autocomplete="name" />
					<p class="desc">The name of coupon</p>
				</div>
			</form-group>

			<!--  Description -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="discount" value="Discount" />
				<div class="w-full mt-1">
					<jet-input v-model="form.discount" id="discount" type="text" class="mt-1 block w-full" autocomplete="name" />
					<p class="desc">Write the number which you offer the discount (only number)</p>
					<jet-input-error class="mt-2" />
				</div>
			</form-group>

            <!--  Description -->
			<!-- <form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="type" value="Type" />
				<div class="w-full mt-1">
					<jet-text-input v-model="form.type" id="type" type="text" class="mt-1 block w-full" autocomplete="name" />
					<jet-input-error class="mt-2" />
				</div>
			</form-group> -->
            <form-group class="border-b">
                <jet-label class="md:w-1/4 mt-2" for="prepration" value="type" required />
                <div class="w-full mt-1">
                    <jet-select v-model="form.type" class="w-full" :options="discount_type"></jet-select>
					<p class="desc">Select the type of coupon</p>
                    <jet-input-error :message="form.errors.type" class="mt-2" />
                </div>
            </form-group>
            
            <!--  limit -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="limit" value="Limit" />
				<div class="w-full mt-1">
					<jet-input v-model="form.limit" id="limit" type="text" class="mt-1 block w-full" autocomplete="limit" />
					<p class="desc">Write the limit of time use of coupon</p>
					<jet-input-error class="mt-2" />
				</div>
			</form-group>

            <!--  used -->
			<!-- <form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="used" value="Used" />
				<div class="w-full mt-1">
					<jet-input v-model="form.used" id="used" type="text" class="mt-1 block w-full" autocomplete="name" />
					<jet-input-error class="mt-2" />
				</div>
			</form-group> -->

            <!--  expiry -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="expiry" value="Expiry" />
				<div class="w-full mt-1">
					<jet-input v-model="form.expiry" id="expiry" type="date" class="mt-1 block w-full" autocomplete="expiry" />
					<p class="desc">Select the expiry date of coupon</p>
					<jet-input-error class="mt-2" />
				</div>
			</form-group>


		</template>

		<template #actions>
			<Link :href="route('coupons.index')" class="xs:mr-4">Cancel</Link>
			<jet-button @click.prevent="save('coupons.store', true)" class="px-6 xs:mr-2 my-2 xs:my-0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Create & Continue</jet-button>
			<jet-button class="px-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Create</jet-button>
		</template>
	</form-view>

</template>

<script>
import FormView from "@/Views/FormView.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetSelect from "@/Jetstream/Select.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetButton from "@/Jetstream/Button.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
import JetImageInput from "@/Jetstream/ImageInput.vue";

export default {
	name: "edit-coupons",
	// props: {
	// 	coupon: Object,
	// },

	components: {
		Link,
		FormView,
		JetInput,
		JetSelect,
		JetInputError,
		JetLabel,
		JetTextInput,
		FormGroup,
		JetButton,
		JetImageInput,
	},
	data() {
		return {
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Coupon", route: this.route("coupons.index") },
				{ label: "Create", route: null },
			],

			form: this.$inertia.form({
				coupon: null,
                discount: null,
                type: null,
                limit: null,
                used: null,
                expiry: null
			}),
            discount_type: [{id:1,name:'fixed'},{id:2,name:'percentage'}]
		};
	},
};
</script>