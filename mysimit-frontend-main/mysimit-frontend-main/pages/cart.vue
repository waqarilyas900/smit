<template>

  <div class="container my-5 md:my-10 lg:my-20">
    <div class="lg:flex">
      <div class="lg:w-9/12 lg:mr-5">
        <h6 class="font-bold text-lg mb-3 text-black">{{ $t('cart.cartitems') }}</h6>
        <!-- cart item -->
        <div v-if="getTotalItem > 0" class="overflow-x-scroll md:overflow-hidden w-full"> 
          <table class="table-auto w-full border-collapse rounded-md min-w-xl overflow-hidden" style="min-width: 650px;">
            <thead>
              <tr class="bg-black text-white">
                <th class="w-1/6 px-4 py-3 hidden md:block">{{ $t('cart.product') }}</th>
                <th class="w-1/6 px-4 py-3">{{ $t('cart.name') }}</th>
                <th class="w-1/6 px-4 py-3">{{ $t('cart.addon') }}</th>
                <th class="w-1/6 px-4 py-3">{{ $t('cart.price') }}</th>
                <th class="w-1/6 px-4 py-3">{{ $t('cart.quantity') }}</th>
                <th class="w-1/6 px-4 py-3">{{ $t('cart.total') }}</th>
                <th class="w-1/6 px-4 py-3">{{ $t('cart.remove') }}</th>
              </tr>
            </thead>
            <tbody class=" divide-y border">
              <tr v-for="item in getCartItems" :key="item.id" class="">
                <td class="px-4 py-3 hidden md:flex justify-center p-3">
                  <div class="h-16 w-16">
                    <img :src="item.thumbnailMediaUrl" class="w-full h-full object-cover" alt="">
                  </div>
                </td>
                <td class="px-4 py-3 text-center font-semibold text-black"> {{`${item.rawTrans.name[$i18n.locale]}`}} </td>
                <td>
                  <div class="text-center text-black" v-if="item.addons" v-for="addon in item.selectedAddons" :key="addon.id">
                    <label>{{addon.option.name}}</label>
                  </div>
                </td>
                <td class="px-4 py-3 text-center text-black">{{currencyFormat(item.subtotalPrice)}} </td>
                <td class="px-4 py-3 text-black">

                  <div class="qty-input-wrap relative flex w-28 h-8">
                    <div class="btn-minus" style="font-size: 22px; padding-right: 10px;" @click="cartbuttonchange('minus', $event)">-</div>
                    <input id="input-number" type="number" @input="changedQuantity(item, $event)" :value="item.quantity" style="width: 120px;" class="font-semibold text-center text-gray-700 border border-gray-200 hover:text-black focus:text-black rounded-lg pl-16 cart-remove-input" />
                    <div class="btn-plus" style="font-size: 22px; padding-left: 10px;" @click="cartbuttonchange('plus', $event)">+</div>
                    <span class="flex items-center absolute px-4 h-full rounded-l-lg font-semibold text-white bg-black uppercase" style="margin-left: 20px;">{{item.unit.code}}</span>
                  </div>
                </td>
                <td class="px-4 py-3 text-center text-black"><span class="font-semibold">{{currencyFormat(item.subtotalPrice*item.quantity)}} </span> </td>
                <td class="px-4 py-3 text-center text-black">
                  <div @click.prevent="removeFromCart" class="text-gray-400 hover:text-black cursor-pointer flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- if no cart items -->
        <div v-else>
          <div class="flex flex-col items-center justify-center text-gray-300 h-44 bg-gray-50 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
              <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z" />
              <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd" />
            </svg>
            <p class="mt-2 text-gray-400">{{ $t('cart.empty') }}</p>
          </div>
        </div>
      </div>
      <div class="md:w-6/12 lg:w-3/12 mt-10 lg:mt-0">
        <h6 class="font-bold mb-3 ml-4 text-black text-lg">{{ $t('cart.cartdetails') }}</h6>

        <div class="bg-gray-200 p-3 rounded-md mb-7 hidden">
          <h6 class="flex justify-between">
            <span>
              Cart Total:
            </span>
            <span class="font-semibold">
              {{currencyFormat(totalPriceWithSelectedZone)}}
            </span>
          </h6>
        </div>

      <div class="cart-btn-main">
        <div class="delivery-btn">
          <input type="radio" v-model="delivery_type" name="group1" id="r1" value="delivery"/>
            <label for="r1">{{ $t('cart.delivery') }}</label>
        </div>
        <div class="pickup-btn">
          <input type="radio" v-model="delivery_type" value="pickup" name="group1" id="r2" />
            <label for="r2">{{ $t('cart.pickup') }}</label>
        </div>
      </div>
     <form class="cart-item">
        <div class="rounded-md my-2" v-if="delivery_type == 'delivery'">
            <div class="font-semibold flex items-center cart-detail-item justify-between px-3">
              <div>
                {{ $t('cart.delivery_charges') }}
              </div>
              <div>
                {{currencyFormat(zonePrice)}} 
              </div>
            </div>
            <div class="cart-multiselect">
            <multiselect class="mb-3 mt-2 border-gray-300"
							 v-model="selectedZone"
							  :custom-label="selectedLangLabel"
							  placeholder="Select Area"
                label="Select Area"
							  :show-labels="false"
							  :searchable="false"
							  :preselectFirst="true"
							  :allowEmpty="false"
							  :preserve-search="false"  
                @input="getZones"
							  :options="cities">
							  <template slot="option" slot-scope="props">
								  <div class="option__desc"><span class="option__title">{{ props.option.city[$i18n.locale] }}</span></div>
							</template>
					</multiselect>
          </div>
        </div>

        <div class="rounded-md my-2 hidden">
            <div class="font-semibold flex items-center cart-detail-item justify-between px-3">
              <div>
                Small Order Charges:
              </div>
              
              <div>{{currencyFormat(mini_order)}}
              </div>
            </div>
        </div>

        <div class="rounded-md my-2">
            <div class="font-semibold flex items-center cart-detail-item justify-between px-3">
              <div>
                {{ $t('cart.carttotal') }}
              </div>
              <div>
                {{currencyFormat(totalPrice)}}
              </div>
            </div>
        </div>

      </form>
        <!-- minimum amount notice -->
        <div v-if="minimumAmountNotice && delivery_type == 'delivery'" class="flex items-start mt-4 text-primary-500">
          <InfoIcon class="flex-none" />
          <span class="block ml-1">{{ $t('cart.more_error',{ price:getSelectedZone.zone.miniOrder }) }}</span>
        </div>

        <div class="px-3">
        <nuxt-link :to="{ path: 'checkout', query: { guest: true,type:delivery_type }}" :class="{'disabled' : minimumAmountNotice}" class="mt-3 bg-black text-white w-full inline-block py-3 px-3 text-center rounded-md">{{ $t('cart.guest') }}</nuxt-link>
        <nuxt-link :to="{ path: 'checkout', query: { type:delivery_type }}" :class="{'disabled' : minimumAmountNotice}" class="mt-3 bg-black text-white w-full inline-block py-3 px-3 text-center rounded-md">{{ $t('cart.Proceedtocheckout') }}</nuxt-link>
        </div>
      </div>
      </div>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";
import Multiselect from 'vue-multiselect'
export default {
  name: "Cart",
  components: {
    Multiselect
  },
  data(){
    return{
      selectedZone: null,
      delivery_type : localStorage.getItem('delivery_type') ? localStorage.getItem('delivery_type') : 'delivery',
      counter:0,
      totalPrice : 0
    }
  }, 
  computed: {
    ...mapGetters({
      getCartItems: "cart/getCartItems",
      getTotalItem: "cart/getTotalItem",
      getTotalPrice: "cart/getTotalPrice",
      getSelectedZone: "zone/getSelectedZone",
      cities: "config/getCities",
    }),
    
    totalPriceWithSelectedZone() {
      this.counter;
      this.zonePrice = 0
      this.mini_order = 0
      this.minimumAmountNotice = false;
    if (this.getSelectedZone && this.getSelectedZone.zone.price) {
      this.zonePrice = this.getSelectedZone.zone.price
      this.mini_order = this.getSelectedZone.zone.miniOrder
      const selectedZone = parseFloat(this.getSelectedZone.zone.price);
      const priceToAdd = this.priceToAdd();
      const totalPrice = selectedZone + priceToAdd;
      this.getTotalPrice = totalPrice.toFixed(2);
      if(totalPrice < this.mini_order && this.delivery_type == 'delivery')
      {
        this.minimumAmountNotice = true
      }
      console.log(totalPrice.toFixed(2));
      this.totalPrice = totalPrice.toFixed(2);
      return totalPrice.toFixed(2);
    }
    return 0;
  }

  },
  mounted(){
    // let cookie = this.getCookie('lang');
    // this.$i18n.setLocale(cookie);
    // document.dir = this.$dir();
    // document.html.classList.add('active');
  },
  watch: {

    delivery_type(newtype, oldType) {
      localStorage.setItem('delivery_type',newtype);
      let zonePrice = this.getSelectedZone.zone.price;
      let toTalPrice = this.totalPrice;
      if (newtype == 'pickup') {
        let priceNew = parseFloat(this.getTotalPrice).toFixed(2);
        this.totalPrice = priceNew;
      }else
      {
        let priceNew = parseFloat(this.getTotalPrice + zonePrice).toFixed(2);
        this.totalPrice = priceNew;
      }
    }
  },
  methods: {
    ...mapMutations({
      cartItemQuantity: "cart/CART_ITEM_QUANTITY"
    }),
    priceToAdd() {
      return this.getTotalPrice
    // Implement your logic to calculate the additional price
    // This method should return the additional price value
    // based on your business requirements
    },
    
    // getCookie(name) {
    //   const value = `; ${document.cookie}`;
    //   const parts = value.split(`; ${name}=`);
    //   if (parts.length === 2) return parts.pop().split(';').shift();
    // },
    removeFromCart() {
      this.$store.dispatch("cart/removeFromCart", this.item);
    },

    changedQuantity(item, e) {
      this.cartItemQuantity({
        item,
        val: e.target.value
      });
    },
    selectedLangLabel(option){
		  return `${option.city[this.$i18n.locale]}`;
	  },
    selectedZoneLabel(option){
      return `${option.name}`;
    },
    cartbuttonchange(type, eventt){
      //console.log(type);
      var event = new Event('input', {
            bubbles: true,
            cancelable: true,
        });
      if(type == 'plus'){
        let nextElement = eventt.target.previousElementSibling;
        nextElement.stepUp(1);
        nextElement.dispatchEvent(event);
      }else{
        let prevElement = eventt.target.nextElementSibling;
        // Check if the value is already at zero before decrementing
        if (prevElement.value > 1) {
          prevElement.stepDown(1);
          prevElement.dispatchEvent(event);
        }
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.disabled {
  pointer-events: none;
  opacity: 0.6;
}
.cart-detail-item {
  background: transparent;
    border: 1px solid #000;
    height: 46px;
    width: 100%;
    border-radius: 8px;
    color: #000;
}
.cart-btn-main input:checked + label {
  background: #000;
    color: #fff;
    border-radius: 7px;
}
.cart-btn-main > div {
  width: 50% !important;
}
.cart-btn-main {
  display: flex;
    border: 1px solid #000;
    border-radius: 8px;
}
.delivery-btn input , .pickup-btn input {
    display: none;
}
.delivery-btn input , .pickup-btn input {
    display: none;
}
.delivery-btn label , .pickup-btn label {
  /* border: 1px solid; */
  padding: 11px 42px;
    cursor: pointer;
    font-weight: 500;
    color: #000;
    border-radius: 8px;
    display: inline-block;
    width: 100%;
    text-align: center;
}
form.cart-item input[data-v-4c1c1dce]::placeholder {
    color: #373636;
    font-weight: 600;
}
.cart-remove-input::-webkit-outer-spin-button, .cart-remove-input::-webkit-inner-spin-button{
  -webkit-appearance: none;
  margin: 0;
}

[dir="rtl"] .qty-input-wrap{
  flex-direction: row-reverse;
}

</style>

