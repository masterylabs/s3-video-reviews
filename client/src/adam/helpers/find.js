export const findTypes = (
  arr,
  value = 'headline',
  key = 'type',
  result = []
) => {
  for (let i = 0; i < arr.length; i++) {
    if (arr[i][key] === value) {
      // result = arr[i]
      result.push(arr[i])
    }

    if (arr[i].children && Array.isArray(arr[i].children)) {
      result = findTypes(arr[i].children, value, key, result)
      // if (result) {
      //   break
      // }
    }
  }

  return result
}

export const findItems = (arr, value, key = 'type', items = []) => {
  for (let i = 0; i < arr.length; i++) {
    if (arr[i][key] === value) {
      items.push(arr[i])
    }

    if (arr[i].children && Array.isArray(arr[i].children)) {
      items = findItems(arr[i].children, value, key, items)
    }
  }

  return items
}

export const findItem = (arr, value, key = 'id') => {
  let result = null

  // if not array but objet
  if (!Array.isArray(arr)) {
    if (arr[key] === value) {
      return arr
    }

    if (arr.children && Array.isArray(arr.children)) {
      return findItem(arr.children, value, key)
    }
    // null
    return result
  }

  for (let i = 0; i < arr.length; i++) {
    if (arr[i][key] === value) {
      result = arr[i]
      break
    }

    if (arr[i].children && Array.isArray(arr[i].children)) {
      result = findItem(arr[i].children, value, key)
      if (result) {
        break
      }
    }
  }

  return result
}

export const findByType = (arr, value) => findItem(arr, value, 'type')

export const findById = (arr, value) => findItem(arr, value, 'id')

export const findParent = (item, value, key = 'id') => {
  let result = null

  if (Array.isArray(item)) {
    for (let i = 0; i < item.length; i++) {
      result = findParent(item[i], value, key)
      if (result) break
    }

    if (result) {
      return result
    }
  }

  if (!item.children || !Array.isArray(item.children)) {
    return null
  }

  // check children for match, return item
  for (let i = 0; i < item.children.length; i++) {
    if (item.children[i][key] === value) {
      result = item
      break
    }

    result = findParent(item.children[i], value, key)

    if (result) {
      break
    }
  }
  return result
}

export const findIndex = (arr, value, key = 'id') => {
  const parent = findParent(arr, value, key)
  return parent.children.findIndex((item) => item[key] === value)
}
