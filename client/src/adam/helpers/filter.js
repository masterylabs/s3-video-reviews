const filterItemsWithoutKeys = (items = [], q = '') => {
  return items.filter((item) => {
    for (const k in item) {
      if (
        item[k] == q ||
        (typeof item[k] === 'string' && item[k].toLowerCase().indexOf(q) > -1)
      ) {
        return true
      }
    }

    return false
  })
}

export const filterItems = (items = [], q = '', keys = null) => {
  if (!q) return items

  q = q.toLowerCase()

  if (!keys) {
    return filterItemsWithoutKeys(items, q)
  }

  return items.filter((item) => {
    for (let i = 0; i < keys.length; i++) {
      const k = keys[i]
      if (item[k]) {
        if (
          item[k] == q ||
          (typeof item[k] === 'string' && item[k].toLowerCase().indexOf(q) > -1)
        ) {
          return true
        }
      }
    }

    return false
  })
}
