<script setup>
import { ref } from 'vue';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import ArrowBack from '@/Icons/ArrowBack.vue';
import { Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const props = defineProps({
   granteePartners: Object
})

const tabActive = ref('home')

const { locale } = useI18n()

const panduans = [
   {
      title: {
         en: 'Project Management Guide',
         id: 'Panduan Pengelolaan Proyek'
      },
      img: '/assets/img/grantee/panduan-pengelolaan.jpg',
      link: 'https://drive.google.com/file/d/1PqhRlGNBHqV24A6E3IxHepck0l9ca0pF/view?usp=drive_link'
   },
   {
      title: {
         en: 'Child Protection Policy',
         id: 'Kebijakan perlindungan anak'
      },
      img: '/assets/img/grantee/kebijakan-perlindungan.jpg',
      link: 'https://drive.google.com/file/d/1TLgJUmUoRh5beymufMA6cMqWE4lFufrI/view?usp=sharing'
   },
   {
      title: {
         en: 'Financial Management Guide',
         id: 'Panduan pengelolaan keuangan'
      },
      img: '/assets/img/grantee/panduan-keuangan.jpg',
      link: 'https://drive.google.com/file/d/1_kpYCAMCDW-QAUXodMpkU7s7wCk-XI1B/view?usp=drive_link'
   },
   {
      title: {
         en: 'Guide to Writing Success Stories',
         id: 'Panduan menulis cerita sukses'
      },
      img: '/assets/img/grantee/panduan-menulis.jpg',
      link: 'https://drive.google.com/file/d/1n3Hos3csF2_hI67Ot_EbNuZtajUaEMBr/view?usp=sharing'
   },
   {
      title: {
         en: 'Branding and Marking',
         id: 'Panduan branding dan marking'
      },
      img: '/assets/img/grantee/panduan-branding.jpg',
      link: 'https://drive.google.com/file/d/1GdARo4yuI2i3MaPNjgb1P1mXJYylAR92/view?usp=sharing'
   },
   {
      title: {
         en: 'Photography and Videography Guide',
         id: 'Panduan fotografi dan videografi'
      },
      img: '/assets/img/grantee/panduan-fotografi.jpg',
      link: 'https://drive.google.com/file/d/16VwPG1uNMpde3FCfcHktPim23rCk1ayy/view?usp=sharing '
   },
]

const format = [
    {
      img: '/assets/img/grantee/format.jpeg',
      title: {
         en: 'Project Substance',
         id: 'Substansi proyek'
      },
      data: [
         {
            title: {
                  en: 'Monthly Discussion Presentation Outline',
                  id: 'Outline Presentasi Diskusi Bulanan'
            },
            link: 'https://docs.google.com/presentation/d/1FHpUOLTgQTmXS2Rl3C6EXxJLH3MxOTCf/edit?usp=drive_link&ouid=108852466687183722203&rtpof=true&sd=true'
         },
         {
            title: {
                  id: 'Format Laporam Kemajuan Proyek',
                  en: 'Project Progress Report Format'
            },
            link: 'https://docs.google.com/presentation/d/1FHpUOLTgQTmXS2Rl3C6EXxJLH3MxOTCf/edit?usp=drive_link&ouid=108852466687183722203&rtpof=true&sd=true'
         },
         {
            title: {
                  en: 'Project Final Report Format',
                  id: 'Format Laporan Akhir Proyek'
            },
            link: 'https://docs.google.com/presentation/d/1FHpUOLTgQTmXS2Rl3C6EXxJLH3MxOTCf/edit?usp=drive_link&ouid=108852466687183722203&rtpof=true&sd=true'
         },
         {
            title: {
                  en: 'Work Plan Adjustment Submission Format',
                  id: 'Format Pengajuan Penyesuaian Rencana Kerja'
            },
            link: 'https://docs.google.com/presentation/d/1FHpUOLTgQTmXS2Rl3C6EXxJLH3MxOTCf/edit?usp=drive_link&ouid=108852466687183722203&rtpof=true&sd=true'
         },
      ]
    },
    {
      img: '/assets/img/grantee/keuangan.jpg',
      title: {
         en: 'Finance',
         id: 'Keuangan'
      },
      data: [
         {
            title: {
                  en: 'Financial Report Format',
                  id: 'Format Laporan Keuangan'
            },
            link: 'https://docs.google.com/spreadsheets/d/1kjI5xkBnHFSO2zg6cf282V8TabGbL4ynxRABZDhczLc/edit?usp=sharing'
         },
         {
            title: {
                  id: 'Format Perkiraan',
                  en: 'Format Forecast'
            },
            link: 'https://docs.google.com/spreadsheets/d/1ni5HuiN9h_QYN0--n-SjD-7JIXjCCPDIYwdGHHGNmiQ/edit?usp=sharing'
         },
         {
            title: {
                  id: 'Format Realokasi Anggaran',
                  en: 'Budget Reallocation Format'
            },
            link: 'https://docs.google.com/spreadsheets/d/1sGzb8DU3us3yLMmZiUT1pZIOr2liWOzyGS-GuWvG464/edit#gid=389132779'
         },
         {
            title: {
                  en: 'Quarterly Financial Report Format',
                  id: 'Format Laporan Keuangan Kuartal'
            },
            link: 'https://docs.google.com/document/d/1NydajIM6WchIkGcMBvgGpUvVq57UFinA91mfZPgQhME/edit?usp=drive_link'
         },
         {
            title: {
                  en: 'Final Financial Report Format',
                  id: 'Format Laporan Keuangan Akhir'
            },
            link: 'https://docs.google.com/presentation/d/1FHpUOLTgQTmXS2Rl3C6EXxJLH3MxOTCf/edit?usp=drive_link&ouid=108852466687183722203&rtpof=true&sd=true'
         },
         {
            title: {
                  en: 'Grant Disbursement Request Format',
                  id: 'Format Permohonan Pencairan Dana Hibah'
            },
            link: 'https://docs.google.com/document/d/1Bq8sZ9RmBmIRVMKeEtauvGK1ouBrZCXqZksuyPoEOJg/edit?usp=sharing'
         },
      ]
    },
    {
      img: '/assets/img/grantee/others.jpg',
      title: {
         en: 'Others',
         id: 'Lain-lain'
      },
      data: [
         {
            title: {
                  en: 'Conflict of Interest Prevention Statement Format',
                  id: 'Format Pernyataan Pencegahan Konflik Kepentingan'
            },
            link: 'https://docs.google.com/document/d/1P0ko0aTuB9lplSGmNAhP82d3HuD0y1VQ/edit?usp=sharing&ouid=108852466687183722203&rtpof=true&sd=true'
         },
         {
            title: {
                  id: 'Format Persetujuan Pengambilan dan Penggunaan Dokumentasi',
                  en: 'Documentation Retrieval and Use Approval Format'
            },
            link: 'https://docs.google.com/document/d/1EKl5Noc-TLrf4yr6DiN3iLo795GOsLWF/edit?usp=sharing&ouid=106573849897693678649&rtpof=true&sd=true'
         },
         {
            title: {
                  id: 'Format Permohonan Akses Portal Penerima Dana',
                  en: 'Grantee Portal Access Request Format'
            },
            link: 'https://docs.google.com/document/d/1EdVuA3wmQz3PqBQ8RV9OGraQn02UunHx/edit?usp=sharing&ouid=108852466687183722203&rtpof=true&sd=true'
         },
         {
            title: {
                  en: 'WLF Logo',
                  id: 'Logo WLF'
            },
            link: 'https://drive.google.com/drive/folders/1_RxI1-aYfXbGVKgaaP8mnZMiwdCNZZo1'
         },
      ]
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
         <h1 class="text-white capitalize text-[2rem] md:text-[72px] leading-[1.1] font-playfair font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2">
            {{ $t('grantee.title') }}
         </h1>
      </div>

      <div class="w-full flex justify-start lg:justify-center overflow-auto px-8 bg-[#2F3C87] lg:gap-8 h-24 items-end">
         <div @click="tabActive = 'home'" role="button" :class="tabActive == 'home' ? 'bg-white rounded-t-xl text-[#2F3C87]' : 'text-white'" class="flex justify-center items-center px-10 h-[80%] font-bold">{{ locale == 'id' ? 'Home' : 'Home' }}</div>
         <div @click="tabActive = 'panduan'" role="button" :class="tabActive == 'panduan' ? 'bg-white rounded-t-xl text-[#2F3C87]' : 'text-white'" class="flex justify-center items-center px-10 h-[80%] font-bold">{{ locale == 'id' ? 'Panduan' : 'Guidelines' }}</div>
         <div @click="tabActive = 'format_pelaporan'" role="button" :class="tabActive == 'format_pelaporan' ? 'bg-white rounded-t-xl text-[#2F3C87]' : 'text-white'" class="flex justify-center items-center px-10 h-[80%] font-bold">{{ locale == 'id' ? 'Format Laporan' : 'Report Format' }}</div>
         <div @click="tabActive = 'pelaporan'" role="button" :class="tabActive == 'pelaporan' ? 'bg-white rounded-t-xl text-[#2F3C87]' : 'text-white'" class="flex justify-center items-center px-10 h-[80%] font-bold">{{ locale == 'id' ? 'Pelaporan' : 'Reporting' }}</div>
      </div>

      <template v-if="tabActive == 'home'">
         <div class="flex justify-center mt-20">
            <div class="max-w-7xl w-full px-8">
               <div class="grid grid-cols-1 lg:grid-cols-[30%,70%]">
                  <h1 class="font-montserrat text-[#2F3C87] text-5xl font-bold">{{ $t('grantee.question') }}</h1>
                  <div class="font-medium mt-5 lg:mt-0">
                     <p>{{ $t('grantee.description.1') }}</p>
                     <p>{{ $t('grantee.description.2') }}</p>
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
                           <img src="/assets/img/grantee/values.jpeg" alt="grantee" class="w-full h-full object-cover rounded-t-[180px] lg:rounded-tl-[150px] lg:rounded-tr-none">
                        </div>
                        <h3 class="text-2xl font-bold">{{ $t('grantee.values.title') }}</h3>
                        <p>{{ $t('grantee.values.description') }}</p>
                        <ul class="list-disc">
                           <li v-for="i in 7">{{ $t('grantee.values.' + i) }}</li>
                        </ul>
                     </div>

                     <div class="w-full text-white space-y-5">
                        <div class="h-90 w-full">
                           <img src="/assets/img/grantee/guiding.jpg" alt="grantee" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-2xl font-bold">{{ $t('grantee.guiding.title') }}</h3>
                        <p>{{ $t('grantee.guiding.description') }}</p>
                     </div>

                     <div class="w-full text-white space-y-5">
                        <div class="h-90 w-full">
                           <img src="/assets/img/grantee/project.jpg" alt="grantee" class="w-full h-full object-cover lg:rounded-tr-[150px]">
                        </div>
                        <h3 class="text-2xl font-bold">{{ $t('grantee.cycle.title') }}</h3>
                        <ul class="list-decimal">
                           <li>{{ $t('grantee.cycle.1') }}</li>
                           <li>{{ $t('grantee.cycle.2') }}</li>
                           <li>{{ $t('grantee.cycle.3') }}</li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="relative">
            <div class="w-full h-52 md:h-32 bg-[#2B3E8C]"></div>
            <div class="flex justify-center mt-4 w-full">
               <div class="w-full max-w-[1600px] h-96 rounded-t-[35%] lg:rounded-t-full border-t border-[#D86727]"></div>
            </div>
            <div class="flex justify-center mt-4 w-full">
               <div class="w-full max-w-[1600px] h-[60rem] lg:h-96 rounded-t-[35%] lg:rounded-t-[200px] border-t border-[#D86727] -mt-52"></div>
            </div>

            <div class="absolute w-full top-[45%] md:top-[40%] -translate-y-1/2 flex justify-center">
               <div class="max-w-7xl h-full w-full mx-8 grid grid-cols-1 lg:grid-cols-2 justify-center gap-10">
                  <div class="w-full space-y-8">
                     <div class="w-full h-[248px] flex justify-center">
                        <img src="/assets/img/grantee/quarterly.jpg" alt="poin1" class="rounded-3xl h-full w-[80%] object-cover shadow-xl shadow-[#D86727]/20">
                     </div>
                     <h3 class="text-center text-2xl text-[#E75E00] font-bold">{{ $t('grantee.quarterly') }}</h3>
                     <p class="font-medium">{{ $t('grantee.quarterly.desc') }}</p>
                     <ul class="list-disc font-medium">
                        <li>{{ $t('grantee.quarterly.1') }}</li>
                        <li>{{ $t('grantee.quarterly.2') }}</li>
                     </ul>
                  </div>
                  <div class="w-full space-y-8">
                     <div class="w-full h-[248px] flex justify-center">
                        <img src="/assets/img/grantee/question.jpg" alt="poin2" class="rounded-3xl h-full w-[80%] object-cover shadow-xl shadow-[#D86727]/20">
                     </div>
                     <h3 class="text-center text-2xl text-[#E75E00] font-bold">{{ $t('grantee.question.title') }}</h3>
                     <p class="font-medium">{{ $t('grantee.question.description') }}</p>
                  </div>
               </div>
            </div>
         </div>

      </template>

      <template v-if="tabActive == 'panduan'">
         <div class="flex justify-center mt-20">
            <div class="max-w-7xl w-full px-8">
               <p class="font-medium">{{ $t('grantee.panduan') }}</p>
            </div>
         </div>

         <div class="flex justify-center my-20">
            <div class="max-w-7xl w-full px-8">
               <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                  <a target="_blank" :href="data.link" v-for="(data, i) in panduans" class="border border-[#E75E00] rounded-t-[20px]">
                     <div class="w-full h-[345px]">
                        <img :src="data.img" alt="lala" class="w-full h-full object-cover rounded-t-[20px]">
                     </div>
                     <div class="bg-[#E75E00] text-center text-white py-5">
                        <p class="text-2xl font-extrabold">{{ data.title[locale] }}</p>
                        <!-- <p class="text-2xl font-extrabold">Sentence 1</p> -->
                     </div>
                  </a>
               </div>
            </div>
         </div>
      </template>

      <template v-if="tabActive == 'format_pelaporan'">
         <div class="flex justify-center my-20" v-for="(data, i) in format">
            <div class="max-w-7xl w-full px-8 flex flex-col justify-center items-center">
                <div class="w-[400px] h-[345px]">
                    <img :src="data.img" alt="lala" class="w-full h-full object-cover rounded-[20px]">
                </div>

                <p class="text-center font-bold text-4xl">{{ data.title[locale] }}</p>

                <div class="w-full flex flex-col gap-3 mt-20">
                    <a target="_blank" :href="d.link" class="border-2 border-[#E75E00] p-3 rounded-[20px]" v-for="(d, i) in data.data">
                        {{ d.title[locale] }}
                    </a>
                </div>
            </div>
         </div>
      </template>

      <template v-if="tabActive == 'pelaporan'">
         <div class="w-full flex justify-center mt-20">
            <div class="max-w-3xl px-8 text-[#000000] font-medium flex flex-col justify-center gap-5">
               <p class="">{{ $t('grantee.reporting.1') }}</p>
               <p class="">{{ $t('grantee.reporting.2') }}</p>
               <p class="">{{ $t('grantee.reporting.3') }}</p>
               <ul class="list-disc">
                  <li>{{ $t('grantee.reporting.4') }}</li>
                  <li>{{ $t('grantee.reporting.5') }}</li>
                  <li>{{ $t('grantee.reporting.6') }}</li>
               </ul>
            </div>
         </div>
         <div class="w-full flex justify-center mt-20" v-if="granteePartners.length > 0">
            <div class="max-w-7xl px-8">
               <div class="flex flex-wrap justify-center gap-5 w-full">
                  <a target="_blank" :href="data.link" class="relative border border-[#E75E00] rounded-[20px] p-3 lg:w-[calc(18%)] shadow-xl shadow-[#D86727]/20" v-for="(data, i) in granteePartners" :key="i">
                     <div class="w-full h-56 flex items-center">
                        <img :src="data.logo" alt="image" class="w-full h-full object-contain rounded-t-[20px]">
                     </div>
                     <div class="h-full w-full absolute p-8 z-20 top-0 flex flex-col justify-between">
                        <div class="flex justify-end w-full">
                           <ArrowBack class="bg-white/30 backdrop-blur-sm border-white border-2 rounded-full p-1 w-6 h-6 sm:w-9 sm:h-9 text-[#D86727] group-hover:text-white group-hover:bg-[#D86727] ease-in-out duration-500 rotate-[135deg] z-20 mb-8" />
                        </div>
                     </div>
                     <p class="font-montserrat text-[#E75E00] font-bold text-center capitalize">{{ data.title }}</p>
                  </a>
               </div>
            </div>
         </div>
         <div class="w-full flex justify-center my-20">
            <div class="max-w-3xl px-8 text-[#000000] font-medium flex flex-col justify-center gap-10">
               <p class=""></p>
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
