const mediaTime = (s) => {
  let val = new Date(s * 1000).toISOString().substr(11, 8)

  if (val.indexOf('00:') === 0) {
    val = val.replace('00:', '')
  }
  if (val.indexOf('0') === 0) {
    val = val.replace('0', '')
  }
  return val
}

export default mediaTime
