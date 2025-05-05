<script setup>
import { router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import { ref } from 'vue';
import SelectInput from '@/Components/SelectInput.vue';
import DocumentIcons from '@/Icons/DocumentIcons.vue';

const props = defineProps({
   resource: Object
})

const form = useForm({
   title_en: props.resource.title.en,
   title_id: props.resource.title.id,
   type: props.resource.type,
   file: null,
})

const tabActive = ref('id')

const type = [
   { label: 'Project Report', value: 'project_report' },
   { label: 'Publications', value: 'publication' },
   { label: 'Tools Approaches', value: 'tools_approaches' },
]

const handleChangeTab = (tab) => {
   tabActive.value = tab
}

const fileInput = ref(null)
const fileName = ref(props.resource.file)

const openFile = () => {
   fileInput.value.click()
}

const handleUpload = (e) => {
   const file = e.target.files[0]
   form.file = file

   fileName.value = file.name

}

const handleSubmit = () => {
   form.processing = true

   form.post(route('resource.update', props.resource.id), {
      preserveScroll: true,
      onSuccess: () => {
         form.processing = false
         router.visit(route('resource.index'))
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
         { label: 'Resource', href: 'resource.index', currPage: false },
         { label: 'Update Resource', href: '', currPage: true }
      ]"/>
      <ComponentCard title="Update Resource">
         <div class="flex gap-3 justify-center">
            <Button @click="handleChangeTab('id')" size="sm" :variant="tabActive == 'id' ? 'primary' : 'outline'">ID</Button>
            <Button @click="handleChangeTab('en')" size="sm" :variant="tabActive == 'en' ? 'primary' : 'outline'">EN</Button>
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

         <div class="space-y-6">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            File <span class="text-error-500">*</span></label>
            <div as="button" @click="openFile" class="cursor-pointer p-12 flex justify-center border border-dashed border-gray-300 rounded-xl" data-hs-file-upload-trigger="">
               <div class="text-center">
                  <span class="inline-flex justify-center items-center size-16 bg-gray-100 text-gray-800 rounded-full">
                  <svg v-if="!fileName" class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                     <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                     <polyline points="17 8 12 3 7 8"></polyline>
                     <line x1="12" x2="12" y1="3" y2="15"></line>
                  </svg>
                  <DocumentIcons v-else />
                  </span>

                  <div class="" v-if="!fileName">
                     <div class="mt-4 flex flex-wrap justify-center text-sm leading-6 text-gray-600">
                        <span class="pe-1 font-medium text-gray-800 dark:text-gray-400">
                           Upload your file here or
                        </span>
                        <span class="font-semibold text-blue-600 hover:text-blue-700 rounded-lg decoration-2 hover:underline focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2">browse</span>
                     </div>
   
                     <p class="mt-1 text-xs text-gray-400">
                        Pick a file up to 10MB.
                     </p>
                  </div>
                  <div class="mt-4 flex flex-wrap justify-center text-sm leading-6 text-gray-600" v-else>
                     <span class="pe-1 font-medium text-gray-800 dark:text-gray-400">
                        {{ fileName }}
                     </span>
                  </div>
               </div>
            </div>
            <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.file }}
            </label>   
            <input class="hidden" type="file" ref="fileInput" accept="application/pdf" name="file" @input="handleUpload" />
         </div>

         <div class="flex justify-between items-center mt-3">
            <p class="text-gray-500 text-theme-sm dark:text-gray-400 italic">Warning: Please fill in all required fields in the Indonesian and English tabs.</p>
            <Button @click="handleSubmit" size="sm" variant="primary" :disabled="form.processing"> Save Data </Button>
         </div>
      </ComponentCard>
   </AdminLayout>
</template>
