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
   partners: Object
})

const fields = [
   { "key": "logo", "label": "Logo" },
   { "key": "title", "label": "Title", "sort": true },
   { "key": "description", "label": "Description", "sort": true },
   { "key": "action", "label": "Action" },
]

const lists = ref(props.partners)

const searchText = ref('')
const perPage = ref(10)
const sort = ref('')
const order = ref('desc')

const getPartner = async (page) => {
   const searchParams = new URLSearchParams({
      search: searchText.value,
      perPage: perPage.value,
      page: page,
      sort: sort.value,
      order: order.value
   })

   try {
      const res = await axios.get(route('partner.data') + '?' + searchParams.toString())
      lists.value = res.data
   } catch (error) {
      HelperService.toastError(error)
   }
}

const handlePageChange = (page) => {
   getPartner(page)
}

const handleSortData = (field) => {
   sort.value = field
   order.value = order.value == 'desc' ? 'asc' : 'desc'
   getPartner()
}

const handleDelete = async(id) => {
   HelperService.confirmDelete(
      async() => await axios.delete(route('partner.destroy', id)),
      async() => {
         HelperService.toastSuccess('Data deleted successfully')
         await getPartner()
      }
   )
}
</script>

<template>
   <AdminLayout>
      <PageBreadcrumb :page-list="[
         { label: 'Partner Management', href: '', currPage: true }
      ]" />

      <ComponentCard title="Data Partner">
         <template #searchbar>
            <div class="flex items-center gap-2">
               <TextInput
                  @keyup.enter="getPartner"
                  class="w-72"
                  v-model="searchText"
                  placeholder="Search someting"
                  :label="false"
               />
            </div>
         </template>
         <template #button>
            <Link :href="route('partner.create')">
               <Button size="sm" variant="primary" :endIcon="PlusIcon"> Add </Button>
            </Link>
         </template>
         <Table :data="lists" :field="fields" :order="order" @page-change="handlePageChange" @sort-change="handleSortData">
            <template #description="{ row }">
               <div class="flex gap-2">
                  <p class="text-gray-500 text-theme-sm dark:text-gray-400 flex gap-1"><strong>ID:</strong> <p v-html="row.description['id'].slice(0, 50)"></p></p>
                  <p class="text-gray-500 text-theme-sm dark:text-gray-400 flex gap-1"><strong>EN:</strong> <p v-html="row.description['en'].slice(0, 50)"></p></p>
               </div>
            </template>
            <template #logo="{ row }">
               <div class="w-10 h-10 overflow-hidden rounded-full">
                  <img :src="row.logo" :alt="row.title" class="h-full w-full object-cover"/>
               </div>
            </template>
            <template #action="{ row }">
               <div class="flex gap-2">
                  <Link :href="route('partner.edit', row.id)">
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