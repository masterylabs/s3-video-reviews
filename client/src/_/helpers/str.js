export const toCamel = (str, startCap = false) => {
  str = str.replace(/-([a-z])/g, function(g) {
    return g[1].toUpperCase()
  })
  if (startCap) return str.charAt(0).toUpperCase() + str.slice(1)
  return str
}

export const makeid = (length = 10, args = {}) => {
  //
  if (typeof length == 'object') {
    args = length
    length = args.len ? args.len : 10
  }

  let result = ''

  const vals = {
    numbers: '0123456789',
    lower: 'abcdefghijklmnopqrstuvwxyz',
    upper: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
  }

  let characters = ''

  if (!args.upper && !args.lower && !args.numbers) {
    characters = `${vals.numbers}${vals.lower}${vals.upper}`
  } else {
    if (args.numbers) {
      characters += args.numbers
    }
    if (args.lower) {
      characters += args.lower
    } else if (args.upper) {
      characters += args.upper
    }
  }

  const prepend = args.prepend || ''
  const append = args.append || ''

  const charactersLength = characters.length
  for (let i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength))
  }
  return `${prepend}${result}${append}`
}
