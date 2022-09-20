<template>
  <div :class="className" :style="style">
    <!-- <div>BOX</div> -->
    <component
      :is="`c-${child.type}`"
      v-for="child in item.children"
      :key="child._id"
      :_id="child._id"
    />
  </div>
</template>

<script setup>
import { getItem } from '.'
const { _id } = defineProps(['_id'])
const { item, className, style } = getItem(_id)
</script>
