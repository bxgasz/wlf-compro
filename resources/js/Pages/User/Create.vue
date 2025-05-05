<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import { router, useForm } from '@inertiajs/vue3';
import axios from 'axios';

const form = useForm({
   name: '',
   email: '',
   role: ''
})

const options = [
   { value: 'admin', label: 'Admin' },
   { value: 'manager', label: 'Manager' },
   { value: 'staff', label: 'Staff' },
]

const handleSubmit = async() => {
   form.processing = true
   form.post(route('user.store'), {
      preserveScroll: true,
      onSuccess: () => {
         form.processing = false
         router.visit(route('user.index'))
      },
      onError: (error) => {
         HelperService.toastError('Failed create data')
      }
   })
}
</script>

<template>
   <AdminLayout>
      <PageBreadcrumb :page-list="[
         { label: 'User Management', href: 'user.index', currPage: false },
         { label: 'Create User', href: '', currPage: true }
      ]"/>
      <ComponentCard title="Create User">
         <div class="space-y-6">
            <div class="">
               <TextInput 
                  v-model="form.name"
                  type="text"
                  title="Name"
                  :required="true"
                  placeholder="Enter a name"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.name }}
               </label>
            </div>
            <div class="">
               <TextInput 
                  v-model="form.email"
                  type="email"
                  title="Email"
                  :required="true"
                  placeholder="Enter a email"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.email }}
               </label>
            </div>
            <div class="">
               <SelectInput
                  v-model="form.role"
                  :options="options"
                  :required="true"
                  title="Role"
               />     
               <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors.role }}
               </label>   
            </div>    
         </div>

         <div class="flex justify-end mt-3">
            <Button @click="handleSubmit" size="sm" variant="primary" :disabled="form.processing"> Save Data </Button>
         </div>
      </ComponentCard>
   </AdminLayout>
</template>