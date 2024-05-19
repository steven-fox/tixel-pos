<script setup lang="ts">
import { CheckIcon } from '@heroicons/vue/20/solid';
import { computed, PropType, ref } from 'vue';
import { Pizza } from '@/types';
import { useForm } from '@inertiajs/vue3';

interface step {
  name: string;
  label: string;
  description: string;
}

const props = defineProps({
  pizza: {
    type: Object as PropType<Pizza>,
    required: true,
  },
});

const steps: Array<step> = [
  {
    name: 'started',
    label: 'Started',
    description: 'The pizza has been started!',
  },
  {
    name: 'baking',
    label: 'Baking',
    description: 'Pizza is in the oven.',
  },
  {
    name: 'finished',
    label: 'Finished',
    description: 'All done!',
  },
];

const isCurrentStatus = (step: step) => step.name === props.pizza.status.name;

const currentStatusIndex = computed(() => steps.findIndex(isCurrentStatus));

const nextStatus = computed(() =>
  props.pizza.status.transitionable_states.length
    ? props.pizza.status.transitionable_states[0]
    : null
);

const form = useForm({
  status: nextStatus,
});

const hovering = ref(false);
</script>

<template>
  <nav aria-label="Progress">
    <ol role="list" class="overflow-hidden">
      <li
        v-for="(step, stepIdx) in steps"
        :key="step.name"
        :class="[stepIdx !== steps.length - 1 ? 'pb-20' : '', 'relative']"
      >
        <template v-if="stepIdx <= currentStatusIndex">
          <div
            v-if="stepIdx !== steps.length - 1"
            class="absolute left-4 top-4 -ml-px mt-0.5 h-full w-0.5 bg-indigo-600"
            aria-hidden="true"
          />
          <div class="group relative flex items-start">
            <span class="flex h-9 items-center">
              <span
                class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 group-hover:bg-indigo-800"
              >
                <CheckIcon class="h-5 w-5 text-white" aria-hidden="true" />
              </span>
            </span>
            <span class="ml-4 flex min-w-0 flex-col">
              <span class="font-medium">{{ step.label }}</span>
              <span class="text-sm text-gray-500">
                {{ step.description }}
              </span>
            </span>
          </div>
        </template>
        <template v-else-if="stepIdx === currentStatusIndex + 1">
          <div
            v-if="stepIdx !== steps.length - 1"
            class="absolute left-4 top-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300"
            aria-hidden="true"
          />
          <form
            id="update-pizza-status"
            @submit.prevent="form.post(`/pizzas/${pizza.id}/status`)"
            class="group relative flex items-center cursor-pointer"
            aria-current="step"
            @mouseover="hovering = true"
            @mouseleave="hovering = false"
          >
            <span class="flex h-9 items-center" aria-hidden="true">
              <span
                class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 group-hover:border-indigo-600 bg-white"
              >
                <span
                  class="h-2.5 w-2.5 rounded-full group-hover:bg-indigo-600"
                />
              </span>
            </span>
            <span class="ml-4 flex min-w-0 flex-col">
              <button
                class="font-medium text-gray-500 group-hover:text-indigo-600"
              >
                {{ (hovering ? 'Mark as ' : '') + step.label }}
              </button>
            </span>
            <div v-if="form.errors.status" class="text-sm text-red-300">
              {{ form.errors.status }}
            </div>
          </form>
        </template>
        <template v-else>
          <div
            v-if="stepIdx !== steps.length - 1"
            class="absolute left-4 top-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300"
            aria-hidden="true"
          />
          <div class="group relative flex items-center">
            <span class="flex h-9 items-center" aria-hidden="true">
              <span
                class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white"
              >
                <span class="h-2.5 w-2.5 rounded-full bg-transparent" />
              </span>
            </span>
            <div class="ml-4 flex min-w-0 flex-col">
              <span class="font-medium text-gray-500">
                {{ step.label }}
              </span>
            </div>
          </div>
        </template>
      </li>
    </ol>
  </nav>
</template>
