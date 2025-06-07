<script setup>
import { defineProps, defineEmits, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
  show: Boolean,
  closeButton: {
    type: String,
    default: 'white'
  },
  padding: {
    type: String,
    default: 'p-10 md:p-15'
  }
});

const emit = defineEmits(['close']);

const classClose = ref('')

const closeModal = () => {
  emit('close');
};

const handleEscape = (event) => {
  if (event.key === 'Escape') {
    closeModal();
  }
};

onMounted(() => {
  if (props.closeButton == 'red') {
    classClose.value = 'text-[#D7261C] border-4 font-bold border-[#D7261C]'
  } else if (props.closeButton == 'white') {
    classClose.value = 'text-white border-4 font-bold border-white'
  }
  document.addEventListener('keydown', handleEscape);
});

onUnmounted(() => {
  document.removeEventListener('keydown', handleEscape);
});
</script>

<template>
  <Teleport to="body">
    <div
      v-if="show"
      class="fixed inset-0 z-50 flex items-center justify-center bg-[#1A1B20] bg-opacity-80"
      @click.self="closeModal"
    >
      <div
        class="bg-[#0D0E13] shadow-lg w-full max-w-[90%] md:max-w-3xl relative transform transition-all scale-95 md:scale-100"
        :class="padding"
      >
        <button
          class="absolute top-2 right-2 z-50 p-1" :class="classClose"
          @click="closeModal"
        >
          ✖
        </button>

        <slot></slot>
      </div>
    </div>
  </Teleport>
</template>
