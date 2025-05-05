<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import PasswordInput from '@/Components/PasswordInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import { router, useForm, usePage } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
   user: Object
})

const page = usePage()

const form = useForm({
   name: props.user.name,
   email: props.user.email,
   role: props.user.role,
   password: '',
   password_confirmation: '',

})

const options = [
   { value: 'admin', label: 'Admin' },
   { value: 'manager', label: 'Manager' },
   { value: 'staff', label: 'Staff' },
]

const handleSubmit = async() => {
   form.processing = true
   form.put(route('user.update', props.user.id), {
      preserveScroll: true,
      onSuccess: () => {
         form.processing = false
         router.visit(route('user.index'))
      },
      onError: (error) => {
         HelperService.toastError('Failed update data')
      }
   })
}
</script>

<template>
   <AdminLayout>
      <PageBreadcrumb :page-list="[
         { label: 'User Management', href: 'user.index', currPage: false },
         { label: 'Update User', href: '', currPage: true }
      ]"/>
      <ComponentCard title="Update User">
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
            
            <div class="" v-if="page.props.auth.user.role == 'admin'">
               <PasswordInput
                  v-model="form.password"
                  type="password"
                  title="Password"
                  placeholder="Enter a password"
               />

               <label
                  class="mt-1.5 block text-sm font-medium text-error-500"
               >
                  {{ form.errors.password }}
               </label>
            </div>
            <div class="" v-if="page.props.auth.user.role == 'admin'">
               <PasswordInput
                  v-model="form.password_confirmation"
                  type="password"
                  title="Password confirmation"
                  placeholder="Enter a password confirmation"
               />

               <label
                  class="mt-1.5 block text-sm font-medium text-error-500"
               >
                  {{ form.errors.password_confirmation }}
               </label>
            </div>
         </div>

         <div class="flex justify-end mt-3">
            <Button @click="handleSubmit" size="sm" variant="primary" :disabled="form.processing"> Save Data </Button>
         </div>
      </ComponentCard>
   </AdminLayout>
</template>