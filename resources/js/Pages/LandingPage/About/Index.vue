<script setup>
import ArrowBack from '@/Icons/ArrowBack.vue';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import { ref } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Pagination, A11y, Autoplay } from 'swiper/modules'
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/autoplay";
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage()

const modules = [
   Autoplay,
   Pagination,
   A11y
]

const ourValues = [
   {
      icon: '/assets/img/about/values-1.png',
      title: 'Zero Hunger',
      description: 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex'
   },
   {
      icon: '/assets/img/about/values-2.png',
      title: 'Quality Education',
      description: 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex'
   },
   {
      icon: '/assets/img/about/values-3.png',
      title: 'Decent Work and Economic Growth',
      description: 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex'
   },
]

const ourTeam = [
{
      image: '/assets/img/about/our-team.jpg',
      name: 'Brooklyn Simmons',
      position: 'Director'
   },
   {
      image: '/assets/img/about/our-team.jpg',
      name: 'Brooklyn Simmons',
      position: 'Director'
   },
   {
      image: '/assets/img/about/our-team.jpg',
      name: 'Brooklyn Simmons',
      position: 'Director'
   },
   {
      image: '/assets/img/about/our-team.jpg',
      name: 'Brooklyn Simmons',
      position: 'Director'
   },
   {
      image: '/assets/img/about/our-team.jpg',
      name: 'Brooklyn Simmons',
      position: 'Director'
   },
   {
      image: '/assets/img/about/our-team.jpg',
      name: 'Brooklyn Simmons',
      position: 'Director'
   },
]

const ourPartners = [
   {
      "data" : [
         {
            image: '/assets/img/about/acer.png'
         },
         {
            image: '/assets/img/about/sid.png'
         },
         {
            image: '/assets/img/about/binatani.png'
         },
         {
            image: '/assets/img/about/satunama.png'
         },
         {
            image: '/assets/img/about/desma.png'
         },
         {
            image: '/assets/img/about/plus.png'
         },
         {
            image: '/assets/img/about/inspirasi.png'
         },
         {
            image: '/assets/img/about/remdec.png'
         },
      ]
   },
   {
      "data" : [
         {
            image: '/assets/img/about/acer.png'
         },
         {
            image: '/assets/img/about/sid.png'
         },
         {
            image: '/assets/img/about/binatani.png'
         },
         {
            image: '/assets/img/about/satunama.png'
         },
         {
            image: '/assets/img/about/desma.png'
         },
         {
            image: '/assets/img/about/plus.png'
         },
         {
            image: '/assets/img/about/inspirasi.png'
         },
         {
            image: '/assets/img/about/remdec.png'
         },
      ]
   },
]

const tabOurTeam = ref('management')
</script>

<template>
   <div class="w-full z-0 font-lato text-[18px] overflow-hidden">
      <Navbar/>

      <div class="w-full text-center relative">
         <div class="image-container">
            <img src="/assets/img/about/bg-section.png" alt="about-us">
         </div>
         <h1 class="text-white text-[2rem] md:text-[72px] leading-[1.1] font-montserrat font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2">
            About Us
         </h1>
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="max-w-7xl text-center px-8 text-[#000000] font-medium flex justify-center">
            <p class="max-w-[70%]">The William & Lily Foundation (WLF) is a philanthropic organization based in Indonesia established in 2009 to continue the philanthropic values of William and Lily Soeryadjaya. Since 2017, WLF has operated as a grant-making organization actively collaborating with various organizations at both national and local levels. Through this approach, WLF focuses on three key areas: early childhood development, basic literacy and numeracy, and economic empowerment.
            </p>
         </div>
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="max-w-7xl px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-[20%,100%]">
               <h2 class="text-[#2B3E8C] text-4xl font-montserrat font-extrabold">
                  Our <br> Journey
               </h2>

               <div class="bg-[#D86727] rounded-[20px] w-full p-10">
                  <div class="flex gap-5 h-64 w-full items-center">
                     <div class="flex flex-col gap-5" v-for="i in 8">
                        <p class="font-bold text-xl text-white">20{{ 9 + i }}</p>
                        <div class="w-40 h-24">
                           <img src="/assets/img/about/journey.jpg" alt="journey" class="rounded-xl">
                        </div>
                        <p class="text-white">Description of journey</p>
                     </div>
                  </div>
                  <div class="w-[80%] flex justify-end gap-2">
                     <ArrowBack class="bg-white rounded-full w-8 h-8 flex items-center justify-center p-2" />
                     <ArrowBack class="bg-white rounded-full w-8 h-8 flex items-center justify-center p-2 rotate-180" />
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="w-full max-w-7xl px-8">
            <div class="w-full flex justify-center">
               <h2 class="text-[#2B3E8C] text-4xl font-extrabold font-montserrat">
                  Visi & Misi
               </h2>
            </div>

            <div class="w-full flex justify-start gap-3">
               <img src="/assets/icon/kutip.svg" alt="kutip" class="rotate-180">
               <img src="/assets/icon/kutipbirru.svg" alt="kutip" class="rotate-180">
            </div>

            <div class="w-full justify-center flex">
               <p class="text-center text-[#000000] font-medium max-w-[80%]">Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere.</p>
            </div>

            <div class="w-full flex justify-end gap-3">
               <img src="/assets/icon/kutipbirru.svg" alt="kutip">
               <img src="/assets/icon/kutip.svg" alt="kutip">
            </div>
         </div>
      </div>

      <div class="flex justify-center mt-20">
         <div class="bg-[#2B3E8C] max-w-7xl h-full w-full rounded-3xl mx-8 p-10">
            <div class="grid grid-cols-1 lg:grid-cols-[30%,70%] gap-10 justify-center items-center">
               <div class="w-full h-[150%] rounded-3xl">
                  <img src="/assets/img/home/hero.png" alt="publication" class="w-[22rem] h-full object-cover rounded-3xl">
               </div>
               <div class="text-white">
                  <h1 class="font-montserrat text-2xl font-bold">Visi</h1>
                  <p class="text-[#] text-base font-medium">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sint quam in distinctio perspiciati</p>
                  <h1 class="font-montserrat text-2xl font-bold mt-16">Misi</h1>
                  <p class="text-[#] text-base font-medium">1. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sint quam in distinctio perspiciati</p>
                  <p class="text-[#] text-base font-medium">2. Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit soluta facere, eius harum laboriosam, temporibus nemo sunt officia, sit at dolor necessitatibus nihil repudiandae fuga odio minus eos autem voluptatem.</p>
                  <p class="text-[#] text-base font-medium">3. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sint quam in distinctio perspiciati</p>
                  <p class="text-[#] text-base font-medium">4. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sint quam in distinctio perspiciati</p>
                  <p class="text-[#] text-base font-medium">5. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sint quam in distinctio perspiciati</p>
               </div>
            </div>
         </div>
      </div>

      <div class="flex justify-center">
         <div class="relative w-full mt-20 max-w-[1600px]">
            <div class="w-full h-96 rounded-t-[35%] lg:rounded-t-full border-t border-[#D86727]"></div>
            <div class="w-full h-60 rounded-t-[35%] lg:rounded-t-full border-t border-[#D86727] -mt-32"></div>

            <div class="w-full flex justify-center absolute top-10">
               <div class="max-w-7xl px-8 w-full">
                  <h1 class="text-5xl font-montserrat text-[#262C51] font-bold text-center">Values</h1>
                  <p class="text-center mt-5">Lorem ipsum dolor sit amet consectetur adipiscing elit. <br> Quisque faucibus ex sapien vitae pellentesque sem placerat.</p>
                  <div class="flex gap-5 justify-start -mt-13 mb-8 overflow-x-auto [&::-webkit-scrollbar]:w-1 [&::-webkit-scrollbar]:h-0">
                     <div class="w-[19rem] h-[23rem] sm:w-[24rem] sm:h-[27rem] flex flex-col justify-center items-center gap-5" v-for="(values, index) in ourValues" :key="index">
                        <div class="w-20 h-20">
                           <img :src="values.icon" alt="values" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-[20px] text-[#C7202F] font-bold">{{ values.title }}</h3>
                        <p class="text-center">{{ values.description }}</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="max-w-7xl pe-8 w-full">
            <div class="flex gap-20">
               <div class="bg-[#D86727] rounded-[20px] w-[100%] p-10 -ms-44">
                  <div class="flex flex-wrap gap-5 min-h-64 w-full items-center justify-end">
                     <div class="text-white space-y-3" v-for="(data, index) in ourTeam" :key="index">
                        <div class="w-72 h-44">
                           <img :src="data.image" alt="values" class="w-full h-full object-cover rounded-[20px]">
                        </div>
                        <h3 class="text-[20px] font-bold">{{ data.name }}</h3>
                        <p>{{ data.position }}</p>
                     </div>
                  </div>
               </div>

               <div class="w-[20%]">
                  <h2 class="text-[#2B3E8C] text-4xl font-montserrat font-extrabold">
                     Our Team
                  </h2>

                  <p @click="tabOurTeam = 'management'" class="p-3 text-base rounded-tl-[20px] mt-10" :class="tabOurTeam == 'management' ? 'bg-[#D86727] text-white font-semibold' : 'border border-[#D86727]'">Management</p>
                  <p @click="tabOurTeam = 'organization'" class="p-3 text-base rounded-bl-[20px]" :class="tabOurTeam == 'organization' ? 'bg-[#D86727] text-white font-semibold' : 'border border-[#D86727]'">Organization Strcuture</p>
               </div>
            </div>
         </div>
      </div>

      <div class="flex justify-center mt-20">
         <div class="max-w-7xl px-8">
            <h1 class="text-5xl font-montserrat text-[#262C51] font-bold text-center">Our Partners</h1>

            <swiper
               class="h-fit mt-20"
               :modules="modules"
               :autoplay="{ delay: 8000, disableOnInteraction: false }"
               :slide-per-view="3"
               :pagination="{ clickable: true }"
            >
               <swiper-slide class="h-full" v-for="i in ourPartners">
                  <div class="flex flex-wrap justify-center gap-10">
                     <div class="w-40 h-40" v-for="data in i.data">
                        <img :src="data.image" alt="img">
                     </div>
                  </div>
               </swiper-slide>
            </swiper>
         </div>
      </div>

      <div class="flex justify-center mt-20 w-full bg-[#2B3E8C] rounded-t-[300px]">
         <div class="max-w-7xl px-8 my-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
               <div class="w-[572px] h-[284px]">
                  <iframe class="rounded-[20px]" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2342680692304!2d106.82871827509548!3d-6.232817993755369!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3ef32de8be3%3A0x9bb807c61923a77e!2sWilliam%20%26%20Lily%20Foundation!5e0!3m2!1sid!2sid!4v1748936984987!5m2!1sid!2sid" width="600" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
               </div>
               <div class="flex flex-col gap-5">
                  <h1 class="text-5xl font-montserrat text-white font-bold">Contact Us</h1>
                  <p class="text-white">
                     Menara Karya, Lt. 17, RT.1/RW.2, Kuningan, Kuningan Tim., Kecamatan Setiabudi, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12950
                  </p>
                  <div class="flex gap-2">
                     <a href="'tel:'+page.props.settings.phone_no"><img role="button" src="/assets/icon/phone.svg" alt="x"> {{ page.props.settings.phone_no }} <br></a>
                     <a href="`https://mail.google.com/mail/?view=cm&fs=1&to=${page.props.settings.email}`"><img role="button" src="/assets/icon/mail.svg" alt="x"> {{ page.props.settings.email }}</a>
                  </div>
                  <Link href="#" class="bg-[#D86727] hover:bg-[#e47636] ease-in-out duration-500 px-6 py-2 text-white rounded-full font-medium w-fit">Send us a message</Link>
               </div>
            </div>
         </div>
      </div>

      <Footer/>
   </div>
</template>

<style scoped>
:deep(.swiper-pagination-bullet){
  background: #262C51 !important;
  opacity: 10;
}

:deep(.swiper-pagination-bullet-active){
  background: #D86727 !important;
  width: 40px;
  border-radius: 10px;
}

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