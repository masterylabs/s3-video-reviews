const getHash = (str) => {
  if (!str) return false
  str = atob(window.mlhash)
  if (!str || typeof str != 'string') return false
  return JSON.parse(str)
}

const getValidHash = (str = '', allowLocal = true) => {
  if (!str) str = window.mlhash
  if (!str) return false
  const obj = getHash(str)

  if (allowLocal && window.location.href.indexOf('http://localhost:8080') > -1)
    return obj

  return obj && obj.site_url && window.location.href.indexOf(obj.site_url) > -1
    ? obj
    : false
}

export default getValidHash
