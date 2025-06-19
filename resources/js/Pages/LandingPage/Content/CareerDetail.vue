<script setup>
import { useI18n } from 'vue-i18n';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import { Head, Link } from '@inertiajs/vue3';
import { formatDate } from '@/Helper/FormatDate';
import { useShare } from '@/Helper/ShareSocialMedia';
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
   content: Object,
})

const { locale } = useI18n()

const contentTitle = computed(() => props.content?.title?.[locale.value]);
const contentUrl = computed(() => route('career-detail', props.content.id));
const { copyLink, shareOnFacebook, shareOnLinkedIn, shareOnX } = useShare(contentTitle.value, contentUrl.value);

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
   <!-- <Head :title="content.meta_head">
      <meta name="title" :content="content.meta_head">
      <meta name="description" :content="content.meta_desc">
      <meta property="og:title" :content="content.title[locale]">
      <meta property="og:description" :content="content.title[locale]">
      <meta property="og:image" :content="content.type == 'video' ? content.thumbnail : content.banner">
   </Head> -->

   <div class="w-full text-center relative">
      <div class="image-container">
         <img src="/assets/img/about/bg-section.png" alt="about-us">
      </div>
   </div>
   
   <div class="w-full z-0 font-lato text-[18px] overflow-hidden">
      <Navbar/>
      <div class="flex justify-center px-8 lg:px-0">
         <div class="w-full flex justify-center mt-28 max-w-5xl px-8">
            <div class="text-center w-full">
               <h1 class=" text-[2rem] md:text-[40px] leading-[1.1] font-montserrat font-extrabold">
                  {{ content.title[locale] }}
               </h1>
               <div class="flex mt-6 mx-auto justify-center">
                  <p class="text-gray-600 text-[16px]">{{ formatDate(content.created_at) }}</p>
               </div>
            </div>
         </div>
      </div>

      <div class="flex justify-center">
         <div class="max-w-5xl w-full flex gap-6 mt-20">
            <div class="flex-col items-center hidden lg:flex">
               <p class=" text-[16px]">{{ locale == 'id' ? 'Bagikan' : 'Share' }}:</p>
               <img role="button" @click="copyLink" src="/assets/icon/share.svg" alt="share" class="w-6 h-6 mt-4">
               <img role="button" @click="shareOnX" src="/assets/icon/twitter.svg" alt="x" class="w-6 h-6 mt-8">
               <img role="button" @click="shareOnLinkedIn" src="/assets/icon/linkedin.svg" alt="linkedin" class="w-6 h-6 mt-4">
               <img role="button" @click="shareOnFacebook" src="/assets/icon/facebook.svg" alt="facebook" class="w-6 h-6 mt-4">
            </div>
            <div class="w-full">
               <div class="h-[212px] md:h-[350px] lg:h-[500px] w-full">
                  <template v-if="content.type === 'video'">
                     <video class="h-full w-full object-cover" autoplay muted loop playsinline>
                           <source :src="content.banner" type="video/mp4">
                           {{ $t('content.detail.banner-vid') }}
                     </video>
                  </template>
                  <template v-else>
                     <img :src="content.image" alt="banner" class="h-full w-full object-cover">
                  </template>
               </div>
               <div class="lg:max-w-[80%] mx-auto space-y-8 mt-8 px-8 lg:px-0">
                  <div class="!text-[18px]">
                     <p v-html="content.description[locale]"></p>
                  </div>
               </div>
            </div>
         </div>
      </div>
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
  height: 10rem;
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