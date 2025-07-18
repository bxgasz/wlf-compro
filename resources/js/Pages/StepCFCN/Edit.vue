<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import { router, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
   step: Object,
   total: Number
})

const menuItems = Array.from({ length: props.total }, (_, i) => ({
  label: `${i + 1}`,
  value: i + 1,
}))

const form = useForm({
   title_en: props.step.title.en,
   desc_en: props.step.description.en,
   title_id: props.step.title.id,
   desc_id: props.step.description.id,
   image: null,
   file: props.step.file ?? null,
   order: props.step.order
})

const image_preview = ref(props.step.image ?? null)
const imageInput = ref(null)

const openFile = () => {
   imageInput.value.click()
}

const handleUpload = (e) => {
   form.image = e.target.files[0]
   image_preview.value = URL.createObjectURL(e.target.files[0])
}

// const file_preview = ref(props.step.file ?? null)
// const fileInput = ref(null)

// const openFileUpload = () => {
//    fileInput.value.click()
// }
// const handleUploadFile = (e) => {
//    form.file = e.target.files[0]
//    file_preview.value = e.target.files[0].name
// }

const tabActive = ref('id')

const handleChangeTab = (tab) => {
   tabActive.value = tab
}

const handleSubmit = async() => {
   form.processing = true
   form.post(route('step-cfcn.update-data', props.step.id), {
      preserveScroll: true,
      onSuccess: () => {
         form.processing = false
         router.visit(route('step-cfcn.index'))
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
         { label: 'Step Management', href: 'step-cfcn.index', currPage: false },
         { label: 'Create Step', href: '', currPage: true }
      ]"/>
      <ComponentCard title="Create Step">
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
            <div class="">
               <TextArea title="Description" :required="true" v-model="form.desc_en" placeholder="Enter a description" />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.desc_en }}
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
            <div class="">
               <TextArea title="Description" :required="true" v-model="form.desc_id" placeholder="Enter a description" />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.desc_id }}
               </label>
            </div>
         </div>

         <div class="mt-6">
            <SelectInput
               title="Order Step"
               :options="menuItems"
               v-model="form.order"
            />
            <label
               class="block text-sm font-medium text-error-500"
            >
               {{ form.errors.order }}
            </label>
         </div>

         <div class="">
            <TextInput 
               v-model="form.file"
               type="url"
               title="URL File"
               :required="true"
               placeholder="Enter a url"
            />
            <label
               class="block text-sm font-medium text-error-500"
            >
               {{ form.errors.file }}
            </label>
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

         <!-- <div class="space-y-6">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            Document</label>
            <div as="button" @click="openFileUpload" class="cursor-pointer p-12 flex justify-center border border-dashed border-gray-300 rounded-xl" data-hs-file-upload-trigger="">
               <div class="text-center">
                  <span class="inline-flex justify-center items-center size-16 bg-gray-100 text-gray-800 rounded-full">
                  <svg v-if="!file_preview" class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                     <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                     <polyline points="17 8 12 3 7 8"></polyline>
                     <line x1="12" x2="12" y1="3" y2="15"></line>
                  </svg>
                  <DocumentIcons v-else />
                  </span>

                  <div class="" v-if="!file_preview">
                     <div class="mt-4 flex flex-wrap justify-center text-sm leading-6 text-gray-600">
                        <span class="pe-1 font-medium text-gray-800 dark:text-gray-400">
                           Upload your file here or
                        </span>
                        <span class="font-semibold text-blue-600 hover:text-blue-700 rounded-lg decoration-2 hover:underline focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2">browse</span>
                     </div>

                     <p class="mt-1 text-xs text-gray-400">
                        Pick a file
                     </p>
                  </div>
                  <div class="mt-4 flex flex-wrap justify-center text-sm leading-6 text-gray-600" v-else>
                     <span class="pe-1 font-medium text-gray-800 dark:text-gray-400">
                        {{ file_preview }}
                     </span>
                  </div>
               </div>
            </div>
            <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.file }}
            </label>
            <input class="hidden" type="file" ref="fileInput" accept="application/pdf" name="file" @input="handleUploadFile" />
         </div> -->

         <div class="flex justify-between mt-3 items-center">
            <p class="text-gray-500 text-theme-sm dark:text-gray-400 italic">Warning: Please fill in all required fields in the Indonesian and English tabs.</p>
            <Button @click="handleSubmit" size="sm" variant="primary" :disabled="form.processing"> Save Data </Button>
         </div>
      </ComponentCard>
   </AdminLayout>
</template>