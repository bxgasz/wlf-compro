<script setup>
import { Link, router } from '@inertiajs/vue3';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import { formatDate } from '@/Helper/FormatDate';
import { useI18n } from 'vue-i18n';
import { ref } from 'vue';

const props = defineProps({
   stories: Object,
   impact: Object
})

const { locale } = useI18n()

const impact = {
    title_1: {
        en: 'Direct beneficiaries',
        id: 'Penerima manfaat langsung'
    },
    subtitle_1: {
      en: '1.634 individuals',
      id: '1.634 individu'
    },
    title_2: {
        en: 'Indirect beneficiaries',
        id: 'Penerima manfaat tidak langsung'
    },
    subtitle_2: {
      en: '19.665 individuals',
      id: '19.665 individu'
    },
    title_3: {
        en: '5 districts',
        id: '5 Kabupaten'
    },
    title_4: {
        en: '89 villages',
        id: '89 Desa'
    },
    title_5: {
        en: '91 early childhood education centers (PAUD)',
        id: '91 PAUD'
    },
    title_6: {
        en: '38 primary schools',
        id: '38 SD'
    },
    title_7: {
        en: '2 vocational high schools (SMK)',
        id: '2 SMK'
    },
    title_8: {
        en: '29 teacher working groups (KKG/PKG)',
        id: '29 KKG / PKG'
    },
    title_9: {
        en: '71 integrated health posts (Posyandu)',
        id: '71 Posyandu'
    },
    title_10: {
        en: '58 local economic development groups',
        id: '58 Kelompok Pengembangan Ekonomi'
    },
}

const datas = ref([...props.stories.data ?? []])
const currentPage = ref(props.stories.current_page)
const lastPage = ref(props.stories.last_page)

const handleShowMore = () => {
   if (currentPage.value < lastPage.value) {
      router.get(route('our-impact', { page: currentPage.value + 1 }), {}, 
      {
         preserveScroll: true,
         preserveState: true,
         onSuccess: (page) => {
            datas.value.push(...page.props.stories.data)
            currentPage.value = page.props.stories.current_page
         }
      })
   }
}

const splitNumberText = (text) => {
  const match = text.match(/^(\d+)\s?(.*)/)
  return match ? { number: match[1], text: match[2] } : { number: '', text }
}
</script>

<template>
   <div class="w-full z-0 font-lato text-[18px] overflow-hidden">
      <Navbar/>

      <div class="w-full text-center relative">
         <div class="image-container">
            <img src="/assets/img/ourImpact/bg-section.jpg" alt="ourImpact">
         </div>
         <h1 class="text-white capitalize text-[2rem] md:text-[72px] leading-[1.1] font-playfair font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2">
            {{ $t('our-impact.title') }}
         </h1>
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="max-w-7xl text-center px-8 text-[#000000] font-medium flex justify-center">
            <p class="max-w-[70%]">{{ $t('our-impact.description') }}</p>
         </div>
      </div>

      <div class="flex justify-center" v-if="impact">
         <div class="relative w-full mt-20 max-w-[1600px]">
            <div class="w-full h-56 rounded-t-[35%] lg:rounded-t-full border-t border-[#D86727]"></div>

            <div class="w-full flex justify-center -mt-56">
               <div class="max-w-7xl px-8 w-full">
                  <div class="grid grid-cols-1 lg:grid-cols-2 items-center"> <!-- lg:grid-cols-[25%,55%,20%] -->
                     <div class="flex flex-col justify-center text-center lg:text-left gap-5 order-2 mt-10 lg:mt-0 lg:order-1">
                        <div class="text-center" v-for="i in 2">
                           <p class="text-4xl font-montserrat font-bold text-[#2B3E8C]">{{ impact['subtitle_' + i][locale] }}</p>
                           <h2 class="text-2xl font-montserrat text-[#2B3E8C] font-bold">{{ impact['title_' + i][locale] }}</h2>
                        </div>
                        <!-- <div class="">
                           <h2 class="text-2xl lg:text-4xl font-montserrat text-[#2B3E8C] font-bold">{{ impact.title_2[locale] }}</h2>
                           <p>{{ impact.subtitle_2[locale] }}</p>
                        </div>
                        <div class="">
                           <h2 class="text-2xl lg:text-4xl font-montserrat text-[#2B3E8C] font-bold">{{ impact.title_3[locale] }}</h2>
                           <p>{{ impact.subtitle_3[locale] }}</p>
                        </div>
                        <div class="">
                           <h2 class="text-2xl lg:text-4xl font-montserrat text-[#2B3E8C] font-bold">{{ impact.title_4[locale] }}</h2>
                           <p>{{ impact.subtitle_4[locale] }}</p>
                        </div> -->
                     </div>
                     <div class="w-full -mt-20 order-1 lg:order-2">
                        <img :src="impact.image ?? '/assets/img/ourimpact/our-impact.png'" alt="bg" class="w-full h-full object-contain">
                     </div>
                     <!-- <div class="flex flex-col justify-center text-center lg:text-left gap-5 order-2 mt-10 lg:mt-0 lg:ms-4 lg:order-3">
                        <div class="" v-for="i in 5">
                           <h2 class="text-2xl font-montserrat text-[#2B3E8C] font-bold">{{ impact['title_' + (i + 5)][locale] }}</h2>
                        </div>
                    </div> -->
                     <!-- <div class="flex flex-col gap-5 justify-center items-center order-3 my-10 lg:mt-0">
                        <h2 class="text-2xl lg:text-4xl font-montserrat text-[#2B3E8C] font-bold text-center lg:text-left">{{ impact.sdg_title[locale] }}</h2>
                        <div class="flex flex-row lg:flex-col gap-5">
                           <div class="flex flex-col justify-center items-center gap-2" v-for="(data, i) in impact.sub_icons">
                              <img :src="data.icon" alt="values-1" class="w-16 h-16">
                              <h3 class="text-[20px] text-[#C7202F] font-bold">{{ data.text[locale] }}</h3>
                           </div>
                        </div>
                     </div> -->
                  </div>
                  <div class="flex justify-center w-full">
                     <div class="grid grid-cols-2 lg:grid-cols-[30%,40%,30%] w-full gap-5 my-10 items-center max-w-7xl px-8">
                        <div class="border border-[#2B3E8C] rounded-lg p-5" v-for="i in 8">
                           <h3 class="font-montserrat text-[#2B3E8C] font-bold items-center grid grid-cols-1 lg:grid-cols-[20%,80%]">
                              <span class="text-4xl block">{{ splitNumberText(impact['title_' + (i + 2)][locale]).number }}</span>
                              <span class="text-base">{{ splitNumberText(impact['title_' + (i + 2)][locale]).text }}</span>
                           </h3>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="w-full text-center bg-[#2B3E8C]">
         <h2 class="text-2xl lg:text-4xl font-bold font-playfair py-8 text-white">{{ locale == 'en' ? 'Stories of Our Impact' : 'Cerita Pengaruh Kami' }}</h2>
      </div>

      <div class="flex justify-center w-full my-20">
         <div class="max-w-7xl px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-16">
               <Link :href="route('publications-detail', { title: data.slug ? data.slug : data.title[lang], date: new Date(data.created_at).toISOString().split('T')[0] })" class="relative w-full fading group" role="button" v-for="(data, i) in datas" :key="i">
                  <div class="relative w-full fading group">
                     <div class="w-full h-[10rem] overflow-hidden img-our-program rounded-2xl">
                        <img :src="data.banner"
                              alt=""
                              class="object-cover w-full h-full group-hover:scale-125 transform ease-in-out duration-300">
                     </div>
                     <div class="absolute h-full w-full flex flex-col top-0 justify-end bg-opacity-50 text-white p-4 z-20">
                        <div class="">
                           <p class="text-white text-[10px] sm:text-[16px] w-full">{{ formatDate(data.created_at) }}</p>
                        </div>
                     </div>
                  </div>
                  <p class="w-full font-bold mt-3">{{ data.title[locale] }}</p>
                  <p class="w-full mt-3">{{ data.writter }}</p>
                  <p class="w-full mt-3" v-html="data.content[locale].slice(0, 200) + '...'"></p>
               </Link>
            </div>

            <div class="w-full flex justify-center mt-10" v-if="currentPage < lastPage">
               <button @click="handleShowMore" class="bg-[#E75E00] px-6 py-3 text-white rounded-full w-fit">{{ $t('button.read-more.stories') }}</button>
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
