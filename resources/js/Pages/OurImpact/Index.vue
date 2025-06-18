<script setup>
import { router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';
import TextArea from '@/Components/TextArea.vue';
import { HelperService } from '@/Helper/Alert';

const props = defineProps({
   our_impact: Object
})

const form = useForm({
   title_1_en: props.our_impact?.title_1?.en ?? '',
   title_1_id: props.our_impact?.title_1?.id ?? '',
   subtitle_1_en: props.our_impact?.subtitle_1?.en ?? '',
   subtitle_1_id: props.our_impact?.subtitle_1?.id ?? '',
   title_2_en: props.our_impact?.title_2?.en ?? '',
   title_2_id: props.our_impact?.title_2?.id ?? '',
   subtitle_2_en: props.our_impact?.subtitle_2?.en ?? '',
   subtitle_2_id: props.our_impact?.subtitle_2?.id ?? '',
   title_3_en: props.our_impact?.title_3?.en ?? '',
   title_3_id: props.our_impact?.title_3?.id ?? '',
   subtitle_3_en: props.our_impact?.subtitle_3?.en ?? '',
   subtitle_3_id: props.our_impact?.subtitle_3?.id ?? '',
   title_4_en: props.our_impact?.title_4?.en ?? '',
   title_4_id: props.our_impact?.title_4?.id ?? '',
   subtitle_4_en: props.our_impact?.subtitle_4?.en ?? '',
   subtitle_4_id: props.our_impact?.subtitle_4?.id ?? '',
   sdg_title_en: props.our_impact?.sdg_title?.en ?? '',
   sdg_title_id: props.our_impact?.sdg_title?.id ?? '',
   image: null,
   sub_icons: Array.isArray(props.our_impact?.sub_icons) 
      ? props.our_impact.sub_icons.map(icon => ({
         icon: null, // Default null karena akan diupload nanti
         text_id: icon?.text?.id ?? '', 
         text_en: icon?.text?.en ?? '', 
      }))
      : [
         { icon: null, text_en: "", text_id: "" },
         { icon: null, text_en: "", text_id: "" },
         { icon: null, text_en: "", text_id: "" },
      ],
})

const tabActive = ref('id')

const handleChangeTab = (tab) => {
   tabActive.value = tab
}

const imageInput = ref(null)
const image_preview = ref(props.our_impact.image ?? null)

const subIconInputs = ref([]);
const subIconPreviews = ref(props.our_impact.sub_icons ? props.our_impact.sub_icons.map(icon => icon.icon) : []);;

const openFile = () => {
   imageInput.value.click()
}

const handleUpload = (e) => {
   const file = e.target.files[0]
   form.image = file

   image_preview.value = URL.createObjectURL(file)

}

const openFileSubIcon = (index) => {
  if (subIconInputs.value[index]) {
    subIconInputs.value[index].click();
  }
};

const handleSubIconUpload = (event, index) => {
  const file = event.target.files[0];
  if (file) {
    form.sub_icons[index].icon = file;
    subIconPreviews.value[index] = URL.createObjectURL(file);
  }
};

const handleSubmit = () => {
   form.processing = true

   form.post(route('our-impact-management.upstore', props.our_impact.id), {
      preserveScroll: true,
      forceFormData: true,
      onSuccess: () => {
         form.processing = false
         router.reload({ only: ['our_impact'] });
         HelperService.toastSuccess('Data updated successfully')
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
         { label: 'Good Mining', href: 'our-impact-management.index', currPage: false },
         { label: 'Update Data', href: '', currPage: true }
      ]"/>
      <ComponentCard title="Update Data">
         <div class="flex gap-3 justify-center">
            <Button @click="handleChangeTab('id')" size="sm" :variant="tabActive == 'id' ? 'primary' : 'outline'">ID</Button>
            <Button @click="handleChangeTab('en')" size="sm" :variant="tabActive == 'en' ? 'primary' : 'outline'">EN</Button>
         </div>
         
         <div class="space-y-6" v-if="tabActive == 'en'">
           <div v-for="i in 4" :key="i" class="grid grid-cols-2 gap-5">
               <div>
                  <TextInput 
                     v-model="form['title_' + i + '_en']"
                     type="text"
                     :title="'Title ' + i"
                     :required="true"
                     placeholder="Enter a title"
                  />
                  <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors['title_' + i + '_en'] }}
                  </label>
               </div>

               <div class="">
                  <TextInput 
                     v-model="form['subtitle_' + i + '_en']"
                     type="text"
                     :title="'Subtitle ' + i"
                     :required="true"
                     placeholder="Enter a subtitle"
                  />
                  <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors['subtitle_' + i + '_en'] }}
                  </label>
               </div>
           </div>
           <div class="">
               <TextInput 
                  v-model="form.sdg_title_en"
                  type="text"
                  title="SDG Title"
                  :required="true"
                  placeholder="Enter a title"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.sdg_title_en }}
               </label>
            </div>
         </div>

         <div class="space-y-6" v-if="tabActive == 'id'">
            <div v-for="i in 4" :key="i" class="grid grid-cols-2 gap-5">
               <div class="">
                  <TextInput 
                     v-model="form['title_' + i + '_id']"
                     type="text"
                     :title="'Title ' + i"
                     :required="true"
                     placeholder="Enter a title"
                  />
                  <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors['title_' + i + '_id'] }}
                  </label>
               </div>

               <div class="">
                  <TextInput 
                     v-model="form['subtitle_' + i + '_id']"
                     type="text"
                     :title="'Subtitle ' + i"
                     :required="true"
                     placeholder="Enter a subtitle"
                  />
                  <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors['subtitle_' + i + '_id'] }}
                  </label>
               </div>
           </div>
           <div class="">
               <TextInput 
                  v-model="form.sdg_title_id"
                  type="text"
                  title="SDG Title"
                  :required="true"
                  placeholder="Enter a title"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.sdg_title_id }}
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
                  Pick a file up to 2MB.
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

            <div class="grid grid-cols-2 gap-4">
               <div v-for="(item, index) in form.sub_icons" :key="index" class="mb-4">
                  <label class="block text-sm font-medium text-gray-700 mb-1.5"> Upload Icon {{ index + 1 }} </label>
                  <div as="button" @click="openFileSubIcon(index)" class="cursor-pointer p-5 h-48 flex justify-center items-center border border-dashed border-gray-300 rounded-xl" data-hs-file-upload-trigger="">
                     <div class="text-center" v-if="!subIconPreviews[index]">
                        <span class="inline-flex justify-center items-center size-6 bg-gray-100 text-gray-800 rounded-full">
                        <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                     <img v-else-if="subIconPreviews[index]" :src="subIconPreviews[index]" alt="preview" class="w-full h-full object-contain">
                     <input class="hidden" type="file" :ref="el => subIconInputs[index] = el" name="file" @change="(e) => handleSubIconUpload(e, index)" />
                  </div>
                  <!-- <input type="file" @change="(e) => handleSubIconChange(e, index)" accept="image/jpeg, image/png, image/jpg, image/svg" />
                  <div v-if="subIconPreviews[index]" class="mt-2">
                  <img :src="subIconPreviews[index]" alt="Preview" class="w-20 h-20 object-cover rounded-md border" />
                  </div> -->

                  <div class="" v-if="tabActive == 'id'">
                     <TextInput 
                        v-model="item.text_id"
                        type="text"
                        :title="'Text - ' + tabActive"
                        :required="true"
                        placeholder="Enter a text"
                     />
                     <label
                        class="block text-sm font-medium text-error-500"
                     >
                     {{ form.errors[`sub_icons.${index}.icon`] }}
                     </label>
                  </div>

                  <div class="" v-if="tabActive == 'en'">
                     <TextInput 
                        v-model="item.text_en"
                        type="text"
                        :title="'Text - ' + tabActive"
                        :required="true"
                        placeholder="Enter a text"
                     />
                     <label
                        class="block text-sm font-medium text-error-500"
                     >
                     {{ form.errors[`sub_icons.${index}.icon`] }}
                     </label>
                  </div>
               </div>
            </div>
         </div>

         <div class="flex justify-between items-center mt-3">
            <p class="text-gray-500 text-theme-sm dark:text-gray-400 italic">Warning: Please fill in all required fields in the Indonesian and English tabs.</p>
            <Button @click="handleSubmit" size="sm" variant="primary" :disabled="form.processing"> Save Data </Button>
         </div>
      </ComponentCard>
   </AdminLayout>
</template>
