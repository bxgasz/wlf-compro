<template>
   <div>
      <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
         {{ title }} <span class="text-error-500" v-if="required">*</span>
      </label>
      <div class="relative">
         <flat-pickr
            v-model="model"
            :config="flatpickrConfig"
            class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pl-4 pr-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
            placeholder="Select date"
         />
         <span
            class="absolute text-gray-500 -translate-y-1/2 pointer-events-none right-3 top-1/2 dark:text-gray-400"
         >
            <svg
            class="fill-current"
            width="20"
            height="20"
            viewBox="0 0 20 20"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            >
            <path
               fill-rule="evenodd"
               clip-rule="evenodd"
               d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z"
               fill=""
            />
            </svg>
         </span>
      </div>
   </div>
</template>

<script setup>
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'

import monthSelectPlugin from 'flatpickr/dist/plugins/monthSelect/index.js'
import 'flatpickr/dist/plugins/monthSelect/style.css'

const props = defineProps({
   required: {
      type: Boolean,
      default: false
   },
   title: String,
})


const model = defineModel({
    type: String,
    required: true,
});

const flatpickrConfig = {
  dateFormat: 'Y-m',
  altInput: true,
  altFormat: 'F Y',
  wrap: true,
  plugins: [
    new monthSelectPlugin({
      shorthand: true,      // Jika true, bulan tampil sebagai singkatan (Jun)
      dateFormat: "Y-m",    // Format penyimpanan data
      altFormat: "F Y",     // Format tampilan
    }),
  ],
}
</script>