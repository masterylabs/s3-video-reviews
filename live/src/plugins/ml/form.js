import { ref, computed } from 'vue'
import { post } from './api'

const createForm = (item) => {
  if (item.value) {
    item = item.value
  }

  const target = item.value ? item.value : item

  const valid = ref(false)
  const dataStr = ref(JSON.stringify(target))
  const hasChanges = computed(() => JSON.stringify(target) !== dataStr.value)
  const disabled = computed(() => !valid.value || !hasChanges.value)
  const clearChanges = () => {
    dataStr.value = JSON.stringify(target)
  }

  return ref({
    valid,
    hasChanges,
    disabled,
    clearChanges,
  })
}

const createApiForm = (endpoint, item = {}) => {
  const target = item.value ? item.value : item

  if (target.id) {
    endpoint += `/${target.id}`
  }
  const form = createForm(target)

  form.value.save = async function () {
    form.value.loading = true

    const { data } = await post(endpoint, target)

    // set data
    form.value.clearChanges()
    if (form.onSaved) form.onSaved(data)

    form.value.loading = false
  }
  return form
}

const nameRules = [
  (v) => !!v || 'Name is required',
  (v) => v.length >= 2 || 'Name must be at least 2 characters',
]

export { createForm, createApiForm, nameRules }
