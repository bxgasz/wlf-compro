<script setup>
import { Link } from '@inertiajs/vue3';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Pagination, A11y, Autoplay, Navigation } from 'swiper/modules'
import "swiper/css";
import "swiper/css/pagination";
import 'swiper/css/navigation';
import "swiper/css/autoplay";
import ChevronIcon from '@/Icons/ChevronIcon.vue';
import { useI18n } from 'vue-i18n';

const props = defineProps({
   programCategories: Object
})

const modules = [
   Autoplay,
   Pagination,
   Navigation,
   A11y
]

const { locale } = useI18n()

const ourProgram = [
   {
      title: 'early childhood development',
      link: route('sub-program', 'aaaaaaaaaaaaaaa'),
      data: [
         {
            img: '/assets/img/ourprogram/program1.png',
            title: 'lorem ipsum dolor sit amet',
            description: 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu.'
         },
         {
            img: '/assets/img/ourprogram/program1.png',
            title: 'lorem ipsum dolor sit amet',
            description: 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu.'
         },
         {
            img: '/assets/img/ourprogram/program1.png',
            title: 'lorem ipsum dolor sit amet',
            description: 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu.'
         },
      ]
   },
   {
      title: 'literacy &  numeracy for early grades',
      link: route('sub-program', 'categories'),
      data: [
         {
            img: '/assets/img/ourprogram/program2.png',
            title: 'lorem ipsum dolor sit amet',
            description: 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu.'
         },
         {
            img: '/assets/img/ourprogram/program2.png',
            title: 'lorem ipsum dolor sit amet',
            description: 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu.'
         },
         {
            img: '/assets/img/ourprogram/program2.png',
            title: 'lorem ipsum dolor sit amet',
            description: 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu.'
         },
      ]
   },
   {
      title: 'economic empowerment',
      link: route('sub-program', 'categories'),
      data: [
         {
            img: '/assets/img/ourprogram/program3.png',
            title: 'lorem ipsum dolor sit amet',
            description: 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu.'
         },
         {
            img: '/assets/img/ourprogram/program3.png',
            title: 'lorem ipsum dolor sit amet',
            description: 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu.'
         },
         {
            img: '/assets/img/ourprogram/program3.png',
            title: 'lorem ipsum dolor sit amet',
            description: 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu.'
         },
      ]
   },
]

</script>

<template>
   <div class="w-full z-0 font-lato text-[18px] overflow-hidden">
      <Navbar/>

      <div class="w-full text-center relative">
         <div class="image-container">
            <img src="/assets/img/ourprogram/bg-section.png" alt="our-program">
         </div>
         <h1 class="text-white text-[2rem] md:text-[72px] leading-[1.1] font-playfair font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2">
            {{ $t('our-program.title') }}
         </h1> 
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="max-w-7xl text-center px-8 text-[#000000] font-medium flex justify-center">
            <p class="max-w-[70%]">Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.</p>
         </div>
      </div>

      <div class="w-full flex justify-center">
         <div class="max-w-7xl px-8">
            <div v-if="programCategories.length > 0" class="w-full border border-[#E75E00] rounded-2xl shadow-xl shadow-[#D86727]/20 my-10" v-for="(list, index) in programCategories">
               <div class="grid grid-cols-1 lg:grid-cols-[30%,70%] lg:gap-5 p-5">
                  <div class="flex flex-col gap-5">
                     <h1 class="font-montserrat text-2xl sm:text-4xl text-[#E75E00] uppercase font-bold">{{ list.title[locale] }}</h1>
                     <Link :href="route('sub-program', list.slug)" class="bg-[#D86727] hover:bg-[#e47636] ease-in-out duration-500 px-6 py-2 text-white rounded-full font-medium w-fit mb-6">See What to do</Link>
                  </div>
                  <div class="w-full">
                     <swiper
                        ref="swiperRef"
                        :modules="modules"
                        :slide-per-view="3"
                        :pagination="{ el: '.custom-pagination-' + index, clickable: true }"
                        :navigation="{
                           nextEl: '.custom-next-' + index,
                           prevEl: '.custom-prev-' + index,
                        }"
                     >
                        <SwiperSlide v-if="list.programs.length > 0" v-for="(item, index) in list.programs">
                           <div class="grid grid-cols-1 lg:grid-cols-2 w-full gap-10">
                              <div class="w-full h-64">
                                 <img :src="item.banner" :alt="item.title[locale]" class="w-full h-full object-cover rounded-[20px]">
                              </div>
                              <div class="">
                                 <h1 class="font-montserrat text-2xl text-[#E75E00] uppercase font-bold">{{ item.title[locale] }}</h1>
                                 <p v-html="item.description[locale]"></p>
                              </div>
                           </div>
                        </SwiperSlide>
                        <div :class="`${'custom-pagination-' + index}`, 'md:!w-auto mt-5'"></div>
                     </swiper>
                  </div>
               </div>
               <div class="flex justify-end w-full items-center gap-5 mb-5 px-8 relative z-99">
                  <button class="bg-[#E75E00] rounded-full p-2 flex justify-center items-center" :class="'custom-prev-' + index">
                     <ChevronIcon class="w-[1rem] h-[1rem] text-white" />
                  </button>
                  <button class="bg-[#E75E00] rounded-full p-2 flex justify-center items-center rotate-180 custom-next" :class="'custom-next-' + index">
                     <ChevronIcon class="w-[1rem] h-[1rem] text-white" />
                  </button>
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