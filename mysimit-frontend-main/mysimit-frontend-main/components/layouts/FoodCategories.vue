<template>
	<div class="food-categories h-full">
		<div class="my-10">
			<div class="food-box bg-white ">
				<section-header :no-subtitle="false">
					<template #title>
						<span class="text-black">{{ $t('category_section.title') }}</span>
					</template>
					<!-- <template #subtitle>
						Completely network impactful users whereas next-generation
						applications engage out thinking via tactical action.
					</template> -->
				</section-header>
				<div
					class="mt-10"
					v-if="categories.length"
				>
					<category-slides :categories="categories"></category-slides>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import CategorySlides from "~/components/layouts/CategorySlides.vue";
export default {
	name: "FoodCategories",
	components: {
		CategorySlides,
	},

	data() {
		return {
			categories: [],
		};
	},

	async mounted() {
		try {
			const resCategories = await this.$axios.$get("/categories");
			this.categories = resCategories.data;
		} catch (error) {
			console.error(error);
		}
	},
};
</script>

<style lang="scss" scoped>
.food-categories {
	// background-image: linear-gradient(
	// 		rgba(255, 255, 255, 0.2),
	// 		rgba(255, 255, 255, 0.2)
	// 	),
	// 	url("/images/food-categories.jpg");
	// background-size: cover;

}
.food-box {
    padding: 60px 0px 0px 0px;
    @media only screen and (max-width: 768px) {
      padding: 0px 0px 0px 0px;
    }
}
</style>
