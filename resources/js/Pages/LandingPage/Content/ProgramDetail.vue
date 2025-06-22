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
   otherContent: Object
})

const { locale } = useI18n()

const contentTitle = computed(() => props.content?.title?.[locale.value]);
const contentUrl = computed(() => route('program-detail', { category: props.content.program_category_id, title: props.content?.slug ? props.content?.slug : props.content?.title[locale.value], date: new Date(props.content?.created_at).toISOString().split('T')[0] }));
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
                  <span class="text-gray-600 mx-3">|</span>
                  <p class="text-gray-600 text-[16px]">{{ content.category[locale] }}</p>
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
                     <img :src="content.banner" alt="banner" class="h-full w-full object-cover">
                  </template>
               </div>
               <div class="lg:max-w-[80%] mx-auto space-y-8 mt-8 px-8 lg:px-0">
                  <div class="!text-[18px]">
                     <p v-html="content.description[locale]"></p>
                  </div>

                  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                     <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <tbody>
                              <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                 <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap dark:text-white">
                                    Implementing Partner
                                 </th>
                                 <td class="px-6 py-4">
                                    {{ content.implementing_partner }}
                                 </td>
                              </tr>
                              <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                 <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap dark:text-white">
                                    Sector
                                 </th>
                                 <td class="px-6 py-4">
                                    {{ content.sector }}
                                 </td>
                              </tr>
                              <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                 <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap dark:text-white">
                                    Location
                                 </th>
                                 <td class="px-6 py-4">
                                    {{ content.location }}
                                 </td>
                              </tr>
                              <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                 <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap dark:text-white">
                                    Date
                                 </th>
                                 <td class="px-6 py-4">
                                    {{ content.start_date }} - {{ content.end_date }}
                                 </td>
                              </tr>
                              <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                 <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap dark:text-white">
                                    Status
                                 </th>
                                 <td class="px-6 py-4">
                                    {{ content.status }}
                                 </td>
                              </tr>
                        </tbody>
                     </table>
                  </div>

                  <div class="mx-auto space-y-8 mt-20 px-8 lg:px-0">
                     <a target="_blank" :href="content.document" class="flex items-center gap-2 w-max border border-[#E75E00] rounded-md p-5 text-[#E75E00] font-bold">
                        <div class="h-7 w-7"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.792 21.25h8.416a3.5 3.5 0 0 0 3.5-3.5v-5.53a3.5 3.5 0 0 0-1.024-2.475l-5.969-5.97A3.5 3.5 0 0 0 10.24 2.75H7.792a3.5 3.5 0 0 0-3.5 3.5v11.5a3.5 3.5 0 0 0 3.5 3.5"/><path fill="currentColor" fill-rule="evenodd" d="M10.437 7.141c-.239.078-.392.236-.436.411c-.09.352 0 .73.253 1.203c.126.234.28.471.45.725l.092.137l.145.215l.019-.068l.086-.306q.148-.503.23-1.02c.089-.642-.011-1.018-.309-1.26c-.08-.065-.278-.119-.53-.037m.055 4.152l-.27-.362l-.032-.048c-.115-.19-.243-.38-.382-.585l-.1-.149a10 10 0 0 1-.512-.828c-.31-.578-.558-1.286-.358-2.067c.17-.664.698-1.081 1.227-1.254c.517-.168 1.174-.147 1.66.247c.792.644.848 1.573.739 2.357a9 9 0 0 1-.261 1.174l-.096.34q-.112.382-.208.769l-.067.194l1.392 1.864c.65-.078 1.364-.125 2.03-.077c.769.054 1.595.242 2.158.776a1.56 1.56 0 0 1 .395 1.441c-.117.48-.454.88-.919 1.123c-.985.515-1.902.105-2.583-.416c-.533-.407-1.045-.975-1.476-1.453l-.104-.114c-.37.057-.72.121-1.004.175c-.305.057-.684.128-1.096.22l-.151.443q-.125.288-.238.58l-.122.303a8 8 0 0 1-.427.91c-.33.578-.857 1.192-1.741 1.241c-1.184.066-1.986-.985-1.756-2.108l.006-.027c.2-.791.894-1.31 1.565-1.653c.597-.306 1.294-.532 1.941-.701zm.87 1.165l-.287.843l.421-.08l.004-.001l.38-.07zm2.84 1.604c.274.29.547.56.831.777c.55.42.94.493 1.299.305c.2-.105.284-.241.309-.342a.35.35 0 0 0-.08-.309c-.257-.228-.722-.38-1.392-.428a8 8 0 0 0-.967-.003m-5.005.947c-.318.109-.62.23-.89.368c-.587.3-.87.604-.944.867c-.078.415.192.673.516.655c.27-.015.506-.184.766-.639q.204-.372.358-.767l.107-.266z" clip-rule="evenodd"/></g></svg></div>
                        Download the PDF's file
                     </a>
                  </div>
               </div>

            </div>
         </div>
      </div>

      <div class="relative w-full h-fit mt-20 px-8">
         <div class="w-[84%] h-full absolute right-0 hidden lg:flex" style="clip-path: polygon(10% 0%, 100% 0%, 100% 100%, 0% 100%);"></div>
         <div class="w-[100%] h-full absolute right-0 flex lg:hidden"></div>
         <div class="flex justify-center">
            <div class="inset-0 py-20 translate-y-1 flex flex-col items-center w-full max-w-5xl">
               <h2 class="text-[#2B3E8C] text-[2rem] md:text-4xl leading-[1.1] font-montserrat font-bold mb-10 text-center uppercase">{{ $t('sub-program.other') }}</h2>

               <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                  <Link :href="route('publications-detail', { title: data.slug ? data.slug : data.title[locale], date: new Date(data.created_at).toISOString().split('T')[0] })" class="relative w-full fading group" role="button" v-for="(data, i) in otherContent.data" :key="i">
                     <div class="w-full h-[20rem] overflow-hidden img-our-program rounded-2xl">
                        <img :src="data.banner"
                              alt="" 
                              class="object-cover w-full h-full group-hover:scale-125 transform ease-in-out duration-300">
                     </div>
                     <div class="absolute h-full w-full flex flex-col top-0 justify-end bg-opacity-50 text-white p-8 z-20">
                        <div class="">
                           <p class="text-white text-[10px] sm:text-[16px] w-full">{{ formatDate(data.created_at) }}</p>
                           <p class="text-white text-[16px] sm:text-[20px] w-full font-medium">{{ data.title[locale] }}</p>
                        </div>
                     </div>
                  </Link>
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