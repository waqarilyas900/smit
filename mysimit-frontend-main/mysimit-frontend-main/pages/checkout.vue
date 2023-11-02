<template>
  <div>
    <!-- top banner -->
      <the-banner v-if="getAboutPageHero && getAboutPageHero.primaryMediaUrl" :bannerLink="getAboutPageHero.primaryMediaUrl">
        <template #header>
          <span class="text-2xl md:text-4xl mt-5 sm:mt-0 inline-block text-black">{{ $t('checkout.title') }}</span>
        </template>
        <template #breadcrumbs>
          <li>
            <nuxt-link to="/" class="font-semibold text-black">{{ $t('checkout.breacrum_home') }}</nuxt-link>
          </li>
          <li><span class="mx-2 text-black">/</span></li>
          <li>
            <span class="font-semibold text-black">{{ $t('checkout.breacrum_cart') }}</span>
          </li>
          <li><span class="mx-2 text-black">/</span></li>
          <li>
            <span class="font-semibold text-black">{{ $t('checkout.breacrum_checkout') }}</span>
          </li>
        </template>
      </the-banner>

    <div class="container my-5 md:my-10 lg:my-20 font-medium text-black">
      <div class="mx-auto">
        <div class="lg:w-10/12 mx-auto">
          <h6 class="font-semibold text-xl mb-3">{{ $t('checkout.personalinformation')}}</h6>
          <div class="border p-3 md:p-5 rounded-lg">
            <form @submit.prevent="login">
              <!-- number found notice -->
              <div v-if="customerFound  && !$auth.loggedIn" class="flex items-center mb-4 text-green-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h6 class="text-md ml-1">{{ $t('checkout.number_error')}}</h6>
              </div>

              <!-- input fields -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
                <input-field @blur="searchCustomer" :disabled="$auth.loggedIn" :label="$t('checkout.phone')" required="" type="tel" v-model="formData.phone" :error="validationErrors.phone"></input-field>
                <input-field v-if="!customerFound " type="email" :disabled="$auth.loggedIn" :label="$t('checkout.email')" required v-model="formData.email" :error="validationErrors.email"></input-field>
                <input-field v-if="!customerFound" :disabled="$auth.loggedIn" :label="$t('checkout.firstname')" required v-model="formData.firstName" :error="validationErrors.firstName"></input-field>
                <input-field v-if="!customerFound && $route.query.type == 'delivery'" :disabled="$auth.loggedIn" label="Last Name" v-model="formData.lastName" :error="validationErrors.lastName"></input-field>
                <input-field v-if="!$auth.loggedIn && $route.query.type == 'delivery'" label="Password" type="password" v-model="formData.password" :required="!$route.query.guest" :error="validationErrors.password"></input-field>
                <input-field v-if="!$auth.loggedIn && !customerFound && $route.query.type == 'delivery'" label="Confirm Password" type="password" :required="!$route.query.guest" v-model="formData.password_confirmation"></input-field> 
              </div>

              <!-- button and links -->
              <!-- <nuxt-link to="/customer/forgot-password" class="text-primary-500">Forgot Password?</nuxt-link> -->
              <div v-if="customerFound && !$auth.loggedIn" class="flex items-center justify-between mt-2">
                <button-field label="Sign In" class="w-36 py-3"></button-field>
              </div>
            </form>
          </div>

          <!-- address -->
          <div class="mt-10 border p-3 md:p-5 rounded-lg">
            <form  @submit.prevent="saveAddress">
              <div class="lg:flex" v-if="$route.query.type == 'delivery'">
                <div class="lg:w-6/12 px-2">
                  <h6 class="text-xl font-semibold inline">{{ $t('checkout.deliveryaddress')}}</h6>

                  <div class="mt-3">

                    <label data-v-15341e8b="" class="flex mb-1 text-sm">
      {{$t('checkout.area')}}
    <span class="text-black-500">*</span></label>
    <!-- <select-field :label="$t('checkout.area')" required class="mb-3 hover:bg-sky-700" v-model="formData.billingAddress.country" :options="countries" :error="validationErrors['billingAddress.country']"></select-field> -->
              <multiselect class="mb-3 mt-1 border-gray-300"
							  v-model="formData.billingAddress.area"
							  :custom-label="selectedLangLabel"
							  placeholder="Select One"
                :disabled="true"
                :label="$t('checkout.area')"
							  :show-labels="false"
							  :searchable="false"
							  :preselectFirst="true"
							  :allowEmpty="false"
							  :preserve-search="false" 
							  :options="cities">
         
							  <!-- <template slot="option" slot-scope="props">
								  <div class="option__desc"><span class="option__title">{{ props.option.city[$i18n.locale] }}</span></div>
							 </template> -->
							</multiselect>
                    <input-field :label="$t('checkout.street')" required v-model="formData.billingAddress.street" :error="validationErrors['billingAddress.street']"></input-field>
                    <input-field :label="$t('checkout.house_building')" required v-model="formData.billingAddress.house" :error="validationErrors['billingAddress.house']"></input-field>
                  </div>
                </div>
                <div class="lg:w-6/12 px-2 mt-5 lg:mt-0">
                  <div class="my-3 md:mb-0 mt-10">
                    <input-field class="mt-2" :label="$t('checkout.block')" required v-model="formData.billingAddress.block" :error="validationErrors['billingAddress.block']"></input-field>
                    <input-field :label="$t('checkout.avanue')" required v-model="formData.billingAddress.avenue" :error="validationErrors['billingAddress.avenue']"></input-field>
                    <input-field :label="$t('checkout.apartment')" v-model="formData.billingAddress.apartment" :error="validationErrors['billingAddress.apartment']"></input-field>
                  </div>
                </div>
              </div>
              <div class="lg:full px-2 mt-5 lg:mt-0">
                <div class="my-3 md:mb-0">
                  <label>{{ $t('checkout.additional_detail')}}</label>
                  <text-field class="col-span-2 mt-2" v-model="formData.message" row="5"></text-field>
                </div>
              </div>
            </form>
          </div>

        <div class="schedule-order md:px-0 px-3">
          <div class="mt-10 rounded-lg font-bold text-black mb-3 flex">
            <div class="flex items-center mr-4">
              <label for="inline-checkbox" class=" text-sm font-medium text-gray-900 dark:text-gray-300  font-bold">{{ $t('checkout.schedule_your_order')}}</label>
              <input id="inline-checkbox" type="checkbox" value="" v-model="schedule" class="accent me-2 ms-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            </div>
          </div>
        <div class="flex flex-wrap w-full" v-if="schedule">
        <div class="max-w-sm relative md:w-6/12 w-full ms-2 me-2 md:pb-0 pb-3">
          <div class="absolute inset-y-0 left-0 pt-3 pl-3 pointer-events-none z-20">
            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
          </div>
          <div class="checkout-datepicker">
            <datepicker v-model="delivery_date" :value="date_today" :disabled-dates="disabledDates"></datepicker>
          </div>
          <!-- <input datepicker datepicker-autohide type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date"> -->
        </div>
          <div class="max-w-sm relative w-full">
            <div class="absolute inset-y-0 left-0 flex pl-3 items-center pointer-events-none z-20">
              <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="vue-timepicker-checkout">
              <vue-timepicker format="HH:mm:ss" v-model="delivery_time"></vue-timepicker>
            </div>
           </div>
          </div>
        </div>
        </div>

        <div class="lg:w-10/12 mx-auto md:flex mt-10 md:px-0 px-3">
          <!-- payment methods -->
            <div class="md:w-5/12 lg:w-6/12 mt-10 md:mt-0 font-bold text-black">
              <h6 class="font-semibold text-lg ">{{ $t('checkout.payment_method')}}</h6>

              <!-- alerts -->
              <div>
                <!-- Billing Address -->
                <div v-if="validationErrors && validationErrors.billingAddress" class="flex items-center bg-primary-50 text-primary-700 text-sm font-semibold px-4 py-3 mt-3" role="alert">
                  <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" />
                  </svg>
                  <p>{{ validationErrors.billingAddress[0] }}</p>
                </div>

                <!-- Shipping Address -->
                <div v-if="validationErrors && validationErrors.shippingAddress" class="flex items-center bg-primary-50 text-primary-700 text-sm font-semibold px-4 py-3 mt-3" role="alert">
                  <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" />
                  </svg>
                  <p>{{ validationErrors.shippingAddress[0] }}</p>
                </div>
              </div>


              <!-- paymemt options -->
              <div class="border rounded-lg py-5 px-4 mt-3 payment-buttons">
                <div class="flex items-center ">
                  <input  type="radio" value="COD" v-model="paymentMethod" id="disabled-radio-1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                  <label for="disabled-radio-1" class="ms-2 me-2 text-sm font-medium text-gray-400 text-gray-800">{{ $t('checkout.cod') }}</label>
              </div>
              
                <!-- <payment-method-button :buttons="paymentButtons" v-model="paymentMethod"></payment-method-button> -->
              </div>

              <!-- confirmation -->
              <!-- <div class="mt-3 mb-2" v-if="getTotalItem > 0">
                <checkbox-field tiny v-model="termsAgreed">
                  <template #label>
                    <span class="text-gray-800 pl-6">
                      I have read the
                      <nuxt-link to="/terms-and-conditions" class="font-semibold" :class="[termsAgreed ? 'text-gray-800' : 'text-primary-500']" target="_blank">terms and conditions</nuxt-link> of Sabziwalay and agree with them.
                    </span>
                  </template>
                </checkbox-field>
              </div> -->

              <!-- payment buttons -->
              <div class="mt-5" v-if="getTotalItem > 0">

                <!-- wallet -->
                <div v-if="paymentMethod === 'walletPay'">
                  <span v-if="$auth.loggedIn" class="font-semibold block">Wallet balance: {{ currencyFormat($auth.user.balance) }}</span>
                  <span v-if="!enoughWalletBalance" class="text-sm text-red-500">Not Enough Wallet Balance</span>
                  <button-field @click="handleWalletPayment" type="button" :class="[!(termsAgreed && enoughWalletBalance) ? 'disabledPayment' : '']" label="PLACE ORDER" class="bg-primary-500 text-white w-full py-3 mt-5"></button-field>
                </div>

                <!-- COD -->
                <button-field v-if="paymentMethod === 'COD'" @click="handleCODPayment" type="button" :class="[!termsAgreed ? 'disabledPayment' : '']" :label="$t('checkout.cehckout')" class="bg-primary-500 text-white w-full py-3"></button-field>
              </div>
            </div>

            <div class="font-bold md:p-5 mt-5">
              <checkbox-field tiny v-model="termsAgreed">
                <template #label>
                  <span class="text-gray-800 pl-6">
                    {{ $t('checkout.read1')}}
                    <nuxt-link to="/terms-and-conditions" class="font-semibold" :class="[termsAgreed ? 'text-gray-800' : 'text-primary-500']" target="_blank">{{ $t('checkout.read3')}}</nuxt-link> {{ $t('checkout.read2')}}
                  </span>
                </template>
              </checkbox-field>
              <!-- <stripe :label="$t('checkout.cehckout')" :class="{ disabledPayment: !termsAgreed || disablePayButton }" v-show="paymentMethod === 'stripe'" @onError="stripeError" @token-generated="handleStripePayment" @onSubmit="onStripeSubmit"></stripe> -->
            </div>
          <!-- <div class="md:w-7/12 lg:w-6/12 md:mr-10">
            <h6 class="font-semibold text-lg mb-3">Cart Totals</h6>
            <div class="border rounded-lg p-3 bg-gray-100">
              <div v-for="item in getCartItems" :key="item.id" class="flex justify-between">
                <h6 class="mb-3 pr-8">
                  {{ item.name }} ×
                  <span class="font-semibold">{{ item.quantity }}</span>
                </h6>
                <h6 class="font-semibold whitespace-nowrap">{{ currencyFormat(item.salePrice * item.quantity) }}</h6>
              </div>
              <div class="font-semibold border-t pt-2 flex justify-between">
                <h6>Order Total :</h6>
                <h6 class="whitespace-nowrap">{{ currencyFormat(getTotalPrice) }}</h6>
              </div>
            </div>
          </div> -->
          <span class="hidden">
            {{ totalPriceWithSelectedZone }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import Stripe from "~/components/Stripe.vue";
import Datepicker from 'vuejs-datepicker';
import VueTimepicker from 'vue2-timepicker/src'
import Multiselect from 'vue-multiselect'
import { startOfToday } from 'date-fns';

export default {
  name: "CheckoutPage",
  middleware: ["redirectRider"],
  components: {
    Stripe,
    Datepicker,
    VueTimepicker,
    Multiselect
  },
  data() {
    return {
      date_today:new Date(),
      delivery_time : null,
      schedule:false,
      formData: {
        firstName: "",
        lastName: "",
        email: "",
        phone: "",
        password: "",
        password_confirmation: "",
        billingAddress: {
          street: "",
          city: "",
          state: "",
          zipcode: "",
          country: "",
          block:"",
          house:"",
          avenue:"",
          apartment:""
        },
        shippingAddress: {
          street: "",
          city: "",
          state: "",
          zipcode: "",
          country: "",
          block:"",
          house:"",
          avenue:"",
          apartment:""
        }
      },
      customerFound: false,
      paymentMethod: "",
      termsAgreed: false,
      shippingIsSame: true,
      countries: [],
      disablePayButton: false
    };
  },

  computed: {
    ...mapGetters({
      validationErrors: "validation/validationErrors",
      getCartItems: "cart/getCartItems",
      getTotalItem: "cart/getTotalItem",
      getTotalPrice: "cart/getTotalPrice",
      getPaymentMethod: "config/getPaymentMethod",
      getSelectedZone: "zone/getSelectedZone",
      getAboutPageHero: "config/getAboutPageHero",
      cities: "config/getCities",
    }),
    disabledDates() {
      const today = startOfToday();
      return {
        to: today,
      };
    },
    totalPriceWithSelectedZone() {
    if (this.getSelectedZone && this.getSelectedZone.zone.price) {
      this.formData.billingAddress.country = this.getSelectedZone.zone.country
      this.formData.billingAddress.state = this.getSelectedZone.zone.state
      this.formData.shippingAddress.country = this.getSelectedZone.zone.country
      this.formData.shippingAddress.state = this.getSelectedZone.zone.state
      this.zonePrice = this.getSelectedZone.zone.price
      const selectedZone = parseFloat(this.getSelectedZone.zone.price);
      const priceToAdd = this.priceToAdd();
      const totalPrice = selectedZone + priceToAdd;
      this.getTotalPrice = totalPrice.toFixed(2);
      this.formData.billingAddress.area = this.getSelectedZone.zone;
      if(this.getSelectedZone.deliver_asap == false){
        this.schedule = true
      }
      if(this.getSelectedZone.delivery_date){
        this.delivery_date = this.getSelectedZone.delivery_date;
      }
      if(this.getSelectedZone.delivery_time){
        this.delivery_time = this.getSelectedZone.delivery_time;
      }
      return totalPrice.toFixed(2);
    }
    return 0; // Or any other default value if needed
  },
    orderItems() {
      return this.getCartItems.map(item => {
        return {
          productId: item.id,
          rate: item.actualPrice,
          quantity: item.quantity,
          amount: item.quantity * item.subtotalPrice,
          unitId: item.unit.id,
          addons: item.selectedAddons ? item.selectedAddons : null,
        };
      });
    },

    // checking if there is enough balance
    enoughWalletBalance() {
      return (
        this.$auth.loggedIn && this.$auth.user.balance >= this.getTotalPrice
      );
    },

    // returning payment buttons
    paymentButtons() {
      return [
        {
          src: "/images/icons/cod.png",
          id: "payment_cod",
          value: "Cash on delivery",
          name: "payment",
          show: true
        },
        {
          //src: "/images/icons/walletPay.png",
          id: "walletPay",
          value: "walletPay",
          name: "payment",
          show: this.$auth.loggedIn
        },
        {
          //src: "/images/icons/cart.png",
          id: "payment_stripe",
          value: "stripe",
          name: "payment",
          show: true
        }
      ];
    }
  },

  methods: {
    // check if the customer exists
    priceToAdd() {
      return this.getTotalPrice
    // Implement your logic to calculate the additional price
    // This method should return the additional price value
    // based on your business requirements
    },
    async searchCustomer(phone) {
      if (!this.$auth.loggedIn) {
        const resCustomer = await this.$axios.$post("/customers/check", {
          phone
        });
        if (resCustomer.data.exists) {
          this.customerFound = true;
        } else {
          this.customerFound = false;
        }
      }
    },
    selectedLangLabel(name){
		return `${name.city[this.$i18n.locale]}`;
	},

    // user login
    async login() {
      try {
        let resUser = await this.$auth.loginWith("local", {
          data: {
            phone: this.formData.phone,
            password: this.formData.password
          }
        });
        this.customerFound = false;
        this.setAuthData();
        this.$router.push("/checkout");
        this.$toast.success("Logged In Successfully.");
      } catch (error) {
        console.log(err);
        this.$toast.error("Credentials doesn't mached");
      }
    },

    setShipping() {
      if (this.shippingIsSame) {
        this.formData.shippingAddress.street = this.formData.billingAddress.street;
        this.formData.shippingAddress.city = this.formData.billingAddress.city = '';
        this.formData.shippingAddress.state = this.formData.billingAddress.state = '';
        this.formData.shippingAddress.zipcode = this.formData.billingAddress.zipcode = '';
        this.formData.shippingAddress.country = this.formData.billingAddress.country = '';

        this.formData.shippingAddress.house = this.formData.billingAddress.house;
        this.formData.shippingAddress.block = this.formData.billingAddress.block;
        this.formData.shippingAddress.avenue = this.formData.billingAddress.avenue;
        this.formData.shippingAddress.apartment = this.formData.billingAddress.apartment;
      }
    },

    // Handle stripe payment
    async handleStripePayment(token) {
      const payload = {
        token: token.id,
        guest : this.$route.query.guest ? true : false,
        type : this.$route.query.type,
        customerId: this.$auth.loggedIn ? this.$auth.user.id : null,
        note: "",
        paymentMethod: this.getPaymentMethod.STRIPE,
        subTotal: this.totalPriceWithSelectedZone,
        totalDiscount: 0,
        orderItems: this.orderItems,
        deliveryCharges : this.getSelectedZone.zone.price,
        zoneId: this.getSelectedZone.zone.id,
        ...this.formData
      };
      try {
        const resStripe = await this.$axios.$post("/orders", payload);
        this.$toast.success("Thank you for the order!");
        this.$store.dispatch("cart/resetCart");
        this.$router.push("/customer/profile/orders");
      } catch (error) {
        console.log(error);
      } finally {
        this.disablePayButton = false;
      }
    },
    // getCookie(name) {
    //   const value = `; ${document.cookie}`;
    //   const parts = value.split(`; ${name}=`);
    //   if (parts.length === 2) return parts.pop().split(';').shift();
    // },
    // Handle wallet payment
    async handleWalletPayment() {
      const payload = {
        customerId: this.$auth.loggedIn ? this.$auth.user.id : null,
        note: "",
        guest : this.$route.query.guest ? true : false,
        type : this.$route.query.type,
        paymentMethod: this.getPaymentMethod.WALLET,
        subTotal: this.totalPriceWithSelectedZone,
        totalDiscount: 0,
        deliveryCharges : this.getSelectedZone.zone.price,
        orderItems: this.orderItems,
        zoneId: this.getSelectedZone,
        ...this.formData
      };
      try {
        const resWallet = await this.$axios.$post("/orders", payload);
        this.$toast.success("Thank you for the order!");
        this.$store.dispatch("cart/resetCart");
        this.$router.push("/customer/profile/orders");
      } catch (error) {
        console.log(error);
      }
    },

    // Handle COD
    async handleCODPayment() {
      const payload = {
        customerId: this.$auth.loggedIn ? this.$auth.user.id : null,
        guest : this.$route.query.guest ? true : false,
        type : this.$route.query.type,
        note: "",
        paymentMethod: this.getPaymentMethod.COD,
        subTotal: this.totalPriceWithSelectedZone,
        totalDiscount: 0,
        deliveryCharges : this.getSelectedZone.zone.price,
        orderItems: this.orderItems,
        zoneId: this.getSelectedZone,
        ...this.formData
      };

      try {
        const resWallet = await this.$axios.$post("/orders", payload);
        this.$toast.success("Thank you for the order!");
        this.$store.dispatch("cart/resetCart");
        this.$router.push("/customer/profile/orders");
      } catch (error) {
        console.log(error);
      }
    },

    onStripeSubmit() {
      this.disablePayButton = true;
    },

    stripeError(err) {
      this.disablePayButton = false;
    },

    // set user
    setAuthData() {
      const user = this.$auth.user;
      if (user) {
        const newUser = {
          firstName: user.firstName,
          lastName: user.lastName,
          email: user.email,
          phone: user.phone,
          password: "",
          password_confirmation: "",

          billingAddress: {
            street: user.billingAddress?.street,
            city: user.billingAddress?.city,
            state: user.billingAddress?.state,
            zipcode: user.billingAddress?.zipcode,
            country: user.billingAddress?.country
          },

          shippingAddress: {
            street: user.shippingAddress?.street,
            city: user.shippingAddress?.city,
            state: user.shippingAddress?.state,
            zipcode: user.shippingAddress?.zipcode,
            country: user.shippingAddress?.country
          }
        };
        this.formData = { ...newUser };
      }
    }
  },

  // created
  created() {
    this.setAuthData();
    this.enoughWalletBalance;
    this.setShipping()
  },

  watch: {
    shippingIsSame() {
      this.setShipping();
    }
  },
  mounted(){
      console.log(this.totalPriceWithSelectedZone);
  },
  async fetch() {
    const resCountries = await this.$axios.$get("/countries");
    this.countries = resCountries;
  }
};
</script>

<style lang="scss" scoped>
.disabledPayment {
  pointer-events: none;
  opacity: 0.6;
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
<style scoped>
input[type="date"]::-webkit-calendar-picker-indicator {
  filter: invert(1);
}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>