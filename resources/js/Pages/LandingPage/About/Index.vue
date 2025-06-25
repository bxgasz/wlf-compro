<script setup>
import ArrowBack from '@/Icons/ArrowBack.vue';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import { ref } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Pagination, A11y, Autoplay, Navigation } from 'swiper/modules'
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/autoplay";
import { Link, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const props = defineProps({
   partners: Object,
   managements: Object,
   organization: Object
})

const page = usePage()

const { locale } = useI18n()

const modules = [
   Autoplay,
   Pagination,
   A11y
]

const modulesJourney = [
   Pagination,
   Navigation
]

const ourValues = [
   {
      icon: '/assets/img/about/1.svg',
      title: {
         en: 'Empowerment',
         id: 'Pemberdayaan'
      },
   },
   {
      icon: '/assets/img/about/2.svg',
      title: {
         en: 'Collaboration',
         id: 'Kolaborasi'
      },
   },
   {
      icon: '/assets/img/about/3.png',
      title: {
         en: 'Accountability & Integrity',
         id: 'Akuntabilitas & Integritas'
      },
   },
   {
      icon: '/assets/img/about/4.svg',
      title: {
         en: 'Sustainability',
         id: 'Keberlanjutan'
      },
   },
   {
      icon: '/assets/img/about/5.svg',
      title: {
         en: 'Driven by Needs',
         id: 'Berdasarkan Kebutuhan'
      },
   },
]

const history = [
   {
      "year": 2009,
      "title": {
         "en": "ESTABLISHMENT",
         "id": "PEMBENTUKAN"
      },
      "description": {
         "en": "The William & Lily Foundation (WLF) was established by Edwin and Joyce Soeryadjaya to continue the philanthropic legacy of their parents, William and Lily Soeryadjaya.",
         "id": "William & Lily Foundation (WLF) didirikan oleh Edwin dan Joyce Soeryadjaya untuk melanjutkan warisan filantropi orang tua mereka, William dan Lily Soeryadjaya."
      }
   },
   {
      "year": 2017,
      "title": {
         "en": "TRANSFORMATION",
         "id": "TRANSFORMASI"
      },
      "description": {
         "en": "WLF transitioned into a grant-making organization, focusing on supporting communities in Sumba and Bali across three key areas: education, health, and economic empowerment.",
         "id": "WLF bertransformasi menjadi organisasi pemberi hibah, dengan fokus mendukung komunitas di Sumba dan Bali dalam tiga bidang utama: pendidikan, kesehatan, dan pemberdayaan ekonomi."
      }
   },
   {
      "year": 2021,
      "title": {
         "en": "EVALUATION",
         "id": "EVALUASI"
      },
      "description": {
         "en": "After a few years of disbursing grants in these three key sectors, WLF began reflecting and evaluating on the impact that it had been working towards and started making incremental changes to how it functioned as a grant-making foundation.",
         "id": "Setelah beberapa tahun menyalurkan hibah di tiga sektor utama ini, WLF mulai melakukan refleksi dan evaluasi terhadap dampak yang telah diupayakan, serta mulai melakukan perubahan bertahap pada cara kerjanya sebagai lembaga pemberi hibah."
      }
   },
   {
      "year": 2021,
      "title": {
         "en": "RENEWED STRATEGY",
         "id": "STRATEGI BARU"
      },
      "description": {
         "en": "As a culmination of the reflections WLF underwent, in 2021 WLF developed a new Theory of Change and designed a new process for disbursing grants. WLF concluded the six programs initiated in 2021, and launched one new program under its renewed strategy.",
         "id": "Sebagai puncak dari refleksi yang dilakukan, pada tahun 2021 WLF mengembangkan Teori Perubahan baru dan merancang proses baru untuk penyaluran hibah. WLF menyelesaikan enam program yang dimulai pada 2021, dan meluncurkan satu program baru di bawah strategi barunya."
      }
   },
   {
      "year": 2024,
      "title": {
         "en": "REINFORCING IDENTITY",
         "id": "PENGUATAN IDENTITAS"
      },
      "description": {
         "en": "WLF continues to reinforce its identity as a grant-making organization. In 2024, WLF launched five new programs focusing on early childhood development, basic literacy and numeracy, and local economic empowerment.",
         "id": "WLF terus memperkuat identitasnya sebagai organisasi pemberi hibah. Pada tahun 2024, WLF meluncurkan lima program baru yang berfokus pada pengembangan anak usia dini, literasi dan numerasi dasar, serta pemberdayaan ekonomi lokal."
      }
   }
]


const tabOurTeam = ref(page.props.settings.show_team ? 'management' : 'organization')
</script>

<template>
   <div class="w-full z-0 font-lato text-[18px] overflow-hidden">
      <Navbar/>

      <div class="w-full text-center relative">
         <div class="image-container">
            <img src="/assets/img/about/bg-section.png" alt="about-us">
         </div>
         <h1 class="text-white uppercase text-[2rem] md:text-[72px] leading-[1.1] font-playfair font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2">
            {{ $t('about.title') }}
         </h1>
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="max-w-4xl w-full text-center px-8 text-[#000000] font-medium">
            <p>{{ $t('about.description') }}</p>
            <p v-html="$t('about.description.2')" class="mt-5"></p>
            <!-- <p>{{ locale == 'id' ? 'Selengkapnya di dokumen' : 'More details in the document' }} <a href=""></a> </p> -->
         </div>
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="max-w-7xl px-8 w-full">
            <div class="grid grid-cols-1 gap-5 lg:gap-0 lg:grid-cols-[20%,100%]">
               <h2 class="text-[#2B3E8C] text-4xl font-playfair font-extrabold text-center lg:text-left">
                  {{ $t('about.journey') }}
               </h2>

               <div class="bg-[#D86727] rounded-[20px] w-full p-10">
                  <div class="flex gap-5 h-[26rem] w-full items-center">
                     <swiper
                        :spaceBetween="5"
                        :centeredSlides="false"
                        :modules="modulesJourney"
                        :breakpoints="{
                           0: {
                              slidesPerView: 1.2,
                           },
                           600: {
                              slidesPerView: 2.5,
                           },
                           768: {
                              slidesPerView: 3.5,
                           },
                           1024: {
                              slidesPerView: 5,
                           },
                           1280: {
                              slidesPerView: 6
                           }
                        }"
                        :navigation="{
                           nextEl: '.custom-next',
                           prevEl: '.custom-prev',
                        }"
                        class="w-full"
                     >
                        <swiper-slide v-for="(data, i) in history">
                           <div class="flex flex-col gap-5">
                              <p class="font-bold text-xl text-white">{{ data.year }}</p>
                              <div class="w-40 h-24">
                                 <img src="/assets/img/about/journey.jpg" alt="journey" class="rounded-xl">
                              </div>
                              <p class="text-white font-bold">{{ data.title[locale] }}</p>
                              <p class="text-white text-xs">{{ data.description[locale] }}</p>
                           </div>
                        </swiper-slide>
                     </swiper>
                  </div>
                  <div class="w-[80%] flex justify-end gap-2">
                     <ArrowBack class="bg-white rounded-full w-8 h-8 flex items-center justify-center p-2 custom-prev" role="button"/>
                     <ArrowBack class="bg-white rounded-full w-8 h-8 flex items-center justify-center p-2 rotate-180 custom-next"  role="button"/>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- <div class="w-full flex justify-center mt-20">
         <div class="w-full max-w-7xl px-8 space-y-5">
            <div class="w-full flex justify-center">
               <h2 class="text-[#2B3E8C] text-4xl font-extrabold font-playfair">
                  {{ $t('about.visi-mission') }}
               </h2>
            </div>

            <div class="w-full flex justify-start gap-3">
               <img src="/assets/icon/kutip.svg" alt="kutip" class="rotate-180">
               <img src="/assets/icon/kutipbirru.svg" alt="kutip" class="rotate-180">
            </div>

            <div class="w-full justify-center flex">
               <p class="text-center text-[#000000] font-medium max-w-[80%]">{{ $t('about.visi-mission.description') }}</p>
            </div>

            <div class="w-full flex justify-end gap-3">
               <img src="/assets/icon/kutipbirru.svg" alt="kutip">
               <img src="/assets/icon/kutip.svg" alt="kutip">
            </div>
         </div>
      </div> -->

      <div class="flex justify-center mt-20">
         <div class="bg-[#2B3E8C] max-w-7xl h-full w-full rounded-3xl mx-8 p-10">
            <div class="grid grid-cols-1 lg:grid-cols-[30%,70%] gap-10 justify-center items-center">
               <div class="w-full h-full lg:h-[150%] rounded-3xl">
                  <img src="/assets/img/home/hero.png" alt="publication" class="w-full h-full object-cover rounded-3xl">
               </div>
               <div class="text-white">
                  <h1 class="font-montserrat text-2xl font-bold">{{ $t('about.visi.title') }}</h1>
                  <p class="text-[#] text-base font-medium">{{ $t('about.visi.description') }}</p>
                  <h1 class="font-montserrat text-2xl font-bold mt-16">{{ $t('about.mission.title') }}</h1>
                  <p class="text-[#] text-base font-medium">{{ $t('about.mission.1') }}</p>
               </div>
            </div>
         </div>
      </div>

      <div class="flex justify-center">
         <div class="relative w-full mt-20 max-w-[1600px]">
            <div class="w-full h-96 rounded-t-[35%] lg:rounded-t-full border-t border-[#D86727]"></div>
            <div class="w-full h-60 rounded-t-[35%] lg:rounded-t-full border-t border-[#D86727] -mt-32"></div>

            <div class="w-full flex justify-center -mt-[30rem]">
               <div class="max-w-7xl px-8 w-full justify-center">
                  <h1 class="text-5xl font-playfair text-[#262C51] font-bold text-center">{{ $t('about.values.title') }}</h1>
                  <p class="text-center mt-5">{{ $t('about.values.description') }}</p>
                  <div class="flex flex-col lg:flex-row flex-wrap gap-10 justify-center items-center mt-10 lg:mt-20 mb-8 overflow-x-auto [&::-webkit-scrollbar]:w-1 [&::-webkit-scrollbar]:h-0">
                     <div class="w-[19rem] h-fit flex flex-col justify-center items-center gap-5 text-center" v-for="(values, index) in ourValues" :key="index">
                        <div class="w-20 h-20">
                           <img :src="values.icon" alt="values" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-[20px] text-[#2B3E8C] font-bold">{{ values.title[locale] }}</h3>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="w-full flex justify-center mt-20" v-if="page.props.settings.show_team || page.props.settings.show_organization">
         <div class="max-w-7xl w-full px-8">
            <div class="flex flex-col lg:flex-row gap-10 lg:gap-20">

               <div class="lg:hidden">
                  <h2 class="text-[#2B3E8C] text-4xl font-playfair font-extrabold">
                     {{ $t('about.team') }}
                  </h2>

                  <div class="flex gap-2 mt-10">
                     <button v-if="page.props.settings.show_team" @click="tabOurTeam = 'management'" class="p-3 text-base rounded-lg" :class="tabOurTeam == 'management' ? 'bg-[#D86727] text-white font-semibold' : 'border border-[#D86727]'">{{ locale == 'id' ? 'Manajemen' : 'Management' }}</button>
                     <button @click="tabOurTeam = 'organization'" class="p-3 text-base rounded-lg" :class="tabOurTeam == 'organization' ? 'bg-[#D86727] text-white font-semibold' : 'border border-[#D86727]'">{{ locale == 'id' ? 'Struktur Organisasi' : 'Organization Strcuture' }}</button>
                  </div>
               </div>

               <div class="bg-[#D86727] rounded-[20px] w-[100%] p-10 lg:-ms-44">
                  <div class="flex flex-wrap gap-5 min-h-64 w-full items-center justify-center md:justify-between lg:justify-end" v-if="page.props.settings.show_team && tabOurTeam == 'management'">
                     <div class="text-white space-y-3 w-full lg:w-[calc(30%)]" v-for="(data, index) in managements" :key="index">
                        <div class="lg:w-72 h-44">
                           <img :src="data.image" alt="values" class="w-full h-full object-cover rounded-[20px]">
                        </div>
                        <h3 class="text-[20px] font-bold">{{ data.title[locale] }}</h3>
                        <p>{{ data.position[locale] }}</p>
                     </div>
                  </div>

                  <div class="w-full" v-if="page.props.settings.show_organization && tabOurTeam == 'organization'">
                     <img :src="organization.image" alt="organization" class="w-full h-full object-contain">
                  </div>
               </div>

               <div class="w-[20%] hidden lg:block">
                  <h2 class="text-[#2B3E8C] text-4xl font-playfair font-extrabold">
                     Our Team
                  </h2>

                  <p role="button" v-if="page.props.settings.show_team" @click="tabOurTeam = 'management'" class="p-3 text-base rounded-tl-[20px] mt-10" :class="tabOurTeam == 'management' ? 'bg-[#D86727] text-white font-semibold' : 'border border-[#D86727]'">Management</p>
                  <p role="button" v-if="page.props.settings.show_organization" @click="tabOurTeam = 'organization'" class="p-3 text-base rounded-bl-[20px]" :class="tabOurTeam == 'organization' ? 'bg-[#D86727] text-white font-semibold' : 'border border-[#D86727]'">Organization Strcuture</p>
               </div>
            </div>
         </div>
      </div>

      <div class="flex justify-center mt-20" v-if="partners.length != 0">
         <div class="max-w-7xl px-8">
            <h1 class="text-5xl font-playfair text-[#262C51] font-bold text-center">{{ $t('about.partner') }}</h1>

            <swiper
               class="h-fit mt-20"
               :modules="modules"
               :autoplay="{ delay: 8000, disableOnInteraction: false }"
               :slide-per-view="3"
               :pagination="{ clickable: true }"
            >
               <swiper-slide class="h-full !w-full" v-for="(chunk, i) in partners">
                  <div class="w-full flex flex-wrap justify-center gap-10 mb-10 lg:mb-0">
                     <div class="h-15 w-15 lg:w-40 lg:h-40" v-for="(data, i) in chunk">
                        <img :src="data.logo" alt="img" class="w-full h-full object-contain">
                     </div>
                  </div>
               </swiper-slide>
            </swiper>
         </div>
      </div>

      <div class="flex justify-center mt-20 w-full bg-[#2B3E8C] rounded-t-[100px] lg:rounded-t-[300px]">
         <div class="max-w-7xl w-full px-8 my-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
               <div class="w-full h-[284px]">
                  <iframe class="rounded-[20px]" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2342680692304!2d106.82871827509548!3d-6.232817993755369!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3ef32de8be3%3A0x9bb807c61923a77e!2sWilliam%20%26%20Lily%20Foundation!5e0!3m2!1sid!2sid!4v1748936984987!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
               </div>
               <div class="flex flex-col gap-5">
                  <h1 class="text-5xl font-playfair text-white font-bold">{{ $t('about.contact') }}</h1>
                  <p class="text-white" v-html="page.props.settings.location">
                  </p>
                  <div class="flex gap-2 text-white">
                     <a href="'tel:'+page.props.settings.phone_no"><img role="button" src="/assets/icon/phone.svg" alt="x"> {{ page.props.settings.phone_no }} <br></a>
                     <a href="`https://mail.google.com/mail/?view=cm&fs=1&to=${page.props.settings.email}`"><img role="button" src="/assets/icon/mail.svg" alt="x"> {{ page.props.settings.email }}</a>
                  </div>
                  <Link :href="route('contact')" class="bg-[#D86727] hover:bg-[#e47636] ease-in-out duration-500 px-6 py-2 text-white rounded-full font-medium w-fit">{{ $t('contact.send-message') }}</Link>
               </div>
            </div>
         </div>
      </div>

      <Footer/>
   </div>
</template>

<style scoped>
:deep(.swiper-pagination-bullet){
  background: #262C51 !important;
  opacity: 10;
}

:deep(.swiper-pagination-bullet-active){
  background: #D86727 !important;
  width: 40px;
  border-radius: 10px;
}

.image-container {
  position: relative;
  width: 100%;
  overflow: hidden;
  height: 20rem;
}

.image-container::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg,rgba(18, 24, 58, 0.8) 0%, rgba(18, 24, 58, 0.5) 50%, rgba(18, 24, 58, 0.8) 100%);
  pointer-events: none;
}

.image-container img, .image-container video{
   width: 100%;
   height: 100%;
   object-fit: cover;
}
</style>
