export const jsonClense = (obj) => {
  return JSON.parse(JSON.stringify(obj))
}

const isObject = (obj) => obj && typeof obj === 'object' && !Array.isArray(obj)
const isArray = (arr) => arr && Array.isArray(arr)
const isSameType = (a, b) => typeof a === typeof b

export const isObjSame = (a, b) => JSON.stringify(a) === JSON.stringify(b)

export const objMerge = (a, b) => {
  if (!a || !isSameType(a, b)) {
    if (isObject(b)) {
      return objMerge({}, b)
    }
    a = b
  } else if (isObject(b)) {
    for (const k in b) {
      a[k] = objMerge(a[k], b[k])
    }
  } else if (isArray(b)) {
    for (let i = 0; i < b.length; i++) {
      a[i] = objMerge(a[i], b[i])
    }
  } else {
    return b
  }

  return a
}
