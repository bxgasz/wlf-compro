<template>
   <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
      {{ title }} <span class="text-error-500" v-if="required">*</span>
   </label>
   <div class="relative">
      <v-select
         v-model="model"
         :options="options"
         :reduce="option => option.value"
         label="label"
         :searchable="true"
         :clearable="true"
         :multiple="multiple"
         placeholder="Select Data"
         class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 pt-1.5 px-2 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
      />
   </div>
</template>

<script setup>

const props = defineProps({
   required: {
      type: Boolean,
      default: false
   },
   title: String,
   options: Array,
   multiple: {
    type: Boolean,
    default: false
   }
})

const model = defineModel({
    type: String,
    required: true,
});

</script>

<style>
.vs__dropdown-toggle {
  border: none !important;
  box-shadow: none !important;
}

.vs__search, .vs__selected {
  color: #1f2937 !important;
}

.dark .vs__search, .dark .vs__selected {
  color: rgba(255, 255, 255, 0.9) !important;
}

.vs__dropdown-menu {
  background-color: white !important;
  border: 1px solid #d1d5db !important;
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
}

.dark .vs__dropdown-menu {
  background-color: #1f2937 !important;
  border: 1px solid #374151 !important;
}

.vs__dropdown-option {
  color: #1f2937 !important;
}

.vs__dropdown-option:hover {
  color: #fff !important;
}

.dark .vs__dropdown-option {
  color: rgba(255, 255, 255, 0.9) !important;
}

.vs__search {
  appearance: none !important;
  line-height: var(--vs-line-height) !important;
  font-size: var(--vs-font-size) !important;
  border: 1px solid transparent !important;
  border-left: none !important;
  outline: none !important;
  margin: 4px 0 0 !important;
  padding: 0 7px !important;
  background: none !important;
  box-shadow: none !important;
  width: 0 !important;
  max-width: 100% !important;
  flex-grow: 1 !important;
  z-index: 1 !important;
}
</style>