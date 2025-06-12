<script setup>
import { Link } from '@inertiajs/vue3';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';

const showMore = () => {

}
</script>

<template>
   <div class="w-full z-0 font-lato text-[18px] overflow-hidden">
      <Navbar/>

      <div class="w-full text-center relative">
         <div class="image-container">
            <img src="/assets/img/ourImpact/bg-section.jpg" alt="ourImpact">
         </div>
         <h1 class="text-white text-[2rem] md:text-[72px] leading-[1.1] font-montserrat font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2">
            {{ $t('our-impact.title') }}
         </h1>
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="max-w-7xl text-center px-8 text-[#000000] font-medium flex justify-center">
            <p class="max-w-[70%]">Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.</p>
         </div>
      </div>

      <div class="flex justify-center">
         <div class="relative w-full mt-20 max-w-[1600px]">
            <div class="w-full h-56 rounded-t-[35%] lg:rounded-t-full border-t border-[#D86727]"></div>

            <div class="w-full flex justify-center -mt-56">
               <div class="max-w-7xl px-8 w-full">
                  <div class="grid grid-cols-[25%,55%,20%] items-center">
                     <div class="flex flex-col gap-5">
                        <div class="">
                           <h2 class="text-4xl font-montserrat text-[#2B3E8C] font-bold">32.041 People</h2>
                           <p>reached</p>
                        </div>
                        <div class="">
                           <h2 class="text-4xl font-montserrat text-[#2B3E8C] font-bold">24 Villages</h2>
                           <p>served</p>
                        </div>
                        <div class="">
                           <h2 class="text-4xl font-montserrat text-[#2B3E8C] font-bold">67.286 Hours</h2>
                           <p>per day served</p>
                        </div>
                        <div class="">
                           <h2 class="text-4xl font-montserrat text-[#2B3E8C] font-bold">446 Youth</h2>
                           <p>involved</p>
                        </div>
                     </div>
                     <div class="w-full -mt-20">
                        <img src="/assets/img/ourImpact/img.png" alt="bg" class="w-full h-full object-contain">
                     </div>
                     <div class="flex flex-col gap-5 justify-center items-center">
                        <h2 class="text-4xl font-montserrat text-[#2B3E8C] font-bold">Sustainable Development Goals</h2>
                        <img src="/assets/img/about/values-1.png" alt="values-1" class="w-16 h-16">
                        <img src="/assets/img/about/values-2.png" alt="values-2" class="w-16 h-16">
                        <img src="/assets/img/about/values-3.png" alt="values-3" class="w-16 h-16">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="w-full text-center bg-[#2B3E8C]">
         <h2 class="text-4xl font-bold font-montserrat py-8 text-white">Stories of Our Impact</h2>
      </div>

      <div class="flex justify-center w-full my-20">
         <div class="max-w-7xl px-8 w-full">
            <div class="grid grid-cols-4 gap-16">
               <Link href="#" class="relative w-full fading group" role="button" v-for="i in 10" :key="i">
                  <div class="relative w-full fading group">
                     <div class="w-full h-[10rem] overflow-hidden img-our-program rounded-2xl">
                        <img src="/assets/img/ourImpact/imp-1.jpg"
                              alt="" 
                              class="object-cover w-full h-full group-hover:scale-125 transform ease-in-out duration-300">
                     </div>
                     <div class="absolute h-full w-full flex flex-col top-0 justify-end bg-opacity-50 text-white p-4 z-20">
                        <div class="">
                           <p class="text-white text-[10px] sm:text-[16px] w-full">15 Feb 2025</p>
                        </div>
                     </div>
                  </div>
                  <p class="w-full font-bold mt-3">Name</p>
                  <p class="w-full mt-3">Lorem Ipsum Title</p>
                  <p class="w-full mt-3">“Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean ”</p>
               </Link>
            </div>

            <div class="w-full flex justify-center mt-10">
               <button @click="showMore" class="bg-[#E75E00] px-6 py-3 text-white rounded-full w-fit">Read More Stories</button>
            </div>
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