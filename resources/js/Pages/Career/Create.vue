<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import { router, useForm } from '@inertiajs/vue3';
import { QuillEditor } from '@vueup/vue-quill';
import { ref } from 'vue';

const props = defineProps({
   positions: Object,
   levels: Object
})

const form = useForm({
   title_en: '',
   title_id: '',
   desc_en: '',
   desc_id: '',
   slug: '',
   status: '',
   type: '',
   image: null
})

const status = [
   { label: 'Open', value: 'open' },
   { label: 'Close', value: 'closed' },
   { label: 'Draft', value: 'draft' },
]

const type = [
   { label: 'Career', value: 'career' },
   { label: 'Intern', value: 'intern' },
]

const image_preview = ref(null)

const imageInput = ref(null)

const openFile = () => {
   imageInput.value.click()
}

const handleUpload = (e) => {
   form.image = e.target.files[0]
   image_preview.value = URL.createObjectURL(e.target.files[0])
}

const tabActive = ref('id')

const handleChangeTab = (tab) => {
   tabActive.value = tab
}

const handleSubmit = async() => {
   form.processing = true
   form.salary_range = form.start_salary + ' - ' + form.to_salary
   form.post(route('career.store'), {
      preserveScroll: true,
      onSuccess: () => {
         form.processing = false
         router.visit(route('career.index'))
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
         { label: 'Career Management', href: 'career.index', currPage: false },
         { label: 'Create Career', href: '', currPage: true }
      ]"/>
      <ComponentCard title="Create Career">
         <div class="flex gap-3 justify-center">
            <Button @click="handleChangeTab('id')" size="sm" :variant="tabActive == 'id' ? 'primary' : 'outline'">ID</Button>
            <Button @click="handleChangeTab('en')" size="sm" :variant="tabActive == 'en' ? 'primary' : 'outline'">EN</Button>
         </div>
         <div class="space-y-6" v-if="tabActive == 'en'">
            <div class="">
               <TextInput 
                  v-model="form.title_en"
                  type="text"
                  title="Title"
                  :required="true"
                  placeholder="Enter a title"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.title_en }}
               </label>
            </div>
         </div>

         <div class="space-y-6" v-if="tabActive == 'id'">
            <div class="">
               <TextInput 
                  v-model="form.title_id"
                  type="text"
                  title="Title"
                  :required="true"
                  placeholder="Enter a title"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.title_id }}
               </label>
            </div>
         </div>

         <div class="description">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
               Description <span class="text-error-500">*</span>
            </label>
            <div class="h-72 mb-24">
               <QuillEditor toolbar="full" theme="snow" v-model:content="form.desc_en" contentType="html" v-if="tabActive == 'en'" />
               <QuillEditor toolbar="full" theme="snow" v-model:content="form.desc_id" contentType="html" v-if="tabActive == 'id'" />
            </div>
         </div>

         <div class="space-y-6">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            Image <span class="text-error-500">*</span></label>
            <div as="button" @click="openFile" class="cursor-pointer p-12 flex justify-center border border-dashed border-gray-300 rounded-xl" data-hs-file-upload-trigger="">
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
            <input class="hidden" type="file" ref="imageInput" name="file" accept="image/*" @input="handleUpload" />
         </div>

         <div class="space-y-6">
            <div class="">
               <TextInput 
                  v-model="form.slug"
                  type="text"
                  title="Slug"
                  :required="true"
                  placeholder="Enter a slug"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.slug }}
               </label>
            </div>

            <div class="">
               <SelectInput
                  title="Status"
                  :options="status"
                  v-model="form.status"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.status }}
               </label>
            </div>

            <div class="">
               <SelectInput
                  title="Type"
                  :options="type"
                  v-model="form.type"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.type }}
               </label>
            </div>
         </div>

         <div class="flex justify-between mt-3 items-center">
            <p class="text-gray-500 text-theme-sm dark:text-gray-400 italic">Warning: Please fill in all required fields in the Indonesian and English tabs.</p>
            <Button @click="handleSubmit" size="sm" variant="primary" :disabled="form.processing"> Save Data </Button>
         </div>
      </ComponentCard>
   </AdminLayout>
</template>