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
   location: '',
   start_salary: '',
   to_salary: '',
   salary_range: '',
   status: '',
   type: '',
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
               <TextInput 
                  v-model="form.location"
                  type="text"
                  title="Localocation"
                  :required="true"
                  placeholder="Enter a location"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.location }}
               </label>
            </div>

            <div class="grid grid-cols-2 gap-5">
               <div class="">
                  <TextInput 
                     v-model="form.start_salary"
                     type="number"
                     title="Start Salary"
                     :required="true"
                     placeholder="Enter a number to start"
                  />
                  <label
                     class="block text-sm font-medium text-error-500"
                  >
                     {{ form.errors.slug }}
                  </label>
               </div>
               <div class="">
                  <TextInput 
                     v-model="form.to_salary"
                     type="number"
                     title="To Salary"
                     :required="true"
                     placeholder="Enter a end salary"
                  />
                  <label
                     class="block text-sm font-medium text-error-500"
                  >
                     {{ form.errors.to_salary }}
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