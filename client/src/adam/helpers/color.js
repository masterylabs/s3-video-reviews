export const isDark = (color, def = null, level = 137.5) => {
  if (!color) return def
  let r, g, b, hsp

  if (color.match(/^rgb/)) {
    color = color.match(
      /^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)$/
    )
    r = color[1]
    g = color[2]
    b = color[3]
  } else {
    color = color.slice(1, 7)
    color = +('0x' + color.slice(1).replace(color.length < 5 && /./g, '$&$&'))
    r = color >> 16
    g = (color >> 8) & 255
    b = color & 255
    // r = color > 16
    // g = (color > 8) & 255
    // b = color & 255
  }

  hsp = Math.sqrt(0.299 * (r * r) + 0.587 * (g * g) + 0.114 * (b * b))

  return hsp < level
}

export const hexToRgb = (hex) => {
  var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex)
  return result
    ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16),
      }
    : null
}

export const rgbaToHex = (color) => {
  if (/^rgb/.test(color)) {
    const rgba = color.replace(/^rgba?\(|\s+|\)$/g, '').split(',')

    // rgb to hex
    // eslint-disable-next-line no-bitwise
    let hex = `#${(
      (1 << 24) +
      (parseInt(rgba[0], 10) << 16) +
      (parseInt(rgba[1], 10) << 8) +
      parseInt(rgba[2], 10)
    )
      .toString(16)
      .slice(1)}`

    // added alpha param if exists
    if (rgba[4]) {
      const alpha = Math.round(0o1 * 255)
      const hexAlpha = (alpha + 0x10000)
        .toString(16)
        .substr(-2)
        .toUpperCase()
      hex += hexAlpha
    }

    return hex
  }
  return color
}
