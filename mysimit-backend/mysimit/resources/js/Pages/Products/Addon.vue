<template>
	<div class="flex  py-8 px-8">
		<div class="w-5/12">
			<div class="mb-4">
				<h6 class="font-bold text-lg">Addons Section</h6>
				<span class=" text-gray-500">Add & change addons content here</span>
			</div>
			<!-- Admin -->
			<button class="btn btn-primary px-6 py-2" @click.prevent="addAddon" v-if="$page.props.can.createUnits">
				<span class="mr-2">+ Add</span>
				<span class="hidden md:inline">Addon</span>
			</button>

		</div>
		<!--Table Rows -->
		<div class="w-7/12 rounded-lg shadow overflow-x-auto">
			<table v-if="$page.props.addons.length">
				<thead class="head">
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>Is Multiple</th>
                        <th>Options</th>
						<th>Action</th>
					</tr>

				</thead>
				<tbody>

					<tr v-for="(row, index) in $page.props.addons" :key="index">
						<td>{{row.id}}</td>
						<td>{{row.name}}</td>
						<td>{{ row.isMultiple ? 'Yes' : 'No' }}</td>
                        <td>
							<div class="flex">
								<jet-button class="btn btn-success mr-2" title="Add Options" @click.prevent="addOption(row.id)" v-if="$page.props.can.updateUnits">
									<i class="ti-plus"></i>
								</jet-button>
							</div>
						</td>
						<td >
							<div class="flex">
								<jet-button class="btn btn-success mr-2" title="Edit" @click.prevent="editAddon(index)" v-if="$page.props.can.updateUnits">
									<i class="ti-pencil-alt"></i>
								</jet-button>

								<jet-danger-button title="Delete" @click="deleteResource(route('addon.destroy', row.id))" v-if="$page.props.can.deleteUnits">
									<i class="ti-trash"></i>
								</jet-danger-button>
							</div>
						</td>
					</tr>

				</tbody>
			</table>

			<div class="flex justify-center items-center text-gray-800 h-32" v-else>
				<span class="font-semibild">No Addon Added</span>
			</div>

		</div>
	</div>
    <div class="flex  py-8 px-8">
		<div class="w-5/12">
			<div class="mb-4">
				<h6 class="font-bold text-lg">Addons Options Section</h6>
				<span class=" text-gray-500">change addons options content here</span>
			</div>
		</div>
        <div class="w-7/12 rounded-lg shadow overflow-x-auto" v-if="$page.props.addons.length">
			<table>
				<thead class="head">
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>Price</th>
                        <th>Action</th>
					</tr>
				</thead>
				<tbody  v-for="(addon, index) in $page.props.addons" :key="index" >
					<tr v-if="addon.options.length > 0" class="bg-primary-500 font-semibold text-center text-primary-600"><td colspan="4" >{{addon.name}}</td></tr>
					<tr v-if="addon.options.length > 0" v-for="(row, i) in addon.options" :key="i">
						<td>{{row.id}}</td>
						<td>{{row.name}}</td>
						<td>{{ row.price}}</td>
                        <td>
							<div class="flex">
								<jet-button class="btn btn-success mr-2" title="Edit Options" @click.prevent="editOption(index,i)" v-if="$page.props.can.updateUnits">
									<i class="ti-pencil-alt"></i>
								</jet-button>
								<jet-danger-button title="Delete" @click="deleteResource(route('option.destroy', row.id))" v-if="$page.props.can.deleteUnits">
									<i class="ti-trash"></i>
								</jet-danger-button>
							</div>
						</td>
					</tr>

				</tbody>
			</table>
		</div>
    </div>
    <!-- Add feature modal -->
    <div>
        <jet-dialog-modal :show="showAddonDialog" @close="closeModal">
            <template #title>Add Addon</template>

            <template #content>

                <!-- Name -->
                <form-group class="border-b">
                    <jet-label class="md:w-1/4 mt-2" for="name" value="Name" required />
                    <div class="w-full mt-1">
                        <jet-input v-model="form.name" id="name" type="text" class="w-full" autocomplete="name" />
                        <jet-input-error :message="form.errors.name" class="mt-2" />
                    </div>
                </form-group>

                <!--is_multiple -->
                <form-group class="border-b">
                    <jet-label class="md:w-1/4 mt-2" for="is_multiple" value="Is Multiple" required />
                    <div class="w-full mt-1 flex">
                        <label class="mr-2">
                            <input v-model="form.is_multiple" type="radio" value="1"  autocomplete="is_multiple" />
                            Yes
                        </label>
                        <label>
                            <input v-model="form.is_multiple" type="radio" value="0"  autocomplete="is_multiple" />
                            No
                        </label>
                        <jet-input-error :message="form.errors.is_multiple" class="mt-2" />
                    </div>
                </form-group>

            </template>

            <template #footer>
                <button class="" @click="closeModal">Cancel</button>

                <button class="ml-2 btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="save">Save</button>
            </template>
        </jet-dialog-modal>
    </div>
    <!-- <div>
        <jet-dialog-modal :show="showAddonDialog" @close="closeModal">
            <template #title>Add Addon</template>

            <template #content>

                <form-group class="border-b">
                    <jet-label class="md:w-1/4 mt-2" for="name" value="Name" required />
                    <div class="w-full mt-1">
                        <jet-input v-model="form.name" id="name" type="text" class="w-full" autocomplete="name" />
                        <jet-input-error :message="form.errors.name" class="mt-2" />
                    </div>
                </form-group>

                <form-group class="border-b">
                    <jet-label class="md:w-1/4 mt-2" for="is_multiple" value="Is Multiple" required />
                    <div class="w-full mt-1 flex">
                        <label class="mr-2">
                            <input v-model="form.is_multiple" type="radio" value="1"  autocomplete="is_multiple" />
                            Yes
                        </label>
                        <label>
                            <input v-model="form.is_multiple" type="radio" value="0"  autocomplete="is_multiple" />
                            No
                        </label>
                        <jet-input-error :message="form.errors.is_multiple" class="mt-2" />
                    </div>
                </form-group>

            </template>

            <template #footer>
                <button class="" @click="closeModal">Cancel</button>

                <button class="ml-2 btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="save">Save</button>
            </template>
        </jet-dialog-modal>
    </div> -->
    <div>
        <jet-dialog-modal :show="showOptionDialog" @close="closeModal">
            <template #title>Option</template>

            <template #content>

                <!-- Name -->
                <form-group class="border-b">
                    <jet-label class="md:w-1/4 mt-2" for="name" value="Name" required />
                    <div class="w-full mt-1">
                        <jet-input v-model="optionform.name" id="name" type="text" class="w-full" autocomplete="name" />
                        <jet-input-error :message="optionform.errors.name" class="mt-2" />
                    </div>
                </form-group>

                <!--Price -->
                <form-group class="border-b">
                    <jet-label class="md:w-1/4 mt-2" for="price" value="Price" required />
                    <div class="w-full mt-1">
                        <jet-input v-model="optionform.price" id="price" type="text" class="w-full" autocomplete="price" />
                        <jet-input-error :message="optionform.errors.price" class="mt-2" />
                    </div>
                </form-group>


            </template>

            <template #footer>
                <button class="" @click="closeModal">Cancel</button>

                <button class="ml-2 btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="saveOptions">Save</button>
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

export default {
	name: "addon",

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
	},

	data() {
		return {
			form: this.$inertia.form({
				name: null,
				is_multiple: false,
			}),
            optionform: this.$inertia.form({
                id: null,
				name: null,
				price: 0,
			}),
			showAddonDialog: false,
			edit: false,
            showOptionDialog: false,
		};
	},

	methods: {
		addAddon() {
			this.edit = false;
			this.form.reset();
			this.showAddonDialog = true;
		},
        addOption(addon_id) {
			this.edit = false;
			this.optionform.reset();
			this.showOptionDialog = true;
            this.optionform.id = addon_id;
		},
        saveOptions(){
            if (this.edit) {
				this.optionform.post(route("option.edit", this.optionform.id), {
					onSuccess: () => {
						this.edit = false;
						this.closeModal();
						this.optionform.reset();
					},
				});
			} else {
				this.optionform.post(route("option.store", this.optionform.id), {
					onSuccess: () => {
						this.closeModal();
						this.optionform.reset();
					},
				});
			}
        },
		save() {
			if (this.edit) {
				this.form.post(route("addon.edit", this.form.id), {
					onSuccess: () => {
						this.edit = false;
						this.closeModal();
						this.form.reset();
					},
				});
			} else {
				this.form.post(route("addon.store", this.$page.props.product.id), {
					onSuccess: () => {
						this.closeModal();
						this.form.reset();
					},
				});
			}
		},

		closeModal() {
			this.showAddonDialog = false;
            this.showOptionDialog = false;
		},
        
		editAddon(index) {
			this.showAddonDialog = true;
			this.edit = true;
			this.form.name = this.$page.props.addons[index].name;
            this.form.id = this.$page.props.addons[index].id;
			this.form.is_multiple = this.$page.props.addons[index].isMultiple;
		},
        editOption(index,i) {
			this.showOptionDialog = true;
			this.edit = true;
			this.optionform.name = this.$page.props.addons[index].options[i].name;
            this.optionform.id = this.$page.props.addons[index].options[i].id;
			this.optionform.price = this.$page.props.addons[index].options[i].price;
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
