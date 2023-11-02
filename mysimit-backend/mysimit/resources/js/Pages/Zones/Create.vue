<template>
	<form-view @submitted="save('zones.store')" title="Create Area" :breadcrumb="breadcrumb">
		<template #form>
			<!-- <form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="search-place" value="Search" />
				<div class="w-full mt-1">
					<place-control @setPlace="setPlace" :countries="restrictedCountries">
					</place-control>
				</div>
			</form-group> -->

			<!-- Name -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="name" value="Name" required />
				<div class="w-full mt-1">
					<jet-input v-model="form.name" id="name" type="text" class="w-full" autocomplete="name" />
					<p class="desc mt-3">For Database Purposes Only</p>
					<jet-input-error :message="form.errors.name" class="mt-2" />
				</div>
			</form-group>

			<!-- City -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="city.en" value="City (en)" required />
				<div class="w-full mt-1">
					<jet-input v-model="form.city.en" id="city.en" type="text" class="w-full" autocomplete="city" />
					<p class="desc mt-3">This Field Will Appear On The Website.</p>
					<jet-input-error :message="form.errors.city" class="mt-2" />
				</div>
			</form-group>

			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="city.ar" value="City (ar)" required />
				<div class="w-full mt-1">
					<jet-input v-model="form.city.ar" id="city.ar" type="text" class="w-full" autocomplete="city" />
					<p class="desc mt-3">This Field Will Appear On The Website.</p>
					<jet-input-error :message="form.errors.city" class="mt-2" />
				</div>
			</form-group>

			<!-- State -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="state" value="Governorate" />
				<div class="w-full mt-1">
					<jet-select v-model="form.state" track="name" class="w-full" :options="governerates" required></jet-select>
					<!-- <jet-input v-model="form.state" id="state" type="text" class="w-full" autocomplete="state" required/> -->
					<jet-input-error :message="form.errors.state" class="mt-2" />
				</div>
			</form-group>

			<!-- Zipcode -->
			<!-- <form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="zipcode" value="Zipcode" />
				<div class="w-full mt-1">
					<jet-input v-model="form.zipcode" id="zipcode" type="text" class="w-full" autocomplete="zipcode" />
					<jet-input-error :message="form.errors.zipcode" class="mt-2" />
				</div>
			</form-group> -->

            <!-- Price -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="price" value="Delivery Fee Of The Area (KD)" />
				<div class="w-full mt-1">
					<jet-input v-model="form.price" id="price" type="text" class="w-full" autocomplete="price" />
					<jet-input-error :message="form.errors.price" class="mt-2" />
				</div>
			</form-group>

			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="mini_order" value="Minimum Order Fee (KD)" />
				<div class="w-full mt-1">
					<jet-input v-model="form.mini_order" id="mini_order" type="text" class="w-full" autocomplete="price" />
					<jet-input-error :message="form.errors.mini_order" class="mt-2" />
				</div>
			</form-group>

			<!-- Country -->
			<form-group class="border-b">
				<jet-label class="md:w-1/4 mt-2" for="countries" value="Country" required />
				<div class="w-full mt-1">
					<jet-select v-model="form.country" track="name" class="w-full" :options="countries"></jet-select>
					<jet-input-error :message="form.errors.country" class="mt-2" />
				</div>
			</form-group>

		</template>

		<template #actions>
			<Link :href="route('zones.index')" class="xs:mr-4">Cancel</Link>
			<jet-button @click.prevent="save('zones.store', true)" class="px-6 xs:mr-2 my-2 xs:my-0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save & Continue</jet-button>
			<jet-button class="px-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save</jet-button>
		</template>
	</form-view>

</template>

<script>
import JetSelect from "@/Jetstream/Select";
import FormView from "@/Views/FormView.vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetTextInput from "@/Jetstream/TextInput.vue";
import JetButton from "@/Jetstream/Button.vue";
import FormGroup from "@/Jetstream/FormGroup.vue";
import PlaceControl from "@/Jetstream/PlaceControl.vue";

export default {
	name: "create-zone",

	props: {
		countries: Object,
	},

	components: {
		Link,
		FormView,
		JetInput,
		JetInputError,
		JetLabel,
		JetTextInput,
		FormGroup,
		JetButton,
		JetSelect,
		PlaceControl,
	},
	data() {
		return {
			showDialog: false,
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Areas", route: this.route("zones.index") },
				{ label: "Create", route: null },
			],
			governerates: [
				{id: 0, name: 'Ahmadi'},
				{id: 1, name: 'Al-Asimah'},
				{id: 2, name: 'Farwaniya'},
				{id: 3, name: 'Hawalli'},
				{id: 4, name: 'Jahra'},
				{id: 5, name: 'Mubarak Al-Kabeer'}
			],

			form: this.$inertia.form({
				name: null,
				city: {en: null, ar: null},
				state: null,
				// zipcode: null,
				country: null,
                price : 0,
				mini_order : 0,
			}),
		};
	},

	computed: {
		restrictedCountries() {
			return this.countries.map((country) => country.code);
		},
	},
	methods: {
		setPlace(e) {
			this.form.name = e.name ?? null;
			this.form.city = e.city ?? null;
			this.form.state = e.state ?? null;
			// this.form.zipcode = e.zipcode ?? null;
			this.form.country = e.country ?? null;
            this.form.price = e.price ?? null;
		},
	},
};
</script>
