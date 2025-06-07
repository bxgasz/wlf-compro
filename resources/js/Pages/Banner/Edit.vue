<script setup>
import { router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import { ref, watch } from 'vue';
import TextArea from '@/Components/TextArea.vue';

const props = defineProps({
   banner: Object,
   total: Number
})

const menuItems = Array.from({ length: props.total }, (_, i) => ({
  label: `${i + 1}`,
  value: i + 1,
}))

const form = useForm({
   title_en: props.banner.title.en,
   title_id: props.banner.title.id,
   desc_en: props.banner.desc.en,
   desc_id: props.banner.desc.id,
   media: null,
   is_active: Boolean(props.banner.is_active),
   type: props.banner.type,
   order_num: props.banner.order_num,
   link_01: props.banner.link_01,
   link_02: props.banner.link_02
})

const tabActive = ref('id')

const handleChangeTab = (tab) => {
   tabActive.value = tab
}

const options = [
   { value: true, label: 'Active' },
   { value: false, label: 'Disabled' },
]

const mediaInput = ref(null)
const media_preview = ref(props.banner.media)
const isImage = ref(props.banner.type == 'img')
const isVideo = ref(props.banner.type == 'video')
const videoRef = ref(null)

const openFile = () => {
   mediaInput.value.click()
}

const handleUpload = (e) => {
   const file = e.target.files[0]
   form.media = file

   const fileType = file.type
    if (fileType.startsWith('image/')) {
      form.type = 'img'
      isImage.value = true
      isVideo.value = false
    } else if (fileType.startsWith('video/')) {
      form.type = 'video'
      isImage.value = false
      isVideo.value = true
    }

   media_preview.value = URL.createObjectURL(file)
}

const handleSubmit = () => {
   form.processing = true

   form.post(route('banner.update', props.banner.id))
}

watch(media_preview, () => {
  if (isVideo.value && videoRef.value) {
    videoRef.value.load()
  }
})
</script>

<template>
   <AdminLayout>
      <PageBreadcrumb :page-list="[
         { label: 'Banner Management', href: 'banner.index', currPage: false },
         { label: 'Update Banner', href: '', currPage: true }
      ]"/>

      <ComponentCard title="Update Banner">
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
               <TextArea 
                  v-model="form.desc_en"
                  title="Description"
                  :required="false"
                  placeholder="Enter a desc"
               />
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
               <TextArea 
                  v-model="form.desc_id"
                  title="Description"
                  :required="false"
                  placeholder="Enter a desc"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.desc_id }}
               </label>
            </div>
         </div>

         <div class="space-y-6">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            Media (Video / Image) <span class="text-error-500">*</span></label>
            <div as="button" @click="openFile" class="cursor-pointer p-12 flex justify-center border border-dashed border-gray-300 rounded-xl" data-hs-file-upload-trigger="">
               <div class="text-center" v-if="!media_preview">
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

               <img v-else-if="isImage && media_preview" :src="media_preview" alt="preview">

               <video ref="videoRef" v-else-if="isVideo && media_preview" controls>
                  <source :src="media_preview" type="video/mp4" />
               </video>
            </div>
            <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.media }}
            </label>   
            <input class="hidden" type="file" ref="mediaInput" name="file" accept="image/*,video/*" @input="handleUpload" />
            
            <div class="">
               <SelectInput
                  v-model="form.is_active"
                  :options="options"
                  :required="true"
                  title="Status"
               />     
               <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors.is_active }}
               </label>   
            </div>    

            <div class="">
               <SelectInput
                  title="Order Banner"
                  :options="menuItems"
                  v-model="form.order_num"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.order_num }}
               </label>
            </div>

            <div class="">
               <TextInput 
                  v-model="form.link_01"
                  type="url"
                  title="Link 1"
                  :required="false"
                  placeholder="Enter a url"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.link_01 }}
               </label>
            </div>
            <div class="">
               <TextInput 
                  v-model="form.link_02"
                  type="url"
                  title="Link 2"
                  :required="false"
                  placeholder="Enter a url"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
                  {{ form.errors.link_02 }}
               </label>
            </div>
         </div>

         <div class="flex justify-end mt-3">
            <Button @click="handleSubmit" size="sm" variant="primary" :disabled="form.processing"> Save Data </Button>
         </div>
      </ComponentCard>
   </AdminLayout>
</template>
