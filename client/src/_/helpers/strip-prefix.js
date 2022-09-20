const stripPrefix = (obj, prefix) => {
  for (const k in obj) {
    if (k.indexOf(prefix) == 0 && k != prefix) delete obj[k]
  }

  return obj
}

export default stripPrefix
