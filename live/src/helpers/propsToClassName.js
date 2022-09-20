const propsToClassName = (props, split = false) => {
  let str = ''
  const list = []
  const innerList = []

  if (props.textSize) {
    list.push(`text-${props.textSize}`)
  }

  if (props.bold) {
    list.push('font-bold')
    console.log('BOLD')
  }
  if (props.italic) {
    list.push('italic')
  }
  if (props.underline) {
    list.push('font-underline')
  }

  if (props.highlight) {
    if (split) {
      innerList.push('highlight')
    } else {
      list.push('highlight')
    }
  }

  if (props.textAlign) {
    list.push(`text-${props.textAlign}`)
  }

  // spacing
  // padding
  if (props.pl) {
    list.push(`pl-${props.pl}`)
  }
  if (props.pr) {
    list.push(`pr-${props.pr}`)
  }
  if (props.pt) {
    list.push(`pt-${props.pt}`)
  }
  if (props.pb) {
    list.push(`pb-${props.pb}`)
  }

  // margin
  if (props.ml) {
    list.push(`ml-${props.ml}`)
  }
  if (props.mr) {
    list.push(`mr-${props.mr}`)
  }
  if (props.mt) {
    list.push(`mt-${props.mt}`)
  }
  if (props.mb) {
    list.push(`mb-${props.mb}`)
  }

  // rounded
  if (props.rounded) {
    list.push(`rounded-${props.rounded}`)
  }

  // elevation
  if (props.elevation) {
    list.push(`elevation-${props.elevation}`)
  }

  // dark
  if (props.dark) {
    list.push('dark-theme')
  }
  if (props.light) {
    list.push('light-theme')
  }

  if (props.fillHeight) {
    list.push('fill-height')
  }

  // pl: null,
  // pr: null,
  // pt: null,
  // pb: null,
  // ml: null,
  // mr: null,
  // mt: null,
  // mb: null,

  for (const k in props) {
    // console.log(k)
  }

  if (split) {
    {
      return {
        inner: innerList.join(' '),
        outer: list.join(' '),
      }
    }
  }

  return list.join(' ')
}

export { propsToClassName }
