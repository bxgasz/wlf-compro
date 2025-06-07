<script setup>
import SearchIcon from '@/Icons/SearchIcon.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n'

const page = usePage()

const showLangButton = ref(false)
const showLangButtonPopUp = ref(false)

const showNavbar = ref(false)
const showNavbarPopUp = ref(false)

const { locale } = useI18n()
// const lang = ref(localStorage.getItem('locale') || 'en')
const lang = ref('en')

const changeLanguage = (language) => {
  locale.value = language
  localStorage.setItem('locale', language)
  lang.value = language
  showLangButton.value = false
  showLangButtonPopUp.value = false
}

watch(lang, changeLanguage, { immediate: true })

const showDropdown = ref(false)

const navLinks = [
   {
      img: '',
      text_id: 'Tentang Kami',
      text_en: 'About Us',
      key: 'about-us',
      link: '/about-us',
   },
   {
      img: '',
      text_id: 'Program Kami',
      text_en: 'Our Program',
      key: 'our-program',
      link: '/our-program',
   },
   {
      img: '',
      text_id: 'Pengaruh Kami',
      text_en: 'Our Impact',
      key: 'our-impact',
      link: '/our-impact',
   },
   {
      img: '',
      text_id: 'Publikasi',
      text_en: 'Publications',
      key: 'publication',
      link: '/publications',
   },
   {
      img: '',
      text_id: 'Kesempatan',
      text_en: 'Grand Oppoturnities',
      key: 'grand-oppoturnities',
      link: '/grand-oppoturnities',
   },
]

const showPopupNav = ref(false);

const handleScroll = () => {
  showPopupNav.value = window.scrollY > 100;
};

const goToSection = (path, section) => {
  if (page.url.split('/')[1] === path.split('/')[1]) {
    scrollToSection(section)
  } else {
    router.visit(path, {
      preserveState: true, 
      replace: true, 
      only: [],
      onSuccess: () => {
        setTimeout(() => scrollToSection(section), 300)
      }
    })
  }
}

const scrollToSection = (section) => {
  const element = document.getElementById(section)
  if (element) {
    element.scrollIntoView({ behavior: 'smooth', block: 'center' })
  }
}

onMounted(() => {
  window.addEventListener("scroll", handleScroll);
  if (window.location.hash) {
    scrollToSection(window.location.hash.substring(1))
  }
});

onUnmounted(() => {
  window.removeEventListener("scroll", handleScroll);
});


const isActive = (path) => '/' + page.url.split('?')[0].split('/')[1] === path;
</script>

<template>
   <nav class="w-full flex justify-center items-center py-5 absolute top-0 z-40 bg-transparent px-8">
      <div class="w-full bg-[#D86727] h-7 absolute top-0 flex justify-center">
         <div class="max-w-7xl w-full px-8 flex justify-center lg:justify-between items-center text-sm">
            <p class="text-white">Equal opportunity for all Indonesians to flourish</p>
            <div class="hidden lg:flex items-center gap-4">
               <p class="text-white">Change Language</p>
               <div class="flex gap-2">
                  <p class="text-white font-bold">EN</p> | <p class="text-[#262C51]">ID</p>
               </div>
            </div>
         </div>
      </div>
      <div class="justify-between items-center w-full lg:flex hidden mt-7 max-w-7xl px-8">
         <Link :href="route('home')" class="ms-2">
            <div class="w-[5rem] h-auto">
               <img :src="page.props.settings.logo" alt="logo" class="w-full h-full object-contain">
            </div>
         </Link>
         <div class="w-auto flex justify-center">
            <div v-for="(nav, index) in navLinks" :key="nav.key" class="relative">
               <Link :href="nav.link">
                  <p class="text-[16px] mx-4 font-bold" :class="isActive(nav.link) ? 'text-[#D86727] font-bold' : 'text-white hover:text-[#ff8b48]'">{{ lang == 'id' ? nav.text_id : nav.text_en }}</p>
               </Link>
            </div>
         </div>
         <div class="flex gap-3 items-center w-auto">
            <SearchIcon class="text-white w-8"/>
            <Link :href="route('donate')" class="bg-[#D86727] hover:bg-[#e47636] ease-in-out duration-500 px-6 py-2.5 text-md text-white rounded-full font-medium w-fit">{{ locale == 'id' ? 'Donasi' : 'Donate' }}</Link>
            <Link :href="route('grantee')" class="bg-[#2B3E8C] hover:bg-[#1e2e6d] ease-in-out duration-500 px-6 py-2.5 text-md text-white rounded-full font-medium w-fit">{{ locale == 'id' ? 'Grantee Portal' : 'Grantee Portal' }}</Link>
         </div>
      </div>

      <div class="w-full relative lg:hidden block mt-7">
         <div class="flex justify-between items-center">
            <Link :href="route('home')" class="w-[5rem] h-auto">
               <img :src="page.props.settings.logo" alt="logo" class="w-full h-full object-contain">
            </Link>
            <div class="">
               <button 
                  @click="showNavbar = !showNavbar" 
                  class="relative w-12 h-6 flex flex-col justify-between items-center"
               >
                  <span 
                     class="block w-8 h-1 bg-white rounded transition-all duration-300"
                     :class="{ 'rotate-45 translate-y-[0.63rem]': showNavbar }"
                  ></span>

                  <span 
                     class="block w-8 h-1 bg-white rounded transition-all duration-300"
                     :class="{ 'opacity-0': showNavbar }"
                  ></span>

                  <span 
                     class="block w-8 h-1 bg-white rounded transition-all duration-300"
                     :class="{ '-rotate-45 -translate-y-[0.63rem]': showNavbar }"
                  ></span>
               </button>
            </div>
         </div>
         
         <div class="w-full bg-[#D7261C] absolute mt-5 p-3 rounded-lg" :class="{ 'opacity-100 translate-y-0': showNavbar, 'opacity-0 -translate-y-1 hidden': !showNavbar }">
            <Link v-for="(nav, index) in navLinks" :key="nav.key" :href="nav.link">
               <p class="text-slate-100 text-[16px] hover:text-slate-100 p-3 mt-2 hover:bg-[#c0000b] rounded-md" :class="{ 'bg-[#c0000b]' : isActive(nav.link) }">{{ lang == 'id' ? nav.text_id : nav.text_en }}</p>
            </Link>
         </div>
      </div>
   </nav>
</template>