<template>
  <div>
    <!-- top banner -->
    <the-banner v-if="getContactPageHero" :bannerLink="getContactPageHero.primaryMediaUrl">
      <template #header>{{`${getContactPageHero.data[$i18n.locale].title}`}}</template>
      <template #breadcrumbs>
        <li>
          <nuxt-link to="/" class="font-semibold text-black">{{ $t('contactus.breacrum_home') }}</nuxt-link>
        </li>
        <li><span class="mx-2 text-black">/</span></li>
        <li>
          <span class="font-semibold text-black">{{ $t('contactus.breacrum_contact_us') }}</span>
        </li>
      </template>
    </the-banner>

    <!-- details -->
    <div class="py-5 md:py-10 lg:py-20">
      <div class="container ">
        <div class="information rounded-lg w-full lg:flex text-gray-700 py-10 px-8">
          <!-- information -->
          <div class="lg:w-1/2" v-if="getWebsiteSettings && getWebsiteSettings.data">
            <h6 class="font-semibold text-xl font-bold">{{ $t('contactus.contact_information') }}</h6>
            <!-- 1st -->
            <div class="flex items-start mt-8 w-full">
              <HomeIcon class="h-12 w-12 text-black flex-none" />
              <div class="ml-3 md:w-3/5">
                <h6 class="uppercase font-semibold">{{ $t('contactus.office_address') }}</h6>
                <p class="text-gray-600 mt-1">
                  {{getWebsiteSettings.data.street}},
                  {{getWebsiteSettings.data.country}}
                </p>
              </div>
            </div>
            <!-- 2nd -->
            <div class="flex items-start mt-5 w-full">
              <PhoneIcon class="h-12 w-12 text-black flex-none" />
              <div class="ml-3 md:w-3/5">
                <h6 class="uppercase font-semibold">{{ $t('contactus.phone') }}</h6>
                <p class="text-gray-600 mt-1">
                  {{getWebsiteSettings.data.phone}}
                </p>
              </div>
            </div>
            <!-- 3rd -->
            <div class="flex items-start mt-5 w-full">
              <EmailIcon class="h-12 w-12 text-black flex-none" />
              <div class="ml-3 md:w-3/5">
                <h6 class="uppercase font-semibold">{{ $t('contactus.email_address') }}</h6>
                <p class="text-gray-600 mt-1">{{getWebsiteSettings.data.email}}</p>
              </div>
            </div>
          </div>
          <!-- form -->
          <div class="lg:w-1/2 mt-10 lg:mt-0">
            <h6 class="font-semibold text-xl font-bold">{{ $t('contactus.send_us_a_message') }}</h6>
            <div class="mt-8 grid grid-cols-2 gap-4">
              <input-field class="col-span-2 md:col-span-1" v-model="formData.name" :placeholder="$t('placeholder.your_name')"></input-field>
              <input-field class="col-span-2 md:col-span-1" v-model="formData.email" :placeholder=" $t('placeholder.your_email')"></input-field>
              <input-field class="col-span-2" v-model="formData.subject" :placeholder="$t('placeholder.subject') "></input-field>
              <text-field class="col-span-2" :placeholder="$t('placeholder.your_query') " v-model="formData.message" row="5"></text-field>
              <button-field type="button" @click="submit" class="w-44 whitespace-nowrap uppercase py-3 bg-black" :label=" $t('placeholder.submit_button') "></button-field>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "Contact",
  data() {
    return {
      formData: {
        name: "",
        email: "",
        subject: "",
        message: ""
      }
    };
  },
  computed: {
    ...mapGetters({
      getContactPageHero: "config/getContactPageHero",
      getWebsiteSettings: "config/getWebsiteSettings"
    })
  },

  methods: {
    async submit() {
      let query = await this.$axios.$post("/contacts", this.formData);
      this.formData = {};
    },
    // getCookie(name) {
    //   const value = `; ${document.cookie}`;
    //   const parts = value.split(`; ${name}=`);
    //   if (parts.length === 2) return parts.pop().split(';').shift();
    // }
  },
  // mounted() {
  //   let cookie = this.getCookie('lang');
  //   this.$i18n.setLocale(cookie);
  //   document.dir = this.$dir();
  // },
};
</script>

<style lang="scss" scoped>
.information {
  background-image: url("/images/contact-bg.png");
  background-repeat: no-repeat;
  background-position: left bottom;
  background-size: 400px;
}
.focus\:border-primary-500:focus {
    --tw-border-opacity: 1;
    border-color: unset !important;
}
</style>
