<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import SelectInput from '@/Components/SelectInput.vue';
import Table from '@/Components/Table.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import EditIcon from '@/Icons/EditIcon.vue';
import PlusIcon from '@/Icons/PlusIcon.vue';
import TrashIcon from '@/Icons/TrashIcon.vue';
import { Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref } from 'vue';

const props = defineProps({
   careers: Object
})

const fields = [
   { "key": "title", "label": "Title", "sort": true },
   { "key": "description", "label": "Description" , "sort": true},
   { "key": "status", "label": "Status" , "sort": false},
   { "key": "action", "label": "Action" },
]

const status = [
   { label: 'Open', value: 'open' },
   { label: 'Close', value: 'closed' },
   { label: 'Draft', value: 'draft' },
]

const lists = ref(props.careers)

const searchText = ref('')
const perPage = ref(10)
const sort = ref('')
const order = ref('desc')

const getCareers = async (page) => {
   const searchParams = new URLSearchParams({
      search: searchText.value,
      perPage: perPage.value,
      page: page,
      sort: sort.value,
      order: order.value
   })

   try {
      const res = await axios.get(route('career.data') + '?' + searchParams.toString())
      lists.value = res.data
   } catch (error) {
      HelperService.toastError(error)
   }
}

const handlePageChange = (page) => {
   getCareers(page)
}

const handleSortData = (field) => {
   sort.value = field
   order.value = order.value == 'desc' ? 'asc' : 'desc'
   getCareers()
}

const updateStatus = async(event, item, status) => {
  event.preventDefault();

    Swal.fire({
        icon: 'question',
        title: 'Warning',
        text: 'Are you sure want to change status of this '+ item.title.en +' ?',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: 'Yes, update status',
        cancelButtonText: 'No',

    }).then(async ({ isConfirmed }) => {
        if(isConfirmed) {
         try {
            await axios.post(route('career.status', { status: status,  career: item.id})).then(() => {
               HelperService.toastSuccess('Status updated successfully')
               getCareers()
            }).catch(error => {
               HelperService.toastError(error)   
            })
          } catch (error) {
            console.log(error)
            HelperService.toastError('Error update status')
          }
        } 
    });
}

const handleDelete = async(id) => {
  HelperService.confirmDelete(
    async() => await axios.delete(route('career.destroy', id)),
    async () => {
      HelperService.toastSuccess('Data deleted successfully')
      await getCareers()
    }
  )
}
</script>

<template>
   <AdminLayout>
      <PageBreadcrumb :page-list="[
         { label: 'Career Management', href: '', currPage: true }
      ]" />

      <!-- <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
         <DataCard title="active career" count="10" :Icon="UserCircleIcon" />
         <DataCard title="close career" count="10" :Icon="UserCircleIcon" />
         <DataCard title="submitted career" count="10" :Icon="UserCircleIcon" />
      </div> -->

      <ComponentCard title="Data Career">
         <template #searchbar>
            <div class="flex items-center gap-2">
               <TextInput
                  @keyup.enter="getCareers"
                  class="w-72"
                  v-model="searchText"
                  placeholder="Search someting"
                  :label="false"
               />
            </div>
         </template>
         <template #button>
            <Link :href="route('career.create')">
               <Button size="sm" variant="primary" :endIcon="PlusIcon"> Add </Button>
            </Link>
         </template>
         <Table :data="lists" :field="fields" :order="order" @page-change="handlePageChange" @sort-change="handleSortData">
            <template #title="{ row }">
              <div class="flex gap-2">
                  <p class="text-gray-500 text-theme-sm dark:text-gray-400"><strong>ID:</strong> {{ row.title['id'].slice(0, 50) }}</p>
                  <p class="text-gray-500 text-theme-sm dark:text-gray-400"><strong>EN:</strong> {{ row.title['en'].slice(0,50) }}</p>
               </div>
            </template>
            <template #status="{row}">
               <SelectInput
                  v-model="row.status"
                  :options="status"
                  @change="updateStatus($event, row, row.status)"
               />
            </template>
            <template #description="{ row }">
               <div class="flex gap-2">
                  <p class="text-gray-500 text-theme-sm dark:text-gray-400"><strong>ID:</strong> {{ row.description['id'].slice(0, 100) }}</p>
                  <p class="text-gray-500 text-theme-sm dark:text-gray-400"><strong>EN:</strong> {{ row.description['en'].slice(0, 100) }}</p>
               </div>
            </template>
            <template #action="{ row }">
               <div class="flex gap-2">
                  <Link :href="route('career.edit', row.id)">
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
