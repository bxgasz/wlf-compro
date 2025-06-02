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
import { onMounted, ref } from 'vue';

const props = defineProps({
   categories: Object
})

const fields = [
   { "key": "title", "label": "Title", "sort": true },
   { "key": "description", "label": "Description" },
   { "key": "action", "label": "Action" },
]

const lists = ref(props.categories)

const searchText = ref('')
const perPage = ref(10)
const sort = ref('')
const order = ref('desc')

const getCategories = async (page) => {
   const searchParams = new URLSearchParams({
      search: searchText.value,
      perPage: perPage.value,
      page: page,
      order: order.value,
      sort: sort.value
   })

   try {
      const res = await axios.get(route('category.data') + '?' + searchParams.toString())
      lists.value = res.data
   } catch (error) {
      HelperService.toastError(error)
   }
}

const handlePageChange = (page) => {
   getCategories(page)
}

const handleSortData = (field) => {
   sort.value = field
   order.value = order.value == 'desc' ? 'asc' : 'desc'
   getCategories()
}

const handleDelete = async(id) => {
  HelperService.confirmDelete(
    async() => await axios.delete(route('category.destroy', id)),
    async () => {
      HelperService.toastSuccess('Data deleted successfully')
      await getCategories()
    }
  )
}
</script>

<template>
   <AdminLayout>
      <PageBreadcrumb :page-list="[
         { label: 'Category Management', href: '', currPage: true }
      ]" />

      <ComponentCard title="Data Category">
         <template #searchbar>
            <div class="flex items-center gap-2">
               <TextInput
                  @keyup.enter="getCategories"
                  class="w-72"
                  v-model="searchText"
                  placeholder="Search someting"
                  :label="false"
               />
            </div>
         </template>
         <template #button>
            <Link :href="route('category.create')">
               <Button size="sm" variant="primary" :endIcon="PlusIcon"> Add </Button>
            </Link>
         </template>
         <Table :data="lists" :field="fields" @page-change="handlePageChange" @sort-change="handleSortData">
            <template #title="{ row }">
              <div class="flex gap-2">
                  <p class="text-gray-500 text-theme-sm dark:text-gray-400"><strong>ID:</strong> {{ row.title['id'].slice(0, 50) }}</p>
                  <p class="text-gray-500 text-theme-sm dark:text-gray-400"><strong>EN:</strong> {{ row.title['en'].slice(0,50) }}</p>
               </div>
            </template>
            <template #description="{ row }">
               <div class="flex gap-2">
                  <p class="text-gray-500 text-theme-sm dark:text-gray-400 flex gap-1"><strong>ID:</strong> <p v-html="row.description['id'].slice(0, 50)"></p></p>
                  <p class="text-gray-500 text-theme-sm dark:text-gray-400 flex gap-1"><strong>EN:</strong> <p v-html="row.description['en'].slice(0, 50)"></p></p>
               </div>
            </template>
            <template #action="{ row }">
               <div class="flex gap-2">
                  <Link :href="route('category.edit', row.id)">
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
