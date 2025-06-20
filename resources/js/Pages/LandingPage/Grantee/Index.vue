<script setup>
import { ref } from 'vue';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import ArrowBack from '@/Icons/ArrowBack.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
   granteePartners: Object
})

const tabActive = ref('home')

const partners = [
   {
      title: 'acer',
      image: '/assets/img/about/acer.png'
   },
   {
      title: 'Sumba Integrated Development',
      image: '/assets/img/about/sid.png'
   },
   {
      title: 'Bina Tani Sejahtera',
      image: '/assets/img/about/binatani.png'
   },
   {
      title: 'SATUNAMA',
      image: '/assets/img/about/satunama.png'
   },
   {
      title: 'DESMA',
      image: '/assets/img/about/desma.png'
   },
   {
      title: 'Platform Usaha Sosial',
      image: '/assets/img/about/plus.png'
   },
   {
      title: 'INSPIRASI',
      image: '/assets/img/about/inspirasi.png'
   },
   {
      title: 'REMDEC SWAPRAKARSA',
      image: '/assets/img/about/remdec.png'
   },
]
</script>

<template>
   <div class="w-ful z-0 bg-white font-lato font-light text-[18px] overflow-hidden">
      <Navbar/>

      <div class="w-full text-center relative">
         <div class="image-container">
            <img src="/assets/img/about/bg-section.png" alt="about-us">
         </div>
         <h1 class="text-white text-[2rem] md:text-[72px] leading-[1.1] font-playfair font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2">
            {{ $t('grantee.title') }}
         </h1>
      </div>

      <div class="w-full flex justify-start lg:justify-center overflow-auto px-8 bg-[#2F3C87] lg:gap-8 h-24 items-end">
         <div @click="tabActive = 'home'" role="button" :class="tabActive == 'home' ? 'bg-white rounded-t-xl text-[#2F3C87]' : 'text-white'" class="flex justify-center items-center px-10 h-[80%] font-bold">Home</div>
         <div @click="tabActive = 'panduan'" role="button" :class="tabActive == 'panduan' ? 'bg-white rounded-t-xl text-[#2F3C87]' : 'text-white'" class="flex justify-center items-center px-10 h-[80%] font-bold">Panduan</div>
         <div @click="tabActive = 'format_pelaporan'" role="button" :class="tabActive == 'format_pelaporan' ? 'bg-white rounded-t-xl text-[#2F3C87]' : 'text-white'" class="flex justify-center items-center px-10 h-[80%] font-bold">Format Laporan</div>
         <div @click="tabActive = 'pelaporan'" role="button" :class="tabActive == 'pelaporan' ? 'bg-white rounded-t-xl text-[#2F3C87]' : 'text-white'" class="flex justify-center items-center px-10 h-[80%] font-bold">Pelaporan</div>
      </div>

      <template v-if="tabActive == 'home'">
         <div class="flex justify-center mt-20">
            <div class="max-w-7xl w-full px-8">
               <div class="grid grid-cols-1 lg:grid-cols-[30%,70%]">
                  <h1 class="font-montserrat text-[#2F3C87] text-5xl font-bold">{{ $t('grantee.question') }}</h1>
                  <div class="font-medium mt-5 lg:mt-0">
                     <p>{{ $t('grantee.description.1') }}</p>
                     <p>{{ $t('grantee.description.2') }}</p>
                  </div>
               </div>
            </div>
         </div>

         <div class="flex w-full justify-center">
            <div class="flex justify-center mt-20 w-full bg-[#2B3E8C] rounded-t-[300px] max-w-[1600px]">
               <div class="max-w-7xl px-8 my-20">
                  <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                     <div class="w-full text-white space-y-5">
                        <div class="h-90 w-full">
                           <img src="/assets/img/grantee/grantee-1.jpg" alt="grantee" class="w-full h-full object-cover rounded-t-[180px] lg:rounded-tl-[150px] lg:rounded-tr-none">
                        </div>
                        <h3 class="text-2xl font-bold">{{ $t('grantee.values.title') }}</h3>
                        <p>{{ $t('grantee.values.description') }}</p>
                        <ul class="list-disc">
                           <li v-for="i in 7">{{ $t('grantee.values.' + i) }}</li>
                        </ul>
                     </div>

                     <div class="w-full text-white space-y-5">
                        <div class="h-90 w-full">
                           <img src="/assets/img/grantee/grantee-1.jpg" alt="grantee" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-2xl font-bold">{{ $t('grantee.guiding.title') }}</h3>
                        <p>{{ $t('grantee.guiding.description') }}</p>
                     </div>

                     <div class="w-full text-white space-y-5">
                        <div class="h-90 w-full">
                           <img src="/assets/img/grantee/grantee-3.jpg" alt="grantee" class="w-full h-full object-cover lg:rounded-tr-[150px]">
                        </div>
                        <h3 class="text-2xl font-bold">{{ $t('grantee.cycle.title') }}</h3>
                        <ul class="list-decimal">
                           <li>{{ $t('grantee.cycle.1') }}</li>
                           <li>{{ $t('grantee.cycle.2') }}</li>
                           <li>{{ $t('grantee.cycle.3') }}</li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="relative">
            <div class="w-full h-20 lg:h-72 md:h-52 bg-[#2B3E8C]"></div>
            <div class="flex justify-center mt-4 w-full">
               <div class="w-full max-w-[1600px] h-96 rounded-t-[35%] lg:rounded-t-full border-t border-[#D86727]"></div>
            </div>
            <div class="flex justify-center mt-4 w-full">
               <div class="w-full max-w-[1600px] h-[60rem] lg:h-96 rounded-t-[35%] lg:rounded-t-[200px] border-t border-[#D86727] -mt-52"></div>
            </div>

            <div class="absolute w-full top-[50%] -translate-y-1/2 flex justify-center">
               <div class="max-w-7xl h-full w-full mx-8 grid grid-cols-1 lg:grid-cols-2 justify-center gap-10">
                  <div class="w-full space-y-8">
                     <div class="w-full h-[248px] flex justify-center">
                        <img src="/assets/img/grantee/poin-1.png" alt="poin1" class="rounded-3xl h-full w-[80%] object-cover shadow-xl shadow-[#D86727]/20">
                     </div>
                     <h3 class="text-center text-2xl text-[#E75E00] font-bold">{{ $t('grantee.quarterly') }}</h3>
                     <p class="font-medium">{{ $t('grantee.quarterly.desc') }}</p>
                     <ul class="list-disc font-medium">
                        <li>{{ $t('grantee.quarterly.1') }}</li>
                        <li>{{ $t('grantee.quarterly.2') }}</li>
                     </ul>
                  </div>
                  <div class="w-full space-y-8">
                     <div class="w-full h-[248px] flex justify-center">
                        <img src="/assets/img/grantee/poin-2.png" alt="poin2" class="rounded-3xl h-full w-[80%] object-cover shadow-xl shadow-[#D86727]/20">
                     </div>
                     <h3 class="text-center text-2xl text-[#E75E00] font-bold">{{ $t('grantee.question.title') }}</h3>
                     <p class="font-medium">{{ $t('grantee.question.description') }}</p>
                  </div>
               </div>
            </div>
         </div>

      </template>

      <template v-if="tabActive == 'panduan'">
         <div class="flex justify-center mt-20">
            <div class="max-w-7xl w-full px-8">
               <p class="font-medium">Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. </p>
            </div>
         </div>

         <div class="flex justify-center my-20">
            <div class="max-w-7xl w-full px-8">
               <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                  <div v-for="i in 6" class="border border-[#E75E00] rounded-t-[20px]">
                     <div class="w-full h-[345px]">
                        <img src="/assets/img/grantee/poin-1.png" alt="lala" class="w-full h-full object-cover rounded-t-[20px]">
                     </div>
                     <div class="bg-[#E75E00] text-center text-white py-5">
                        <p class="text-2xl font-extrabold">Title 1</p>
                        <p class="text-2xl font-extrabold">Sentence 1</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </template>

      <template v-if="tabActive == 'pelaporan'">
         <div class="w-full flex justify-center mt-20">
            <div class="max-w-3xl px-8 text-[#000000] font-medium flex flex-col justify-center gap-10">
               <p class="">{{ $t('grantee.reporting.1') }}</p>
               <p class="">{{ $t('grantee.reporting.2') }}</p>
               <p class="">{{ $t('grantee.reporting.3') }}</p>
               <ul class="list-disc">
                  <li>{{ $t('grantee.reporting.4') }}</li>
                  <li>{{ $t('grantee.reporting.5') }}</li>
                  <li>{{ $t('grantee.reporting.6') }}</li>
               </ul>
            </div>
         </div>
         <div class="w-full flex justify-center mt-20" v-if="granteePartners.length > 0">
            <div class="max-w-7xl px-8">
               <div class="flex flex-wrap justify-center gap-5 w-full">
                  <Link :href="data.link" class="relative border border-[#E75E00] rounded-[20px] p-3 lg:w-[calc(18%)] shadow-xl shadow-[#D86727]/20" v-for="(data, i) in granteePartners" :key="i">
                     <div class="w-full h-56 flex items-center">
                        <img :src="data.logo" alt="image" class="w-full object-cover rounded-t-[20px]">
                     </div>
                     <div class="h-full w-full absolute p-8 z-20 top-0 flex flex-col justify-between">
                        <div class="flex justify-end w-full">
                           <ArrowBack class="bg-white/30 backdrop-blur-sm border-white border-2 rounded-full p-1 w-6 h-6 sm:w-9 sm:h-9 text-[#D86727] group-hover:text-white group-hover:bg-[#D86727] ease-in-out duration-500 rotate-[135deg] z-20 mb-8" />
                        </div>
                     </div>
                     <p class="font-montserrat text-[#E75E00] font-bold text-center capitalize">{{ data.title }}</p>
                  </Link>
               </div>
            </div>
         </div>
         <div class="w-full flex justify-center my-20">
            <div class="max-w-3xl px-8 text-[#000000] font-medium flex flex-col justify-center gap-10">
               <p class=""></p>
            </div>
         </div>
      </template>

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