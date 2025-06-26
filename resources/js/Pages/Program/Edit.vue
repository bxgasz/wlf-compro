<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import DatePicker from '@/Components/DatePicker.vue';
import SearchSelect from '@/Components/SearchSelect.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import DocumentIcons from '@/Icons/DocumentIcons.vue';
import { router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
   categories: Array,
   locations: Array,
   program: Object
})

const status = [
   { label: 'Ongoing', value: 'ongoing' },
   { label: 'Published', value: 'published' },
   { label: 'Draft', value: 'draft' },
   { label: 'Closed', value: 'closed' },
]

const form = useForm({
   'title_en': props.program.title.en,
   'title_id': props.program.title.id,
   'description_en': props.program.description.en,
   'description_id': props.program.description.en,
   'implementing_partner': props.program.implementing_partner,
   'slug': props.program.slug,
   'sector': props.program.sector,
   'location': props.program.location,
   'status': props.program.status,
   'location_id': props.program.location_id,
   'start_date': props.program.start_date,
   'end_date': props.program.end_date,
   'youtube_link': props.program.youtube_link ?? '',
   'banner': null,
   'document': null,
   'program_category_id': props.program.program_category_id,
   'type':  props.program.banner ? 'media' : 'link'
})

const tabActive = ref('id')

const handleChangeTab = (tab) => {
   tabActive.value = tab
}

const tabBanner = ref(props.program.banner ? 'media' : 'link')

const bannerInput = ref(null)
const banner_preview = ref(props.program.banner)

const openFilebanner = () => {
   bannerInput.value.click()
}

const handleUploadbanner = (e) => {
   form.banner = e.target.files[0]
   banner_preview.value = URL.createObjectURL(e.target.files[0])
}

const documentInput = ref(null)
const documentName = ref(props.program.document)

const openDocument = () => {
   documentInput.value.click()
}

const handleUpload = (e) => {
   const document = e.target.files[0]
   form.document = document

   documentName.value = document.name
}

const handleSubmit = async() => {
   form.processing = true
   form.type = tabBanner.value
   form.post(route('program.update', props.program.id), {
      preserveScroll: true,
      onSuccess: () => {
         form.processing = false
         router.visit(route('program.index'))
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
         { label: 'Program Management', href: 'program.index', currPage: false },
         { label: 'Update Program', href: '', currPage: true }
      ]"/>
      <ComponentCard title="Update Program">
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

         <div class="space-y-6">
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
               <TextInput
                  v-model="form.implementing_partner"
                  type="text"
                  title="Implementing Partner"
                  :required="false"
                  placeholder="Enter a implementing partner"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.implementing_partner }}
               </label>
            </div>

            <div class="">
               <TextInput
                  v-model="form.sector"
                  type="text"
                  title="Sector"
                  :required="true"
                  placeholder="Enter a sector"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.sector }}
               </label>
            </div>

            <div class="">
               <TextInput
                  v-model="form.location"
                  type="text"
                  title="Location"
                  :required="false"
                  placeholder="Enter a location"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.location }}
               </label>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
               <div class="">
                  <DatePicker
                     v-model="form.start_date"
                     :required="false"
                     title="Start Date"
                  />
                  <label
                        class="block text-sm font-medium text-error-500"
                     >
                     {{ form.errors.start_date }}
                  </label>
               </div>
               <div class="">
                  <DatePicker
                     v-model="form.end_date"
                     :required="false"
                     title="End Date"
                  />
                  <label
                        class="block text-sm font-medium text-error-500"
                     >
                     {{ form.errors.end_date }}
                  </label>
               </div>
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
               <SearchSelect
                  :options="categories"
                  v-model="form.program_category_id"
                  :required="true"
                  title="Category"
               />
               <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors.program_category_id }}
               </label>
            </div>

            <div class="">
               <SearchSelect
                  :options="locations"
                  v-model="form.location_id"
                  :required="true"
                  title="Location point"
               />
               <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors.program_category_id }}
               </label>
            </div>

            <label class="text-sm font-medium text-gray-700 dark:text-gray-400 flex gap-3 items-center">
               <div class="">
                  Banner
                  <span class="text-error-500">*</span>
               </div>
               <p class="gap-2 flex">
                  <span @click="tabBanner = 'media'" :class="tabBanner == 'media' ? 'bg-indigo-500 text-white' : 'border-indigo-500 text-indigo-500 border-2'" class="cursor-pointer p-1 px-2 rounded-lg hover:bg-indigo-500 hover:text-white transition ease-in-out">Media ( Video/Img )</span>
                  <span @click="tabBanner = 'link'" :class="tabBanner == 'link' ? 'bg-indigo-500 text-white' : 'border-indigo-500 text-indigo-500 border-2'" class="cursor-pointer p-1 px-2 rounded-lg hover:bg-indigo-500 hover:text-white transition ease-in-out">Link</span>
               </p>
            </label>

            <div class="" v-if="tabBanner == 'media'">
               <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
               banner (Banner) <span class="text-error-500">*</span></label>
               <div as="button" @click="openFilebanner" class="cursor-pointer p-12 flex justify-center border border-dashed border-gray-300 rounded-xl" data-hs-file-upload-trigger="">
                  <div class="text-center" v-if="!banner_preview">
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
                     Pick a file up to 5MB.
                     </p>
                  </div>

                  <img v-else :src="banner_preview" alt="preview">
               </div>
               <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors.banner }}
               </label>
               <input class="hidden" type="file" ref="bannerInput" name="file" accept="banner/*" @input="handleUploadbanner" />
            </div>

            <div class="" v-if="tabBanner == 'link'">
               <TextInput
                  :label="false"
                  v-model="form.youtube_link"
                  type="url"
                  title="youtube URL"
                  :required="true"
                  placeholder="Enter a youtube url"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.youtube_link }}
               </label>
            </div>

            <div class="content">
               <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                  Description <span class="text-error-500">*</span>
               </label>
               <div class="h-72 mb-24">
                  <QuillEditor toolbar="full" theme="snow" v-model:content="form.description_en" contentType="html" v-if="tabActive == 'en'" />
                  <QuillEditor toolbar="full" theme="snow" v-model:content="form.description_id" contentType="html" v-if="tabActive == 'id'" />
               </div>
               <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ tabActive == 'id' ? form.errors.description_id : form.errors.description_en }}
               </label>
            </div>

            <div class="space-y-6">
               <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
               Document</label>
               <div as="button" @click="openDocument" class="cursor-pointer p-12 flex justify-center border border-dashed border-gray-300 rounded-xl" data-hs-file-upload-trigger="">
                  <div class="text-center">
                     <span class="inline-flex justify-center items-center size-16 bg-gray-100 text-gray-800 rounded-full">
                     <svg v-if="!documentName" class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" x2="12" y1="3" y2="15"></line>
                     </svg>
                     <DocumentIcons v-else />
                     </span>

                     <div class="" v-if="!documentName">
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
                           {{ documentName }}
                        </span>
                     </div>
                  </div>
               </div>
               <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors.document }}
               </label>
               <input class="hidden" type="file" ref="documentInput" accept="application/pdf" name="file" @input="handleUpload" />
            </div>
         </div>
         <div class="flex justify-between items-center mt-3">
            <p class="text-gray-500 text-theme-sm dark:text-gray-400 italic">Warning: Please fill in all required fields in the Indonesian and English tabs. (title, description)</p>
            <Button @click="handleSubmit" size="sm" variant="primary" :disabled="form.processing"> Save Data </Button>
         </div>
      </ComponentCard>
   </AdminLayout>
</template>
