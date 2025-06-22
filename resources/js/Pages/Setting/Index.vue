<script setup>
import AdminLayout from '@/Components/admin/layout/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import ComponentCard from '@/Components/common/ComponentCard.vue';
import PageBreadcrumb from '@/Components/common/PageBreadcrumb.vue';
import TextInput from '@/Components/TextInput.vue';
import { HelperService } from '@/Helper/Alert';
import { router, useForm } from '@inertiajs/vue3';
import { QuillEditor } from '@vueup/vue-quill';
import Swal from 'sweetalert2';
import { ref } from 'vue';

const props = defineProps({
   setting: Object
})

const form = useForm({
   title: props.setting.title,
   favicon: '',
   logo: '',
   instagram_url: props.setting.instagram_url,
   facebook_url: props.setting.facebook_url,
   linkedin_url: props.setting.linkedin_url,
   x_url: props.setting.x_url,
   email: props.setting.email,
   phone_no: props.setting.phone_no,
   youtube_url: props.setting.youtube_url,
   tiktok_url: props.setting.tiktok_url,
   location: props.setting.location,
   gmap_url: props.setting.gmap_url,
   footer_notes_en: props.setting.footer_notes?.en ?? '',
   footer_notes_id: props.setting.footer_notes?.id ?? '',
})

const formCta = useForm({
   cta_title_en: props.setting.cta_title?.en ?? '',
   cta_title_id: props.setting.cta_title?.id ?? '',
   cta_link: props.setting.cta_link ?? '',
   show_cta: props.setting.show_cta
})

const favicon_preview = ref(props.setting.favicon ?? null)
const logo_preview = ref(props.setting.logo ?? null)

const favIconInput = ref(null)
const logoInput = ref(null)

const openFileIcon = () => {
   favIconInput.value.click()
}

const openFileLogo = () => {
   logoInput.value.click()
}

const handleUploadIcon = (e) => {
   form.favicon = e.target.files[0]
   favicon_preview.value = URL.createObjectURL(e.target.files[0])
}

const handleUploadLogo = (e) => {
   form.logo = e.target.files[0]
   logo_preview.value = URL.createObjectURL(e.target.files[0])
}

const handleSubmit = () => {
   form.processing = true
   form.post(route('setting.update', props.setting.id), {
      preserveScroll: true,
      forceFormData: true,
      onSuccess: () => {
         form.processing = false
         router.reload({ only: ['setting'] });
         HelperService.toastSuccess('Setting updated successfully')
      },
      onError: (error) => {
         HelperService.toastError('Failed update data')
      }
   })
}

const handleSubmitCta = () => {
   formCta.processing = true
   formCta.post(route('setting.cta', props.setting.id), {
      preserveScroll: true,
      forceFormData: true,
      onSuccess: () => {
         form.processing = false
         router.reload({ only: ['setting'] })
         HelperService.toastSuccess('Setting CTA update successfully')
      },
      onError: (error) => {
         HelperService.toastError('Failed update data')
      }
   })
}

const toggleShowSection = async(event, section) => {
  event.preventDefault();

    Swal.fire({
        icon: 'question',
        title: 'Warning',
        text: 'Are you sure want to switch to show mode?',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: 'Yes, change to show mode',
        cancelButtonText: 'No',

    }).then(async ({ isConfirmed }) => {
        if(isConfirmed) {
         try {
            await axios.post(route('setting.show-section', { setting: props.setting.id, section: section })).then(() => {
               HelperService.toastSuccess('Mode changed successfully')
               window.location.reload()
            }).catch(error => {
               HelperService.toastError(error)   
            })
          } catch (error) {
            console.log(error)
            HelperService.toastError('Error changed mode')
          }
        }
    });
}

</script>

<template>
   <AdminLayout>
      <PageBreadcrumb :page-list="[
         { label: 'Setting Content', href: '', currPage: true  }
      ]"/>

      <ComponentCard title="Show Section Management" class="mb-5">
         <h1 class="mb-5 text-xl font-bold">Component</h1>

         <div class="flex items-center gap-5">
            <label for="">Button Donate</label>
            <label class="inline-flex items-center cursor-pointer">
               <input
                  type="checkbox"
                  class="sr-only peer"
                  :checked="setting.show_donate_button"
                  @change="toggleShowSection($event, 'show_donate_button')"
               >
               <div
                  class="relative w-11 h-6 rounded-full transition-all 
                     peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
                     "
                  :class="setting.show_donate_button == true ? 'bg-blue-600 dark:bg-blue-600' : 'bg-gray-200 dark:bg-gray-700'"
               >
                  <div
                     class="absolute top-0.5 left-0.5 h-5 w-5 bg-white border border-gray-300 rounded-full shadow 
                     dark:border-gray-600"
                     :class="setting.show_donate_button == true ? 'translate-x-5 transition-all transform' : ''"
                  ></div>
               </div>
               <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                  {{ setting.show_donate_button == true ? "Active" : "Disabled" }}
               </span>
            </label>
         </div>

         <h1 class="mb-5 text-xl font-bold">About Page</h1>

         <div class="flex items-center gap-5">
            <label for="">Organization Section</label>
            <label class="inline-flex items-center cursor-pointer">
               <input
                  type="checkbox"
                  class="sr-only peer"
                  :checked="setting.show_organization"
                  @change="toggleShowSection($event, 'show_organization')"
               >
               <div
                  class="relative w-11 h-6 rounded-full transition-all 
                     peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
                     "
                  :class="setting.show_organization == true ? 'bg-blue-600 dark:bg-blue-600' : 'bg-gray-200 dark:bg-gray-700'"
               >
                  <div
                     class="absolute top-0.5 left-0.5 h-5 w-5 bg-white border border-gray-300 rounded-full shadow 
                     dark:border-gray-600"
                     :class="setting.show_organization == true ? 'translate-x-5 transition-all transform' : ''"
                  ></div>
               </div>
               <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                  {{ setting.show_organization == true ? "Active" : "Disabled" }}
               </span>
            </label>
         </div>

         <div class="flex items-center gap-5">
            <label for="">Team Section</label>
            <label class="inline-flex items-center cursor-pointer">
               <input
                  type="checkbox"
                  class="sr-only peer"
                  :checked="setting.show_team"
                  @change="toggleShowSection($event, 'show_team')"
               >
               <div
                  class="relative w-11 h-6 rounded-full transition-all 
                     peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
                     "
                  :class="setting.show_team == true ? 'bg-blue-600 dark:bg-blue-600' : 'bg-gray-200 dark:bg-gray-700'"
               >
                  <div
                     class="absolute top-0.5 left-0.5 h-5 w-5 bg-white border border-gray-300 rounded-full shadow 
                     dark:border-gray-600"
                     :class="setting.show_team == true ? 'translate-x-5 transition-all transform' : ''"
                  ></div>
               </div>
               <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                  {{ setting.show_team == true ? "Active" : "Disabled" }}
               </span>
            </label>
         </div>
      </ComponentCard>

      <ComponentCard title="setting">
         <div class="space-y-6">
            <div class="space-y-6">
               <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
               FavIcon <span class="text-error-500">*</span></label>
               <div as="button" @click="openFileIcon" class="cursor-pointer p-12 flex justify-center border border-dashed border-gray-300 rounded-xl" data-hs-file-upload-trigger="">
                  <div class="text-center" v-if="!favicon_preview">
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
                     Pick a file up to 1MB.
                     </p>
                  </div>

                  <img v-else="favicon_preview" :src="favicon_preview" alt="preview">
               </div>
               <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors.favicon }}
               </label>   
               <input class="hidden" type="file" ref="favIconInput" name="file" accept="image/*" @input="handleUploadIcon" />
            </div>

            <div class="space-y-6">
               <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
               Logo <span class="text-error-500">*</span></label>
               <div as="button" @click="openFileLogo" class="cursor-pointer p-12 flex justify-center border border-dashed border-gray-300 rounded-xl" data-hs-file-upload-trigger="">
                  <div class="text-center" v-if="!logo_preview">
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
                     Pick a file up to 1MB.
                     </p>
                  </div>

                  <img v-else="logo_preview" :src="logo_preview" alt="preview">
               </div>
               <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors.logo }}
               </label>   
               <input class="hidden" type="file" ref="logoInput" name="file" accept="image/*" @input="handleUploadLogo" />
            </div> 

            <div class="">
               <TextInput 
                  v-model="form.title"
                  type="text"
                  title="Company Title"
                  placeholder="Enter a company title"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.title }}
               </label>
            </div>
            
            <div class="">
               <TextInput 
                  v-model="form.instagram_url"
                  type="url"
                  title="Instagram URL"
                  placeholder="Enter a instagram url"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.instagram_url }}
               </label>
            </div>

            <div class="">
               <TextInput 
                  v-model="form.facebook_url"
                  type="url"
                  title="Facebook URL"
                  placeholder="Enter a facebook url"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.facebook_url }}
               </label>
            </div>

            <div class="">
               <TextInput 
                  v-model="form.linkedin_url"
                  type="url"
                  title="Linkedin URL"
                  placeholder="Enter a linkedin url"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.linkedin_url }}
               </label>
            </div>

            <div class="">
               <TextInput 
                  v-model="form.x_url"
                  type="url"
                  title="X URL"
                  placeholder="Enter a x url"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.x_url }}
               </label>
            </div>

            <div class="">
               <TextInput 
                  v-model="form.tiktok_url"
                  type="url"
                  title="TikTok URL"
                  placeholder="Enter a tiktok url"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.tiktok_url }}
               </label>
            </div>

            <div class="">
               <TextInput 
                  v-model="form.email"
                  type="email"
                  title="Email"
                  placeholder="Enter a company email"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.email }}
               </label>
            </div>

            <div class="">
               <TextInput 
                  v-model="form.phone_no"
                  type="text"
                  title="Phone Number"
                  placeholder="Enter a Phone Number"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.phone_no }}
               </label>
            </div>

            <div class="">
               <TextInput 
                  v-model="form.youtube_url"
                  type="url"
                  title="Youtube URL"
                  placeholder="Enter a youtube url"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.youtube_url }}
               </label>
            </div>

            <div class="">
               <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                  Location
               </label>
               <div class="h-52 mb-24">
                  <QuillEditor toolbar="essentials" theme="snow" v-model:content="form.location" contentType="html" />
               </div>
               <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.location }}
               </label>
            </div>

            <div class="">
               <TextInput
                  v-model="form.gmap_url"
                  type="url"
                  title="Google map URL"
                  placeholder="Enter a gmap url"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ form.errors.gmap_url }}
               </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
               <div class="">
                  <TextInput
                     v-model="form.footer_notes_en"
                     type="text"
                     title="Footer Notes in EN"
                     placeholder="Enter a footer notes"
                  />
                  <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors.footer_notes_en }}
                  </label>
               </div>
               <div class="">
                  <TextInput
                     v-model="form.footer_notes_id"
                     type="text"
                     title="Footer Notes in ID"
                     placeholder="Enter a footer notes"
                  />
                  <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ form.errors.footer_notes_id }}
                  </label>
               </div>
            </div>

            <div class="flex justify-end mt-3">
               <Button @click="handleSubmit" size="sm" variant="primary" :disabled="form.processing"> Save Data </Button>
            </div>
         </div>
      </ComponentCard>

      <ComponentCard title="CTA (Call To Action) Section" class="mt-5">
         <div class="space-y-6">
            <div class="flex items-center gap-5">
               <label for="">Show CTA</label>
               <label class="inline-flex items-center cursor-pointer">
                  <input
                     type="checkbox"
                     class="sr-only peer"
                     :checked="setting.show_cta"
                     @change="toggleShowSection($event, 'show_cta')"
                  >
                  <div
                     class="relative w-11 h-6 rounded-full transition-all 
                        peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500
                        "
                     :class="setting.show_cta == true ? 'bg-blue-600 dark:bg-blue-600' : 'bg-gray-200 dark:bg-gray-700'"
                  >
                     <div
                        class="absolute top-0.5 left-0.5 h-5 w-5 bg-white border border-gray-300 rounded-full shadow 
                        dark:border-gray-600"
                        :class="setting.show_cta == true ? 'translate-x-5 transition-all transform' : ''"
                     ></div>
                  </div>
                  <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                     {{ setting.show_cta == true ? "Active" : "Disabled" }}
                  </span>
               </label>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
               <div class="">
                  <TextInput
                     v-model="formCta.cta_title_en"
                     type="text"
                     title="Cta title in EN"
                     placeholder="Enter a cta title"
                  />
                  <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ formCta.errors.cta_title_en }}
                  </label>
               </div>
               <div class="">
                  <TextInput
                     v-model="formCta.cta_title_id"
                     type="text"
                     title="Cta title in ID"
                     placeholder="Enter a cta title"
                  />
                  <label
                     class="block text-sm font-medium text-error-500"
                  >
                  {{ formCta.errors.cta_title_id }}
                  </label>
               </div>
            </div>

            <div class="">
               <TextInput
                  v-model="formCta.cta_link"
                  type="url"
                  title="Button Link"
                  placeholder="Enter a cta url"
               />
               <label
                  class="block text-sm font-medium text-error-500"
               >
               {{ formCta.errors.cta_link }}
               </label>
            </div>

            <div class="flex justify-end mt-3">
               <Button @click="handleSubmitCta" size="sm" variant="primary" :disabled="form.processing"> Save Data </Button>
            </div>
         </div>
      </ComponentCard>
   </AdminLayout>
</template>