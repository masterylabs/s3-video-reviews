<template>
  <!-- <div> -->
  <!-- <c-item v-for="item in body.children" v-bind="item"> </c-item> -->
  <!-- <c-item v-bind="body"> </c-item> -->
  <!-- {{ body.children }} -->
  <component
    :is="`c-${child.type}`"
    v-for="(child, index) in state.body.children"
    :key="child._id"
    :_id="child._id"
  />

  <!-- <c-code>
      {{ body.children[0] }}
    </c-code> -->
  <!-- </div> -->
</template>

<script setup>
import body from './lib/body'
import { state, setBody } from './store'
setBody(body)
// console.log(state.body)
</script>
