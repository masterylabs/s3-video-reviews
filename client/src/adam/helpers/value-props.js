export default (obj, props) => {
  const value = {}

  Object.keys(props).forEach((key) => {
    if (obj[key]) {
      value[key] = obj[key]
    }
  })

  return value
}
