<script setup>
import { computed } from 'vue';

const props = defineProps({
   current_page: Number,
   total: Number,
   per_page: Number,
   links: String,
   last_page: Number
})

const emit = defineEmits(['pageChange']);

const changePage = (page) => {
    if (page > 0 && page <= props.last_page) {
        emit('pageChange', page)
    }
}

const isNumeric = (value) => {
  return !isNaN(parseInt(value));
}

const visibleLinks = computed(() => {
  let start = Math.max(props.current_page - 2, 1);
  let end = start + 5;

  if (props.current_page + 1 == props.last_page) {
      start = start-1
  }

  if (props.current_page == props.last_page) {
    end = props.last_page + 1;
    start = Math.max(end - 5, 0);
  }

  return props.links.slice(start, end);
});

const fromIndex = computed(() => (props.current_page - 1) * props.per_page + 1)
const toIndex = computed(() => Math.min(props.current_page * props.per_page, props.total))
</script>
<template>
   <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
      <div class="flex flex-1 justify-between sm:hidden">
         <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
         <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
      </div>
      <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
         <div>
            <p class="text-sm text-gray-700">
            Showing
            <span class="font-medium">{{ fromIndex }}</span>
            to
            <span class="font-medium">{{ toIndex }}</span>
            of
            <span class="font-medium">{{ total }}</span>
            results
            </p>
         </div>
         <div>
            <nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">
               <a href="#" @click="changePage(current_page - 1)" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                  <span class="sr-only">Previous</span>
                  <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                     <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                  </svg>
               </a>
   
               <template v-for="(link, index) in visibleLinks">
                  <a role="button" @click="changePage(parseInt(link.label))" v-if="isNumeric(link.label)" 
                     class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-inset focus:z-20 focus:outline-offset-0 md:inline-flex"
                     :class="link.active ? 'bg-brand-500 text-white rounded-md' :  'hover:bg-gray-50'"
                  >{{ link.label }}</a>
               </template>

               <a href="#" @click.prevent="changePage(current_page + 1)" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                  <span class="sr-only">Next</span>
                  <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                     <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                  </svg>
               </a>
            </nav>
         </div>
      </div>
   </div>
</template>