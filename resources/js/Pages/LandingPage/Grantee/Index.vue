<script setup>
import { ref } from 'vue';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import ArrowBack from '@/Icons/ArrowBack.vue';

const tabActive = ref('home')

const partners = [
   {
      title: 'acer',
      image: '/assets/img/about/acer.png'
   },
   {
      title: 'Sumba Integrated Development',
      image: '/assets/img/about/sid.png'
   },
   {
      title: 'Bina Tani Sejahtera',
      image: '/assets/img/about/binatani.png'
   },
   {
      title: 'SATUNAMA',
      image: '/assets/img/about/satunama.png'
   },
   {
      title: 'DESMA',
      image: '/assets/img/about/desma.png'
   },
   {
      title: 'Platform Usaha Sosial',
      image: '/assets/img/about/plus.png'
   },
   {
      title: 'INSPIRASI',
      image: '/assets/img/about/inspirasi.png'
   },
   {
      title: 'REMDEC SWAPRAKARSA',
      image: '/assets/img/about/remdec.png'
   },
]
</script>

<template>
   <div class="w-ful z-0 bg-white font-lato font-light text-[18px] overflow-hidden">
      <Navbar/>

      <div class="w-full text-center relative">
         <div class="image-container">
            <img src="/assets/img/about/bg-section.png" alt="about-us">
         </div>
         <h1 class="text-white text-[2rem] md:text-[72px] leading-[1.1] font-montserrat font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2">
            {{ $t('grantee.title') }}
         </h1>
      </div>

      <div class="w-full flex justify-start lg:justify-center overflow-auto px-8 bg-[#2F3C87] lg:gap-8 h-24 items-end">
         <div @click="tabActive = 'home'" role="button" :class="tabActive == 'home' ? 'bg-white rounded-t-xl text-[#2F3C87]' : 'text-white'" class="flex justify-center items-center px-10 h-[80%] font-bold">Home</div>
         <div @click="tabActive = 'panduan'" role="button" :class="tabActive == 'panduan' ? 'bg-white rounded-t-xl text-[#2F3C87]' : 'text-white'" class="flex justify-center items-center px-10 h-[80%] font-bold">Panduan</div>
         <div @click="tabActive = 'format_pelaporan'" role="button" :class="tabActive == 'format_pelaporan' ? 'bg-white rounded-t-xl text-[#2F3C87]' : 'text-white'" class="flex justify-center items-center px-10 h-[80%] font-bold">Format Laporan</div>
         <div @click="tabActive = 'pelaporan'" role="button" :class="tabActive == 'pelaporan' ? 'bg-white rounded-t-xl text-[#2F3C87]' : 'text-white'" class="flex justify-center items-center px-10 h-[80%] font-bold">Pelaporan</div>
      </div>

      <template v-if="tabActive == 'home'">
         <div class="flex justify-center mt-20">
            <div class="max-w-7xl w-full px-8">
               <div class="grid grid-cols-1 lg:grid-cols-[30%,70%]">
                  <h1 class="font-montserrat text-[#2F3C87] text-5xl font-bold">Apa itu <br> Grantee Portal?</h1>
                  <div class="font-medium mt-5 lg:mt-0">
                     <p>Grantee Portal ini merupakan laman untuk mendukung pengelolaan proyek-proyek yang dilakukan oleh mitra-mitra WLF. Pada laman ini dapat diakses: (1) panduan dan kebijakan WLF terbaru, (2) format-format laporan yang berlaku, dan (3) pelaporan, untuk laporan keuangan dan narasi mitra.</p>
                     <p>Untuk dapat mengakses portal, grantee wajib mendaftarkan alamat email (google based). Seluruh pelaporan mitra baik berupa laporan proyek maupun keuangan disampaikan kepada WLF melalui portal ini. </p>
                  </div>
               </div>
            </div>
         </div>

         <div class="flex w-full justify-center">
            <div class="flex justify-center mt-20 w-full bg-[#2B3E8C] rounded-t-[300px] max-w-[1600px]">
               <div class="max-w-7xl px-8 my-20">
                  <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                     <div class="w-full text-white space-y-5">
                        <div class="h-90 w-full">
                           <img src="/assets/img/grantee/grantee-1.jpg" alt="grantee" class="w-full h-full object-cover rounded-t-[180px] lg:rounded-tl-[150px] lg:rounded-tr-none">
                        </div>
                        <h3 class="text-2xl font-bold">Nilai-Nilai</h3>
                        <p>Dalam pengelolaan dana hibah, WLF menerapkan 7 nilai-nilai dasar. Nilai-nilai ini pula yang diharapkan akan dipraktikkan oleh lembaga mitra. </p>
                        <ul class="list-disc">
                           <li>Pemberdayaan</li>
                           <li>Kolaborasi</li>
                           <li>Akuntabillitas & Integritas</li>
                           <li>Komunikasi Terbuka</li>
                           <li>Berdasarkan kebutuhan</li>
                           <li>Value-for-money (efisiensi dan efektivitas dalam pengelolaan dan penganggaran kegiatan proyek)</li>
                        </ul>
                     </div>

                     <div class="w-full text-white space-y-5">
                        <div class="h-90 w-full">
                           <img src="/assets/img/grantee/grantee-1.jpg" alt="grantee" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-2xl font-bold">Guiding Principles</h3>
                        <p>WLF menerapkan dan mendorong mitra-mitranya untuk menerapkan dua guiding principles: challenging gender norms dan promoting universal access dalam impementasi program-programnya. 
                        Challenging gender norms merefleksikan langkah-langkah mitra yang memungkinkan untuk menantang norma-norma gender yang tidak adil yang berlaku di konteks lokal proyek.
                        Promoting universal access merefleksikan bagaimana pelibatan kelompok marjinal tereksklusi dan disabilitas yang terkait proyek dapat berpartisipasi dalam proyek.  </p>
                     </div>

                     <div class="w-full text-white space-y-5">
                        <div class="h-90 w-full">
                           <img src="/assets/img/grantee/grantee-3.jpg" alt="grantee" class="w-full h-full object-cover lg:rounded-tr-[150px]">
                        </div>
                        <h3 class="text-2xl font-bold">Siklus Pengelolaan Proyek</h3>
                        <ul class="list-decimal">
                           <li>Diskusi bulanan: setiap bulan, waktu sesuai kesepakatan dengan program officer (minggu ke-3).</li>
                           <li>Unggah foto/video: setelah kegiatan, dan/atau ketika ada dokumentasi cerita perubahan.</li>
                           <li>Laporan kuartal proyek dan keuangan: setiap 3 bulan, sesuai dengan tenggat yang diatur dalam Perjanjian Kerja Sama. </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="relative">
            <div class="w-full h-20 lg:h-72 md:h-52 bg-[#2B3E8C]"></div>
            <div class="flex justify-center mt-4 w-full">
               <div class="w-full max-w-[1600px] h-96 rounded-t-[35%] lg:rounded-t-full border-t border-[#D86727]"></div>
            </div>
            <div class="flex justify-center mt-4 w-full">
               <div class="w-full max-w-[1600px] h-[60rem] lg:h-96 rounded-t-[35%] lg:rounded-t-[200px] border-t border-[#D86727] -mt-52"></div>
            </div>

            <div class="absolute w-full top-[50%] -translate-y-1/2 flex justify-center">
               <div class="max-w-7xl h-full w-full mx-8 grid grid-cols-1 lg:grid-cols-2 justify-center gap-10">
                  <div class="w-full space-y-8">
                     <div class="w-full h-[248px] flex justify-center">
                        <img src="/assets/img/grantee/poin-1.png" alt="poin1" class="rounded-3xl h-full w-[80%] object-cover shadow-xl shadow-[#D86727]/20">
                     </div>
                     <h3 class="text-center text-2xl text-[#E75E00] font-bold">Pengiriman Laporan Kuartal</h3>
                     <p class="font-medium">Masing-masing laporan dikirimkan melalui Grantee Portal. Setelah mengunggah ke Grantee Portal, mitra menginfokan kepada officer terkait melalui surel. </p>
                     <ul class="list-disc font-medium">
                        <li>Laporan Kemajuan Program: Dikirimkan kepada Program Officer dengan cc kepada Program Lead dan Grant Officer.</li>
                        <li>Laporan keuangan: Dikirimkan kepada Grant Officer dan Admin and Finance Manager dengan cc kepada Program Officer.</li>
                     </ul>
                  </div>
                  <div class="w-full space-y-8">
                     <div class="w-full h-[248px] flex justify-center">
                        <img src="/assets/img/grantee/poin-2.png" alt="poin2" class="rounded-3xl h-full w-[80%] object-cover shadow-xl shadow-[#D86727]/20">
                     </div>
                     <h3 class="text-center text-2xl text-[#E75E00] font-bold">Pertanyaan</h3>
                     <p class="font-medium">Apabila anda menemui kesulitan atau memiliki pertanyaan dalam mengakses atau mempergunakan portal ini, silakan untuk menghubungi Program Officer yang bertanggungjawab atas proyek Anda. </p>
                  </div>
               </div>
            </div>
         </div>

      </template>

      <template v-if="tabActive == 'panduan'">
         <div class="flex justify-center mt-20">
            <div class="max-w-7xl w-full px-8">
               <p class="font-medium">Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. </p>
            </div>
         </div>

         <div class="flex justify-center my-20">
            <div class="max-w-7xl w-full px-8">
               <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                  <div v-for="i in 6" class="border border-[#E75E00] rounded-t-[20px]">
                     <div class="w-full h-[345px]">
                        <img src="/assets/img/grantee/poin-1.png" alt="lala" class="w-full h-full object-cover rounded-t-[20px]">
                     </div>
                     <div class="bg-[#E75E00] text-center text-white py-5">
                        <p class="text-2xl font-extrabold">Title 1</p>
                        <p class="text-2xl font-extrabold">Sentence 1</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </template>

      <template v-if="tabActive == 'pelaporan'">
         <div class="w-full flex justify-center mt-20">
            <div class="max-w-3xl px-8 text-[#000000] font-medium flex flex-col justify-center gap-10">
               <p class="">Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.</p>
               <p class="">Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.</p>
            </div>

         </div>
         <div class="w-full flex justify-center mt-20">
            <div class="max-w-7xl px-8">
               <div class="flex flex-wrap justify-center gap-5 w-full">
                  <div class="relative border border-[#E75E00] rounded-[20px] p-3 lg:w-[calc(18%)] shadow-xl shadow-[#D86727]/20" v-for="i in partners">
                     <div class="w-full h-56 flex items-center">
                        <img :src="i.image" alt="image" class="w-full object-cover rounded-t-[20px]">
                     </div>
                     <div class="h-full w-full absolute p-8 z-20 top-0 flex flex-col justify-between">
                        <div class="flex justify-end w-full">
                           <ArrowBack class="bg-white/30 backdrop-blur-sm border-white border-2 rounded-full p-1 w-6 h-6 sm:w-9 sm:h-9 text-[#D86727] group-hover:text-white group-hover:bg-[#D86727] ease-in-out duration-500 rotate-[135deg] z-20 mb-8" />
                        </div>
                     </div>
                     <p class="font-montserrat text-[#E75E00] font-bold text-center capitalize">{{ i.title }}</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="w-full flex justify-center my-20">
            <div class="max-w-3xl px-8 text-[#000000] font-medium flex flex-col justify-center gap-10">
               <p class="">Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.</p>
            </div>
         </div>
      </template>

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