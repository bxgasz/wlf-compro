<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import { router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
   organization: Object
})

const form = useForm({
   image: '',
})

const image_preview = ref(props.organization?.image ?? null)

const imageInput = ref(null)

const openFileIcon = () => {
   imageInput.value.click()
}

const handleUploadIcon = (e) => {
   form.image = e.target.files[0]
   image_preview.value = URL.createObjectURL(e.target.files[0])
}

const handleSubmit = () => {
   form.processing = true

   form.post(route('organization.update'), {
      preserveScroll: true,
      forceFormData: true,
      onSuccess: () => {
         form.processing = false
         router.reload({ only: ['organization'] });
         HelperService.toastSuccess('Organization updated successfully')
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
         { label: 'Organization Content', href: '', currPage: true  }
      ]"/>

      <ComponentCard title="organization">
         <div class="space-y-6">
            <div class="space-y-6">
               <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
               Image <span class="text-error-500">*</span></label>
               <div as="button" @click="openFileIcon" class="cursor-pointer p-12 flex justify-center border border-dashed border-gray-300 rounded-xl" data-hs-file-upload-trigger="">
                  <div class="text-center" v-if="!image_preview">
                     <span class="inline-flex justify-center items-center size-16 bg-gray-100 text-gray-800 rounded-full">
                     <svg class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" x2="12" y1="3" y2="15"></line>
                     </svg>
                     </span>

                     <div class="mt-4 flex flex-wrap justify-center text-sm leading-6 text-gray-600">
                     <span class="pe-1 font-medium text-gray-800 dark:text-gray-400">
                        Upload your file here or
                     </span>
                     <span class="font-semibold text-blue-600 hover:text-blue-700 rounded-lg decoration-2 hover:underline focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2">browse</span>
                     </div>

                     <p class="mt-1 text-xs text-gray-400">
                     Pick a file up to 1MB.
                     </p>
                  </div>

                  <img v-else="image_preview" :src="image_preview" alt="preview">
               </div>
               <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors.image }}
               </label>   
               <input class="hidden" type="file" ref="imageInput" name="file" accept="image/*" @input="handleUploadIcon" />
            </div>

            <div class="flex justify-end mt-3">
               <Button @click="handleSubmit" size="sm" variant="primary" :disabled="form.processing"> Save Data </Button>
            </div>
         </div>
      </ComponentCard>
   </AdminLayout>
</template>