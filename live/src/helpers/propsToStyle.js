const propsToStyle = (props, opts = {}, split = false) => {
  let str = ''
  const list = []
  const innerList = []

  if (props.textColor) {
    list.push(`color:${props.textColor}`)
  }

  if (props.color) {
    list.push(`background-color:${props.color}`)
  }

  if (opts.width && props.width) {
    list.push(`width:${props.width}px`)
  }
  if (opts.height && props.height) {
    list.push(`height:${props.height}px`)
  }
  if (opts.maxWidth && props.maxWidth) {
    list.push(`max-width:${props.maxWidth}px`)
  }
  if (opts.maxHeight && props.maxHeight) {
    list.push(`max-height:${props.maxHeight}px`)
  }

  // console.log('propsToStyle', props)

  if (split) {
    {
      return {
        inner: innerList.join(';'),
        outer: list.join(';'),
      }
    }
  }

  return list.join(';')
}

export { propsToStyle }
