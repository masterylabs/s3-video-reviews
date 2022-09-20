const Slugify = require('slugify')

const slugify = (str, replacement = '-', append = '') => {
  const slug = Slugify(str, {
    replacement, // replace spaces with replacement character, defaults to `-`
    remove: '*+~,()\'"!:@ ', ///[^\w.]|_/g
    lower: true, // convert to lower case, defaults to `false`
    strict: true, // language code of the locale to use
    trim: true,
  })

  return slug + append
}

export { slugify }
