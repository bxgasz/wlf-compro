<script setup>
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'

const props = defineProps({
   list: Object
})

const activeIndex = ref(null)

const toggle = (index) => {
activeIndex.value = activeIndex.value === index ? null : index
}

const { locale } = useI18n()
</script>

<template>
   <div class="space-y-4">
      <div
         v-for="(item, index) in list"
         :key="index"
         class="rounded-xl p-4 shadow border w-full bg-[#F3EAE5]"
      >
         <button
            class="w-full flex justify-between gap-4 text-left"
            @click="toggle(index)"
         >
            <span :class="{'font-bold': activeIndex === index}">
               {{ item.question[locale] }}
            </span>
            <span class="text-white h-fit rounded-full p-1" :class="activeIndex === index ? 'bg-[#2B3E8C]' : 'bg-[#FA8F21]'">
               <svg
                  v-if="activeIndex === index"
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 transform rotate-180 transition-transform font-bold"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
               >
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M19 9l-7 7-7-7" />
               </svg>
               <svg
                  v-else
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 transition-transform font-bold"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
               >
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M19 9l-7 7-7-7" />
               </svg>
            </span>
         </button>

         <div
         v-show="activeIndex === index"
         class="mt-4 text-sm text-gray-700 leading-relaxed border-t border-orange-300 pt-4"
         >
         <p v-html="item.answer[locale]"></p>
         </div>
      </div>
   </div>
</template>
 
 
 <style scoped>
 [ v-cloak ] { display: none }
 </style>
 