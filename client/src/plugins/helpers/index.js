export * from './bucket'
export * from './str'

const getJson = (str) => {
  try {
    return JSON.parse(str)
  } catch (e) {
    return false
  }
}

export { getJson }
