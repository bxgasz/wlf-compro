<template>
  <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div class="flex gap-1 items-center">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" x-text="pageTitle" v-for="page in pageList">
        <Link :href="route(page.href)" class="flex items-center gap-1.5 text-gray-400 hover:text-gray-800 dark:hover:text-white/90" v-if="!page.currPage">
          {{ page.label }}
          <svg v-if="!page.currPage"
            class="stroke-current"
            width="17"
            height="16"
            viewBox="0 0 17 16"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366"
              stroke=""
              stroke-width="1.2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
        </Link>
        <p v-else>{{ page.label }}</p>
      </h2>
    </div>
    <nav>
      <ol class="flex items-center gap-1.5">
        <li class="text-sm text-gray-800 dark:text-white/90" v-for="page in pageList">
          <Link v-if="!page.currPage"
            class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 dark:hover:text-gray-400"
            :href="route(page.href)"
          >
            {{ page.label }}
            <svg v-if="!page.currPage"
              class="stroke-current"
              width="17"
              height="16"
              viewBox="0 0 17 16"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366"
                stroke=""
                stroke-width="1.2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </Link>
          <p v-else>{{ page.label }}</p>
        </li>
      </ol>
    </nav>
  </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue'

interface BreadcrumbProps {
  pageList: [{
    label: string,
    href: string,
    currPage: boolean
  }]
}

defineProps<BreadcrumbProps>()
</script>
