<script setup>
import { router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import { ref } from 'vue';
import TextArea from '@/Components/TextArea.vue';

const form = useForm({
   title_en: '',
   title_id: '',
   desc_en: '',
   desc_id: '',
   position_id: '',
   position_en: '',
   image: '',
   link_ig: null,
   link_fb: null,
   link_linkedin: null,
})

const tabActive = ref('id')

const handleChangeTab = (tab) => {
   tabActive.value = tab
}

const options = [
   { value: true, label: 'Active' },
   { value: false, label: 'Disabled' },
]

const imageInput = ref(null)
const image_preview = ref(null)

const openFile = () => {
   imageInput.value.click()
}

const handleUpload = (e) => {
   const file = e.target.files[0]
   form.image = file

   image_preview.value = URL.createObjectURL(file)

}

const handleSubmit = () => {
   form.processing = true

   form.post(route('management.store'), {
      preserveScroll: true,
      onSuccess: () => {
         form.processing = false
         router.visit(route('management.index'))
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
         { label: 'Management', href: 'management.index', currPage: false },
         { label: 'Create Management', href: '', currPage: true }
      ]"/>
      <ComponentCard title="Create Management">
         <div class="flex gap-3 justify-center">
            <Button @click="handleChangeTab('id')" size="sm" :variant="tabActive == 'id' ? 'primary' : 'outline'">ID</Button>
            <Button @click="handleChangeTab('en')" size="sm" :variant="tabActive == 'en' ? 'primary' : 'outline'">EN</Button>
         </div>
         <div class="">
            <TextInput 
               v-model="form.title_en"
               type="text"
               title="Name"
               :required="true"
               placeholder="Enter a name"
            />
            <label
               class="block text-sm font-medium text-error-500"
            >
            {{ form.errors.title_en }}
            </label>
         </div>
         <div class="space-y-6" v-if="tabActive == 'en'">
            <div class="">
               <TextArea 
                  v-model="form.desc_en"
                  title="Desc"
                  :required="true"
                  placeholder="Enter a desc"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.desc_en }}
               </label>
            </div>
            <div class="">
               <TextInput 
                  v-model="form.position_en"
                  type="url"
                  title="Position"
                  :required="true"
                  placeholder="Enter a position"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.position_en }}
               </label>
            </div>
         </div>

         <div class="space-y-6" v-if="tabActive == 'id'">
            <div class="">
               <TextArea 
                  v-model="form.desc_id"
                  title="Desc"
                  :required="true"
                  placeholder="Enter a desc"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.desc_id }}
               </label>
            </div>
            <div class="">
               <TextInput 
                  v-model="form.position_id"
                  type="url"
                  title="Position"
                  :required="false"
                  placeholder="Enter a position"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.position_id }}
               </label>
            </div>
         </div>

         <div class="space-y-6">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            Image (Image) <span class="text-error-500">*</span></label>
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
                  Pick a file up to 1,5MB.
                  </p>
               </div>

               <img v-else-if="image_preview" :src="image_preview" alt="preview">
            </div>
            <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.image }}
            </label>   
            <input class="hidden" type="file" ref="imageInput" name="file" accept="image/*,video/*" @input="handleUpload" />
             
            <div class="">
               <TextInput 
                  v-model="form.link_ig"
                  type="url"
                  title="Instagram URL"
                  :required="false"
                  placeholder="Enter a url"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.link_ig }}
               </label>
            </div>
            <div class="">
               <TextInput 
                  v-model="form.link_fb"
                  type="url"
                  title="Facebook URL"
                  :required="false"
                  placeholder="Enter a url"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.link_fb }}
               </label>
            </div>
            <div class="">
               <TextInput 
                  v-model="form.link_linkedin"
                  type="url"
                  title="Linkedin URL"
                  :required="false"
                  placeholder="Enter a url"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.link_linkedin }}
               </label>
            </div>
         </div>

         <div class="flex justify-between items-center mt-3">
            <p class="text-gray-500 text-theme-sm dark:text-gray-400 italic">Warning: Please fill in all required fields in the Indonesian and English tabs.</p>
            <Button @click="handleSubmit" size="sm" variant="primary" :disabled="form.processing"> Save Data </Button>
         </div>
      </ComponentCard>
   </AdminLayout>
</template>
