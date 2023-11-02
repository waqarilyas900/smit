<template>
	<div>
    <head v-if="siteData">
      <!-- <title>{{ siteData}}</title> -->
      <!-- <meta  name="description" :content="siteData.data.description" /> -->
      <!-- Other meta tags -->
    </head>
		<the-header></the-header>
		<div class="lg:pt-20 pt-16">

			<nuxt></nuxt>
			<zone-modal></zone-modal>
		</div>
    <pre v-if="siteData">
      {{ siteData.name }}
    </pre>
		<the-footer></the-footer>
	</div>
</template>

<script>
import TheHeader from "@/components/layouts/TheHeader.vue";
import TheFooter from "@/components/layouts/TheFooter.vue";
import ZoneModal from "@/components/shared/ZoneModal.vue";
import { mapGetters } from "vuex";

export default {
  name: "default-layout",
  middleware: ["redirectRider"],
    head() {
        return {
           title: this.siteName,
            meta: [
              {
                hid: 'description',
                name: 'description',
                content: this.siteDescription
              }
            ],
            htmlAttrs: {
                lang: this.$i18n.locale,
                dir: this.$i18n.locale == 'en' ? 'ltr' : 'rtl',
            }
        }
    },
    computed: {
    ...mapGetters({
      siteName: "config/getWebsiteName",
      siteDescription : "config/getWebsiteDescription"
    })
  },  
  components: {
    TheHeader,
    TheFooter,
    ZoneModal
  },
  async mounted() {
    await this.$store.dispatch("cart/setCart");
    await this.$store.dispatch("config/setConfig", { url: "/config" });
  },
};
</script>

<style lang="scss">
.btn {
  @apply inline-flex bg-white items-center px-4 py-2 shadow-md border border-transparent rounded-md text-sm transition;
}

.btn-primary {
  @apply bg-primary-500 text-white;
}

.btn-primary:hover {
  @apply bg-primary-600;
}

.btn-primary:focus {
  @apply bg-primary-700 outline-none ring-transparent;
}

.btn-success {
  @apply bg-green-500 text-white;
}

.btn-success:hover {
  @apply bg-green-600;
}

.btn-success:focus {
  @apply outline-none ring ring-green-300 border-green-700;
}

.btn-info {
  @apply bg-blue-500 text-white;
}

.btn-info:hover {
  @apply bg-blue-600;
}

.btn-info:focus {
  @apply outline-none ring ring-blue-300 border-blue-700;
}

.btn-purple {
  @apply bg-purple-500 text-white;
}

.btn-purple:hover {
  @apply bg-purple-600;
}

.btn-purple:focus {
  @apply outline-none ring ring-purple-300 border-purple-700;
}

.btn-danger {
  @apply bg-red-500 text-white;
}

.btn-danger:hover {
  @apply bg-red-600;
}

.btn-danger:focus {
  @apply outline-none ring ring-red-300 border-red-700;
}

.btn-secondary {
  @apply bg-secondary-500 text-white;
}

.btn-secondary:hover {
  @apply bg-secondary-400;
}

.btn-secondary:focus {
  @apply outline-none ring ring-secondary-300 border-secondary-700;
}

.btn-light {
  @apply bg-gray-200 text-gray-800 shadow-none;
}

.btn-light:hover {
  @apply bg-gray-300;
}

.btn-light:focus {
  @apply outline-none ring ring-gray-100 border-gray-400;
}
</style>
