<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue'
import ComponentCard from '@/Components/common/ComponentCard.vue'
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue'
import Table from '@/Components/Table.vue'
import TextInput from '@/Components/TextInput.vue'
import { HelperService } from '@/Helper/Alert'
import { formatDate } from '@/Helper/FormatDate'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
   subscriptions: Object
})

const fields = [
   { "key": "email", "label": "Email" },
   { "key": "date", "label": "Date", "sort": true },
]

const lists = ref(props.subscriptions)

const searchText = ref('')

const getSubs = async (page) => {
   const searchParams = new URLSearchParams({
      search: searchText.value,
   })

   try {
      router.get(route('list.teacher') + '?' + searchParams.toString())
   } catch (error) {
      HelperService.toastError(error)
   }
}

const handlePageChange = (page) => {
   getSubs(page)
}

const handleSortData = (field) => {
   sort.value = field
   order.value = order.value == 'desc' ? 'asc' : 'desc'
   getSubs()
}
</script>

<template>
   <AdminLayout>
      <PageBreadcrumb :page-list="[
         { label: 'Subscriptions', href: '', currPage: true }
      ]" />

      <ComponentCard title="Data Tag">
         <template #searchbar>
            <div class="flex items-center gap-2">
               <TextInput
                  @keyup.enter="getSubs"
                  class="w-72"
                  v-model="searchText"
                  placeholder="Search someting"
                  :label="false"
               />
            </div>
         </template>
         <Table :data="lists" :field="fields" @page-change="handlePageChange" @sort-change="handleSortData">
            <template #date="{ row }">
               <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ formatDate(row.created_at) }}</p>
            </template>
         </Table>
      </ComponentCard>
   </AdminLayout>
</template>