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
   staticPage: Object
})

const form = useForm({
   'title_page_en': props.staticPage.title_page.en,
   'title_page_id': props.staticPage.title_page.id,
   'slug': props.staticPage.slug,
   'meta_head': props.staticPage.meta_head,
   'meta_description': props.staticPage.meta_description,
   'image': null,
   'content_en': props.staticPage.content.en,
   'content_id': props.staticPage.content.id,
})

const tabActive = ref('id')

const handleChangeTab = (tab) => {
   tabActive.value = tab
}

const imageInput = ref(null)
const image_preview = ref(props.staticPage.image ?? null)

const openFileImage = () => {
   imageInput.value.click()
}

const handleUploadImage = (e) => {
   form.image = e.target.files[0]
   image_preview.value = URL.createObjectURL(e.target.files[0])
}

const handleSubmit = async() => {
   form.processing = true
   form.post(route('static-page.update', props.staticPage.id), {
      preserveScroll: true,
      onSuccess: () => {
         form.processing = false
         router.visit(route('static-page.index'))
      },
      onError: (error) => {
         console.log(error)
         HelperService.toastError('Failed update data')
      }
   })
}
</script>

<template>
   <AdminLayout>
      {{ console.log(tags) }}
      <PageBreadcrumb :page-list="[
         { label: 'News Stories Management', href: 'static-page.index', currPage: false },
         { label: 'update News Stories', href: '', currPage: true }
      ]"/>
      <ComponentCard title="Update Static Pages">
         <div class="flex gap-3 justify-center">
            <Button @click="handleChangeTab('id')" size="sm" :variant="tabActive == 'id' ? 'primary' : 'outline'">ID</Button>
            <Button @click="handleChangeTab('en')" size="sm" :variant="tabActive == 'en' ? 'primary' : 'outline'">EN</Button>
         </div>

         <div class="space-y-6" v-if="tabActive == 'en'">
            <div class="">
               <TextInput 
                  v-model="form.title_page_en"
                  type="text"
                  title="Title"
                  :required="true"
                  placeholder="Enter a title"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.title_page_en }}
               </label>
            </div>
         </div>

         <div class="space-y-6" v-if="tabActive == 'id'">
            <div class="">
               <TextInput 
                  v-model="form.title_page_id"
                  type="text"
                  title="Title"
                  :required="true"
                  placeholder="Enter a title"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.title_page_id }}
               </label>
            </div>
         </div>

         <div class="space-y-6">
            <div class="">
               <TextInput 
                  v-model="form.meta_head"
                  type="text"
                  title="Meta Head"
                  :required="true"
                  placeholder="Enter a meta head"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.meta_head }}
               </label>
            </div>
            <div class="">
               <TextArea :required="true" title="Meta Description" placeholder="Enter a meta description" v-model="form.meta_description" />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.meta_description }}
               </label>
            </div>

            <div class="">
               <TextInput 
                  v-model="form.slug"
                  type="text"
                  title="Slug"
                  :required="true"
                  placeholder="Enter a slug (exp: your-slug-title)"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.slug }}
               </label>
            </div>
            
            <div class="">
               <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
               Image (Image) <span class="text-error-500">*</span></label>
               <div as="button" @click="openFileImage" class="cursor-pointer p-12 flex justify-center border border-dashed border-gray-300 rounded-xl" data-hs-file-upload-trigger="">
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
                     Pick a file up to 1.5MB.
                     </p>
                  </div>

                  <img v-else :src="image_preview" alt="preview">
               </div>
               <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors.image }}
               </label>   
               <input class="hidden" type="file" ref="imageInput" name="file" accept="image/*" @input="handleUploadImage" />
            </div>

            <div class="description">
               <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                  Content <span class="text-error-500">*</span>
               </label>
               <div class="h-72 mb-24">
                  <QuillEditor toolbar="full" theme="snow" v-model:content="form.content_en" contentType="html" v-if="tabActive == 'en'" />
                  <QuillEditor toolbar="full" theme="snow" v-model:content="form.content_id" contentType="html" v-if="tabActive == 'id'" />
               </div>
               <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ tabActive == 'id' ? form.errors.content_id : form.errors.content_en }}
               </label> 
            </div>
         </div>
         <div class="flex justify-between items-center mt-3">
            <p class="text-gray-500 text-theme-sm dark:text-gray-400 italic">Warning: Please fill in all required fields in the Indonesian and English tabs. (title, description)</p>
            <Button @click="handleSubmit" size="sm" variant="primary" :disabled="form.processing"> Save Data </Button>
         </div>
      </ComponentCard>
   </AdminLayout>
</template>