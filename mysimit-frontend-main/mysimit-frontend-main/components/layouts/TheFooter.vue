<template>
  <footer  v-if="getWebsiteSettings">
    <hr class="md:pt-12 pt-6" />

    <div class="container">
    <div class="flex flex-wrap justify-between md:px-0 px-3">
      <div class="footer-item md:flex-1 md:pr-20">
          <h6 class="font-bold uppercase pb-3">{{ $t('footer.box1.title') }}</h6>
          <p>{{ $t('footer.box1.content') }}</p>
      </div>
      <div class="footer-item md:flex-1">
        <h6 class="font-bold uppercase pb-3">{{ $t('footer.box2.title') }}</h6>
        <ul>

          <li v-for="abc in $t('footer.box2.menu')">
            <a href="#">{{ abc.name }}</a>
          </li>
        </ul>
      </div>
      <div class="footer-item md:flex-1">
        <h6 class="font-bold uppercase pb-3">{{ $t('footer.box3.title') }}</h6>

         <ul>
          <li v-for="abc in $t('footer.box3.menu')">
            <a href="#">{{ abc.name }}</a>
          </li>
          </ul>
      </div>
      <div class="footer-item md:flex-1">
        <h6 class="font-bold uppercase pb-3">{{ $t('footer.box4.title4') }}</h6>
              <div class="flex items-center" v-if="getWebsiteSettings && getWebsiteSettings.data">
                <a :href="getWebsiteSettings.data.facebook" target="_blank" class="icon">
                  <Facebook class="" />
                </a>
                <a :href="getWebsiteSettings.data.twitter" target="_blank" class="icon ">
                  <Twitter class="" />
                </a>
                <a :href="getWebsiteSettings.data.instagram" target="_blank" class="icon">
                  <Instagram class="" />
                </a>
              </div>
      </div>
    </div>
  </div>


    <div class="bg-shape flex items-center justify-center">
      <div class="container">
        <div>
          <div class="footer-top flex flex-col items-center pt-20 pb-16 hidden">
            <!-- logo -->
            <div class="brand">
              <img class="h-16" :src="getWebsiteSettings.primaryMediaUrl" alt="">
            </div>
            <!-- social icons -->
            <div class="flex items-center justify-center mt-4" v-if="getWebsiteSettings && getWebsiteSettings.data">
              <a :href="getWebsiteSettings.data.facebook" target="_blank" class="icon">
                <Facebook class="h-5 w-5" />
              </a>
              <a :href="getWebsiteSettings.data.twitter" target="_blank" class="icon ">
                <Twitter class="h-5 w-5" />
              </a>
              <a :href="getWebsiteSettings.data.instagram" target="_blank" class="icon">
                <Instagram class="h-5 w-5" />
              </a>
            </div>
            <!-- footer-menu -->
            <div class="footer-menu mt-4">
              <ul class="flex flex-wrap justify-center">
                <li class="footer-menu-item m-1 px-4 uppercase text-white">
                  <nuxt-link to="/terms-and-conditions">terms & conditions</nuxt-link>
                </li>
                <li class="footer-menu-item m-1 px-4 uppercase text-white">
                  <nuxt-link to="/payment-and-refunds">payment & refunds</nuxt-link>
                </li>
                <li class="footer-menu-item m-1 px-4 uppercase text-white">
                  <nuxt-link to="/rider/become-rider">become a rider</nuxt-link>
                </li>
              </ul>
            </div>
          </div>
          <div class="footer-bottom border-t">
            <p class="text-center my-3 sm:my-7 text-white" style="color: black;">
              © 2023,
              <span v-if="getWebsiteSettings && getWebsiteSettings.data">
                <nuxt-link to='/'>{{getWebsiteSettings.data.name}}</nuxt-link>
              </span>
              || Rights Reserved
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "TheFooter",
  computed: {
    ...mapGetters({
      getWebsiteSettings: "config/getWebsiteSettings"
    })
  }
};
</script>

<style lang="scss" scoped>
// .bg-shape {
//   background-image: url("/images/bg-shape.png");
//   background-repeat: no-repeat;
//   background-size: cover;
// }

.icon {
  cursor: pointer;
  position: relative;
  width: 20px;
  height: 20px;
  text-align: center;
  padding: 0;
  margin-right:13px;
  @apply flex items-center rounded-full;
}
.footer-item svg {
    height: auto !important;
}

.icon:hover {
  transform: translateY(-4px);
}
</style>
