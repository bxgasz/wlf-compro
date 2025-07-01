<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import { router, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
   location: Object
})

const form = useForm({
   title_en: props.location.title.en,
   title_id: props.location.title.id,
   address: props.location.address,
   top: props.location.top,
   left: props.location.left,
})

const tabActive = ref('id')

const handleChangeTab = (tab) => {
   tabActive.value = tab
}

const addLocation = (event) => {
  const rect = event.target.getBoundingClientRect();
  form.left = ((event.clientX - rect.left) / rect.width) * 100;
  form.top = ((event.clientY - rect.top) / rect.height) * 100;
  console.log
};

const handleSubmit = async() => {
   form.processing = true
   form.put(route('location.update', props.location.id), {
      preserveScroll: true,
      onSuccess: () => {
         form.processing = false
         router.visit(route('location.index'))
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
         { label: 'Project Management', href: 'location.index', currPage: false },
         { label: 'Update Project', href: '', currPage: true }
      ]"/>
      <ComponentCard title="Update Project">
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
            <div class="address">
               <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                  Address <span class="text-error-500">*</span>
               </label>
               <div class="h-72 mb-24">
                  <QuillEditor toolbar="full" theme="snow" v-model:content="form.address" contentType="html" />
               </div>
               <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors.address }}
               </label> 
            </div> 
         </div>

         <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            Location Point <span class="text-error-500">*</span>
         </label>
         <div class="relative w-full">
            <img src="/assets/img/home/map-new.png" alt="project location" class="w-full brightness-[0.3]" @click="addLocation">
            
            <div
               v-if="form.top && form.left"
               class="absolute w-[8px] md:w-[15px] h-[8px] md:h-[15px] rounded-[50%] cursor-pointer -translate-x-1/2 -translate-y-1/2 bg-[#D7261C]"
               :style="{
                  top: form.top + '%',
                  left: form.left + '%',
               }"
            >
               <span class="absolute inline-flex right-0 h-full w-full animate-ping rounded-full bg-[#D7261C] opacity-75"></span>
            </div>
         </div>

         <label
            class="block text-sm font-medium text-error-500"
         >
            {{ form.errors.left && form.errors.top ? 'Location point is required' : '' }}
         </label>

         <div class="flex justify-between mt-3 items-center">
            <p class="text-gray-500 text-theme-sm dark:text-gray-400 italic">Warning: Please fill in all required fields in the Indonesian and English tabs.</p>
            <Button @click="handleSubmit" size="sm" variant="primary" :disabled="form.processing"> Save Data </Button>
         </div>
      </ComponentCard>
   </AdminLayout>
</template>