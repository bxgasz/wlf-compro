<template>
  <ThemeProvider>
    <SidebarProvider>
      <LayoutContent>
        <slot></slot>
      </LayoutContent>
    </SidebarProvider>
  </ThemeProvider>
</template>

<script setup>
import LayoutContent from "@/Components/admin/layout/LayoutContent.vue";
import SidebarProvider from "@/Components/admin/layout/SidebarProvider.vue";
import ThemeProvider from "@/Components/admin/layout/ThemeProvider.vue";
</script>