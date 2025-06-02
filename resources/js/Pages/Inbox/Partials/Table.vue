<template>
  <div
    class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
  >
    <div class="max-w-full overflow-x-auto custom-scrollbar">
      <table class="min-w-full">
        <thead>
          <tr class="border-b border-gray-200 dark:border-gray-700">
            <th class="px-5 py-3 text-left w-3/11 sm:px-6">
              <div class="flex justify-between">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">No.</p>
                  <SortIcon @click="handleSort('id')" class="text-gray-500 w-4 h-4"  role="button" /> 
              </div>
            </th>
            <th class="px-5 py-3 text-left w-3/11 sm:px-6" v-for="f in field" :key="f.key" >
              <div class="flex justify-between">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">{{ f.label }}</p>
                  <SortIcon @click="handleSort(f.key)" class="text-gray-500 w-4 h-4" role="button" v-if="f.sort" /> 
              </div>
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
          <tr role="button"
            @click="handleDetail(row.id)"
            v-if="data.data.length > 0"
            v-for="(row, index) in data.data"
            :key="index"
            class="border-t border-gray-100 dark:border-gray-800 hover:bg-gray-100"
          >
            <td class="px-5 py-4 sm:px-6">
              <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ order == 'desc' ? (currentPage - 1) * perPage + index + 1 : totalData - ((currentPage - 1) * perPage + index) }}</p>
            </td>
            <td class="px-5 py-4 sm:px-6" v-for="f in field" :key="f.key">
              <slot :name="f.key" :row="row">
                  <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ row[f.key] }}</p>
              </slot>
            </td>
          </tr>
          <tr v-else>
            <td :colspan="field.length + 1" class="text-center">
              <p class="text-gray-500 text-theme-sm dark:text-gray-400 my-3">- No data yet -</p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <Pagination
      :current_page="data.current_page"
      :last_page="data.last_page"
      :total="data.total"
      :per_page="data.per_page"
      :links="data.links"
      @page-change="handlePageChange"
    />
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import Pagination from '@/Components/Pagination.vue';
import SortIcon from '@/Icons/SortIcon.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  data: Object,
  field: Object,
  order: {
    type: String,
    default: 'desc'
  }
})

const emit = defineEmits(['pageChange', 'sortChange']);

const handlePageChange = (page) => {
  emit('pageChange', page)
}

const handleSort = (field) => {
  emit('sortChange', field)
}

const handleDetail = (id) => {
  router.get(route('inbox.show', id))
}

const currentPage = computed(() => props.data.current_page);
const totalData = computed(() => props.data.total);
const perPage = computed(() => props.data.per_page);
</script>
