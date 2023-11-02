<template>
  <div>
    <hero-section></hero-section>
    <food-categories></food-categories>
    <how-it-works></how-it-works>
    <popular-products></popular-products>
    <get-app></get-app>
    <buyer-reviews></buyer-reviews>

  <section class="discount-deals">

    <!-- <pre>
    {{ getDiscountedProducts }}
    </pre> -->

    <section-header :no-subtitle="false" class="pb-3">
					<template #title>
						<span class="text-black">{{ $t('discount_section.title') }}</span>
					</template>
      <template #subtitle>
        Completely network impactful users whereas next-generation
        applications engage out thinking via tactical action.
      </template>
    </section-header>
    <div class="container">
      <div class="row">
        <div class="discounted_products">


          <div class="discounted_product_item" v-for="(product,index) in getDiscountedProducts">
            <router-link :to="{ path: 'shop', query: { discounted: true }}">
                <div class="discounted_product_image">
                  <img :src="product.thumbnailMediaUrl">
                </div>
                <div class="discounted_product_content">
                  <h6>{{ product.discount }}% Discount</h6>
                </div>
              </router-link>
          </div>

          <!-- <div class="discounted_product_item">
            <div class="discounted_product_image">
              <img src="/images/discount/discount2.jpg">
           </div>
           <div class="discounted_product_content">
              <h6>{{ $t('discount_section.discount_10') }}</h6>
           </div>
          </div>

          <div class="discounted_product_item">
            <div class="discounted_product_image">
              <img src="/images/discount/discount3.jpg">
           </div>
           <div class="discounted_product_content">
              <h6>{{ $t('discount_section.discount_20') }}</h6>
           </div>
          </div>

          <div class="discounted_product_item">
            <div class="discounted_product_image">
              <img src="/images/discount/discount4.jpg">
           </div>
           <div class="discounted_product_content">
              <h6>{{ $t('discount_section.discount_20') }}</h6>
           </div>
          </div> -->

        </div>
      </div>
    </div>
  </section>
  </div>
</template>

<script>
import HeroSection from "~/components/layouts/HeroSection.vue";
import FoodCategories from "~/components/layouts/FoodCategories.vue";
import HowItWorks from "~/components/layouts/HowItWorks.vue";
import PopularProducts from "~/components/layouts/PopularProducts.vue";
import GetApp from "~/components/layouts/GetApp.vue";
import BuyerReviews from "~/components/layouts/BuyerReviews.vue";
import { mapGetters } from "vuex";

export default {
  components: {
    HeroSection,
    FoodCategories,
    HowItWorks,
    PopularProducts,
    GetApp,
    BuyerReviews
  },
  computed: {
    ...mapGetters({
      getDiscountedProducts: "config/getDiscountedProducts",
    }),
  },
  created() {
    // document.body.classList.remove('active');
    // let cookie = this.getCookie('lang');
    // this.$i18n.setLocale(cookie);
    // document.dir = this.$dir();
    // setTimeout(()=>{
    //   document.body.classList.add('active');
    // }, 500);
  },
  methods:{
    // getCookie(name) {
    //   const value = `; ${document.cookie}`;
    //   const parts = value.split(`; ${name}=`);
    //   if (parts.length === 2) return parts.pop().split(';').shift();
    // }
  },
};
</script>

<style>
body {
  color: #696969;
}
.hero h1 {
  font-size: 53px;
  line-height: 61px;
}
.discounted_products {
    display: grid;
    grid-template-columns: repeat(4,1fr);
    grid-template-rows: 207px 207px;
    column-gap: 16px;
    row-gap: 26px;
}
.discounted_product_content {
    position: absolute;
    top: 18px;
    left: 17px;
}
.discounted_product_item a{
    position: relative;
    height:100%;
}
.discounted_product_image{
  height:inherit;
}
.discounted_product_image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.discounted_product_item:first-child {
    grid-column: 1/3;
    grid-row: 1/3;
}
.discounted_product_item:nth-child(2) {
    grid-column: 3/5;
}
.discounted_product_content h5 {
    padding: 7px 18px;
    background: #fff;
    font-family: sans-serif;
    font-size: 14px;
    font-weight: 700;
}
section.discount-deals {
    background-image: url(/images/deals-bg.png);
    background-repeat: no-repeat;
    background-position: left top;
    padding: 60px 0px;
    background-size: 26%;

}
.section-header h3 span {
    position: relative;
}

.section-header h3 span:before,.section-header h3 span:after {
    position: absolute;
    content: '';
    background-image: url(/images/heading-img2.png);
    width: 50px;
    height: 50px;
    background-repeat: no-repeat;
}

.section-header h3 span:before {
    left: -52px;
}

.section-header h3 span:after {
    right: -52px;
    transform: rotate(90deg);
}
.discounted_product_content h6 {
    color: #000;
    background: #fff;
    padding: 5px 15px;
}
@media only screen and (max-width: 768px) {
    section.discount-deals{
      padding: 0px 0px;
    }
    .discounted_products{
      grid-template-columns: repeat(2,1fr);
    }
    .discounted_product_item:first-child{
        grid-column: unset;
        grid-row: unset;}

        .discounted_product_item:nth-child(2) {
          grid-column: unset;
      }

    }
</style>
