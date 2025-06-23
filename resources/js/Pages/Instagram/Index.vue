<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import Table from '@/Components/Table.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import EditIcon from '@/Icons/EditIcon.vue';
import PlusIcon from '@/Icons/PlusIcon.vue';
import TrashIcon from '@/Icons/TrashIcon.vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';

const props = defineProps({
   instagrams: Object
})

const fields = [
   { "key": "media", "label": "Media" },
   { "key": "link", "label": "Link", "sort": true },
   { "key": "action", "label": "Action" },
]

const lists = ref(props.instagrams)

const searchText = ref('')
const perPage = ref(10)
const sort = ref('')
const order = ref('desc')

const getInstagram = async (page) => {
   const searchParams = new URLSearchParams({
      search: searchText.value,
      perPage: perPage.value,
      page: page,
      sort: sort.value,
      order: order.value
   })

   try {
      const res = await axios.get(route('instagram.data', 'instagram') + '?' + searchParams.toString())
      lists.value = res.data
   } catch (error) {
      HelperService.toastError(error)
   }
}

const handlePageChange = (page) => {
   getInstagram(page)
}

const handleSortData = (field) => {
   sort.value = field
   order.value = order.value == 'desc' ? 'asc' : 'desc'
   getInstagram()
}

const handleDelete = async(id) => {
   HelperService.confirmDelete(
      async() => await axios.delete(route('instagram.destroy', id)),
      async() => {
         HelperService.toastSuccess('Data deleted successfully')
         await getInstagram()
      }
   )
}
</script>

<template>
   <AdminLayout>
      <PageBreadcrumb :page-list="[
         { label: 'Instagram Management', href: '', currPage: true }
      ]" />

      <ComponentCard title="Data Instagram">
         <template #searchbar>
            <div class="flex items-center gap-2">
               <TextInput
                  @keyup.enter="getInstagram"
                  class="w-72"
                  v-model="searchText"
                  placeholder="Search someting"
                  :label="false"
               />
            </div>
         </template>
         <template #button>
            <Link :href="route('instagram.create')">
               <Button size="sm" variant="primary" :endIcon="PlusIcon"> Add </Button>
            </Link>
         </template>
         <Table :data="lists" :field="fields" :order="order" @page-change="handlePageChange" @sort-change="handleSortData">
            <template #media="{ row }">
               <div class="w-10 h-10 overflow-hidden rounded-full">
                  <img :src="row.media" :alt="row.title" class="h-full w-full object-cover"/>
               </div>
            </template>
            <template #action="{ row }">
               <div class="flex gap-2">
                  <Link :href="route('instagram.edit', row.id)">
                     <EditIcon class="cursor-pointer text-gray-700 hover:text-yellow-500 dark:text-gray-400 dark:hover:text-yellow-500"/>
                  </Link>
                  <button @click="handleDelete(row.id)">
                     <TrashIcon class="cursor-pointer text-gray-700 hover:text-error-500 dark:text-gray-400 dark:hover:text-error-500"/>
                  </button>
               </div>
            </template>
         </Table>
      </ComponentCard>
   </AdminLayout>
</template>