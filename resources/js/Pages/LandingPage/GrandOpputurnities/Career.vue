<script setup>
import { Link } from '@inertiajs/vue3';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import { useI18n } from 'vue-i18n';

const props = defineProps({
   careers: Object
})

const { locale } = useI18n()
</script>

<template>
   <div class="w-full z-0 font-lato text-[18px] overflow-hidden">
      <Navbar/>

      <div class="w-full text-center relative">
         <div class="image-container">
            <img src="/assets/img/career/bg-section.png" alt="about-us">
         </div>
         <h1 class="text-white text-[2rem] md:text-[42px] leading-[1.1] font-playfair font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2 uppercase">
            {{ $t('career.title') }}
         </h1>
      </div>

      <div class="flex justify-center w-full my-20">
         <div class="max-w-7xl px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
               <Link :href="route('career-detail', data.id)" class="relative w-full fading group" role="button" v-for="(data, i) in careers" :key="i">
                  <div class="relative w-full fading group">
                     <div class="w-full h-[20rem] overflow-hidden img-our-program rounded-2xl">
                        <img :src="data.image"
                              alt="" 
                              class="object-cover w-full h-full group-hover:scale-125 transform ease-in-out duration-300">
                     </div>
                  </div>
                  <p class="w-full text-gray-500 mt-3">{{ data.type }}</p>
                  <p class="w-full mt-3">{{ data.title[locale] }}</p>
               </Link>
            </div>

            <!-- <div class="w-full flex justify-center mt-10">
               <button @click="showMore" class="bg-[#E75E00] px-6 py-3 text-white rounded-full w-fit">See More</button>
            </div> -->
         </div>
      </div>

      <Footer/>
   </div>
</template>

<style scoped>
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