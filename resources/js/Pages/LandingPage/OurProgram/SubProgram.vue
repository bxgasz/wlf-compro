<script setup>
import { ref } from 'vue';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';

const categories = [
   'Early Childhood Development',
   'Literacy & Numeracy  For Early Grads',
   'Economic Empowerment'
]

const tabActive = ref('Early Childhood Development')
</script>

<template>
   <div class="w-full z-0 font-lato font-light text-[18px] overflow-hidden">
      <Navbar/>

      <div class="w-full text-center relative">
         <div class="image-container">
            <img src="/assets/img/ourprogram/bg-section.png" alt="our-program">
         </div>
         <h1 class="text-white text-[2rem] md:text-[72px] leading-[1.1] font-playfair font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2">
            Our Program
         </h1>
      </div>

      <div class="w-full flex justify-center my-20">
         <div class="max-w-7xl w-full px-8">
            <div class="grid grid-cols-[25%,70%] gap-10">
               <div class="">
                  <p role="button" v-for="(i, index) in categories" @click="tabActive = i" class="p-3 text-base" :class="tabActive == i ? 'bg-[#D86727] text-white font-semibold' : 'border border-[#D86727]', index == 0 ? 'rounded-tr-[20px]' : index == categories.length - 1 ? 'rounded-br-[20px]' : ''">{{ i }}</p>
               </div>
               <div class="">
                  <p class="text-justify">Early childhood development (ECD) plays important roles in ensuring the future of Indonesian children as well as country’s development. Early childhood development refers to the physical, cognitive, socio-emotional, and linguistic development of young children until they enter primary school. In Indonesia, government has developed the holistic integrated services from related sectors to optimize early childhood development called PAUD HI. However, there are still some issues related to the implementation of early childhood development services. One of the most challenging  issue is accessibility of early childhood development services, especially in rural areas.</p>
                  <p class="text-justify mt-4">According to the data from Ministry of Education and Culture (Kemendikbud), it indicated that the access to Early Childhood Development centres in Indonesia is only 34.19 % (Center for Educational Data and Statistics and Culture, 2019). The data also reveal that geographical disparities make some children have limited access to early childhood development services. Another issue is about the quality of the early childhood development centers in Indonesia that are still using teacher-centred approach that emphasis on the academic activities such as reading and writing rather than playing (Kurniati, Adriany, & Yulindrasari, 2007)</p>
                  <p class="text-justify mt-4">William & Lily Foundation (WLF) works to improve access to high quality early childhood development services especially for children under six years old. Our programs contribute to improve access of early childhood development services  and ensure various early childhood development interventions such as the implementation of the PAUD HI, Posyandu, and other related services being provided are functioning effectively in accordance with their intended aims. Together with our implementing partners, we provide capacity building for related actors (PAUD teachers, teaching assistants, Posyandu cadres) and the organisations that run the services (Posyandu, PAUD, and Puskesmas). WLF also supports the related stakeholder forums that aim to improve the quality of early childhood development services, engage with the village government to improve their involvement in supporting actors in early childhood development, and advocate to the local government to address policy gaps in relation to early childhood development.</p>

                  <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-10">
                     <div class="w-full">
                        <div class="w-full h-40">
                           <img src="/assets/img/ourprogram/program1.png" alt="program" class="w-full h-full object-cover rounded-[20px]">
                        </div>
                        <div class="flex w-full justify-between my-5">
                           <p class="text-gray-500">05 May 2025</p>
                           <p class="bg-[#2B3E8C] text-sm p-1 px-3 rounded-full text-white">Selesai</p>
                        </div>
                        <p class="w-full font-medium">
                           Developing Holistic Integrated Early Childhood Development Model
                        </p>
                     </div>
                     <div class="w-full">
                        <div class="w-full h-40">
                           <img src="/assets/img/ourprogram/program2.png" alt="program" class="w-full h-full object-cover rounded-[20px]">
                        </div>
                        <div class="flex w-full justify-between my-5">
                           <p class="text-gray-500">05 May 2025</p>
                           <p class="bg-[#C5BF00] text-sm p-1 px-3 rounded-full text-white">Berlangsung</p>
                        </div>
                        <p class="w-full font-medium">
                           Developing Holistic Integrated Early Childhood Development Model
                        </p>
                     </div>
                     <div class="w-full">
                        <div class="w-full h-40">
                           <img src="/assets/img/ourprogram/program3.png" alt="program" class="w-full h-full object-cover rounded-[20px]">
                        </div>
                        <div class="flex w-full justify-between my-5">
                           <p class="text-gray-500">05 May 2025</p>
                           <p class="bg-[#2B3E8C] text-sm p-1 px-3 rounded-full text-white">Selesai</p>
                        </div>
                        <p class="w-full font-medium">
                           Developing Holistic Integrated Early Childhood Development Model
                        </p>
                     </div>
                  </div>
               </div>
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