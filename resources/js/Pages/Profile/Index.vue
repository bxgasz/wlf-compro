<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import PasswordInput from '@/Components/PasswordInput.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import { useForm, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';

const page = usePage()

const formPersonal = useForm({
   name: page.props.auth.user.name,
   email: page.props.auth.user.email,
   profile_pic: null
})

const formPassword = useForm({
   old_password: '',
   new_password: '',
   new_password_confirmation: '',
})

const profile_picture = ref(null)
const fileInput = ref(null)

const openFile = () => {
   fileInput.value.click()
}

const handleUpload = (e) => {
   formPersonal.profile_pic = e.target.files[0]
   profile_picture.value = URL.createObjectURL(e.target.files[0]);
}

const handleSubmitPersonal = async () => {
   formPersonal.processing = true

   formPersonal.post(route('profile.update'), {
      preserveScroll: true,
      onSuccess: () => {
         HelperService.toastSuccess('Profile updated successfully')
         formPersonal.processing = false
      },
      onError: (error) => {
         console.log(error)
         HelperService.toastError('Failed update data')
      }
   })
}

const handleSubmitPassword = () => {
   formPassword.post(route('update.password'), {
      preserveScroll: true,
      onSuccess: (page) => {
         formPassword.reset()
         HelperService.toastSuccess('Password updated successfully')
         formPersonal.processing = false
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
         { label: 'User Profile', href: '', currPage: true  }
      ]"/>

      <ComponentCard title="Profile">
         <div>
            <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
               <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">
                  Personal Information
               </h4>
               
               <div class="flex justify-center">
                  <div class="flex justify-center flex-col items-center">
                     <div
                        class="w-36 h-36 overflow-hidden border border-gray-200 rounded-full dark:border-gray-800"
                     >
                        <img :src="profile_picture ? profile_picture : page.props.auth.user.profile_pic" alt="user" class="profile_img" />
                     </div>
                     <input class="hidden" type="file" ref="fileInput" name="file" accept="image/*" @input="handleUpload" />
                     <div class="flex items-center mt-5">
                        <button class="p-[0.5rem] text-sm bg-blue-500 text-white rounded-md" @click="openFile">change photo</button>
                     </div>
                  </div>
               </div>

               <div class="space-y-6">
                  <div class="">
                     <TextInput
                        v-model="formPersonal.name"
                        type="text"
                        title="Name"
                        :required="true"
                        placeholder="Enter your name"
                     />

                     <label
                        class="mt-1.5 block text-sm font-medium text-error-500"
                     >
                        {{ formPersonal.errors.name }}
                     </label>
                  </div>
                  
                  <!-- <div class="">
                     <TextInput
                        v-model="formPersonal.email"
                        type="email"
                        title="Email"
                        :required="true"
                        placeholder="Enter your email"
                     />

                     <label
                        class="mt-1.5 block text-sm font-medium text-error-500"
                     >
                        {{ formPersonal.errors.email }}
                     </label>
                  </div> -->
                  
                  

                  <div class="flex justify-end mt-3">
                     <Button @click="handleSubmitPersonal" size="sm" variant="primary" :disabled="formPersonal.processing"> Update Data </Button>
                  </div>
               </div>
            </div>

            <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
               <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">
                  Change Password
               </h4>
               <div class="space-y-6">
                  <div class="">
                     <PasswordInput
                        v-model="formPassword.old_password"
                        type="password"
                        title="Old Password"
                        :required="true"
                        placeholder="Enter a password"
                     />
                     <label
                        class="mt-1.5 block text-sm font-medium text-error-500"
                     >
                        {{ formPassword.errors.old_password }}
                     </label>
                  </div>
                  
                  <div class="">
                     <PasswordInput
                        v-model="formPassword.new_password"
                        type="password"
                        title="New Password"
                        :required="true"
                        placeholder="Enter a new password"
                     />

                     <label
                        class="mt-1.5 block text-sm font-medium text-error-500"
                     >
                        {{ formPassword.errors.new_password }}
                     </label>
                  </div>
                  <div class="">
                     <PasswordInput
                        v-model="formPassword.new_password_confirmation"
                        type="password"
                        title="New Password confirmation"
                        :required="true"
                        placeholder="Enter a new password confirmation"
                     />

                     <label
                        class="mt-1.5 block text-sm font-medium text-error-500"
                     >
                        {{ formPassword.errors.new_password_confirmation }}
                     </label>
                  </div>
                  <div class="flex justify-end mt-3">
                     <Button @click="handleSubmitPassword" size="sm" variant="primary" :disabled="formPassword.processing"> Change Password </Button>
                  </div>
               </div>
            </div>

         </div>
      </ComponentCard>
   </AdminLayout>
</template>

<style scoped>
.profile_img {
   object-fit: cover;
   height: 100%;
   width: 100%;
}
</style>