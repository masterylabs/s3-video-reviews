export const simpleMerge = (a = {}, b = {}, spread = false) => {
  if (!b) return a

  for (let k in b) {
    if (typeof a[k] == 'object') {
      a[k] = simpleMerge(b[k])
    } else if (
      typeof a[k] == 'undefined' ||
      (typeof a[k] == 'string' && !a[k])
    ) {
      a[k] = b[k]
    }
  }

  return spread ? { ...a } : a
}

export default simpleMerge
