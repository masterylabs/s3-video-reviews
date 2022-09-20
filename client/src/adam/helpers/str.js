import { strEndsWith } from '@/plugins/helpers'

// export const ucfirst = (str) => {
//   return str.charAt(0).toUpperCase() + str.slice(1)
// }

// const capitalize = (str, lower = false) =>
//   (lower ? str.toLowerCase() : str).replace(/(?:^|\s|["'([{])+\S/g, (match) =>
//     match.toUpperCase()
//   )

// export const toName = (str) => {
//   return capitalize(str.replace(/-/g, ' '))
// }

const getBucketFileName = (slug) => {
  if (!strEndsWith(slug, '.html')) {
    return `${slug}/index.html`.replace(/\/\/+/g, '/')
  }

  return slug
}

export { getBucketFileName }
