export default {
  ssr: false,
  target:'static',
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    //title: "My Simit",
    //titleTemplate: "My Simit | %s",
    htmlAttrs: {
      lang: "en"
    },
    meta: [{
      charset: "utf-8"
    },
    {
      name: "viewport",
      content: "width=device-width, initial-scale=1"
    },
    {
      hid: "description",
      name: "description",
      content: ""
    },
    {
      name: "format-detection",
      content: "telephone=no"
    }
    ],
    link: [{
      rel: "icon",
      type: "image/x-icon",
      href: "/favicon.ico"
    }]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    "@/assets/fonts/stylesheet.css",
    "@/assets/scss/app.scss",
    "@/assets/css/style.css",
    "@/assets/css/responsive.css",
  ],
  loading: {
    color: '#fff',
    height: '100vh',
    with:'100vw',
    background:'#fff',
    duration: 500
  },

  // Customize the progress-bar color
  loading: {
    color: "#1dbf73"
  },

  // Routes Global Configuration
  router: {
    middleware: ["clearValidationErrors"]
  },

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    "~/plugins/axios.js",
    "~/plugins/components.js",
    "~/plugins/mixins.js",
    "~/plugins/vue-pagination.js",
    '~/plugins/mixins/loading.js',
    '~/plugins/direction-control',
    {
      src: "~/plugins/vue-infinite-loading.js",
      ssr: false,
    },
    {
      src: "~/plugins/vue-splide",
      ssr: false
    },
    {
      src: "~/plugins/slick-slider",
      ssr: false
    },
    {
      src: "~/plugins/star-rating",
      ssr: false
    },
    {
      src: "~/plugins/vue-stripe.js",
      ssr: false
    },
    {
      src: "~/plugins/vue-social-sharing.js",
      ssr: false
    },
    { src: '~/plugins/vue-datepicker.js',ssr: false },
    
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: [
    '~/components',
    { path: '~/components/layouts', extensions: ['vue'] }
  ],

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/tailwindcss
    "@nuxtjs/tailwindcss"
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/axios
    "@nuxtjs/axios",
    "@nuxtjs/auth-next",
    '@nuxtjs/toast',
    'vue-sweetalert2/nuxt',
    'cookie-universal-nuxt',
    [
      'nuxt-i18n', {
        lazy:true,
        locales: [
          {
            code: 'en',
            name: 'EN',
            iso: 'en-US',
            dir: 'ltr',
            // flag : 'english-flag.jpg',
            flag : 'https://upload.wikimedia.org/wikipedia/commons/a/a5/Flag_of_the_United_Kingdom_%281-2%29.svg',
            file: 'en_US.json',
          },
          {
            code: 'ar',
            name: 'AR',
            iso: 'ar',
            dir: 'rtl',
            // flag : 'kuwait-flag.jpg',
            flag : 'https://www.countryflags.com/wp-content/uploads/kuwait-flag-png-large.png',
            file: 'ar.json',
          },
        ],
        strategy: 'prefix',
        detectBrowserLanguage: {
          useCookie: true,
          cookieKey: 'i18n_redirected',
          alwaysRedirect: true,
          fallbackLocale: 'ar',
          redirectOn: 'root',
        },
        loadLanguagesAsync: true,
        langDir: 'locales/',
        defaultLocale: 'en'
      },
    ]
  ],
  // i18n: {
  //   locales: ['en', 'fr', 'es', 'ar'],
  //   defaultLocale: 'en',
  //   vueI18n: {
  //     fallbackLocale: 'en',
  //     messages: {
  //       en: {
  //         welcome: 'Welcome'
  //       },
  //       fr: {
  //         welcome: 'Bienvenue'
  //       },
  //       es: {
  //         welcome: 'Bienvenido'
  //       },
  //       ar: {
  //         welcome: 'wlc'
  //       }
  //     }
  //   }
  // },

  // Nuxt toast config
  toast: {
    position: "top-right",
    duration: 2000,
  },

  // Public runtime config
  publicRuntimeConfig: {
    apiUrl: process.env.API_URL,
    stripePulishableKey: process.env.STRIPE_PUBLISHABLE_KEY,
  },

  // Private runtime config
  privateRuntimeConfig: {
    //
  },

  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    baseURL: process.env.API_URL
  },

  // Nuxt Auth Authentication strategies
  auth: {
    strategies: {
      local: {
        token: {
          property: "access_token"
        },
        user: {
          property: "data"
        },
        endpoints: {
          login: {
            url: "/customer/login",
            method: "post"
          },
          logout: {
            url: "/customer/logout",
            method: "post"
          },
          user: {
            url: "/customer/profile",
            method: "get"
          }
        }
      },
      rider: {
        scheme: "local",
        token: {
          property: "access_token"
        },
        user: {
          property: "data"
        },
        endpoints: {
          login: {
            url: "/rider/login",
            method: "post"
          },
          logout: {
            url: "/rider/logout",
            method: "post"
          },
          user: {
            url: "/rider/profile",
            method: "get"
          }
        }
      }
    }
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  },

  // Nuxt server configuration
  server: {
    https: false,
    //port: process.env.PORT || 9000, //default 3000
    //host: process.env.HOST || "0.0.0.0"
  }
};
