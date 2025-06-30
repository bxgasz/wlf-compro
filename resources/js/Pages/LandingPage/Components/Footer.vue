<script setup>
import { HelperService } from '@/Helper/Alert';
import { Link, router, useForm, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const page = usePage()

const { locale } = useI18n()

const form = useForm({
   email: ''
})  

const handleSubscribe = () => {
   form.processing = true
   form.post(route('email.subscribe'), {
      preserveScroll: true,
      onSuccess: () => {
         form.processing = false
         form.reset()
         HelperService.toastSuccess('Subscribed to newsletter!')
         router.reload()
      },
      onError: (error) => {
         HelperService.toastError('Failed to subscribe')
      }
   })
}
</script>
<template>
   <footer class="text-white pt-20 font-light pb-10 bg-[#2F3C87] border-t border-[#262C51]">
      <div class="container mx-auto max-w-7xl px-8">
         <div class="flex justify-between flex-col sm:flex-wrap sm:flex-row gap-6">
            <div class="w-full sm:w-auto">
               <img :src="page.props.settings.logo" alt="WLF Logo" class="h-28 mb-4">
            </div>

            <div class="grid">
               <div class="space-y-3">
                  <Link :href="route('about-us')" class="block hover:text-[#D86727] hover:font-semibold capitalize">{{ $t('about.title') }}</Link>
                  <Link :href="route('our-program')" class="block hover:text-[#D86727] hover:font-semibold capitalize">{{ $t('our-program.title') }}</Link>
                  <Link :href="route('publications')" class="block hover:text-[#D86727] hover:font-semibold capitalize">{{ $t('publications.title') }}</Link>
                  <Link :href="route('contact')" class="block hover:text-[#D86727] hover:font-semibold capitalize">{{ $t('contact.title') }}</Link>
                  <Link :href="route('career')" class="block hover:text-[#D86727] hover:font-semibold capitalize">{{ locale == 'id' ? 'Bergabung Dengan Kami' : 'Join Us' }}</Link>
               </div>
            </div>

            <div class="w-[70%] md:w-[25%]">
               <h3 class="font-semibold mb-2">{{ locale == 'id' ? 'Alamat' : 'Address' }}</h3>
               <p class="text-white text-md" v-html="page.props.settings.location">
               </p>
               <a target="_blank" :href="'tel:'+page.props.settings.phone_no" class="mt-10 flex gap-5"><img role="button" src="/assets/icon/phone.svg" alt="x"> {{ page.props.settings.phone_no }} <br></a>
               <a target="_blank" :href="`https://mail.google.com/mail/?view=cm&fs=1&to=${page.props.settings.email}`" class="flex gap-5 mt-5"><img role="button" src="/assets/icon/mail.svg" alt="x"> {{ page.props.settings.email }}</a>
            </div>

            <div>
               <h3 class="font-semibold mb-2">{{ locale == 'id' ? 'Ikuti Kami' : 'Follow Us' }}</h3>
               <p class="text-gray-400 text-sm">
                  <div class="flex gap-3 mt-5 items-center">
                     <a target="_blank" v-if="page.props.settings.x_url" :href="page.props.settings.x_url"><img role="button" src="/assets/icon/twitter.svg" alt="x"></a>
                     <a target="_blank" v-if="page.props.settings.linkedin_url" :href="page.props.settings.linkedin_url"><img role="button" src="/assets/icon/linkedin.svg" alt="linkedin"></a>
                     <a target="_blank" v-if="page.props.settings.facebook_url" :href="page.props.settings.facebook_url"><img role="button" src="/assets/icon/facebook.svg" alt="facebook"></a>
                     <a target="_blank" v-if="page.props.settings.instagram_url" :href="page.props.settings.instagram_url"><img role="button" src="/assets/icon/instagram.svg" alt="instagram"></a>
                     <a target="_blank" v-if="page.props.settings.youtube_url" :href="page.props.settings.youtube_url" class="w-7 h-7 text-[#f26522]"><img role="button" src="/assets/icon/yt.svg" alt="youtube" class="h-full w-full object-contain"></a>
                  </div>
               </p>

               <h3 class="font-semibold mb-2 capitalize mt-5">{{ $t('footer.subscribe') }}</h3>
               <div class="relative w-fit">
                  <input
                     type="email"
                     v-model="form.email"
                     placeholder="Enter your email...."
                     class="pl-4 pr-20 py-2 rounded-full text-sm focus:outline-none w-64 text-black"
                  />
                  <button
                  @click="handleSubscribe"
                  class="absolute right-1 top-1/2 -translate-y-1/2 bg-[#f26522] text-white text-sm font-semibold px-4 py-1.5 rounded-full hover:bg-[#d45315]"
                  >
                  Send
               </button>
            </div>
            <label
               class="block text-sm font-medium text-error-500 mt-2"
            >
               {{ form.errors.email }}
            </label>
            </div>
         </div>
         <div class="flex w-full mt-20 justify-center text-gray-400 text-sm">
            <p>{{ page.props.settings.footer_notes[locale] != null ? page.props.settings.footer_notes[locale] : '© 2024 Hak cipta dilindungi oleh undang-undang.' }}</p>
         </div>
         <!-- <div class="border-t border-gray-700 my-6"></div> -->
      </div>
   </footer>
</template>