<script setup>
import ArrowBack from '@/Icons/ArrowBack.vue';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import { Link } from '@inertiajs/vue3';
import Accordion from '../Components/Accordion.vue';
import { useI18n } from 'vue-i18n';

const props = defineProps({
   programCategories: Object
})

const { locale } = useI18n()

const lists = [
   {
      question:
         'Apakah komunitas yang belum memiliki legalitas, atau berbentuk perusahaan, perusahaan daerah bisa mengakses dana hibah WLF baik secara mandiri maupun sebagai anggota konsorsium?',
      answer:
         'Tidak bisa. Call for Concept Notes yang sedang dipublikasikan saat ini ditujukan untuk organisasi masyarakat sipil atau organisasi non-profit yang berbadan hukum resmi sebagai yayasan atau perkumpulan serta terdaftar pada Kementerian Hukum dan Hak Asasi Manusia.',
   },
   {
      question:
         'Apakah organisasi yang belum memiliki NPWP dan/atau belum melaporkan pajak tahunan bisa mengajukan concept note?',
      answer:
         '-',
   },
   {
      question:
         'Terkait pengalaman pengelolaan dana, apakah ada batas minimal besaran dana yang pernah dikelola maupun ketentuan khusus terkait sumber pendanaannya?',
      answer:
         '-',
   },
   {
      question:
         'Apakah organisasi yang mengajukan usulan proyek harus mempunyai pengalaman terkait proyek tersebut?',
      answer:
         '-',
   },
   {
      question:
         'Apakah organisasi yang belum pernah dilakukan audit eksternal dapat mengajukan concept note?',
      answer:
         '-',
   },
]
</script>

<template>
   <div class="w-full z-0 font-lato text-[18px] overflow-hidden">
      <Navbar/>

      <div class="w-full text-center relative">
         <div class="image-container">
            <img src="/assets/img/about/bg-section.png" alt="about-us">
         </div>
         <h1 class="text-white text-[2rem] md:text-[42px] leading-[1.1] font-playfair font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2 uppercase">
            {{ $t('grandopp.title') }}
         </h1>
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="max-w-3xl px-8 text-[#000000] font-medium flex flex-col justify-center gap-10">
            <p class="font-extrabold text-center">{{ $t('cfcn.subtitle') }}</p>
            <p class="">{{ $t('cfcn.description') }}</p>
         </div>
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="w-full flex justify-center">
            <div class="max-w-7xl px-8 w-full">
               <div class="flex gap-5 justify-start my-8 overflow-x-auto [&::-webkit-scrollbar]:w-1 [&::-webkit-scrollbar]:h-0 [&::-webkit-scrollbar-track]:bg-[#5A5A5A] [&::-webkit-scrollbar-thumb]:bg-[#D7261C]">
                  <Link :href="route('sub-program', data.slug)" class="w-[19rem] h-[23rem] sm:w-[24rem] sm:h-[35rem] flex-shrink-0 flex justify-start relative fading group" v-for="(data, i) in programCategories" :key="i">
                     <div class="w-full h-full overflow-hidden rounded-2xl img-our-program">
                        <img :src="data.image" class="object-cover w-full h-full transition duration-500 ease-in-out group-hover:scale-125">
                     </div>
                     <div class="h-full w-full absolute p-8 z-20 flex flex-col justify-between">
                        <div class="flex justify-end w-full">
                           <ArrowBack class="bg-white/30 backdrop-blur-sm border-white border-2 rounded-full p-1 w-6 h-6 sm:w-9 sm:h-9 text-[#D86727] group-hover:text-white group-hover:bg-[#D86727] ease-in-out duration-500 rotate-[135deg] z-20 mb-8" />
                        </div>
                        <div class="">
                           <p class="text-white text-[20px] sm:text-3xl w-full font-bold">{{ data.title[locale] }}</p>
                        </div>
                     </div>
                  </Link>
               </div>
            </div>
         </div>
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="max-w-3xl px-8 text-[#000000] font-medium flex flex-col justify-center gap-10">
            <p class="">{{ $t('cfcn.description.1') }}</p>
            <p class="">{{ $t('cfcn.description.2') }}</p>
            <p class="">{{ $t('cfcn.description.3') }}</p>
         </div>
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="max-w-5xl px-8">
            <div class="grid grid-cols-1 lg:grid-cols-[30%,70%] gap-5">
               <div class="w-72 h-80">
                  <img src="/assets/img/grandopp/step1.jpg" alt="grandopp" class="w-full h-full object-cover rounded-[20px]">
               </div>
               <div class="flex flex-col gap-5">
                  <p class="text-xl bg-[#D86727] rounded-full p-1 w-8 h-8 text-center text-white">1</p>
                  <p class="font-bold">{{ $t('cfcn.step1.title') }}</p>
                  <p>{{ $t('cfcn.step1.description') }}</p>
                  <Link :href="route('contact')" class="bg-[#D86727] hover:bg-[#e47636] ease-in-out duration-500 px-6 py-2 text-white rounded-full font-medium w-fit">{{ $t('cfcn.sendbutton') }}</Link>
               </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-[70%,30%] mt-20 gap-5">
               <div class="flex flex-col gap-5">
                  <p class="text-xl bg-[#D86727] rounded-full p-1 w-8 h-8 text-center text-white">2</p>
                  <p class="font-bold">{{ $t('cfcn.step2.title') }}</p>
                  <p>{{ $t('cfcn.step2.description') }}
                  </p>
                  <Link :href="route('contact')" class="bg-[#D86727] hover:bg-[#e47636] ease-in-out duration-500 px-6 py-2 text-white rounded-full font-medium w-fit">{{ $t('cfcn.sendbutton') }}</Link>
               </div>
               <div class="w-72 h-80">
                  <img src="/assets/img/grandopp/step2.jpg" alt="grandopp" class="w-full h-full object-cover rounded-[20px]">
               </div>
            </div>
         </div>
      </div>

      <div class="w-full flex justify-center my-20">
         <div class="max-w-3xl px-8 text-[#000000] font-medium flex flex-col justify-center gap-3">
            <p class="">{{ $t('cfcn.afterdesc1') }}</p>
            <p>{{ $t('cfcn.afterdesc2') }}</p>
            <p>{{ $t('cfcn.afterdesc3') }}</p>
         </div>
      </div>

      <div class="w-full flex justify-center mt-36 mb-20">
         <div class="max-w-3xl px-8 space-y-15">
            <h1 class="uppercase text-4xl font-playfair font-bold text-center">{{ $t('cfcn.faq.title') }}</h1>
            <p class="text-center">{{ $t('cfcn.faq.description') }}</p>

            <Accordion :list="lists"/>
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