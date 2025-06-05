<script setup>
import { ref } from 'vue';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import { Link } from '@inertiajs/vue3';
import { formatDate } from '@/Helper/FormatDate';

const categories = [
   'Product Knowledge',
   'Annual Report'
]

const tabActive = ref('Product Knowledge')

const lang = 'en'

const news = [
  {
    category_id: 1,
    slug: 'early-childhood-education',
    title: {
      en: 'Early Childhood Education Program Launched',
      id: 'Program Pendidikan Anak Usia Dini Diluncurkan'
    },
    created_at: '2025-05-15T10:30:00Z',
    banner: '/assets/img/ourprogram/program1.png',
  },
  {
    category_id: 2,
    slug: 'literacy-improvement-video',
    title: {
      en: 'Improving Literacy Through Community Programs',
      id: 'Meningkatkan Literasi Lewat Program Komunitas'
    },
    created_at: '2025-05-20T09:00:00Z',
    banner: '/assets/img/ourprogram/program1.png',
  },
  {
    category_id: 3,
    slug: '',
    title: {
      en: 'Empowering Women Through Microbusiness',
      id: 'Pemberdayaan Perempuan Melalui Usaha Mikro'
    },
    created_at: '2025-05-22T13:45:00Z',
    banner: '/assets/img/ourprogram/program1.png',
  },
  {
    category_id: 3,
    slug: '',
    title: {
      en: 'Empowering Women Through Microbusiness',
      id: 'Pemberdayaan Perempuan Melalui Usaha Mikro'
    },
    created_at: '2025-05-22T13:45:00Z',
    banner: '/assets/img/ourprogram/program1.png',
  },
  {
    category_id: 3,
    slug: '',
    title: {
      en: 'Empowering Women Through Microbusiness',
      id: 'Pemberdayaan Perempuan Melalui Usaha Mikro'
    },
    created_at: '2025-05-22T13:45:00Z',
    banner: '/assets/img/ourprogram/program1.png',
  },
  {
    category_id: 3,
    slug: '',
    title: {
      en: 'Empowering Women Through Microbusiness',
      id: 'Pemberdayaan Perempuan Melalui Usaha Mikro'
    },
    created_at: '2025-05-22T13:45:00Z',
    banner: '/assets/img/ourprogram/program1.png',
  },
]
</script>

<template>
   <div class="w-full z-0 font-lato text-[18px] overflow-hidden">
      <Navbar/>

      <div class="w-full text-center relative">
         <div class="image-container-hero">
            <img src="/assets/img/ourprogram/bg-section.png" alt="our-program">
         </div>
         <h1 class="text-white text-[2rem] md:text-[72px] leading-[1.1] font-playfair font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2">
            Publications
         </h1>
      </div>

      <div class="w-full flex justify-center my-20">
         <div class="max-w-7xl w-full px-8">
            <div class="grid grid-cols-[25%,70%] gap-10">
               <div class="">
                  <p role="button" v-for="(i, index) in categories" @click="tabActive = i" class="p-3 text-base" :class="tabActive == i ? 'bg-[#D86727] text-white font-semibold' : 'border border-[#D86727]', index == 0 ? 'rounded-tr-[20px]' : index == categories.length - 1 ? 'rounded-br-[20px]' : ''">{{ i }}</p>
               </div>
               <div class="">
                  <div class="w-full" v-if="news.length > 0">
                     <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 min-h-[364px]">
                        <Link :href="route('publications-detail', { category: news[0].category_id, title: news[0].slug ? news[0].slug : news[0].title[lang], date:  new Date(news[0].created_at).toISOString().split('T')[0] })" class="relative w-full fading bg-white group" role="button">
                           <div class="w-full h-full overflow-hidden fading rounded-[20px]">
                              <img :src="news[0].banner"
                                    alt="Excavator" 
                                    class="object-cover w-full rounded-[20px] h-full group-hover:scale-125 transform ease-in-out duration-300">
                           </div>
                           <div class="absolute h-full w-full flex flex-col top-0 justify-end bg-opacity-50  p-8 z-20">
                              <div class="">
                                 <p class="text-gray-400 text-[10px] sm:text-[16px] w-full">{{ formatDate(news[0].created_at, lang) }}</p>
                                 <p class="text-white text-[16px] sm:text-[20px] w-full">{{ news[0].title[lang] }}</p>
                              </div>
                           </div>
                        </Link>
                        
                        <div class="grid grid-rows-2 gap-4 mt-4 md:mt-0">
                           <Link v-if="news.length >= 2" :href="route('publications-detail', { category: news[1].category_id, title: news[1].slug ? news[1].slug : news[1].title[lang], date:  new Date(news[1].created_at).toISOString().split('T')[0] })" class="grid grid-cols-1 lg:grid-cols-[40%,60%] group gap-5" role="button">
                              <div class="w-full h-full overflow-hidden rounded-[20px]">
                                 <img :src="news[1].banner"
                                    alt="Excavator" 
                                    class="object-cover h-[219px] lg:h-[182px] rounded-[20px] w-full group-hover:scale-125 transform ease-in-out duration-300">
                              </div>
                              <div class="md:ml-4 mt-4 md:mb-4 lg:mt-0">
                                 <p class="text-gray-400 text-[10px] sm:text-[16px] w-full">{{ formatDate(news[1].created_at, lang) }}</p>
                                 <p class=" text-[16px] sm:text-[20px] w-full">{{ news[1].title[lang] }}</p>
                              </div>
                           </Link>

                           <Link v-if="news.length >= 3" :href="route('publications-detail', { category: news[2].category_id, title: news[2].slug ? news[2].slug : news[2].title[lang], date:  new Date(news[2].created_at).toISOString().split('T')[0] })" class="grid grid-cols-1 lg:grid-cols-[40%,60%] group" role="button">
                              <div class="w-full h-full overflow-hidden rounded-[20px]">
                                 <img :src="news[2].banner"
                                    alt="Excavator" 
                                    class="object-cover h-[219px] lg:h-[182px] w-full group-hover:scale-125 transform ease-in-out duration-300 rounded-[20px]">
                              </div>
                              <div class="md:ml-4 mt-4 lg:mt-0">
                                 <p class="text-gray-400 text-[10px] sm:text-[16px] w-full">{{ formatDate(news[2].created_at, lang) }}</p>
                                 <p class=" text-[16px] sm:text-[20px] w-full">{{ news[2].title[lang] }}</p>
                              </div>
                           </Link>
                        </div>

                     </div>

                     <div class="mt-8">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                           <Link
                              v-for="(item, index) in news.slice(3)"
                              :key="index"
                              :href="route('publications-detail', { category: item.category_id, title: item.slug ? item.slug : item.title[lang], date: new Date(item.created_at).toISOString().split('T')[0] })"
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


                     <div class="w-full flex justify-center mt-10">
                        <button @click="showMore" class="bg-[#E75E00] px-6 py-3 text-white rounded-full w-fit">See More</button>
                     </div>
                  </div>
                  <div class="w-full text-center " v-else>No data provided for News</div>
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

.image-container img, .image-container video{
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