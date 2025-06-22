<script setup>
import { Link, router, useForm, usePage } from '@inertiajs/vue3';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import { HelperService } from '@/Helper/Alert';
import Modal from '../Components/Modal.vue';
import { ref } from 'vue';

const page = usePage()
const modal = ref(false)

const form = useForm({
  full_name: "",
  phone_number: "",
  email: "",
  subject: "",
  message: "",
});

const submitForm = () => {
   form.processing = true

   form.post(route('inbox.store'), {
      preserveScroll: true,
      onSuccess: () => {
         form.processing = false
         modal.value = true
         form.reset()
      },
      onError: (error) => {
         HelperService.toastError('Failed create data')
      }
   })
};

</script>

<template>
   <div class="w-full z-0 font-lato text-[18px] overflow-hidden">
      <Navbar/>

      <div class="w-full text-center relative">
         <div class="image-container">
            <img src="/assets/img/about/bg-section.png" alt="about-us">
         </div>
         <h1 class="text-white uppercase text-[2rem] md:text-[72px] leading-[1.1] font-montserrat font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2">
            Contact Us
         </h1>
      </div>

      <div class="px-8 lg:px-0 flex justify-center">
         <div class="grid grid-cols-1 lg:grid-cols-[20%,80%] w-full max-w-5xl gap-10 mt-20">
            <p class="text-center md:text-left text-[16px]">
               Sebelum mulai, silakan lengkapi formulir berikut.Kirim dan tunggu kabar selanjutnya dari kami.
            </p>
            <div class="w-full">
               <div>
                  <form @submit.prevent="submitForm">
                     <div class="mb-4">
                        <label class="block text-sm font-medium mb-3">{{ $t('contact.name') }}</label>
                        <input
                           v-model="form.full_name"
                           type="text"
                           required
                           maxlength="50"
                           :placeholder="`Input ${$t('contact.name')}`"
                           class="w-full p-3 rounded-lg border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-700"
                        />
                        <label
                           class="block text-sm font-medium text-error-500"
                        >
                           {{ form.errors.full_name }}
                        </label>
                     </div>

                     <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                     <div>
                        <label class="block text-sm font-medium mb-3">{{ $t('contact.phone') }}</label>
                        <input
                           v-model="form.phone_number"
                           type="number"
                           required
                           :placeholder="`Input ${$t('contact.phone')}`"
                           class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-700"
                        />
                        <label
                           class="block text-sm font-medium text-error-500"
                        >
                           {{ form.errors.phone_number }}
                        </label>
                     </div>
                     <div>
                        <label class="block text-sm font-medium mb-3">{{ $t('contact.email') }}</label>
                        <input
                           v-model="form.email"
                           type="email"
                           required
                           :placeholder="`Input ${$t('contact.email')}`"
                           class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-700"
                        />
                        <label
                           class="block text-sm font-medium text-error-500"
                        >
                           {{ form.errors.email }}
                        </label>
                     </div>
                     </div>

                     <div class="mb-4">
                        <label class="block text-sm font-medium mb-3">{{ $t('contact.subject') }}</label>
                        <input
                           v-model="form.subject"
                           type="text"
                           required
                           maxlength="100"
                           :placeholder="`Input ${$t('contact.subject')}`"
                           class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-700"
                        />
                        <label
                           class="block text-sm font-medium text-error-500"
                        >
                           {{ form.errors.subject }}
                        </label>
                     </div>

                     <div class="mb-4">
                        <label class="block text-sm font-medium mb-3">{{ $t('contact.message') }}</label>
                        <textarea
                           v-model="form.message"
                           rows="4"
                           required
                           maxlength="250"
                           :placeholder="`Input ${$t('contact.title')}`"
                           class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-700"
                        ></textarea>
                        <label
                           class="block text-sm font-medium text-error-500"
                        >
                           {{ form.errors.message }}
                        </label>
                     </div>

                     <button
                        type="submit"
                        class="bg-[#D86727] px-6 py-3 text-white rounded-xl w-fit"
                     >
                        {{ $t('contact.button') }}
                     </button>
                  </form>
               </div>
            </div>
         </div>
      </div>

      <div class="flex justify-center mt-20 w-full">
         <div class="max-w-7xl w-full px-8 my-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
               <div class="w-full h-[284px]">
                  <iframe class="rounded-[20px]" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2342680692304!2d106.82871827509548!3d-6.232817993755369!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3ef32de8be3%3A0x9bb807c61923a77e!2sWilliam%20%26%20Lily%20Foundation!5e0!3m2!1sid!2sid!4v1748936984987!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
               </div>
               <div class="flex flex-col gap-5">
                  <h1 class="text-5xl font-montserrat  font-bold">Contact Us</h1>
                  <p class="" v-html="page.props.settings.location">
                  </p>
                  <div class="flex gap-2">
                     <a :href="'tel:'+page.props.settings.phone_no"><img role="button" src="/assets/icon/phone.svg" alt="x"> {{ page.props.settings.phone_no }} <br></a>
                     <a :href="`https://mail.google.com/mail/?view=cm&fs=1&to=${page.props.settings.email}`"><img role="button" src="/assets/icon/mail.svg" alt="x"> {{ page.props.settings.email }}</a>
                  </div>
                  <Link href="#" class="bg-[#D86727] hover:bg-[#e47636] ease-in-out duration-500 px-6 py-2 text-white rounded-full font-medium w-fit">Send us a message</Link>
               </div>
            </div>
         </div>
      </div>
      <Footer/>
   </div>

   <Modal :show="modal" @close="modal = false" closeButton="red">
      <div class="flex flex-col text-center justify-center w-full space-y-10">
         <h1 class="text-4xl font-montserrat font-medium uppercase">{{ $t('contact.modal.header') }}</h1>
         <p class="text-[16px]">{{ $t('contact.modal.text') }}</p>
         <div class="flex w-full justify-center">
            <Link :href="route('home')" class="bg-[#D86727] px-6 py-3 rounded-xl w-fit hidden sm:flex">{{ $t('contact.modal.button') }}</Link>
         </div>
      </div>
   </Modal>
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