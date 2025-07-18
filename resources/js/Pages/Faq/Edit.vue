<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import { router, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
   faq: Object
})

const form = useForm({
   question_en: props.faq.question_en,
   question_id: props.faq.question_id,
   answer_en: props.faq.answer_en,
   answer_id: props.faq.answer_id,
   category_en: props.faq.category_en,
   category_id: props.faq.category_id,
})

const tabActive = ref('id')

const handleChangeTab = (tab) => {
   tabActive.value = tab
}

const handleSubmit = async() => {
   form.processing = true
   form.put(route('faq.update', props.faq.id), {
      preserveScroll: true,
      onSuccess: () => {
         form.processing = false
         router.visit(route('faq.index'))
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
         { label: 'Faq Management', href: 'faq.index', currPage: false },
         { label: 'Create Faq', href: '', currPage: true }
      ]"/>
      <ComponentCard title="Create Faq">
         <div class="flex gap-3 justify-center">
            <Button @click="handleChangeTab('id')" size="sm" :variant="tabActive == 'id' ? 'primary' : 'outline'">ID</Button>
            <Button @click="handleChangeTab('en')" size="sm" :variant="tabActive == 'en' ? 'primary' : 'outline'">EN</Button>
         </div>

         <div class="space-y-6" v-if="tabActive == 'en'">
            <div class="">
               <TextInput 
                  v-model="form.question_en"
                  type="text"
                  title="Question"
                  :required="true"
                  placeholder="Enter a question"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.question_en }}
               </label>
            </div>
            <div class="">
               <TextInput 
                  v-model="form.answer_en"
                  type="text"
                  title="Answer"
                  :required="true"
                  placeholder="Enter a answer"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.answer_en }}
               </label>
            </div>
            <div class="">
               <TextInput 
                  v-model="form.category_en"
                  type="text"
                  title="Category"
                  :required="true"
                  placeholder="Enter a category"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.category_en }}
               </label>
            </div>
         </div>

         <div class="space-y-6" v-if="tabActive == 'id'">
            <div class="">
               <TextInput 
                  v-model="form.question_id"
                  type="text"
                  title="Question"
                  :required="true"
                  placeholder="Enter a question"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.question_id }}
               </label>
            </div>
            <div class="">
               <TextInput 
                  v-model="form.answer_id"
                  type="text"
                  title="Answer"
                  :required="true"
                  placeholder="Enter a answer"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.answer_id }}
               </label>
            </div>
            <div class="">
               <TextInput 
                  v-model="form.category_id"
                  type="text"
                  title="Category"
                  :required="true"
                  placeholder="Enter a category"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.category_id }}
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