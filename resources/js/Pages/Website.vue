<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed, ComputedRef, onMounted, PropType } from 'vue';
import { Pizza, PizzaState } from '@/types';
import StatusBadge from '@/Components/StatusBadge.vue';

const page = usePage();

const props = defineProps({
  pizza: {
    type: Object as PropType<Pizza>,
    required: true,
  },
});

const statusColors: any = {
  pending: 'text-gray-400 bg-gray-400/10 ring-gray-400/30',
  started: 'text-cyan-400 bg-cyan-400/10 ring-cyan-400/30',
  baking: 'text-orange-400 bg-orange-400/10 ring-orange-400/30',
  finished: 'text-emerald-400 bg-emerald-400/10 ring-emerald-400/30',
};

const badgeClass: ComputedRef = computed(
  () => statusColors[props.pizza.status.name]
);

interface PizzaStateChangeEvent {
  finalState: PizzaState;
  initialState: PizzaState;
  model: Pizza;
  transition: Object;
}

onMounted(() => {
  (window as any).Echo.private('pizzas.' + props.pizza.id).listen(
    '.pizza.status.updated',
    (event: PizzaStateChangeEvent) => {
      props.pizza.status = event.model.status;
    }
  );
});
</script>

<template>
  <Head title="Customer Website" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Mock Customer Website
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <h3 class="text-2xl mb-4">Hi {{ page.props.auth.user.name }}</h3>
          <p class="mb-4 text-gray-900">
            The current status of your pizza is
            <StatusBadge
              :status-name="pizza.status.name"
              class="text-lg"
            ></StatusBadge>
          </p>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
