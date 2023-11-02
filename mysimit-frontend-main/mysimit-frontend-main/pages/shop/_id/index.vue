<template>
  <div v-if="product">
    <!-- banner -->
    <!-- <the-banner class="hidden sm:block" bannerLink="/images/food-categories2.jpg">
      <template #header>{{product.name}}</template>
      <template #breadcrumbs>
        <li>
          <nuxt-link to="/" class="font-semibold">Home</nuxt-link>
        </li>
        <li><span class="mx-2">-</span></li>
        <li>
          <nuxt-link to="/shop" class="font-semibold">Shop</nuxt-link>
        </li>
        <li><span class="mx-2">-</span></li>
        <li>
          <span class="font-semibold text-primary-500">{{product.name}}</span>
        </li>
      </template>
    </the-banner> -->
    
    <!-- product -->
    <div class="container lg:flex my-5 md:my-10">
      <!-- left side -->
      <div class="lg:w-full ">
        <div class="lg:flex">
          <!-- Image -->
          <div class="lg:w-5/12">
            <client-only>
              <single-product-slides :images="product.mediaCollection">
              </single-product-slides>
            </client-only>

          </div>

          <!-- product details -->
          <div class="lg:w-7/12 mt-6 lg:mt-3 lg:px-6">
            <!-- rating -->
            <div class="rating flex items-center hidden">
              <!-- rating component -->
              <client-only>
                <star-rating :rating="product.averageRatings" :read-only="true" :star-size="12" :padding="4" :increment="0.5" :show-rating="false" active-color="#F59E0B" :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]" style="margin-top: -2px"></star-rating>
              </client-only>

              <span class="text-gray-700 font-bold text-xs ml-1 mt-1 hidden">
                <span v-if="product.ratings && product.ratings.length">( {{product.ratings.length}} Reviews )</span>
                <span v-else>( 0 Reviews )</span>
              </span>
            </div>

            <h6 class="font-bold text-xl mt-2">{{`${product.rawTrans.name[$i18n.locale]}`}}</h6>

            <!-- price -->
            <div class="mt-2 font-bold text-2xl">
              <!-- <span class="text-primary-500">{{currencyFormat(product.salePrice)}}</span> -->
              <span class="text-primary-500" ref="priceSelector" v-if="pPrice">{{currencyFormat(pPrice)}}</span>
            </div>
           
            <div v-if="product.addons">
              <div v-for="addon in product.addons" :key="addon.id" v-if="addon.isMultiple == 0">
                <h4 class="mt-5 text-md">{{addon.name}}</h4>
                <div class="flex border-b border-t py-3" v-if="addon.options">
                  <div class="flex items-center mr-4" v-for="option in addon.options" :key="option.id">
                      <input :id="option.id"  type="radio" v-model="addonOption" :value="option.price" name="inline-radio-group" @change="updatePrice_radio(addon.id,option)" class="accent w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                      <label :for="option.id" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ option.name }}</label>
                  </div>
                </div>
              </div>
            
              <div v-else>
                <h4 class="mt-5 text-md">{{addon.name}}</h4>
                <div class="flex border-b border-t py-3" v-if="addon.options">
                  <div class="flex items-center mr-4" v-for="(option,index) in addon.options" :key="option.id">
                    <input :id="option.id" type="checkbox" :value="option.price" v-model="selectedOptions[index]" @change="updatePrice($event,addon.id,option)" class="accent w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label :for="option.id" class="ms-2 me-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ option.name }}</label>
                  </div>
                </div>
              </div>
            </div>
            <div v-if="product.id == 97">
            <h4 class="mt-5 text-md">{{ $t('productDetail.flavour') }}</h4>
            <div class="flex border-b border-t py-3">
            <div class="flex items-center mr-4">
                <input id="inline-radio" type="radio" value="" name="inline-radio-group" class="accent w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="inline-radio" class="ms-2 mr-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $t('productDetail.choaclate') }}</label>
            </div>
            <div class="flex items-center mr-4">
                <input id="inline-2-radio" type="radio" value="" name="inline-radio-group" class="accent w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="inline-2-radio" class="ms-2 mr-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $t('productDetail.strawberry') }}</label>
            </div>
            <div class="flex items-center mr-4">
                <input id="inline-2-radio" checked type="radio" value="" name="inline-radio-group" class="accent w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="inline-2-radio" class="ms-2 me-2 mr-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $t('productDetail.vanilla') }}</label>
            </div>
            </div>
            </div>
            <div v-if="product.id == 98">
            <h4 class="mt-5 text-md">{{ $t('productDetail.flavour') }}</h4>
            <div class="flex border-b border-t py-3">
            <div class="flex items-center mr-4">
                <input id="inline-checkbox" type="checkbox" value="" class="accent w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="inline-checkbox" class="ms-2 me-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $t('productDetail.choaclate') }}</label>
            </div>
            <div class="flex items-center mr-4">
                <input id="inline-2-checkbox" type="checkbox" value="" class="accent w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="inline-2-checkbox" class="ms-2 me-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $t('productDetail.strawberry') }}</label>
            </div>
            <div class="flex items-center mr-4">
                <input checked id="inline-checked-checkbox" type="checkbox" value="" class="accent w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="inline-checked-checkbox" class="ms-2 me-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $t('productDetail.vanilla') }}</label>
            </div>
            </div>

            </div>
            <div v-if="product.id == 99">
            <h4 class="mt-5 text-md">{{ $t('productDetail.flavour') }}</h4>
            <div class="flex border-b border-t py-3">
            <div class="flex items-center mr-4">
                <input id="inline-checkbox" type="checkbox" value="" class="accent w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="inline-checkbox" class="ms-2 me-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $t('productDetail.choaclate') }}</label>
            </div>
            <div class="flex items-center mr-4">
                <input id="inline-2-checkbox" type="checkbox" value="" class="accent w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="inline-2-checkbox" class="ms-2 me-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $t('productDetail.strawberry') }}</label>
            </div>
            <div class="flex items-center mr-4">
                <input checked id="inline-checked-checkbox" type="checkbox" value="" class="accent w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="inline-checked-checkbox" class="ms-2 me-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $t('productDetail.vanilla') }}</label>
            </div>
            </div>
            <h4 class="mt-5 text-md">{{ $t('productDetail.wrapping') }}</h4>
            <div class="flex border-b border-t py-3">
            <div class="flex items-center mr-4">
                <input id="inline-radio" type="radio" value="" name="inline-radio-group" class="accent w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="inline-radio" class="ms-2 me-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $t('productDetail.yes') }}</label>
            </div>
            <div class="flex items-center mr-4">
                <input id="inline-2-radio" type="radio" checked value="" name="inline-radio-group" class="accent w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="inline-2-radio" class="ms-2 me-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $t('productDetail.no') }}</label>
            </div>

            </div>
            </div>
            <!-- tags -->
            <div class="border-t border-b border-gray-200 py-4 mt-5 hidden">
              <h6 class="text-sm ">Tags:
                <span class="ms-2 font-semibold">
                  {{ product.tags.map(tag => tag.name).join(', ') }}
                </span>
              </h6>
            </div>

            <!-- quantity and add to cart button  -->
            <div class="mt-5 flex">
              <div class="w-28 h-12 hidden">
                <div class="relative flex flex-row w-full h-12">
                  <input type="number" value="1" class="w-full font-semibold text-center text-gray-700 border border-gray-200 hover:text-black focus:text-black rounded-lg pl-16" />
                  <span class="absolute py-3 px-4 rounded-l-lg font-semibold text-gray-700 bg-gray-200 uppercase">{{product.unit.code}}</span>
                </div>
              </div>
              <button-field :disabled="!selectedZone" type="button" @click="addToCart" :label= "$t('productDetail.addtocart')"  ></button-field>
            </div>
            <h4 v-if="product.description" class="border-b mb-3 mt-10 pb-3 text-xl">{{ $t('productDetail.description') }}</h4>
            <p v-if="product.description" class="mb-3 text-gray-500 dark:text-gray-400">{{`${product.rawTrans.description[$i18n.locale]}`}}</p>
            <p v-if="!selectedZone" class="mt-2 text-sm text-primary-500 font-semibold cursor-pointer">Please select a zone first to check product availability!</p>

            <!-- wishlist -->
            <div class="flex items-center text-sm mt-5 hidden">
              <wishlist-button :favourite="product.isFavourite" @click="toggleWishlist"></wishlist-button>
              <span v-if="product.isFavourite == false" class="ml-1">Add to Wishlist</span>
              <span v-else class="ml-1">Added to Wishlist</span>
            </div>

            <!-- share -->
            <div class="border-t border-b border-gray-200 py-4 mt-5 flex hidden">
              <h6 class="text-sm">Share:</h6>
              <div class="flex items-center">
                <client-only>
                  <social-share :link="shareLink" :sharingProduct="product" :title="product.name"></social-share>
                </client-only>
              </div>
            </div>

          </div>
        </div>

        <!-- description and reviews -->
        <div class="mt-12 lg:pr-6 hidden">
          <!-- nav -->
          <div class="flex border-b-2 border-gray-200">
            <h6 class="mr-7 pb-4 font-semibold cursor-pointer" :class="{'active' : activeComponent == 'product-description'}" @click="activeComponent = 'product-description'">Description</h6>
            <!-- <h6 class="mr-7 pb-4 font-semibold cursor-pointer" :class="{'active' : activeComponent == 'product-reviews'}" @click="activeComponent = 'product-reviews'">Reviews</h6> -->
          </div>
          <!-- body -->
          <div class="my-8">
            <div v-if="activeComponent == 'product-description'">
              <product-description :description="product.description"></product-description>
            </div>
            <div v-else>
              <product-reviews :reviews="product.ratings" :averageRatings="product.averageRatings"></product-reviews>
            </div>
          </div>
        </div>
      </div>

      <!-- Right side -->

    </div>
    <div class="container lg:flex mb-5 md:mb-10" v-if="relatedProducts">
      <div class="lg:w-full ">

<!-- Related products -->
<div class=" mt-4 lg:mt-0">
  <h6 class="font-semibold mb-2 text-xl text-center mb-5">{{ $t('productDetail.relatedProduct') }}</h6>
  <!-- <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-8 lg:pr-5"> -->
  <div class="flex gap-8 lg:pr-5 products-wrapper justify-center">
    <shop-product v-for="(product, i) in relatedProducts" :key="i" :product="product"></shop-product>
  </div>
</div>
<!-- banner -->
<!-- <div class="mt-5">
  <client-only>
    <shop-banner-slides :banners="banners"></shop-banner-slides>
  </client-only>
</div> -->

</div>
    </div>

  </div>
</template>

<script>
import ShopProduct from "~/components/layouts/ShopProduct.vue";
import ProductDescription from "~/components/layouts/ProductDescription.vue";
import ProductReviews from "~/components/layouts/ProductReviews.vue";
import SingleProductSlides from "~/components/layouts/SingleProductSlides.vue";
import ShopBannerSlides from "~/components/layouts/ShopBannerSlides.vue";
import { mapGetters } from "vuex";

export default {
  name: "ProductSinglePage",

  components: {
    SingleProductSlides,
    ShopProduct,
    ProductDescription,
    ProductReviews,
    ShopBannerSlides
  },

  data() {
    return {
      product: null,
      selectedAddons:[],
      subtotalPrice: 0,
      addon:null,
      relatedProducts: null,
      pPrice: null,
      selectedOptions: [],
      addonOption: null,
      activeComponent: "product-description",
      banners: [
        {
          url: "/images/banners/01.jpg"
        },
        {
          url: "/images/banners/02.jpg"
        }
      ]
    };
  },

  methods: {
    // add to cart method
    addToCart() {
      let cart_item_id = Date.now();
      this.product.cart_item_id = cart_item_id;
      if(this.subtotalPrice > 0)
      {
        this.product.subtotalPrice = this.subtotalPrice;
      }
      else
      {
        this.product.subtotalPrice = this.product.actualPrice
      }
      this.$store.dispatch("cart/addToCart", this.product);
      this.selectedAddons = [];
      this.selectedOptions = [];
      this.addonOption = null;
      this.pPrice = this.product.actualPrice;
    },

    // toggling wishlist
    async toggleWishlist() {
      if (this.$auth.loggedIn) {
        this.product.isFavourite = !this.product.isFavourite;
        let res = await this.$axios.$post(
          `/customer/favourites/${this.$route.params.id}/toggle`
        );
        this.product.isFavourite = res.isFavourite;
      } else {
        this.$router.push("/login");
      }
    },

    updatePrice(event,addonId,option) {
      if(event.currentTarget.checked){
        this.selectedAddons.push({
            addonId,
            option
          });
      }else
      {
        let inx = this.selectedAddons.findIndex(element => element.option.id === option.id);
        console.log(inx);
        if(inx > -1){
          this.selectedAddons.splice(inx, 1);
        }
      }
    },

    updatePrice_radio(addonId,option){
      if(option.price != 0){
        this.selectedAddons.push({
          addonId,
          option
        });
      } else{
        let inx = this.selectedAddons.findIndex(Option => Option.addonId === addonId);
        if(inx > -1){
          this.selectedAddons.splice(inx, 1);
        }
      }
    }
    
    
    // getCookie(name) {
    //   const value = `; ${document.cookie}`;
    //   const parts = value.split(`; ${name}=`);
    //   if (parts.length === 2) return parts.pop().split(';').shift();
    // }
  },
  watch: {
    selectedAddons(alloptions, oldQuestion) {
      //console.log(alloptions);
      //return false;
      if(alloptions.length > 0){
        let price = this.product.actualPrice ? this.product.actualPrice : 0;
        alloptions.forEach(item => {
          price += parseInt(item.option.price);
        })
        // this.$refs.priceSelector.innerText  = price;
         this.pPrice = price;
         this.subtotalPrice = price;
      }else
      {
        //this.$refs.priceSelector.innerText  = this.product.actualPrice;
        this.pPrice = this.product.actualPrice;
        this.subtotalPrice = this.product.actualPrice;
      }
      console.log(alloptions);
      this.product.selectedAddons = alloptions;
    }
  },
  // mounted() {
  //   let cookie = this.getCookie('lang');
  //   this.$i18n.setLocale(cookie);
  //   document.dir = this.$dir();
  // },
  computed: {
    ...mapGetters({
      selectedZone: "zone/getSelectedZone"
    }),

    // genarate link for sharing product
    shareLink() {
      return `${process.env.APP_URL}shop/${this.$route.params.id}`;
    }
  },

  async fetch() {
    if (this.$auth.loggedIn) {
      // fetching product
      let resProduct = await this.$axios.$get(
        `/products/${this.$route.params.id}/auth`
      );
      this.product = resProduct.data;
      this.relatedProducts = resProduct.relatedProducts;
    } else {
      // fetching product
      let resProduct = await this.$axios.$get(
        `/products/${this.$route.params.id}`
      );
      this.product = resProduct.data;
      this.relatedProducts = resProduct.relatedProducts;
      this.pPrice = this.product.actualPrice;
      // console.log(this.relatedProducts)
    }
  }
};
</script>

<style lang="scss" scoped>
.active {
  margin-bottom: -2px;
  @apply border-b-2 border-black text-black;
}
.accent{
  accent-color: black;
}
.accent:focus{
  outline: 0 !important;
  box-shadow: none;
  border: none;
}
</style>
