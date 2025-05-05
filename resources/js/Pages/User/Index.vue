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
import Swal from 'sweetalert2';
import { ref } from 'vue';

const pageTitle = ref('User Management')

const props = defineProps({
  users: Object
})

const fields = [
   { "key": "user", "label": "User", "sort": true },
   { "key": "email", "label": "Email", "sort": true },
   { "key": "active", "label": "Active"},
   { "key": "action", "label": "Action" },
]
const lists = ref(props.users)

const searchText = ref('')
const roleFilter = ref('')
const perPage = ref(10)
const sort = ref('')
const order = ref('desc')

const getUsers = async(page) => {
   const searchParams = new URLSearchParams({
      search: searchText.value,
      role: roleFilter.value,
      perPage: perPage.value,
      page: page,
      sort: sort.value,
      order: order.value
   })

   try {
      const res = await axios.get(route('user.data') + '?' + searchParams.toString())
      lists.value = res.data
   } catch (error) {
      HelperService.toastError(error)
   }
}

const handlePageChange = (page) => {
   getUsers(page)
}

const handleSortData = (field) => {
   sort.value = field
   order.value = order.value == 'desc' ? 'asc' : 'desc'
   getUsers()
}

const handleDelete = async(id) => {
  HelperService.confirmDelete(
    async() => await axios.delete(route('user.destroy', id)),
    async () => {
      HelperService.toastSuccess('Data deleted successfully')
      await getUsers()
    }
  )
}

const toggleStatus = async(event, item) => {
  event.preventDefault();

    Swal.fire({
        icon: 'question',
        title: 'Warning',
        text: 'Are you sure want to change status of this '+ `${item.email}` +' ?',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: 'Yes, update status',
        cancelButtonText: 'No',

    }).then(async ({ isConfirmed }) => {
        if(isConfirmed) {
         try {
            await axios.post(route('user.status', item.id)).then(() => {
               HelperService.toastSuccess('Status updated successfully')
               getUsers()
            }).catch(error => {
               HelperService.toastError(error)   
            })
          } catch (error) {
            console.log(error)
            HelperService.toastError('Error update status')
          }
        } else {
            event.target.checked = item.is_active === true;
        }
    });
}

</script>

<template>
   <AdminLayout>
      <PageBreadcrumb :page-list="[
         { label: 'User Management', href: '', currPage: true }
      ]" />
      <ComponentCard title="Data User">
         <template #searchbar>
            <div class="flex items-center gap-2">
               <TextInput
                  @keyup.enter="getUsers"
                  class="w-72"
                  v-model="searchText"
                  placeholder="Search someting"
                  :label="false"
               />
            </div>
         </template>
         <template #button>
            <Link :href="route('user.create')">
               <Button size="sm" variant="primary" :endIcon="PlusIcon"> Add </Button>
            </Link>
         </template>
         <Table :data="lists" :field="fields" :order="order" @page-change="handlePageChange" @sort-change="handleSortData">
            <template #user="{ row }">
               <div class="flex items-center gap-3">
                  <div class="w-10 h-10 overflow-hidden rounded-full">
                     <img :src="row.profile_pic" :alt="row.name" class="profile_img"/>
                  </div>
                  <div>
                     <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                     {{ row.name }}
                     </span>
                     <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                     {{ row.role }}
                     </span>
                  </div>
               </div>
            </template>

            <template #active="{row}">
               <label class="inline-flex items-center cursor-pointer">
                  <input
                     type="checkbox"
                     class="sr-only peer"
                     :checked="row.is_active"
                     @change="toggleStatus($event, row)"
                  >
                  <div
                     class="relative w-11 h-6 rounded-full transition-all 
                        peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
                        "
                     :class="row.is_active == true ? 'bg-blue-600 dark:bg-blue-600' : 'bg-gray-200 dark:bg-gray-700'"
                  >
                     <div
                        class="absolute top-0.5 left-0.5 h-5 w-5 bg-white border border-gray-300 rounded-full shadow 
                        dark:border-gray-600"
                        :class="row.is_active == true ? 'translate-x-5 transition-all transform' : ''"
                     ></div>
                  </div>
                  <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                     {{ row.is_active == true ? "Active" : "Disabled" }}
                  </span>
               </label>
            </template>

            <template #action="{ row }">
               <div class="flex gap-2">
                  <Link :href="route('user.edit', row.id)">
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