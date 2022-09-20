const findItem = (arr, value, key = '_id') => {
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

export { findItem }
