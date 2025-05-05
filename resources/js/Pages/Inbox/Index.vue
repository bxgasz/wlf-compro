<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import TextInput from '@/Components/TextInput.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import Table from './Partials/Table.vue';
import { formatDate } from '@/Helper/FormatDate';
import Button from '@/Components/Button.vue';
import ArrowBack from '@/Icons/ArrowBack.vue';
import { HelperService } from '@/Helper/Alert';

const props = defineProps({
   inboxes: Object
})

// const historyEmails = ref([]);
// const isLastPage = ref(true);
// const isLoading = ref(true);
// const errorMessage = ref("");
// const page = ref(1);
// const searchQuery = ref('');

// const tabActive = ref('inbox')

// const getEmails = async (toPage) => {
//    const userId = import.meta.env.VITE_APP_EMAILJS_PUBLIC_KEY;
//    const accessToken = import.meta.env.VITE_APP_EMAILJS_PRIVATE_KEY;
//    const count = 10;

//    try {
//       const res = await axios.get(`https://api.emailjs.com/api/v1.1/history`, {
//          params: {
//             user_id: userId,
//             accessToken: accessToken,
//             page: toPage,
//             count: count,
//             ...(searchQuery.value ? { search: searchQuery.value } : {})
//          },
//       })

//       historyEmails.value = res.data.rows;
//       isLastPage.value = res.data.is_last_page
//       page.value = toPage
//    } catch (error) {
//       console.error("Error:", error);
//    } finally {
//       isLoading.value = false
//    }
// }

// const searchEmails = () => {
//    getEmails()
// }

// const next = () => {
//    getEmails(page.value + 1)
// }

// const prev = () => {
//    getEmails(page.value - 1)
// }

// const detailEmail = ref(null)
// const handleShowDetail = async(id) => {
//    try {
//       detailEmail.value = historyEmails.value.find(email => email.id == id)
//       tabActive.value = 'detail'
//    } catch (error) {
//       HelperService.toastError('Failed open email')
//    } finally {
//       isLoading.value = false
//    }
// }

// onMounted(async() => {
//    getEmails(1)
// })

const fields = [
   { "key": "full_name", "label": "Name", "sort": true },
   { "key": "subject", "label": "Subject" },
   { "key": "created_at", "label": "Date" },
]

const lists = ref(props.inboxes)

const searchText = ref('')
const perPage = ref(10)
const sort = ref('')
const order = ref('desc')

const getInboxes = async (page) => {
   const searchParams = new URLSearchParams({
      search: searchText.value,
      perPage: perPage.value,
      page: page,
      order: order.value,
      sort: sort.value
   })

   try {
      const res = await axios.get(route('inbox.data') + '?' + searchParams.toString())
      lists.value = res.data
   } catch (error) {
      HelperService.toastError(error)
   }
}

const handlePageChange = (page) => {
   getInboxes(page)
}

const handleSortData = (field) => {
   sort.value = field
   order.value = order.value == 'desc' ? 'asc' : 'desc'
   getInboxes()
}
</script>

<template>
   <AdminLayout>
      <PageBreadcrumb :page-list="[
         { label: 'Inbox', href: '', currPage: true }
      ]" />

      <div class="flex flex-wrap lg:flex-nowrap gap-4">
         <ComponentCard title="Inbox" class="w-full relative">
            <template #button>
               <div class="flex items-center gap-2">
                  <TextInput
                     @keyup.enter="getInboxes"
                     v-model="searchText"
                     class="w-72"
                     placeholder="Search someting"
                     :label="false"
                  />
               </div>
            </template>
            <Table :data="lists" :field="fields" @page-change="handlePageChange" @sort-change="handleSortData">
               <template #created_at="{ row }">
                  <p class="text-gray-500 text-theme-sm dark:text-gray-400" :class="{ 'font-semibold' : row.is_read == false, 'text-gray-700' : row.is_read == false }">{{ formatDate(row.created_at, 'en') }}</p>
               </template>
               <template #full_name="{ row }">
                  <p class="text-gray-500 text-theme-sm dark:text-gray-400" :class="{ 'font-semibold' : row.is_read == false, 'text-gray-700' : row.is_read == false }">{{ row.full_name }}</p>
               </template>
               <template #subject="{ row }">
                  <p class="text-gray-500 text-theme-sm dark:text-gray-400" :class="{ 'font-semibold' : row.is_read == false, 'text-gray-700' : row.is_read == false }">{{ row.subject }}</p>
               </template>
            </Table>
            <!-- <Table2 v-if="!isLoading" :data="historyEmails" :isLastPage="isLastPage" :current_page="page" per_page="10" @next="next" @prev="prev" @show-email="handleShowDetail" /> -->

            <!-- <div v-if="isLoading" role="status" class="flex justify-center items-center absolute inset-0 bg-opacity-50 rounded-xl">
               <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
               <span class="sr-only">Loading...</span>
            </div> -->
         </ComponentCard>

         <!-- <ComponentCard title="Detail Email" class="w-full relative" v-else>
            <template #searchbar>
               <Button @click="tabActive = 'inbox'" size="sm" variant="primary" :endIcon="ArrowBack" />
            </template>

            <template #button>
               <span class="block text-gray-500 text-theme-sm dark:text-gray-400">
                  {{ JSON.parse(detailEmail.template_params)?.from_email }}
               </span>
            </template>

            <div class="flex justify-between items-center">
               <div class="">
                  <span class="block font-medium text-gray-800 text-theme-md dark:text-white/90">
                     Subject : {{ JSON.parse(detailEmail.template_params)?.subject }}
                  </span>
                  <span class="block text-gray-500 text-theme-sm dark:text-gray-400">
                     From : {{ JSON.parse(detailEmail.template_params)?.from_name }}
                  </span>
                  <span class="block text-gray-500 text-theme-sm dark:text-gray-400">
                     Phone : {{ JSON.parse(detailEmail.template_params)?.phone }}
                  </span>
               </div>

               <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ formatDate(detailEmail.created_at, 'en') }}</p>
            </div>

            <div class="h-[50vh] overflow-auto whitespace-pre-wrap text-gray-500 max-w-[70rem]">
              Messsage : <br> {{ JSON.parse(detailEmail.template_params)?.message }}
            </div>
         </ComponentCard> -->
      </div>
   </AdminLayout>
</template>
