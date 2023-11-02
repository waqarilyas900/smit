<template>
	<header class="fixed w-full">
		<nav
			class="md:bg-white bg-black px-2 shadow for-mobile">
			<div class="container flex flex-col text-center">
				<!-- logo -->
				<div
						class="brand mx-auto hidden md:block"
						v-if="getWebsiteSettings && getWebsiteSettings.primaryMediaUrl"
					>
						<nuxt-link
							to="/"
							class="inline-flex items-end"
						>
							<img
								class="h-10"
								:src="getWebsiteSettings.primaryMediaUrl"
								alt=""
							>

						</nuxt-link>

					</div>
					<div v-else>
						<nuxt-link
							to="/"
							class="inline-flex items-end"
						>
							<h1 class="text-gray-900 font-semibold text-2xl ml-2">Logo</h1>
						</nuxt-link>
				</div>

				<div class="flex h-full items-center justify-between relative">
				<!-- nav items -->
				<div class="navigation hidden md:flex items-center h-full pt-4 mx-auto">

					<!-- links -->
					<ul class="flex items-center h-full px-7">
						<li class="nav-item">
								<nuxt-link
									to="/"
									class="nav-link"
								>{{ $t('header.menu.home') }}</nuxt-link>
							</li>
						<li class="nav-item">
								<nuxt-link
									to="/about"
									class="nav-link"
								>{{ $t('header.menu.about') }}</nuxt-link>
							</li>
						<li class="nav-item">
							<nuxt-link
								to="/shop"
								class="nav-link"
							>{{ $t('header.menu.product') }}</nuxt-link>
						</li>
						<li class="nav-item">
							<nuxt-link
								to="/contact"
								class="nav-link"
							>{{ $t('header.menu.contact_us') }}</nuxt-link>
						</li>
					</ul>

					<!-- Cart -->
					<div class="absolute account_wrap flex items-center right-0">
            <div
						class="flex items-center border-r h-full px-5"
					>
					<div class="lang-dropdown w-24">
						<!-- dropdown -->
            <!-- <template  v-for="locale in availableLocales">
								<div class="cursor-pointer">
									<nuxt-link :to="switchLocalePath(locale.code)">{{ locale.name }}</nuxt-link>
								</div>
							</template> -->
							<multiselect 
							  v-model="selected"
							  @select="changeLocale"
							  placeholder="Select Language"
							  label="name" track-by="name" 
							  :show-labels="false"
							  :searchable="false"
							  :preselectFirst="true"
							  :allowEmpty="false"
							  :preserve-search="false"  
							  :preselect-first="true"
							  :options="$i18n.locales">

							  <template slot="singleLabel" slot-scope="props">
								<span class="flex gap-1">
								<img class="option__image w-8" :src="props.option.flag">
								<span class="option__desc">
									<span class="option__title">{{ props.option.name }}</span>
							    </span>
								</span>
							   </template>
							  <template slot="option" slot-scope="props">
								<div class="option__desc"><span class="option__title">
									<span class="flex gap-1"> 
									<img class="w-5" v-if="props.option.flag" :src="props.option.flag">
									{{ props.option.name }}
								   </span>
								</span></div>
							 </template>
							</multiselect>
              
                <!-- <select @change="(e) => changeLocale(e.target.value)">
                  <option
                    v-for="lang in $i18n.locales"
                    :key="lang.code"
                    :value="lang.code"
                    onchange="changeLocale(lang)"
                  >
                    {{ lang.name }}
                  </option>
                </select> -->
              </div>
					<!--	<dropdown-comp :dropdownMarginTop="48">


							<template #dropdown="{ toggle }">
								<nuxt-link :to="switchLocalePath('fr')">Français</nuxt-link>
							</template>


						</dropdown-comp> -->
					</div>

					<div
						class="flex items-center border-r h-full px-5"
						v-if="$route.path !== '/checkout'"
					>
						<!-- dropdown -->
						<dropdown-comp :dropdownMarginTop="48">
							<template>
								<div class="cursor-pointer">
									<CartIcon class="relative" />
									<div
										v-if="getTotalItem > 0"
										class="absolute -top-2.5 -right-2.5 bg-primary-500 h-5 w-5 rounded-full flex items-center justify-center"
									>
										<span class="inline-block mb-0 text-xs text-white whitespace-nowrap">{{ getTotalItem }}</span>
									</div>
								</div>
							</template>

							<template #dropdown="{ toggle }">
								<!-- cart body component -->
								<header-cart-menu @close="toggle"></header-cart-menu>
							</template>
						</dropdown-comp>
					</div>

					<!-- profile -->
					<div class="flex items-center h-full">
						<!-- dropdown -->
						<dropdown-comp>
							<template>
								<div
									:class="
                    $auth.loggedIn ? 'border-primary-500' : 'border-gray-900'
                  "
									class="w-10 h-10 overflow-hidden cursor-pointer flex items-center justify-center"
								>
									<svg
                   style="height: 23px; margin: 0;"
										v-if="!$auth.loggedIn || $auth.user.profilePhotoUrl == ''"
										xmlns="http://www.w3.org/2000/svg"
										class="h-10 w-7 mb-2"
										fill="none"
										viewBox="0 0 24 24"
										stroke="currentColor"
									>
										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											stroke-width="2"
											d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
										/>
									</svg>
									<img
										v-if="$auth.loggedIn && $auth.user.profilePhotoUrl"
										:src="$auth.user.profilePhotoUrl"
										alt
										class="w-full h-full object-cover"
									/>
								</div>
							</template>
							<template #dropdown>
								<div
									class="p-2 w-44"
									v-if="$auth.loggedIn"
								>
									<nuxt-link
										v-if="$auth.user.type == 'rider'"
										to="/rider/profile"
										class="dropdown-link"
									>{{ $t('header.menu.my_profile') }}</nuxt-link>
									<nuxt-link
										v-else
										to="/customer/profile"
										class="dropdown-link"
									>{{ $t('header.menu.my_profile') }}</nuxt-link>
									<button-field
										@click="logout"
										type="button"
										label="Logout"
										class="dropdown-link w-full text-left"
									>Logout</button-field>
								</div>

								<div
									class="p-2 w-44"
									v-else
								>
									<nuxt-link
										to="/login"
										class="dropdown-link"
									>{{ $t('header.menu.sign_in') }}</nuxt-link>
									<nuxt-link
										to="/register"
										class="dropdown-link"
									>{{ $t('header.menu.sign_up') }}</nuxt-link>
								</div>
							</template>
						</dropdown-comp>
					</div>
					</div>

				</div>

				<!-- mobile nav items -->
				<div class="flex items-center md:hidden w-full">
					<!-- cart on mobile nav -->


					<!-- burger on mobile nav -->

            <div
              @click="toggleMobileNav"
              class="toggleIcon text-primary-500 "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-7 w-7"
                viewBox="0 0 20 20"
                fill="#fff"
              >
                <path
                  fill-rule="evenodd"
                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                  clip-rule="evenodd"
                />
              </svg>
            </div>

            <div
              class="brand brand-mob mx-auto"
              v-if="getWebsiteSettings && getWebsiteSettings.primaryMediaUrl"
            >
              <nuxt-link
                to="/"
                class="inline-flex items-end w-1/2"
              >
                <img
                  class=""
                  :src="getWebsiteSettings.primaryMediaUrl"
                  alt=""
                >

              </nuxt-link>
              <nuxt-link
                to="/"
                class="inline-flex items-end"
              >

              </nuxt-link>
            </div>
            <div :class="$auth.loggedIn ? 'border-primary-500 ' : 'border-gray-900'">
                    <svg
                    style="height: 23px; margin: 0;"
                      v-if="!$auth.loggedIn || $auth.user.profilePhotoUrl == ''"
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-10 w-7 mb-2"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="#fff"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                      />
                    </svg>
                    <img
                      v-if="$auth.loggedIn && $auth.user.profilePhotoUrl"
                      :src="$auth.user.profilePhotoUrl"
                      alt
                      class="w-full h-full object-cover"
                    />
            </div>


            <nuxt-link
              to="/cart"
              v-if="$route.path !== '/checkout'"
            >
              <div class="cursor-pointer relative">
                <CartIcon class="text-gray-800 white-icon" />
                <div
                  v-if="getTotalItem > 0"
                  class="absolute -top-2.5 -right-2.5 bg-white h-5 w-5 rounded-full flex items-center justify-center "
                >
                  <span class="inline-block mb-0 text-xs text-black whitespace-nowrap">{{ getTotalItem }}</span>
                </div>
              </div>
            </nuxt-link>
				</div>
				</div>
			</div>
		</nav>
		<!-- mobile-nav -->
		<transition
			name="mobile-nav"
			mode="out-in"
			appear
		>
			<ul
				v-show="mobileNav"
				class="sidebar px-3 shadow-md"
				v-click-outside="hide"
			>
				<li class="nav-item">
					<nuxt-link
						to="/shop"
						class="nav-link"
					>
            {{ $t('header.menu.product') }}

					</nuxt-link>
				</li>
				<li class="nav-item">
					<nuxt-link
						to="/about"
						class="nav-link"
					>
          {{ $t('header.menu.about') }}

					</nuxt-link>
				</li>
				<li class="nav-item">
					<nuxt-link
						to="/contact"
						class="nav-link"
					>
          {{ $t('header.menu.contact_us') }}

					</nuxt-link>
				</li>
				<div v-if="$auth.loggedIn">
					<li
						v-if="$auth.user.type == 'rider'"
						class="nav-item"
					>
						<nuxt-link
							to="/rider/profile"
							class="nav-link"
						>
            {{ $t('header.menu.my_profile') }}
							<svg
								xmlns="http://www.w3.org/2000/svg"
								class="h-4 w-4"
								fill="none"
								viewBox="0 0 24 24"
								stroke="currentColor"
							>
								<path
									stroke-linecap="round"
									stroke-linejoin="round"
									stroke-width="2"
									d="M12 6v6m0 0v6m0-6h6m-6 0H6"
								/>
							</svg>
						</nuxt-link>
					</li>

					<li
						v-else
						class="nav-item"
					>
						<nuxt-link
							to="/customer/profile"
							class="nav-link"
						>
            {{ $t('header.menu.my_profile') }}
							<svg
								xmlns="http://www.w3.org/2000/svg"
								class="h-4 w-4"
								fill="none"
								viewBox="0 0 24 24"
								stroke="currentColor"
							>
								<path
									stroke-linecap="round"
									stroke-linejoin="round"
									stroke-width="2"
									d="M12 6v6m0 0v6m0-6h6m-6 0H6"
								/>
							</svg>
						</nuxt-link>
					</li>
					<li class="nav-item">
						<p
							@click="logout"
							class="nav-link cursor-pointer"
						>
            {{ $t('header.menu.logout') }}
							<svg
								xmlns="http://www.w3.org/2000/svg"
								class="h-4 w-4"
								fill="none"
								viewBox="0 0 24 24"
								stroke="currentColor"
							>
								<path
									stroke-linecap="round"
									stroke-linejoin="round"
									stroke-width="2"
									d="M12 6v6m0 0v6m0-6h6m-6 0H6"
								/>
							</svg>
						</p>
					</li>
				</div>
				<div
					v-else
					class="mt-5"
				>
					<nuxt-link to="/login">
						<button-field
							label="SIGN IN"
							class="bg-primary-500 text-white w-full"
						></button-field>
					</nuxt-link>
				</div>
			</ul>
		</transition>
	</header>
</template>

<script>
import { mapGetters } from "vuex";
import ClickOutside from "vue-click-outside";
import HeaderCartMenu from "~/components/layouts/HeaderCartMenu.vue";
import Multiselect from 'vue-multiselect'
export default {
  components: { HeaderCartMenu,Multiselect  },
  name: "TheHeader",
  data() {
    return {
      mobileNav: false,
	  selected: null,
      options: ['list', 'of', 'options']
    };
  },
  created(){
    let cookie = this.getCookie('lang');
  },
  computed: {
    ...mapGetters({
      getTotalItem: "cart/getTotalItem",
      getWebsiteSettings: "config/getWebsiteSettings"
    }),

    availableLocales () {
      return this.$i18n.locales.filter(i => i.code !== this.$i18n.locale)
    }
  },

  methods: {
    toggleMobileNav() {
      this.mobileNav = !this.mobileNav;
    },
    async logout() {
      await this.$auth.logout();
      this.$router.push("/");
    },
    hide() {
      this.mobileNav = false;
    },
    getCookie(name) {
      const value = `; ${document.cookie}`;
      const parts = value.split(`; ${name}=`);
      if (parts.length === 2) return parts.pop().split(';').shift();
    },
    changeLocale(option){
		console.log(option);
      this.$i18n.setLocale(option.code);
      document.cookie = `lang=${option.code}; expires=Sun, 1 May 2023 00:00:00 UTC; path=/`
    }
  },
  mounted() {
    // prevent click outside event with popupItem.
    let cookie = this.getCookie('lang');
    console.log(cookie);
    this.popupItem = this.$el;
  },
  watch: {
  '$route'(to, from) {
    this.mobileNav = false;
  }
},
  // do not forget this section
  directives: {
    ClickOutside
  }
};
</script>

<style  scoped>
header {
  z-index: 99;
  box-shadow: 0 0 10px rgb(136 136 136 / 10%);
}

nav {
  /* height: 120px; */
}
.nav-link[data-v-1343ea8d]:hover {
    color: #000;
}
.nuxt-link-exact-active {

    color: #000000 !important;
}
.nav-link {
  font-weight: 600;
  font-size: 14px;
  text-transform: uppercase;
  transition: all 0.2s ease;
  color: #000;
  @apply hover:text-primary-500 px-2 md:px-4 lg:px-6;
}

.toggleIcon {
  cursor: pointer;
}

.sidebar {
  width: 100%;
  max-width: 250px;
  height: 100%;
  top: 69px;
  left: 0;
  z-index: 100;
  padding-top: 0 !important;
  @apply flex flex-col py-4 fixed bg-white md:hidden;

  .nav-item {
    .nav-link {
      @apply m-0 p-0 flex items-center justify-between;
    }
    @apply py-3 px-1;
  }
  .nav-item {
    @apply border-t border-gray-200;
  }
}

.dropdown-link {
  @apply block px-4 py-2 mt-2 text-sm font-semibold bg-transparent text-gray-800 rounded-lg md:mt-0 hover:text-white focus:text-gray-800 hover:bg-black focus:bg-black focus:outline-none cursor-pointer;
}

/* .nuxt-link-exact-active {
  @apply text-white !important;
} */

.mobile-nav-enter-active,
.mobile-nav-leave-active {
  transition: all 0.5s ease-in-out;
}

.mobile-nav-enter,
.mobile-nav-leave-to {
  transform: translateX(-100%);
}

@media screen and (max-width:768px) and (min-width:100){
  .for-mobile{
    height: 80px;
  }
}

.brand-mob img {
    filter: invert(1);
}
.white-icon {
    stroke: #fff;
}
.bg-white {
    color: #fff;
}
.sidebar .nuxt-link-exact-active:before {
    content: "";
    background-color: #000;
    width: 5px;
    height: 5px;
    display: table;
    border-radius: 50%;
}
.sidebar .nuxt-link-exact-active{
    justify-content: start !important;
    gap: 10px;

}
.h-10 {
    height: 2.2rem;
}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>