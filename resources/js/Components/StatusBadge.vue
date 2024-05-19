<script setup lang="ts">
import { computed, ComputedRef } from 'vue';

const props = defineProps({
    statusName: {
        type: String,
        required: true,
    }
})

const statusColors: any = {
  pending: 'text-gray-400 bg-gray-400/10 ring-gray-400/30',
  started: 'text-cyan-400 bg-cyan-400/10 ring-cyan-400/30',
  baking: 'text-orange-400 bg-orange-400/10 ring-orange-400/30',
  finished: 'text-emerald-400 bg-emerald-400/10 ring-emerald-400/30',
};

const badgeColorClass: ComputedRef = computed(
  () => statusColors[props.statusName]
);
</script>

<template>
  <span
    class="rounded-full py-1 px-2 ring-1 ring-inset uppercase"
    :class="badgeColorClass"
  >
    {{ statusName }}
  </span>
</template>
