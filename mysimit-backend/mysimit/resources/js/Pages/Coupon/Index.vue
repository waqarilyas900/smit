<template>

	<index-view title="Coupons" :breadcrumb="breadcrumb">
		<datatable :data="coupons" searchRoute="coupons.index" :filters="filters">
			<!-- Left Header -->
			<template #left-header>
				<search-input v-model="filters.search"></search-input>
			</template>

			<template #right-header>

				<!-- Admin -->
				<button-link class="px-6 py-3 ml-4" :href="route('coupons.create')" >
					<span class="mr-2">+ Add</span>
					<span class="hidden md:inline">Coupon</span>
				</button-link>
			</template>

			<!--Table Rows -->
			<template #default="{rows}">
				<table v-if="rows.length">
					<thead>
						<tr>
							<th>Id</th>
							<th>Coupon</th>
							<th>Discount</th>
							<th>Type</th>
							<th>Limit</th>
							<th>Used</th>
							<th>Expiry</th>
							<th>Action</th>
						</tr>

					</thead>
					<tbody>
						<tr v-for="(row, index) in rows" :key="index">
							<td>{{row.id}}</td>
							<td>{{row.coupon}}</td>
							<td>{{row.discount}}</td>
							<td>{{row.type}}</td>
							<td>{{row.limit}}</td>
							<td>{{row.used}}</td>
							<td>{{row.expiry}}</td>
							<td class="flex">
								<div>
									<Link class="btn btn-purple mr-2" title="Edit" :href="route('coupons.edit', row.id)" >
									<i class="ti-pencil-alt"></i>
									</Link>

									<jet-danger-button title="Delete" @click="deleteResource(route('coupons.destroy', row.id))" >
										<i class="ti-trash"></i>
									</jet-danger-button>

								</div>
							</td>

						</tr>

					</tbody>
				</table>
			</template>
			<template #nodata>No Coupon Found</template>

		</datatable>
	</index-view>

</template>

<script>
import IndexView from "@/Views/IndexView.vue";
import { Link } from "@inertiajs/inertia-vue3";
import ButtonLink from "@/Jetstream/ButtonLink.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import Datatable from "@/Jetstream/Datatable.vue";
import SearchInput from "@/Jetstream/SearchInput.vue";
import FilterDropdown from "@/Jetstream/FilterDropdown.vue";
import DetailIcon from "@/Icons/DetailIcon.vue";
export default {
	name: "coupons",

	props: {
		coupons: Object,
		query: Object,
	},

	components: {
		IndexView,
		Link,
		ButtonLink,
		JetDangerButton,
		Datatable,
		SearchInput,
		FilterDropdown,
		DetailIcon,
	},

	data() {
		return {
			filters: {
				search: this.query.search,
			},
			breadcrumb: [
				{ label: "Home", route: this.route("dashboard") },
				{ label: "Coupons", route: null },
			],
		};
	},
};
</script>
