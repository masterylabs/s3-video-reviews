const queryString = require('query-string')
import axios from 'axios'

const getImage = async (from = 'collection/3362993') => {
  const { request } = await axios.get(
    `https://source.unsplash.com/${from}/160x90`
  )

  if (!request || !request.responseURL) {
    return false
  }

  const part = request.responseURL.split('?')

  const baseUrl = `${part[0]}?`

  const args = queryString.parse(part[1])

  const src = baseUrl + queryString.stringify({ ...args, w: 1600, h: 900 })
  const mobiSrc = baseUrl + queryString.stringify({ ...args, w: 400, h: 890 })

  return {
    src,
    mobiSrc,
  }
}

export default getImage
