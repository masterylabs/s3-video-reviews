const strEndsWith = (str, strEnd) => {
  const index = str.indexOf(strEnd)

  if (index < 0) {
    return false
  }
  return index === str.length - strEnd.length
}

export { strEndsWith }
