<script setup>
import TextInput from '@/Components/TextInput.vue';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import { useI18n } from 'vue-i18n';
import { ref } from 'vue';
import { HelperService } from '@/Helper/Alert';
import axios from 'axios';
import { Link } from '@inertiajs/vue3';
import { formatDate } from '@/Helper/FormatDate';

const { locale } = useI18n()

const search = ref('')

const datas = ref(null)

const getContent = async (page) => {
   const searchParams = new URLSearchParams({
      search: search.value,
      perPage: 100
   })

   try {
      const res = await axios.get(route('search.post') + '?' + searchParams.toString())
      datas.value = res.data
   } catch (error) {
      HelperService.toastError(error)
   }
}
</script>

<template>
   <div class="w-full z-0 font-lato text-[18px] overflow-hidden">
      <Navbar/>

      <div class="w-full text-center relative">
         <div class="image-container">
            <img src="/assets/img/about/bg-section.png" alt="about-us">
         </div>
         <h1 class="text-white w-full capitalize text-[2rem] md:text-[72px] leading-[1.1] font-playfair font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2">
            {{ $t('search.title') }}
         </h1>
      </div>

      <div class="w-full flex justify-center my-20">
         <div class="max-w-7xl w-full px-8">
            <TextInput
               @keyup.enter="getContent"
               :placeholder="locale == 'id' ? 'Temukan cerita dan publikasi..' : 'Find Stories and newest publications..'"
               v-model="search"
               class="w-full"
            />
         </div>
      </div>

      <div class="w-full flex justify-center my-20" v-if="datas != null">
         <div class="max-w-7xl w-full px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-10" v-if="datas.length > 0">
               <Link class="relative w-full fading group" role="button" :href="route('publications-detail', { title: data.slug ? data.slug : data.title[locale], date: new Date(data.created_at).toISOString().split('T')[0] })" v-for="(data, i) in datas">
                  <div class="w-full h-40 overflow-hidden rounded-2xl">
                     <img :src="data.banner" alt="banner" class="object-cover w-full h-full group-hover:scale-125 transform ease-in-out duration-300">
                  </div>
                  <div class="flex w-full justify-between my-5">
                     <p class="text-gray-500">{{ formatDate(data.created_at) }}</p>
                     <p class="bg-[#2B3E8C] text-sm p-1 px-3 rounded-full text-white">{{ data.type }}</p>
                  </div>
                  <p class="w-full font-medium">{{ data.title[locale] }}</p>
               </Link>
            </div>
            <div class="text-center" v-else>{{ locale == 'id' ? 'Hasil tidak ditemukan' : 'Result not found' }}</div>
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