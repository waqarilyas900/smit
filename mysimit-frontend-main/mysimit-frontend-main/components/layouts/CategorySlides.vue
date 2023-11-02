<template>
  <div class="h-full mx-auto">
    <client-only>
      <!-- <vue-slick-carousel v-bind="categoriesSettings"> -->
        <div class="category-items">
        <div v-for="(category, i) in categories.slice(0,3)" :key="i" :class="'grid_item_'+i">

          <div class="food-item normal-food-item" v-if="i == 0" @click="searchByCategories(category.id)">
            <div class="food-thumbnail">
              <img :src="category.primaryMediaUrl" class="w-full h-full object-cover" alt="" />
            </div>
            <div class="food-content pt-2">
              <p href="#">{{`${category.name[$i18n.locale]}`}}</p>
            </div>
          </div>

          <div class="food-item normal-food-item" v-if="i == 1" @click="searchByCategories(category.id)">
            <div class="food-content pt-2">
              <p href="#">{{`${category.name[$i18n.locale]}`}}</p>
            </div>
            <div class="food-thumbnail">
              <img :src="category.primaryMediaUrl" class="w-full h-full object-cover" alt="" />
            </div>
          </div>

          <div class="food-item grid-food-item" v-if="i == 2" @click="searchByCategories(category.id)">
            <div class="food-thumbnail">
              <img :src="category.primaryMediaUrl" class="w-full h-full object-cover" alt="" />
            </div>
            <div class="food-content pt-2">
              <p href="#">{{`${category.name[$i18n.locale]}`}}</p>
            </div>
          </div>

        </div>
      </div>

        <!-- <template #prevArrow>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
          </svg>
        </template> -->

        <!-- <template #nextArrow>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
          </svg>
        </template> -->
      <!-- </vue-slick-carousel> -->
    </client-only>
  </div>
</template>

<script>
export default {
  name: "CategorySlides",
  props: {
    categories: {
      type: Array
    }
  },

  data() {
    return {
      categoriesSettings: {
        slidesToShow: 4,
        slidesToScroll: 4,
        centerMode: true,
        responsive: [
          {
            breakpoint: 1280,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2,
              centerMode: false
            }
          },

          {
            breakpoint: 450,
            settings: {
              slidesToShow: 1,
              initialSlide: 1,
              slidesToScroll: 1,
              centerMode: false
            }
          }
        ]
      }
    };
  },

  methods: {
    searchByCategories(id) {
      this.$router.push(`/shop?category=${id}`);
    }
  }
};
</script>

<style lang="scss">
.food-item {
  .food-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
    cursor: pointer;
    transition: all 0.3s ease;
    @media only screen and (max-width: 1024px) {
      // width: 150px;
      // height: 150px;
    }
  }

}


.slick-slide {
  text-align: center !important;
}

.slick-prev,
.slick-next {
  top: 35%;
  @apply text-primary-500 hover:text-primary-600;
}
.food-thumbnail img {
    height: 100%;
    width: 100%;
    object-fit: cover;
}
.category-items {
  display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-template-rows: 350px 350px;
    overflow: hidden;
    @media only screen and (max-width: 768px) {
      grid-template-columns: repeat(1, 1fr);
    }

}
.normal-food-item {
    display: flex;
    height: 100%;
}
.normal-food-item .food-thumbnail,.normal-food-item .food-content {
    width: 50%;
}
.normal-food-item .food-content {
    background: #000;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    font-size: 24px;
    text-transform: uppercase;
}
.normal-food-item {
    display: flex;
}
.normal-food-item .food-thumbnail,.normal-food-item .food-content {
    width: 50%;
}
.normal-food-item .food-content {
    background: #000;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    font-size: 24px;
    text-transform: uppercase;
    margin-top: 0;
}

.grid_item_2 {
    grid-column: 2/3;
    grid-row: 1/3;
    @media only screen and (max-width: 768px) {
      grid-column: unset;
      grid-row: 1;
    }
}

.grid-food-item .food-content {
    position: absolute !important;
    z-index: 9;
    top: 0;
    left: 0;
    background: 000;
    width: 100%;
    height: 100%;
    color: #fff;
    font-size: 24px;
    text-transform: uppercase;
    padding: 19px 25px;
}
.grid-food-item {
    position: relative;
}
.category-items > div {
  cursor: pointer;
}
.grid-food-item{
  height: 100%;
}
</style>
