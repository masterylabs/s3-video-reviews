export const domScriptExists = (url) => {
  const scripts = document.getElementsByTagName('script')

  for (let i = scripts.length; i--; ) {
    if (scripts[i].src.indexOf(url) > -1) return true
  }
  return false
}
