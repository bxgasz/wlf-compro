<script setup>
const props = defineProps({
   type: String,
   required: {
      type: Boolean,
      default: false
   },
   title: String,
   placeholder: String,
   label: {
      type: Boolean,
      default: true
   }
})

const model = defineModel({
    type: String,
    required: true,
});
</script>

<template>
   <div>
      <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400" v-if="label">
      {{ title }} <span class="text-error-500" v-if="required">*</span>
      </label>
      <input
      :type="type"
      v-model="model"
      :placeholder="placeholder"
      class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
      />
   </div>
</template>