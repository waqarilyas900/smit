<template>
  <div>
    <div class="banner flex items-center justify-center sm:h-52 md:h-72 lg:h-96" :style="{ backgroundImage: bannerImage }">
      <div class="banner__text text-center">
        <p class="font-bold text-white text-2xl md:text-4xl mt-5 sm:mt-0 inline-block">
          <slot name="header">Page Name</slot>
        </p>

        <div class="py-3 px-5 text-white">
          <ul class="flex justify-center">
            <slot name="breadcrumbs">
              <li>
                <nuxt-link to="/" class="font-semibold">Home</nuxt-link>
              </li>
              <li><span class="mx-2">-</span></li>
              <li>
                <nuxt-link to="#" class="font-semibold text-primary-500">page name</nuxt-link>
              </li>
            </slot>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "banner",
  props: {
    bannerLink: {
      type: String,
      default: "/images/chefs/chef.jpg"
    }
  },
  computed: {
    bannerImage() {
      if (this.bannerLink) {
        return `linear-gradient(rgb(0 0 0 / 1%), rgb(6 6 6 / 0%)),
          url(${this.bannerLink})`;
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.banner {
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
}
.banner {
    height: 351px;
}
</style>
