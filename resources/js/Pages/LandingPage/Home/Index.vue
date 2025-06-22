<script setup>
import Navbar from '../Components/Navbar.vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Pagination, A11y, Autoplay, Navigation } from 'swiper/modules'
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/autoplay";
import 'swiper/css/navigation';
import { Link } from '@inertiajs/vue3';
import ArrowBack from '@/Icons/ArrowBack.vue';
import Footer from '../Components/Footer.vue';
import { useI18n } from 'vue-i18n';
import ChevronIcon from '@/Icons/ChevronIcon.vue';
import { computed, ref } from 'vue';
import { formatDate } from '@/Helper/FormatDate';
import PlayIcon from '@/Icons/PlayIcon.vue';

const props = defineProps({
   banners: Object,
   programCategories: Object,
   stories: Object,
   programs: Object,
   newPublications: Object
})

const modules = [
   Autoplay,
   Pagination,
   A11y
]

const modules2 = [
   Autoplay,
   Navigation,
   A11y
]

const { locale } = useI18n()

const locations = [
   {
      type: 'project_area',
      top: 25,
      left: 38
   },
   {
      type: 'project_area',
      top: 20,
      left: 90
   },
   {
      type: 'project_area',
      top: 65,
      left: 90
   },
]

const youtubeVideoId = 'bgXWh1oQRfE'

const showVideo = ref(false)

const youtubeUrl = computed(() =>
  `https://www.youtube.com/embed/${youtubeVideoId}?autoplay=1`
)

// const programCategories = [
//    {
//       title: 'Early Childhood Development',
//       image: '/assets/img/home/our-program.png'
//    },
//    {
//       title: 'Literacy and Numeracy for early grades',
//       image: '/assets/img/home/program-2.png'
//    },
//    {
//       title: 'Economic Empowerment',
//       image: '/assets/img/home/program-3.png'
//    },
// ]
</script>

<template>
   <div class="w-full bg-[#F1EAE7] z-0 font-lato text-[18px] overflow-hidden">
      <Navbar/>

      <!-- hero section -->
      <div class="min-h-screen h-[40rem] max-h-[50rem] w-full">
         <swiper
            class="h-full"
            :modules="modules"
            :autoplay="{ delay: 8000, disableOnInteraction: false }"
            :slide-per-view="3"
            :pagination="{ clickable: true }"
         >
            <swiper-slide class="relative h-full" v-for="(banner, index) in banners">
               <div class="image-container">
                  <template v-if="banner.type == 'video'">
                     <video autoplay muted loop playsinline>
                           <source :src="banner.media" type="video/mp4">
                           {{ $t('news.detail.banner-vid') }}
                     </video>
                  </template>
                  <template v-else>
                     <img :src="banner.media" :alt="banner.title[locale]">
                  </template>
               </div>
               <div class="w-screen px-8 max-w-7xl absolute inset-0 left-1/2 top-[55%] -translate-x-1/2 -translate-y-1/2 flex items-center z-20">
                  <div class="flex flex-col justify-center z-20 w-[80%] lg:w-[50%]">
                     <h1 class="text-white text-[2rem] md:text-[72px] leading-[1.1] font-playfair font-bold">
                        {{ banner.title[locale] }}
                     </h1>
                     <div class="flex items-center my-5" v-if="true">
                        <p class="text-xl text-slate-300">{{ banner.desc[locale] }}</p>
                     </div>
                     <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center">
                        <a v-if="banner.link_01" :href="banner.link_01" class="bg-[#D86727] hover:bg-[#e47636] ease-in-out duration-500 px-6 py-2 text-white rounded-full font-medium w-fit">{{ locale == 'id' ? 'Pelajari Lebih Lanjut' : 'Learn More' }}</a>
                        <a v-if="banner.link_02" :href="banner.link_02" class="border border-[#D86727] text-[#D86727] px-6 py-3 font-semibold rounded-xl w-fit">{{ locale == 'id' ? 'Informasi Lainnya' : 'Another Information' }}</a>
                     </div>
                  </div>
               </div>
            </swiper-slide>
         </swiper>
         
      </div>

      <!-- who are we section -->
      <div class="w-full flex justify-center">
         <div class="mt-20 max-w-7xl grid grid-cols-1 lg:grid-cols-[20%,30%,50%] gap-5 px-8">
            <h1 class="text-5xl font-playfair font-bold text-[#262C51]">
               {{ $t('home.who-we-are.title') }}
            </h1>
            <div class="text-[#262C51] text-sm flex flex-col justify-between gap-5 lg:gap-0">
               <p class="font-medium text-base">{{ $t('home.who-we-are') }}</p>
               <Link :href="route('about-us')" class="bg-[#D86727] hover:bg-[#e47636] ease-in-out duration-500 px-6 py-2 text-white rounded-full font-medium w-fit">{{ $t('home.readmore') }}</Link>
            </div>
            <div>
               <div class="w-full cursor-pointer relative" @click="showVideo = true">
                  <img
                  src="/assets/img/home/who-are-we.png"
                  alt="video"
                  class="h-60 w-full lg:w-[90%] object-cover rounded-3xl"
                  />
                  <PlayIcon class="text-white opacity-45 h-20 w-20 absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2" />
               </div>

               <div
                  v-if="showVideo"
                  class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50"
                  @click.self="showVideo = false"
               >
                  <div class="relative w-full max-w-3xl px-4">
                  <!-- Tombol close -->
                  <button
                     class="absolute top-0 right-0 text-white text-3xl font-bold z-10"
                     @click="showVideo = false"
                  >
                     &times;
                  </button>

                  <!-- YouTube Embed -->
                  <div class="relative pt-[56.25%]">
                     <iframe
                        class="absolute top-0 left-0 w-full h-full rounded-xl"
                        :src="youtubeUrl"
                        frameborder="0"
                        allow="autoplay; encrypted-media"
                        allowfullscreen
                     ></iframe>
                  </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="relative mt-20 w-full" v-if="programCategories.length > 0">
         <div class="w-full h-96 rounded-t-[35%] lg:rounded-t-full border-t border-[#D86727]"></div>
         <div class="w-full h-96 rounded-t-[35%] lg:rounded-t-full border-t border-[#D86727] -mt-52"></div>
         <div class="w-full h-72 md:h-[28rem] bg-[#D86727] rounded-t-[35%] lg:rounded-t-[300px] -mt-72"></div>

         <!-- our program section -->
         <div class="w-full flex justify-center absolute top-10">
            <div class="max-w-7xl px-8 w-full">
               <h1 class="text-5xl font-playfair text-[#262C51] font-bold text-center">{{ $t('home.our-program') }}</h1>
               <div :class="programCategories.length > 1 ? 'justify-start' : 'justify-center'" class="flex gap-5 my-8 overflow-x-auto [&::-webkit-scrollbar]:w-1 [&::-webkit-scrollbar]:h-0 [&::-webkit-scrollbar-track]:bg-[#5A5A5A] [&::-webkit-scrollbar-thumb]:bg-[#D7261C]">
                  <Link :href="route('sub-program', data.slug)" class="w-[16rem] h-[23rem] sm:w-[24rem] sm:h-[34rem] flex-shrink-0 flex justify-start relative fading group" v-for="(data, i) in programCategories" :key="i">
                     <div class="w-full h-full overflow-hidden rounded-2xl img-our-program">
                        <img :src="data.image" class="object-cover w-full h-full transition duration-500 ease-in-out group-hover:scale-125">
                     </div>
                     <div class="h-full w-full absolute p-8 z-20 flex flex-col justify-between">
                        <div class="flex justify-end w-full">
                           <ArrowBack class="bg-white/30 backdrop-blur-sm border-white border-2 rounded-full p-1 w-6 h-6 sm:w-9 sm:h-9 text-[#D86727] group-hover:text-white group-hover:bg-[#D86727] ease-in-out duration-500 rotate-[135deg] z-20 mb-8" />
                        </div>
                        <div class="">
                           <p class="text-white text-[20px] sm:text-3xl w-full font-bold capitalize">{{ data.title[locale] }}</p>
                        </div>
                     </div>
                  </Link>
               </div>
            </div>
         </div>
      </div>

      <div class="flex justify-center w-full" v-if="programs.length > 0">
         <div class="max-w-7xl text-center w-full my-20 px-8">
            <h2 class="text-[#2B3E8C] text-[2rem] md:text-4xl leading-[1.1] font-playfair font-bold">{{ $t('home.whatwedo') }}</h2>

            <div class="grid grid-cols-1 lg:grid-cols-[70%,25%] gap-10 lg:gap-20 mt-20">
               <div class="relative w-full h-full">
                  <img src="/assets/img/home/map.png" alt="project location" class="w-full h-full brightness-[0.8]">
                  
                  <div
                     v-for="(data, index) in programs"
                     :key="index"
                     class="absolute w-[8px] md:w-[15px] h-[8px] md:h-[15px] rounded-[50%] cursor-pointer -translate-x-1/2 -translate-y-1/2 bg-[#E75E00]"
                     :style="{
                     top: data.location_map.top + '%',
                     left: data.location_map.left + '%',
                     }"
                     @click="handleShowPopup(data.location)"
                  >
                     <span class="absolute inline-flex right-0 h-full w-full animate-ping rounded-full opacity-75 bg-[#E75E00]"></span>
                  </div>

                  <div v-if="showPopup" @click.stop ref="popupRef" class="absolute bg-[#24252A80]/50 backdrop-blur-sm rounded-lg p-3 -translate-x-[50%] -translate-y-[120%]" :style="{ top: selectedLocation.top + '%', left: selectedLocation.left + '%', }">
                     <p class="text-white text-[16px]"><strong>{{ selectedLocation.title[locale] }}</strong></p>
                     <!-- <p class="text-white text-[14px]" v-html="selectedLocation.address"></p> -->
                  </div>

               </div>

               <div class="w-full">
                  <swiper
                        ref="swiperRef"
                        :modules="modules2"
                        :slide-per-view="3"
                        :navigation="{
                           nextEl: '.custom-next',
                           prevEl: '.custom-prev',
                        }"
                  >
                     <SwiperSlide v-for="(data, index) in programs">
                        <p class="bg-[#2B3E8C] text-sm p-1 px-3 rounded-full text-white w-fit mb-5">{{ data.status }}</p>
                        <div class="w-full h-40">
                           <img :src="data.banner" alt="program" class="w-full h-full object-cover rounded-[20px]">
                        </div>
                        <p class="text-left my-5">{{ formatDate(data.created_at) }}</p>
                        <p class="w-full font-medium text-left">
                           {{ data.title[locale] }}
                        </p>
                     </SwiperSlide>
                  </swiper>
                  <div class="flex justify-start w-full items-center gap-5 mb-5 mt-5 relative z-99">
                     <button class="bg-[#E75E00] rounded-full p-2 flex justify-center items-center custom-prev">
                        <ChevronIcon class="w-[1rem] h-[1rem] text-white" />
                     </button>
                     <button class="bg-[#E75E00] rounded-full p-2 flex justify-center items-center rotate-180 custom-next">
                        <ChevronIcon class="w-[1rem] h-[1rem] text-white" />
                     </button>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- news section -->
      <div class="bg-[#D86727] flex justify-center pt-20" v-if="stories.length > 0">
         <div class="grid grid-cols-1 w-full lg:grid-cols-[30%,70%] max-w-7xl px-8 h-[80%] gap-10 lg:gap-0">
            <div class="flex flex-col gap-5">
               <h1 class="font-playfair text-white text-5xl font-bold">{{ $t('home.stories') }}</h1>
               <Link :href="route('publications')" class="bg-[#2F3C87] hover:bg-[#3c50c0] ease-in-out duration-500 px-6 py-2 text-white rounded-full font-medium w-fit hidden lg:flex">{{ $t('home.storiesbutton') }}</Link>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-[40%,60%] gap-4 min-h-[364px]">
               <Link :href="route('publications-detail', { title: stories[0].slug ? stories[0].slug : stories[0].title[lang], date:  new Date(stories[0].created_at).toISOString().split('T')[0] })" class="relative w-full fading group" role="button">
                  <div class="w-full h-full overflow-hidden img-our-program rounded-2xl">
                  <img :src="stories[0].banner"
                           alt="" 
                           class="object-cover w-full h-full group-hover:scale-125 transform ease-in-out duration-300">
                  </div>
                  <div class="absolute h-full w-full flex flex-col top-0 justify-end bg-opacity-50 text-white p-8 z-20">
                     <div class="">
                        <p class="text-white text-[10px] sm:text-[16px] w-full">{{ formatDate(stories[0].created_at) }}</p>
                        <p class="text-white text-[16px] sm:text-[20px] w-full font-medium">{{ stories[0].title[locale] }}</p>
                     </div>
                  </div>
               </Link>
               
               <div class="grid grid-rows-2 gap-4 mt-4 md:mt-0" v-if="stories.length > 1">
                  <Link :href="route('publications-detail', { title: data.slug ? data.slug : data.title[lang], date:  new Date(data.created_at).toISOString().split('T')[0] })" class="grid grid-cols-[45%,55%] lg:grid-cols-[50%,50%] group gap-5" role="button" v-for="(data, i) in stories.slice(1)">
                     <div class="w-full h-full overflow-hidden rounded-2xl">
                        <img :src="data.banner"
                           alt="" 
                           class="object-cover h-[140px] md:h-[219px] lg:h-[182px] w-full group-hover:scale-125 transform ease-in-out duration-300">
                     </div>
                     <div class="w-[95%]">
                        <p class="text-white text-[10px] sm:text-[16px] w-full">{{ formatDate(data.created_at) }}</p>
                        <p class="text-white text-[16px] sm:text-[20px] w-full font-bold">{{ data.title[locale] }}</p>
                     </div>
                  </Link>
               </div>

            </div>
         </div>
      </div>

      <!-- publications section -->
      <div class="relative">
         <div class="w-full h-72 md:h-96 bg-[#D86727]"></div>
         <div class="w-full h-72 md:h-52 bg-[#2F3C87]"></div>

         <div class="absolute w-full top-[70%] -translate-y-1/2 flex justify-center h-96">
            <div class="bg-white max-w-7xl h-full w-full rounded-3xl mx-8">
               <div class="flex flex-col md:flex-row justify-center items-center md:items-end gap-10 lg:gap-32">
                  <div class="w-[15rem] border-2 border-gray-200 rounded-3xl -mt-32 flex md:hidden">
                     <img :src="newPublications.banner" alt="publication" class="w-full h-full rounded-3xl">
                  </div>
                  <div class="pb-5 px-5">
                     <h1 class="font-playfair text-[#262C51] text-5xl font-bold">{{ $t('home.publication') }}</h1>
                     <p class="text-[#262C51] text-base font-medium mt-5">{{ formatDate(newPublications.created_at) }}</p>
                     <p class="text-[#] text-2xl font-semibold max-w-56">{{ newPublications.title[locale] }}</p>
                  </div>
                  <div class="w-[24rem] lg:w-[26rem] h-[26rem] border-2 border-gray-200 rounded-3xl -mt-32 hidden md:flex">
                     <img :src="newPublications.banner" alt="publication" class="w-full h-full rounded-3xl">
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- instagram section -->
       <div class="w-full flex justify-center bg-[#2F3C87] pt-28">
         <div class="max-w-7xl flex flex-wrap gap-5 justify-between w-full px-8">
            <h1 class="font-playfair text-white text-5xl font-bold">{{ $t('home.follow') }}</h1>
            <p class="text-white text-2xl font-bold flex gap-2 items-center"><img role="button" src="/assets/icon/instagram.svg" alt="instagram" class="w-8 h-8"> @williamlilyfoundation</p>
         </div>
      </div>
      <div class="flex gap-3 bg-[#2F3C87] pt-10 pb-20 overflow-x-auto [&::-webkit-scrollbar]:w-1 [&::-webkit-scrollbar]:h-0">
         <div class="w-72 aspect-square rounded-3xl overflow-hidden flex-shrink-0" v-for="i in 15">
            <img src="/assets/img/home/news.jpg" alt="instagram" class="w-full h-full object-cover">
         </div>
      </div>

      <Footer/>
   </div>
</template>

<style scoped>
:deep(.swiper-pagination-bullet){
  background: white !important;
  opacity: 10;
}

:deep(.swiper-pagination-bullet-active){
  background: #D86727 !important;
  width: 40px;
  border-radius: 10px;
}

.img-our-program::after {
   border-radius: 1rem;
   content: "";
   position: absolute;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   background: linear-gradient(0deg,rgba(18, 24, 58, 1) 0%, rgba(18, 24, 58, 0.49) 61%, rgba(18, 24, 58, 0) 100%);
}

.image-container {
  position: relative;
  width: 100%;
  overflow: hidden;
  height: 100%;
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