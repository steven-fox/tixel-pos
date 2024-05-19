<script setup lang="ts">
import { PropType } from 'vue';
import { Pizza } from '@/types';
import {usePrettyDate} from "@/Composables/prettyDate";

defineProps({
  pizzas: {
    type: Array as PropType<Array<Pizza>>,
    required: true,
  },
});

const statusColors: Object = {
    pending: 'text-gray-400 bg-gray-400/10 ring-gray-400/30',
    started: 'text-cyan-400 bg-cyan-400/10 ring-cyan-400/30',
    baking: 'text-orange-400 bg-orange-400/10 ring-orange-400/30',
    finished: 'text-emerald-400 bg-emerald-400/10 ring-emerald-400/30',
}
</script>

<template>
  <ul role="list" class="divide-y divide-gray-100">
    <li
      v-for="pizza in pizzas"
      :key="pizza.id"
      class="flex justify-between gap-x-6 py-5"
    >
      <div class="flex min-w-0 gap-x-4">
        <div class="min-w-0 flex-auto">
          <p class="leading-6 text-gray-900">
            Pizza {{ pizza.id }}
          </p>
          <p class="mt-1 truncate text-xs text-gray-600">
              {{ pizza.customer?.name }}
          </p>
        </div>
      </div>
      <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
        <span
          class="rounded-full flex-none py-1 px-2 text-xs font-medium ring-1 ring-inset uppercase"
          :class="statusColors[pizza.status.name]"
        >
          {{ pizza.status.name }}
        </span>
        <p class="mt-1 text-xs leading-5 text-gray-500">
          <time :datetime="pizza.updated_at">{{
            usePrettyDate(new Date(pizza.updated_at))
          }}</time>
        </p>
      </div>
    </li>
  </ul>
</template>
