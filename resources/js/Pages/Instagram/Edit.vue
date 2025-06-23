<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import SearchSelect from '@/Components/SearchSelect.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import { router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
   instagram: Object
})

const form = useForm({
   'media': '',
   'link': props.instagram.link,
})

const tabActive = ref('id')

const handleChangeTab = (tab) => {
   tabActive.value = tab
}

const mediaInput = ref(null)
const media_preview = ref(props.instagram.media ?? null)

const openFileMedia = () => {
   mediaInput.value.click()
}

const handleUploadMedia = (e) => {
   form.media = e.target.files[0]
   media_preview.value = URL.createObjectURL(e.target.files[0])
}

const handleSubmit = async() => {
   form.processing = true
   form.post(route('instagram.update', props.instagram.id), {
      preserveScroll: true,
      onSuccess: () => {
         form.processing = false
         router.visit(route('instagram.index'))
      },
      onError: (error) => {
         console.log(error)
         HelperService.toastError('Failed create data')
      }
   })
}
</script>

<template>
   <AdminLayout>
      {{ console.log(tags) }}
      <PageBreadcrumb :page-list="[
         { label: 'Instagram Management', href: 'instagram.index', currPage: false },
         { label: 'Update Instagram', href: '', currPage: true }
      ]"/>
      <ComponentCard title="Update Instagram">

         <div class="space-y-6">
            <div class="">
               <TextInput 
                  v-model="form.link"
                  type="text"
                  title="Link"
                  :required="true"
                  placeholder="Enter a link"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.link }}
               </label>
            </div>
            
            <div class="">
               <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
               Media (Media) <span class="text-error-500">*</span></label>
               <div as="button" @click="openFileMedia" class="cursor-pointer p-12 flex justify-center border border-dashed border-gray-300 rounded-xl" data-hs-file-upload-trigger="">
                  <div class="text-center" v-if="!media_preview">
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
                     Pick a file up to 1.5MB.
                     </p>
                  </div>

                  <img v-else :src="media_preview" alt="preview">
               </div>
               <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors.media }}
               </label>   
               <input class="hidden" type="file" ref="mediaInput" name="file" accept="media/*" @input="handleUploadMedia" />
            </div>
         </div>
         <div class="flex justify-between items-center mt-3">
            <p class="text-gray-500 text-theme-sm dark:text-gray-400 italic">Warning: Please fill in all required fields in the Indonesian and English tabs. (title, description)</p>
            <Button @click="handleSubmit" size="sm" variant="primary" :disabled="form.processing"> Save Data </Button>
         </div>
      </ComponentCard>
   </AdminLayout>
</template>