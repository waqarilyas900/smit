<template>
  <div>
    <!-- top banner -->
    <the-banner v-if="getAboutPageHero && getAboutPageHero.primaryMediaUrl" :bannerLink="getAboutPageHero.primaryMediaUrl">
      <template #header>
        <span class="text-2xl md:text-4xl mt-5 sm:mt-0 inline-block text-black">{{`${getAboutPageHero.data[$i18n.locale].title}`}}</span>
      </template>
      <template #breadcrumbs>
        <li>
          <nuxt-link to="/" class="font-semibold text-black">{{ $t('about_us.breacrum_home') }}</nuxt-link>
        </li>
        <li><span class="mx-2 text-black">/</span></li>
        <li>
          <span class="font-semibold text-black">{{ $t('about_us.breacrum_about') }}</span>
        </li>
      </template>
    </the-banner>

    <!-- 1st section -->
    <div class="container bg-white lg:flex items-center text-gray-700 mt-10 mb-12 lg:my-16" v-if="getOwnerSection">
      <div class="lg:w-1/2  flex justify-center items-center about-us-img">
        <div class="about-img">
        <img :src="getOwnerSection.primaryMediaUrl" alt="">
      </div>
      </div>
      <div class="lg:w-1/2 mt-10 lg:mt-0 flex items-center">
        <div v-if="getOwnerSection && getOwnerSection.data" class="about-sec-content">
          <h5 class="font-regular text-3xl font-bold lg:text-5xl text-gray-700 leading-snug">
            {{`${getOwnerSection.data[$i18n.locale].title}`}}
          </h5>
          <p class="mt-7 border-primary-500 italic">
            {{`${getOwnerSection.data[$i18n.locale].subtitle}`}}
          </p>
          <p class="mt-7">{{`${getOwnerSection.data[$i18n.locale].description}`}}</p>
          <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus alias dolores velit eaque tenetur repudiandae quasi perferendis in quod dignissimos.</p>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus alias dolores velit eaque tenetur repudiandae quasi perferendis in quod dignissimos.</p>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus alias dolores velit eaque tenetur repudiandae quasi perferendis in quod dignissimos.</p> -->
        </div>
      </div>
    </div>

    <!-- why choose us -->
    <div class="choose-main">
    <div class="py-10 lg:py-16">
      <div class="container text-gray-700">
        <!-- section header -->
        <section-header>
          <template #title>
            <span class="font-bold">
             {{ $t('why_choose_us.title') }}
            </span>
          </template>
          <template #subtitle>
            Completely network impactful users whereas next-generation
            applications engage out thinking via tactical action.
          </template>
        </section-header>
        <p class="font-regular text-center mt-3">{{ $t('why_choose_us.description') }}</p>

        <!-- cards -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-8">
          <!-- card 1 -->
          <div class="choose-us-card" v-for="(item, i) in whyChooseUs" :key="i">
            <div class="flex items-center">
              <div class="bg-white rounded-full h-12 w-12 p-2 border-2 border-black flex-none">
                <img :src="item.primaryMediaUrl" class="h-full w-full object-contain" alt="">
              </div>
              <h5 class="text-2xl font-semibold ml-3">{{item.title[$i18n.locale]}}</h5>
            </div>
            <p class="mt-5">{{item.description[$i18n.locale]}}</p>
          </div>

        </div>
      </div>
    </div>

    <!-- faq -->
    <div class="container">
      <div class="md:w-10/12 lg:w-7/12 mx-auto my-10 lg:my-16">
        <section-header>
          <template #title>
            <span class="font-bold">
              {{ $t('about_us.frequently_asked_questions') }}
            </span>
          </template>
          <template #subtitle>
            {{ $t('about_us.questions_subtitle') }}
          </template>
        </section-header>
             <p class="text-center mt-5"> {{ $t('about_us.questions_subtitle') }}</p>
        <div class="mt-10">
          <client-only>
            <VueFaqAccordion :items="fieldData"/>
          </client-only>
        </div>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import VueFaqAccordion from "vue-faq-accordion";

export default {
  name: "AboutUs",
  components: { VueFaqAccordion },
  data() {
    return {};
  },
  methods:{
    // getCookie(name) {
    //   const value = `; ${document.cookie}`;
    //   const parts = value.split(`; ${name}=`);
    //   if (parts.length === 2) return parts.pop().split(';').shift();
    // }
  },
  mounted(){
    // document.body.classList.remove('active');
    // let cookie = this.getCookie('lang');
    // this.$i18n.setLocale(cookie);
    // document.dir = this.$dir();
    // setTimeout(()=>{
    //   document.body.classList.add('active');
    // }, 500);

  },
  computed: {
    ...mapGetters({
      getOwnerSection: "config/getOwnerSection",
      getAboutPageHero: "config/getAboutPageHero",
      getAboutFaqs: "config/getAboutFaqs",
      whyChooseUs: "config/whyChooseUs"
    }),
    fieldData(){
      let data = [];
      this.getAboutFaqs.forEach(element => {
        data.push({title:element.title[this.$i18n.locale], value:element.value[this.$i18n.locale]})
      });
      console.log(data)
      return data;
    }
  }
};
</script>

<style lang="scss">
.choose-us-card {
  @apply py-4 px-5 md:py-8 md:px-10 bg-white rounded-lg shadow-sm border-2 border-transparent hover:border-primary-500 hover:shadow transition duration-300 cursor-default;
}

.faq-wrapper {
  margin-left: auto !important;
  margin-right: auto !important;
}
.choose-main {
    background-color: #f9f9f9;
}

.accordion {
  border: none !important;
}

.accordion__item {
  margin-top: 13px !important;
  border-bottom: none !important;
}
  .accordion__title {
    background-color: #e9e6e691 !important;
    padding: 12px 20px !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
  }

  .accordion__value {
    padding: 10px 20px !important;
  }

  .accordion__toggle-button {
    transition: all 0.01s !important;
  }
  .about-sec-content p {
    line-height: 2;
    margin-bottom: 25px;
}

.about-us-img img {
    height: 640px;
    width: 100%;
    object-fit: cover;
    position: relative;
}

.about-img {
    width: 70%;
    position: relative;
    margin-bottom: 38px;
    @media only screen and (max-width: 768px) {
      width: 100%;
    }
}

.about-img:before {
    position: absolute;
    content: '';
    width: 100%;
    height: 100%;
    border: 2px solid #000;
    top: 4%;
    left: 5%;
    @media only screen and (max-width: 768px) {
      display: none;
    }
}

.accordion__title:hover {
    color: #000 !important;
}
.accordion__title_active {
    color: #000 !important;
}
.accordion__toggle-button_active::before,
 .accordion__toggle-button_active::after {
    background: #000 !important;
}
.accordion__title:hover .accordion__toggle-button::before,
 .accordion__title:hover .accordion__toggle-button::after{
  background-color: #000 !important;
}
.choose-us-card:hover {
    border-color: unset;
}
.choose-us-card {
    padding-right: 12px;
}
</style>
