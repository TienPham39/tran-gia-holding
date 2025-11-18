<template>
  <component :is="layoutComponent">
    <component :is="page.component" />
  </component>
</template>

<script setup>
import { usePage, router } from '@inertiajs/vue3'
import { computed } from 'vue'
import ClientLayout from './layouts/client.vue'
import AdminLayout from './layouts/admin.vue'

const layouts = {
  client: ClientLayout,
  admin: AdminLayout,
}

const page = usePage()

const layoutComponent = computed(() => {
  const layoutName = page.props.layout || page.component?.layout
  return layouts[layoutName] || layouts.client
})
</script>
