<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, PropType } from 'vue';
import { Pizza } from '@/types';
import PizzaSteps from '@/Components/PizzaSteps.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ArrowPathIcon } from '@heroicons/vue/24/outline';
import { usePrettyDate } from '@/Composables/prettyDate';
import RecentPizzas from "@/Components/RecentPizzas.vue";

const props = defineProps({
  currentPizza: {
    type: Object as PropType<Pizza>,
    required: true,
  },
  recentPizzas: {
    type: Array as PropType<Array<Pizza>>,
    required: true,
  },
});

const form = useForm({});

const placedAt = computed(() =>
  usePrettyDate(new Date(props.currentPizza?.created_at))
);
</script>

<template>
  <Head title="Tixel POS" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Tixel POS
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <div class="flex flex-row no-wrap justify-between items-start">
            <div>
              <h3 class="text-xl">Current Pizza Order</h3>
              <p class="text-gray-700 mt-2">
                  Ordered by {{ currentPizza.customer?.name }}
              </p>
              <span class="text-sm text-gray-600 mt-1"> on {{ placedAt }} </span>
            </div>
            <form
              id="reset-pizza"
              @submit.prevent="
                form.post(`pizzas/${props.currentPizza.id}/reset`)
              "
            >
              <SecondaryButton type="submit" :disabled="form.processing">
                <ArrowPathIcon class="w-4"></ArrowPathIcon>
              </SecondaryButton>
            </form>
          </div>

          <PizzaSteps :pizza="currentPizza" class="mt-6"></PizzaSteps>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <h3 class="text-xl">Recent Orders</h3>

          <RecentPizzas :pizzas="recentPizzas"></RecentPizzas>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
