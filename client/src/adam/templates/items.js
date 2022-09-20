export const spacingProps = {
  pl: null,
  pr: null,
  pt: null,
  pb: null,
  ml: null,
  mr: null,
  mt: null,
  mb: null,
}

const itemProps = {
  // id: null,
  // type: null,
  // name: null,
  // value: null,
  props: {},
  opts: {},
  // childProps: {},
  children: null,
  // disabled: null,
  timed: null,
}

const footer = {
  id: 'footer',
  type: 'footer',
  opts: {},
  props: {},
  children: [],
  childProps: {},
}

const links = {
  props: {
    justify: 'center',
    align: 'center',
  },
  opts: {},
  children: [],
  childProps: {
    color: '',
    variant: 'text',
  },
}

const body = {
  props: {
    ...spacingProps,
  },
  opts: {},
  children: [],
}

const nav = {
  ...itemProps,
  id: 'nav',
  type: 'nav',
  name: 'Navigation',
  children: [],
}

const appBar = {
  ...itemProps,
  id: 'app-bar',
  type: 'app-bar',
  name: 'Brandbar',
  children: [],
}

const main = {
  ...itemProps,
  id: 'main',
  type: 'main',
  children: [],
  props: {
    ...spacingProps,
  },
}

const section = {
  ...itemProps,
  id: null,
  children: [],
  props: {
    ...spacingProps,
  },
  childProps: {},
}

const block = {
  ...section,
  childProps: {
    cols: 12,
  },
}

const box = {
  ...section,
  // childProps: {},
}

const row = {
  ...itemProps,
  type: 'row',
  name: 'Row',
  children: [],
  props: {
    ...spacingProps,
    noGutters: false,
    dense: false,
    align: null,
    justify: null,
    alignContent: null,
    tag: 'div',
  },
}

const col = {
  ...itemProps,
  type: 'col',
  name: 'Col',
  children: [],
  props: {
    ...spacingProps,
    cols: null,
    sm: null,
    md: null,
    lg: null,
    xl: null,
    offset: null,
    tag: 'div',
  },
}

const sheet = {
  ...itemProps,
  type: 'sheet',
  name: 'Sheet',
  props: {
    ...spacingProps,
  },
  // props: {
  //   // color: null,
  //   // dark: false,
  //   // light: false,
  //   // // elevation: null,
  //   // // height: null,
  //   // // width: null,
  //   // // maxHeight: null,
  //   // // maxWidth: null,
  //   // // rounded: null,
  //   // shaped: false,
  //   // tag: 'div',
  //   // tile: false,
  // },
  children: [],
}

const btn = {
  ...itemProps,
  type: 'btn',
  name: 'Button',
  textContent: null,
  props: {
    color: '',
    openNew: false,
    checkout: false,
    size: '',
    // dark: false,
    // depressed: false,
    // disabled: false,
    // // elevation: null,
    // // height: null,
    // // width: null,
    // // href: null,
    // fab: false,
    // icon: false,
    // light: false,
    // outlined: false,
    // plain: false,
    // shaped: false,
    // tag: 'button',
    // text: false,
    // small: false,
    // large: false,
    // xLarge: false,
    // xSmall: false,
    // checkout: true,
  },
}

const buyBtn = {
  ...btn,
  type: 'buy-btn',
  id: 'buy-btn',
  name: 'Buy Button',
  props: {
    openNew: false,
    checkout: true,
    cart: true,
    cards: true,
    paypal: false,
    size: 'x-large',
    // ...btn.props,
  },
  opts: {
    ...btn.opts,
    checkout: true,
  },
  textContent: 'BUY NOW',
}

const text = {
  type: 'text',
  id: 'text',
  name: 'Text',
  props: {
    highlight: false,
    bold: false,
    italic: false,
    underline: false,
    textSize: '',
    textAlign: 'center',
    textColor: '',
  },
  opts: {},
  // disabled: null,
  timed: null,
  textContent: '',
  children: null,
}

const content = {
  ...itemProps,
  type: 'content',
  name: 'Content',
  htmlContent: null,
}

const customHtml = {
  ...itemProps,
  type: 'custom-html',
  name: 'Custom HTML',
  htmlContent: '',
}

const image = {
  id: 'image',
  type: 'image',
  name: 'Image',
  props: {
    ...spacingProps,
    checkout: false,
    openNew: false,
  },
  opts: {},
  disabled: false,
  children: [],
}

const video = {
  ...itemProps,
  props: {
    ...itemProps.props,
    src: '',
    poster: '',
    color: '',
    // autoplay: false,
    preview: false,
    noControls: false,
    noPause: false,
  },
  type: 'video',
  name: 'Video',
  service: null,
  duration: 0,
}

export default {
  body,
  footer,
  links,
  'app-bar': appBar,
  nav,
  main,
  row,
  col,
  sheet,
  btn,
  'buy-btn': buyBtn,
  content,
  text,
  image,
  video,

  // customs
  section,
  block,
  box,

  //
  'custom-html': customHtml,
}
