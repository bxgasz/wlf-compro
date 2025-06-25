<script setup>
import { ref } from 'vue';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import { Link } from '@inertiajs/vue3';
import { formatDate } from '@/Helper/FormatDate';
import { useI18n } from 'vue-i18n';

const props = defineProps({
   datas: Object,
   type: String
})

const { locale } = useI18n()

const categories = [
   { 
      title: {
         en: 'Learning Documents',
         id: 'Dokumen Pembelajaran'
      },
      value: 'publication'
   },
   { 
      title: {
         en: 'Annual Report',
         id: 'Laporan Tahunan'
      },
      value: 'annual_report' 
   },
   { 
      title: {
         en: 'Stories',
         id: 'Cerita'
      },
      value: 'story' 
   },
]

const tabActive = ref(props.type)

const lang = 'en'
</script>

<template>
   <div class="w-full z-0 font-lato text-[18px] overflow-hidden">
      <Navbar/>

      <div class="w-full text-center relative">
         <div class="image-container-hero">
            <img src="/assets/img/ourprogram/bg-section.png" alt="our-program">
         </div>
         <h1 class="text-white text-[2rem] md:text-[72px] leading-[1.1] font-playfair font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2 uppercase">
            {{ $t('publications.title') }}
         </h1>
      </div>

      <div class="w-full flex justify-center my-20">
         <div class="max-w-7xl w-full px-8">
            <div class="grid grid-cols-1 lg:grid-cols-[25%,70%] gap-10">
               <div class="lg:hidden">
                  <Link :href="route('publications', { type: i.value })" role="button" v-for="(i, index) in categories" @click="tabActive = i" class="p-3 text-base" :class="tabActive == i.value ? 'bg-[#D86727] text-white font-semibold' : 'border border-[#D86727]'">{{ i.title[locale] }}</Link>
               </div>
               <div class="hidden lg:flex flex-col">
                  <Link :href="route('publications', { type: i.value })" role="button" v-for="(i, index) in categories" @click="tabActive = i" class="p-3 text-base" :class="tabActive == i.value ? 'bg-[#D86727] text-white font-semibold' : 'border border-[#D86727]', index == 0 ? 'rounded-tr-[20px]' : index == categories.length - 1 ? 'rounded-br-[20px]' : ''">{{ i.title[locale] }}</Link>
               </div>
               <div class="">
                  <div class="w-full" v-if="datas.length > 0 && tabActive != 'publication'">
                     <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 min-h-[364px]">
                        <Link :href="route('publications-detail', { title: datas[0].slug ? datas[0].slug : datas[0].title[lang], date:  new Date(datas[0].created_at).toISOString().split('T')[0] })" class="relative w-full fading bg-white group" role="button">
                           <div class="w-full h-full overflow-hidden fading rounded-[20px]">
                              <img :src="datas[0].banner"
                                    alt="Excavator" 
                                    class="object-cover w-full rounded-[20px] h-full group-hover:scale-125 transform ease-in-out duration-300">
                           </div>
                           <div class="absolute h-full w-full flex flex-col top-0 justify-end bg-opacity-50  p-8 z-20">
                              <div class="">
                                 <p class="text-gray-400 text-[10px] sm:text-[16px] w-full">{{ formatDate(datas[0].created_at, lang) }}</p>
                                 <p class="text-white text-[16px] sm:text-[20px] w-full">{{ datas[0].title[lang] }}</p>
                              </div>
                           </div>
                        </Link>
                        
                        <div class="grid grid-rows-2 gap-4 mt-4 md:mt-0">
                           <Link v-if="datas.length >= 2" :href="route('publications-detail', { title: datas[1].slug ? datas[1].slug : datas[1].title[lang], date:  new Date(datas[1].created_at).toISOString().split('T')[0] })" class="grid grid-cols-1 lg:grid-cols-[40%,60%] group gap-5" role="button">
                              <div class="w-full h-full overflow-hidden rounded-[20px]">
                                 <img :src="datas[1].banner"
                                    alt="Excavator" 
                                    class="object-cover h-[219px] lg:h-[182px] rounded-[20px] w-full group-hover:scale-125 transform ease-in-out duration-300">
                              </div>
                              <div class="md:ml-4 mt-4 md:mb-4 lg:mt-0">
                                 <p class="text-gray-400 text-[10px] sm:text-[16px] w-full">{{ formatDate(datas[1].created_at, lang) }}</p>
                                 <p class=" text-[16px] sm:text-[20px] w-full">{{ datas[1].title[lang] }}</p>
                              </div>
                           </Link>

                           <Link v-if="datas.length >= 3" :href="route('publications-detail', { title: datas[2].slug ? datas[2].slug : datas[2].title[lang], date:  new Date(datas[2].created_at).toISOString().split('T')[0] })" class="grid grid-cols-1 lg:grid-cols-[40%,60%] group" role="button">
                              <div class="w-full h-full overflow-hidden rounded-[20px]">
                                 <img :src="datas[2].banner"
                                    alt="Excavator" 
                                    class="object-cover h-[219px] lg:h-[182px] w-full group-hover:scale-125 transform ease-in-out duration-300 rounded-[20px]">
                              </div>
                              <div class="md:ml-4 mt-4 lg:mt-0">
                                 <p class="text-gray-400 text-[10px] sm:text-[16px] w-full">{{ formatDate(datas[2].created_at, lang) }}</p>
                                 <p class=" text-[16px] sm:text-[20px] w-full">{{ datas[2].title[lang] }}</p>
                              </div>
                           </Link>
                        </div>

                     </div>

                     <div class="mt-8">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                           <Link
                              v-for="(item, index) in datas.slice(3)"
                              :key="index"
                              :href="route('publications-detail', { title: item.slug ? item.slug : item.title[lang], date: new Date(item.created_at).toISOString().split('T')[0] })"
                              class="group flex flex-col w-full h-full rounded overflow-hidden"
                           >
                              <div class="w-full h-[219px] lg:h-[182px] overflow-hidden relative">
                              <img
                                 :src="item.banner"
                                 alt="Thumbnail"
                                 class="object-cover w-full h-full group-hover:scale-125 transition-transform duration-300 ease-in-out rounded-[20px]"
                              />
                              </div>
                              <div class="p-4 flex flex-col justify-between flex-1">
                                 <p class="text-gray-400 text-xs sm:text-sm">{{ formatDate(item.created_at, lang) }}</p>
                                 <p class=" text-base mt-2">{{ item.title[lang] }}</p>
                              </div>
                           </Link>
                        </div>
                     </div>


                     <!-- <div class="w-full flex justify-center mt-10">
                        <button @click="showMore" class="bg-[#E75E00] px-6 py-3 text-white rounded-full w-fit">See More</button>
                     </div> -->
                  </div>

                  <div class="w-full" v-if="datas.length > 0 && tabActive == 'publication'">
                     <div class="mt-8">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                           <a
                              v-for="(item, index) in datas"
                              :key="index"
                              :href="item.document"
                              class="group flex flex-col w-full h-full rounded overflow-hidden"
                           >
                              <div class="w-full h-[219px] lg:h-[182px] overflow-hidden relative">
                              <img
                                 :src="item.banner"
                                 alt="Thumbnail"
                                 class="object-cover w-full h-full group-hover:scale-125 transition-transform duration-300 ease-in-out rounded-[20px]"
                              />
                              </div>
                              <div class="p-4 flex flex-col justify-between flex-1">
                                 <!-- <p class="text-gray-400 text-xs sm:text-sm">{{ formatDate(item.created_at, lang) }}</p> -->
                                 <p class=" text-base mt-2">{{ item.title[lang] }}</p>
                              </div>
                           </a>
                        </div>
                     </div>


                     <!-- <div class="w-full flex justify-center mt-10">
                        <button @click="showMore" class="bg-[#E75E00] px-6 py-3 text-white rounded-full w-fit">See More</button>
                     </div> -->
                  </div>
                  <div class="w-full text-center " v-if="!datas.length">No data provided</div>
               </div>
            </div>
         </div>
      </div>

      <Footer/>
   </div>
</template>

<style scoped>
.image-container-hero {
  position: relative;
  width: 100%;
  overflow: hidden;
  height: 20rem;
}

.image-container-hero::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg,rgba(18, 24, 58, 0.8) 0%, rgba(18, 24, 58, 0.5) 50%, rgba(18, 24, 58, 0.8) 100%);
  pointer-events: none;
}

.image-container-hero img, .image-container-hero video{
   width: 100%;
   height: 100%;
   object-fit: cover;
}

.fading::after {
   content: '';
   position: absolute;
   top: 0;
   left: 0;
   right: 0;
   bottom: 0;
   background: linear-gradient(to bottom, rgba(26, 27, 32, 0) 0%, rgba(26, 27, 32, 1) 100%);
   border-radius: 20px;
}
</style>