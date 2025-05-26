<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const page = usePage()

const { locale } = useI18n()
</script>
<template>
   <footer class="text-white py-20 bg-[#2F3C87] border-t border-[#262C51]">
      <div class="container mx-auto max-w-7xl px-8">
         <div class="flex justify-between flex-col sm:flex-wrap sm:flex-row gap-6">
            <div class="w-full sm:w-auto">
               <img :src="page.props.settings.logo" alt="BSS Logo" class="h-10 mb-4">
            </div>

            <div class="space-y-3">
               <Link href="route('landing.about')" class="block hover:text-[#D7261C] hover:font-semibold">About Us</Link>
               <Link href="route('landing.governance')" class="block hover:text-[#D7261C] hover:font-semibold">Our Program</Link>
               <Link href="route('landing.project')" class="block hover:text-[#D7261C] hover:font-semibold">Resources</Link>
               <Link href="route('landing.project')" class="block hover:text-[#D7261C] hover:font-semibold">News & Stories</Link>
               <Link href="route('landing.project')" class="block hover:text-[#D7261C] hover:font-semibold">Work With Us</Link>
            </div>

            <div>
               <Link href="route('landing.media')" class="mb-2 hover:text-[#D7261C] hover:font-semibold">Contact Us</Link>
               <nav class="space-y-2">
                  <Link href="route('landing.life-at-bss')" class="block hover:text-[#D7261C] hover:font-semibold">Join Us</Link>
               </nav>
            </div>

            <div class="sm:basis-1/4">
               <h3 class="font-semibold mb-2">Address</h3>
               <p class="text-white text-md">
                  Menara Karya 17th Floor
                  Jl HR Rasuna Said Blok X-5, Kav. 1-2
                  Jakarta 12950, Indonesia
               </p>
               <a href="'tel:'+page.props.settings.phone_no" class="mt-10"><span class="text-red-500 font-semibold">T.</span> {{ page.props.settings.phone_no }} <br></a>
               <a href="`https://mail.google.com/mail/?view=cm&fs=1&to=${page.props.settings.email}`"><span class="text-red-500 font-semibold">E.</span> {{ page.props.settings.email }}</a>
            </div>

            <div>
               <h3 class="font-semibold mb-2">Follow Us</h3>
               <p class="text-gray-400 text-sm">
                  <div class="flex gap-3 mt-5">
                     <a v-if="page.props.settings.x_url" :href="page.props.settings.x_url"><img role="button" src="/assets/icon/x.svg" alt="x" class="w-5 h-5"></a>
                     <a v-if="page.props.settings.linkedin_url" :href="page.props.settings.linkedin_url"><img role="button" src="/assets/icon/linkedin.svg" alt="linkedin" class="w-5 h-5"></a>
                     <a v-if="page.props.settings.facebook_url" :href="page.props.settings.facebook_url"><img role="button" src="/assets/icon/facebook.svg" alt="facebook" class="w-5 h-5"></a>
                     <a v-if="page.props.settings.instagram_url" :href="page.props.settings.instagram_url"><img role="button" src="/assets/icon/ig.svg" alt="instagram" class="w-5 h-5"></a>
                     <a v-if="page.props.settings.youtube_url" :href="page.props.settings.youtube_url"><img role="button" src="/assets/icon/yt.svg" alt="youtube" class="w-5 h-5"></a>
                  </div>
               </p>
            </div>
         </div>

         <div class="border-t border-gray-700 my-6"></div>

         <div class="flex flex-col sm:flex-row justify-between text-gray-400 text-sm">
            <p>{{ page.props.settings.footer_notes[locale] ?? '© 2024 Hak cipta dilindungi oleh undang-undang.' }}</p>
         </div>
      </div>
   </footer>
</template>