<script setup>
import { ref } from 'vue';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import { Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { formatDate } from '@/Helper/FormatDate';

const props = defineProps({
   programCategories: Object,
   programCategory: Object,
   category: String
})

const categories = [
   'Early Childhood Development',
   'Literacy & Numeracy  For Early Grads',
   'Economic Empowerment'
]

const { locale } = useI18n()

const tabActive = ref(props.category)
</script>

<template>
   <div class="w-full z-0 font-lato text-[18px] overflow-hidden">
      <Navbar/>

      <div class="w-full text-center relative">
         <div class="image-container">
            <img src="/assets/img/ourprogram/program1.png" alt="our-program">
         </div>
         <h1 class="text-white text-[2rem] md:text-[72px] leading-[1.1] font-playfair font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2">
            {{ programCategory.title[locale] }}
         </h1>
      </div>

      <div class="w-full flex justify-center my-20">
         <div class="max-w-7xl w-full px-8">
            <div class="grid w-full grid-cols-1 lg:grid-cols-[25%,70%] gap-10">
               <div class="lg:hidden">
                  <Link :href="route('sub-program', i.slug)" v-for="(i, index) in programCategories" class="p-3 text-base" :class="tabActive == i.slug ? 'bg-[#D86727] text-white font-semibold' : 'border border-[#D86727]'">{{ i.title[locale] }}</Link>
               </div>
               <div class="hidden lg:flex flex-col">
                  <Link :href="route('sub-program', i.slug)" v-for="(i, index) in programCategories" class="p-3 text-base" :class="tabActive == i.slug ? 'bg-[#D86727] text-white font-semibold' : 'border border-[#D86727]', index == 0 ? 'rounded-tr-[20px]' : index == programCategories.length - 1 ? 'rounded-br-[20px]' : ''">{{ i.title[locale] }}</Link>
               </div>
               <div class="w-full">
                  <p class="text-justify" v-html="programCategory.description[locale]"></p>

                  <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-10">
                     <Link class="relative w-full fading group" role="button" :href="route('program-detail', { category: programCategory.id, title: data.slug ? data.slug : data.title[locale], date: new Date(data.created_at).toISOString().split('T')[0] })" v-for="(data, i) in programCategory.programs">
                        <div class="w-full h-40 overflow-hidden img-our-program rounded-2xl">
                           <img :src="data.banner" alt="program" class="object-cover w-full h-full group-hover:scale-125 transform ease-in-out duration-300">
                        </div>
                        <div class="flex w-full justify-between my-5">
                           <p class="text-gray-500">{{ formatDate(data.created_at) }}</p>
                           <p class="bg-[#2B3E8C] text-sm p-1 px-3 rounded-full text-white">{{ data.status }}</p>
                        </div>
                        <p class="w-full font-medium">{{ data.title[locale] }}</p>
                     </Link>
                  </div>
               </div>
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