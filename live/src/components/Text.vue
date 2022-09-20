<template>
  <div :class="className.outer" :style="style">
    <span :class="className.inner">{{ item.textContent }}</span>
  </div>

  <c-code>
    {{ className }}
  </c-code>
</template>

<script setup>
import { getItem } from '.'
const { _id } = defineProps(['_id'])
const { item, className, style } = getItem(_id, { splitClass: true })
</script>
