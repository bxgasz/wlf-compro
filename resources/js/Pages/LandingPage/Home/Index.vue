<script setup>
import Navbar from '../Components/Navbar.vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Pagination, A11y, Autoplay } from 'swiper/modules'
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/autoplay";
import { Link } from '@inertiajs/vue3';
import ArrowBack from '@/Icons/ArrowBack.vue';
import Footer from '../Components/Footer.vue';

const modules = [
   Autoplay,
   Pagination,
   A11y
]
</script>

<template>
   <div class="w-full bg-[#F1EAE7] z-0 font-lato font-light text-[18px] overflow-hidden">
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
            <swiper-slide class="relative h-full" v-for="i in 5">
               <div class="image-container">
                  <!-- <template v-if="banner.type == 'video'">
                     <video autoplay muted loop playsinline>
                           <source :src="banner.media" type="video/mp4">
                           {{ $t('news.detail.banner-vid') }}
                     </video>
                  </template>
                  <template v-else>
                     <img :src="banner.media" :alt="banner.title[locale]">
                  </template> -->
                  <img src="/assets/img/home/hero.png" alt="banner">
               </div>
               <div class="w-screen px-8 max-w-7xl absolute inset-0 left-1/2 top-[55%] -translate-x-1/2 -translate-y-1/2 flex items-center z-20">
                  <div class="flex flex-col justify-center z-20 w-[50%]">
                     <h1 class="text-white text-[2rem] md:text-[72px] leading-[1.1] font-playfair font-bold">
                        <!-- {{ banner.title[locale] }} -->
                        Equal opportunity for all indonesians flourish
                     </h1>
                     <div class="flex items-center my-5" v-if="true">
                        <!-- <p class="text-xl text-slate-300 ms-7">{{ banner.desc[locale] }}</p> -->
                        <p class="text-xl text-slate-300">To empower vulnerable and marginalized communities by bridging learning and access to opportunities in four intervention sectors.</p>
                     </div>
                     <div class="flex gap-4 items-center">
                        <Link href="#" class="bg-[#D86727] hover:bg-[#e47636] ease-in-out duration-500 px-6 py-2 text-white rounded-full font-medium w-fit">{{ locale == 'id' ? 'Pelajari Lebih Lanjut' : 'Learn More' }}</Link>
                        <!-- <Link v-if="banner.link_02" :href="banner.link_02" class="border border-[#D7261C] text-[#D7261C] px-6 py-3 font-semibold rounded-xl w-fit">{{ locale == 'id' ? 'Informasi Lainnya' : 'Another Information' }}</Link> -->
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
            Who We Are
         </h1>
         <div class="text-[#262C51] text-sm flex flex-col justify-between gap-5 lg:gap-0">
            <p class="font-medium text-base">The William & Lily Foundation (WLF) is a philanthropic organization to continue the philanthropic legacy of William and Lily Soeryadjaya in Indonesia. Established in 2009, William & Lily Foundation work as an active grant-making foundation that work closely with implementing partners to support three key areas that consist of education, health, and economic empowerment.</p>
            <Link href="#" class="bg-[#D86727] hover:bg-[#e47636] ease-in-out duration-500 px-6 py-2 text-white rounded-full font-medium w-fit">Read More</Link>
         </div>
         <div class="w-full">
            <img src="/assets/img/home/who-are-we.png" alt="video" class="h-60 w-full lg:w-[90%] object-cover rounded-3xl">
         </div>
      </div>
      </div>

      <div class="relative mt-20 w-full">
         <div class="w-full h-96 rounded-t-[35%] lg:rounded-t-full border-t border-[#D86727]"></div>
         <div class="w-full h-96 rounded-t-[35%] lg:rounded-t-full border-t border-[#D86727] -mt-52"></div>
         <div class="w-full h-72 md:h-96 bg-[#D86727] rounded-t-[35%] lg:rounded-t-full -mt-72"></div>

         <!-- our program section -->
         <div class="w-full flex justify-center absolute top-10">
            <div class="max-w-7xl px-8 w-full">
               <h1 class="text-5xl font-playfair text-[#262C51] font-bold text-center">Our Program</h1>
               <div class="flex gap-5 justify-start my-8 overflow-x-auto [&::-webkit-scrollbar]:w-1 [&::-webkit-scrollbar]:h-0 [&::-webkit-scrollbar-track]:bg-[#5A5A5A] [&::-webkit-scrollbar-thumb]:bg-[#D7261C]">
                  <Link href="#" class="w-[19rem] h-[23rem] sm:w-[24rem] sm:h-[27rem] flex-shrink-0 flex justify-start relative fading group" v-for="i in 3" :key="i">
                     <div class="w-full h-full overflow-hidden rounded-2xl img-our-program">
                        <img src="/assets/img/home/our-program.png" class="object-cover w-full h-full transition duration-500 ease-in-out group-hover:scale-125">
                     </div>
                     <div class="h-full w-full absolute p-8 z-20 flex flex-col justify-between">
                        <div class="flex justify-end w-full">
                           <ArrowBack class="bg-white/30 backdrop-blur-sm border-white border-2 rounded-full p-1 w-6 h-6 sm:w-9 sm:h-9 text-[#D86727] group-hover:text-white group-hover:bg-[#D86727] ease-in-out duration-500 rotate-[135deg] z-20 mb-8" />
                        </div>
                        <div class="">
                           <p class="text-white text-[20px] sm:text-3xl w-full font-bold">Early Childhood Development</p>
                        </div>
                     </div>
                  </Link>
               </div>
            </div>
         </div>
      </div>

      <!-- news section -->
      <div class="bg-[#D86727] flex justify-center">
         <div class="grid grid-cols-1 lg:grid-cols-[30%,70%] max-w-7xl px-8 h-[80%] gap-10 lg:gap-0">
            <div class="flex flex-col gap-5">
               <h1 class="font-playfair text-white text-5xl font-bold">News <br>& Stories</h1>
               <Link href="#" class="bg-[#2F3C87] hover:bg-[#3c50c0] ease-in-out duration-500 px-6 py-2 text-white rounded-full font-medium w-fit hidden lg:flex">See All News & Stories</Link>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-[40%,60%] gap-4 min-h-[364px]">
               <Link href="#" class="relative w-full fading group" role="button">
                  <div class="w-full h-full overflow-hidden img-our-program rounded-2xl">
                     <img src="/assets/img/home/news.jpg"
                           alt="" 
                           class="object-cover w-full h-full group-hover:scale-125 transform ease-in-out duration-300">
                  </div>
                  <div class="absolute h-full w-full flex flex-col top-0 justify-end bg-opacity-50 text-white p-8 z-20">
                     <div class="">
                        <p class="text-white text-[10px] sm:text-[16px] w-full">15 Feb 2025</p>
                        <p class="text-white text-[16px] sm:text-[20px] w-full font-medium">Pak Ape dan Kelas yang Lebih Hidup Berkat Metode Mengajar Interaktif</p>
                     </div>
                  </div>
               </Link>
               
               <div class="grid grid-rows-2 gap-4 mt-4 md:mt-0">
                  <Link href="#" class="grid grid-cols-[45%,55%] lg:grid-cols-[50%,50%] group gap-5" role="button" v-for="i in 2">
                     <div class="w-full h-full overflow-hidden rounded-2xl">
                        <img src="/assets/img/home/news.jpg"
                           alt="" 
                           class="object-cover h-[140px] md:h-[219px] lg:h-[182px] w-full group-hover:scale-125 transform ease-in-out duration-300">
                     </div>
                     <div class="w-[95%]">
                        <p class="text-white text-[10px] sm:text-[16px] w-full">15 Feb 2025</p>
                        <p class="text-white text-[16px] sm:text-[20px] w-full font-bold">Pak Ape dan Kelas yang Lebih Hidup Berkat Metode Mengajar Interaktif</p>
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
                     <img src="/assets/img/home/publications.png" alt="publication" class="w-full h-auto rounded-3xl">
                  </div>
                  <div class="">
                     <h1 class="font-playfair text-[#262C51] text-5xl font-bold">New <br> Publication</h1>
                     <p class="text-[#262C51] text-base font-medium mt-5">16 Feb 2025</p>
                     <p class="text-[#] text-2xl font-semibold">Permata Petani</p>
                  </div>
                  <div class="w-[24rem] lg:w-[26rem] border-2 border-gray-200 rounded-3xl -mt-32 hidden md:flex">
                     <img src="/assets/img/home/publications.png" alt="publication" class="w-full h-auto rounded-3xl">
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- instagram section -->
       <div class="w-full flex justify-center bg-[#2F3C87] pt-28">
         <div class="max-w-7xl flex flex-wrap gap-5 justify-between w-full px-8">
            <h1 class="font-playfair text-white text-5xl font-bold">Follow Us</h1>
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