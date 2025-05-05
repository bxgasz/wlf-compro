<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import { formatDate } from '@/Helper/FormatDate';
import Button from '@/Components/Button.vue';
import ArrowBack from '@/Icons/ArrowBack.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
   inbox: Object
})
</script>

<template>
   <AdminLayout>
      <PageBreadcrumb :page-list="[
         { label: 'Inbox', href: '', currPage: true }
      ]" />

      <div class="flex flex-wrap lg:flex-nowrap gap-4">
         <ComponentCard title="Detail Inbox" class="w-full relative">
            <template #searchbar>
               <Link :href="route('inbox.index')">
                  <Button size="sm" variant="primary" :endIcon="ArrowBack" />
               </Link>
            </template>

            <template #button>
               <span class="block text-gray-500 text-theme-sm dark:text-gray-400">
                  {{ inbox.email }}
               </span>
            </template>

            <div class="flex justify-between items-center">
               <div class="">
                  <span class="block font-medium text-gray-800 text-theme-md dark:text-white/90">
                     Subject : {{ inbox.subject }}
                  </span>
                  <span class="block text-gray-500 text-theme-sm dark:text-gray-400">
                     From : {{ inbox.full_name }}
                  </span>
                  <span class="block text-gray-500 text-theme-sm dark:text-gray-400">
                     Phone : {{ inbox.phone_number }}
                  </span>
               </div>

               <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ formatDate(inbox.created_at, 'en') }}</p>
            </div>

            <div class="h-[50vh] overflow-auto whitespace-pre-wrap text-gray-500 max-w-[70rem]">
              Messsage : <br> {{ inbox.message }}
            </div>
         </ComponentCard>
      </div>
   </AdminLayout>
</template>
