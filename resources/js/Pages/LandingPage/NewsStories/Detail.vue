<script setup>
import { useI18n } from 'vue-i18n';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import { Head, Link } from '@inertiajs/vue3';
import { formatDate } from '@/Helper/FormatDate';
import { useShare } from '@/Helper/ShareSocialMedia';
import { computed, onMounted, onUnmounted, ref } from 'vue';

// const props = defineProps({
//    news: Object,
//    otherNews: Object
// })

const { locale } = useI18n()

// const newsTitle = computed(() => props.news?.title?.[locale.value]);
// const newsUrl = computed(() => route('landing.news-detail', { category: props.news.category_id, title: props.news?.slug ? props.news?.slug : props.news?.title[locale.value], date: new Date(props.news?.created_at).toISOString().split('T')[0] }));
// const { copyLink, shareOnFacebook, shareOnLinkedIn, shareOnX } = useShare(newsTitle.value, newsUrl.value);

const showPopupShare = ref(false);

const handleScroll = () => {
  showPopupShare.value = window.scrollY > 100;
};

onMounted(() => {
  window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
  window.removeEventListener("scroll", handleScroll);
});
</script>

<template>
   <!-- <Head :title="news.meta_head">
      <meta name="title" :content="news.meta_head">
      <meta name="description" :content="news.meta_desc">
      <meta property="og:title" :content="news.title[locale]">
      <meta property="og:description" :content="news.title[locale]">
      <meta property="og:image" :content="news.type == 'video' ? news.thumbnail : news.banner">
   </Head> -->

   <div class="w-full text-center relative">
      <div class="image-container">
         <img src="/assets/img/about/bg-section.png" alt="about-us">
      </div>
   </div>
   
   <div class="w-full z-0 font-lato font-light text-[18px] overflow-hidden">
      <Navbar/>
      <div class="flex justify-center px-8 lg:px-0">
         <div class="w-full flex justify-center mt-28 max-w-5xl px-8">
            <div class="text-center w-full">
               <h1 class=" text-[2rem] md:text-[40px] leading-[1.1] font-playfair font-extrabold">
                  <!-- {{ news.title[locale] }} -->
                  Basic Literacy Development in Southwest Sumba
               </h1>
               <div class="flex mt-6 mx-auto justify-center">
                  <p class="text-gray-600 text-[16px]">05 May 2025</p>
                  <span class="text-gray-600 mx-3">|</span>
                  <p class="text-gray-600 text-[16px]">Education</p>
               </div>
            </div>
         </div>
      </div>

      <div class="flex justify-center">
         <div class="max-w-5xl flex gap-6 mt-20">
            <div class="flex-col items-center hidden lg:flex">
               <p class=" text-[16px]">{{ locale == 'id' ? 'Bagikan' : 'Share' }}:</p>
               <img role="button" @click="copyLink" src="/assets/icon/share.svg" alt="share" class="w-6 h-6 mt-4">
               <img role="button" @click="shareOnX" src="/assets/icon/twitter.svg" alt="x" class="w-6 h-6 mt-8">
               <img role="button" @click="shareOnLinkedIn" src="/assets/icon/linkedin.svg" alt="linkedin" class="w-6 h-6 mt-4">
               <img role="button" @click="shareOnFacebook" src="/assets/icon/facebook.svg" alt="facebook" class="w-6 h-6 mt-4">
            </div>
            <div class="w-full">
               <div class="h-[212px] md:h-[350px] lg:h-[500px] w-full">
                  <!-- <template v-if="news.type === 'video'">
                     <video class="h-full w-full object-cover" autoplay muted loop playsinline>
                           <source :src="news.banner" type="video/mp4">
                           {{ $t('news.detail.banner-vid') }}
                     </video>
                  </template>
                  <template v-else>
                     <img :src="news.banner" alt="banner" class="h-full w-full object-cover">
                  </template> -->
                  <img src="/assets/img/about/bg-section.png" alt="banner" class="h-full w-full object-cover">
               </div>
               <div class="lg:max-w-[80%] mx-auto space-y-8 mt-8 px-8 lg:px-0">
                  <div class="! !text-[18px]">
                     <!-- <p v-html="news.description[locale]"></p> -->
                      <p>Strengthening the capacity of early grade teachers (grades 1-3 in Elementary School) which is expected to improve students’ reading skills and the effectiveness of teaching and learning activities in West Wewewa, Central Wewewa Tengah, and East Wewewa.</p>
                      <p>Strengthening the capacity of early grade teachers (grades 1-3 in Elementary School) which is expected to improve students’ reading skills and the effectiveness of teaching and learning activities in West Wewewa, Central Wewewa Tengah, and East Wewewa.</p>
                      <p>Strengthening the capacity of early grade teachers (grades 1-3 in Elementary School) which is expected to improve students’ reading skills and the effectiveness of teaching and learning activities in West Wewewa, Central Wewewa Tengah, and East Wewewa.</p>
                      <p>Strengthening the capacity of early grade teachers (grades 1-3 in Elementary School) which is expected to improve students’ reading skills and the effectiveness of teaching and learning activities in West Wewewa, Central Wewewa Tengah, and East Wewewa.</p>
                  </div>

                  <div class="flex items-center mt-20">
                     <!-- <p v-for="tag in news.tags" class="border border-white rounded-full p-1 px-3 ms-4 font-semibold  text-[14px]">{{ tag['en'] }}</p> -->
                     <p class="border border-[#E75E00] rounded-full p-1 px-3 font-semibold text-[#E75E00] text-[14px]">NTT</p>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- <div class="relative w-full h-fit mt-20">
         <div class="w-[84%] h-full bg-[#0D0E13] absolute right-0 hidden lg:flex" style="clip-path: polygon(10% 0%, 100% 0%, 100% 100%, 0% 100%);"></div>
         <div class="w-[100%] h-full bg-[#0D0E13] absolute right-0 flex lg:hidden"></div>
         <div class="flex justify-center">
            <div class="inset-0 py-20 translate-y-1 flex flex-col items-center w-full max-w-5xl">
               <h2 class=" text-[2rem] md:text-4xl leading-[1.1] font-playfair font-medium mb-10 text-center uppercase">{{ $t('news.detail.otherNews') }}</h2>

               <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                  <Link :href="route('landing.news-detail', { category: item.category_id, title: item.slug ? item.slug : item.title[locale], date: new Date(item.created_at).toISOString().split('T')[0] })" class="lg:w-[278px] group" v-for="item in otherNews.data">
                     <div class=" w-full h-[219px] lg:h-[182px] overflow-hidden" >
                        <img :src="item.type == 'video' ? item.thumbnail : item.banner" 
                           :alt="item.title" 
                           class="object-cover h-full w-full group-hover:scale-125 transition duration-300 ease-in-out">
                     </div>
                     <div class="pt-6">
                        <p class="text-gray-300 text-[10px] sm:text-[16px] w-full">{{ formatDate(item.created_at) }}</p>
                        <p class=" text-[16px] w-full">{{ item.title[locale] }}</p>
                     </div>
                  </Link>
               </div>
            </div>
         </div>
      </div> -->
      <div class="mt-20"></div>
      <Footer />
   </div>

   <nav class="w-fit bg-[#24252A80]/50 backdrop-blur-sm rounded-xl flex lg:hidden justify-center items-center fixed bottom-5 z-40 px-8 left-[50%] -translate-x-[50%]">
      <div class="justify-center gap-5 items-center flex py-2">
         <img role="button" @click="copyLink" src="/assets/icon/share.svg" alt="share" class="w-6 h-6">
         <img role="button" @click="shareOnX" src="/assets/icon/twitter.svg" alt="x" class="w-6 h-6">
         <img role="button" @click="shareOnLinkedIn" src="/assets/icon/linkedin.svg" alt="linkedin" class="w-6 h-6">
         <img role="button" @click="shareOnFacebook" src="/assets/icon/facebook.svg" alt="facebook" class="w-6 h-6">
      </div>
   </nav>
</template>

<style scoped>
span {
   color: white !important;
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