import { findItem, propsToClassName, propsToStyle } from '../helpers'
import { state } from '../store'

const getItem = (_id, opts = {}) => {
  const item = findItem(state.body.children, _id)
  const className = propsToClassName(item.props, opts.splitClass)
  const style = propsToStyle(item.props, item.opts)
  return { item, className, style }
}

export { getItem }
