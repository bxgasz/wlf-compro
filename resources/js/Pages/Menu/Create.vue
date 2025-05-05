<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import SearchSelect from '@/Components/SearchSelect.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import PlusIcon from '@/Icons/PlusIcon.vue';
import TrashIcon from '@/Icons/TrashIcon.vue';
import { router, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
   // routes: Array
})

const form = useForm({
   title_en: '',
   title_id: '',
   slug: '',
   link: '',
   dropdown: []
})

const tabActive = ref('id')

const handleChangeTab = (tab) => {
   tabActive.value = tab
}

const addDropdown = () => {
   form.dropdown.push({
      title_en: '',
      title_id: '',
      slug: '',
      link: '',
   })
}

const removeDropdown = (index) => {
   form.dropdown.splice(index, 1)
}

const handleSubmit = async() => {
   form.processing = true
   form.post(route('menu.store'), {
      preserveScroll: true,
      onSuccess: () => {
         form.processing = false
         router.visit(route('menu.index'))
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
         { label: 'Menu Management', href: 'menu.index', currPage: false },
         { label: 'Create Menu', href: '', currPage: true }
      ]"/>
      <ComponentCard title="Create Menu">
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
                  title="Meta title"
                  :required="true"
                  placeholder="Enter a meta title"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.slug }}
               </label>
            </div>

            <div class="">
               <TextInput 
                  v-model="form.link"
                  type="url"
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
         </div> 

         <div class="flex justify-between items-center">
            <label class="block text-xl font-medium text-gray-700 dark:text-gray-400">Dropdown List</label>
            <Button size="sm" variant="primary" :endIcon="PlusIcon" @click="addDropdown"> Add </Button>
         </div>

         <div class="" v-if="form.dropdown.length > 0">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 py-5 border-b-2" v-for="(dropdown, index) in form.dropdown">
               <div class="">
                  <TextInput 
                     v-model="dropdown.title_en"
                     type="text"
                     title="Dropdown title EN"
                     :required="true"
                     placeholder="Enter a title"
                  />
                  <label
                     class="block text-sm font-medium text-error-500"
                  >
                     {{ dropdown.errors?.title_en }}
                  </label>
               </div>

               <div class="">
                  <TextInput 
                     v-model="dropdown.title_id"
                     type="text"
                     title="Dropdown title ID"
                     :required="true"
                     placeholder="Enter a title"
                  />
                  <label
                     class="block text-sm font-medium text-error-500"
                  >
                     {{ dropdown.errors?.title_id }}
                  </label>
               </div>

               <div class="">
                  <TextInput 
                     v-model="dropdown.slug"
                     type="text"
                     title="Meta title"
                     :required="true"
                     placeholder="Enter a meta title"
                  />
                  <label
                     class="block text-sm font-medium text-error-500"
                  >
                     {{ dropdown.errors?.slug }}
                  </label>
               </div>

               <div class="">
                  <TextInput 
                     v-model="dropdown.link"
                     type="url"
                     title="Link"
                     :required="true"
                     placeholder="Enter a link"
                  />
                  <label
                     class="block text-sm font-medium text-error-500"
                  >
                     {{ dropdown.errors?.link }}
                  </label>
               </div>
               
               <div class="col-span-2 w-full flex justify-center">
                  <button class="p-3 bg-error-500 text-white rounded-md w-64 flex items-center justify-center gap-5" @click="removeDropdown(index)">Delete <TrashIcon/></button>
               </div>
            </div>
         </div>

         <div class="flex justify-between mt-3 items-center">
            <p class="text-gray-500 text-theme-sm dark:text-gray-400 italic">Warning: Please fill in all required fields in the Indonesian and English tabs.</p>
            <Button @click="handleSubmit" size="sm" variant="primary" :disabled="form.processing"> Save Data </Button>
         </div>
      </ComponentCard>
   </AdminLayout>
</template>