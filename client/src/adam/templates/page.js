export default {
  page_type: 'page', // custom value
  id: null,
  name: null,
  description: null,
  slug: null,
  checkout_url: '',
  parent_id: null,

  prod_name: '',
  admin_image: '',
  favicon: '',

  theme: {
    color: '',
    dark: false,
  },
  // bg: {}, // body props
  meta: {},
  header_code: '',
  footer_code: '',
  bg: {
    color: '',
    src: '',
    mobiSrc: '',
    filter: '',
    position: 'center center',
  },
  seo: {
    title: '',
    image: '',
    description: '',
    keywords: '',
    sponsored: false,
    nofollow: false,
    noindex: false,
  },
  body: {
    type: 'body',
    props: {},
    opts: {},
    children: [],
    footer: null,
  },

  // additional fields
  // identifier: null,
  // user_id: null,

  // name: '',
}

// // next product

// import { itemProps } from './items'
// import items from './items'

// const pageV2 = (name = 'Page', args = {}) => {
//   return {
//     id: null,
//     name: null,
//     description: null,
//     slug: null,
//     checkout_code: '',
//     theme: {
//       color: '',
//       dark: '',
//     },
//     // bg: {}, // body props
//     meta: {},
//     header_code: '',
//     footer_code: '',
//     body: {
//       ...items.body,
//       children: [
//         // {
//         //   ...items.main,
//         // },
//       ],
//     },
//     ...args,
//   }
// }

// export const page = () => {
//   return {
//     id: null,
//     name: null,
//     description: null,
//     slug: null,
//     checkout_code: '',
//     theme: {
//       color: '',
//       dark: '',
//     },
//     bg: {},
//     meta: {},
//     header_code: '',
//     footer_code: '',
//     body: [
//       // {
//       //   ...itemProps,
//       //   id: 'nav',
//       //   type: 'nav',
//       //   name: 'Navigation',
//       // },
//       // {
//       //   ...itemProps,
//       //   id: 'app-bar',
//       //   type: 'app-bar',
//       //   name: 'Brandbar',
//       // },
//       {
//         ...itemProps,
//         id: 'main',
//         type: 'main',
//         name: 'Main',
//         children: [
//           {
//             ...itemProps,
//             id: 'main-sheet',
//             type: 'sheet',
//             name: 'Sheet',
//             disabled: true,
//             props: {
//               width: '100%',
//               rounded: 'xl',
//               elevation: 14,
//               color: '',
//               class: 'mx-auto',
//               maxWidth: null,
//               style: {
//                 overflow: 'hidden',
//                 marginLeft: 'auto',
//               },
//             },
//             children: [
//               // blocks
//               // {
//               //   ...itemProps,
//               //   id: 'row-1',
//               //   type: 'row',
//               //   name: 'Row 1',
//               //   props: {},
//               //   children: [
//               //     {
//               //       ...itemProps,
//               //       id: 'col-1',
//               //       type: 'col',
//               //       name: 'Col 1',
//               //       props: {},
//               //       children: [
//               //         {
//               //           ...items.text,
//               //           // ...itemProps,
//               //           id: 'headline-1',
//               //           // type: 'text',
//               //           // name: 'Headline ',
//               //           // props: {},
//               //           // children: 'MY First Headline',
//               //         },
//               //       ],
//               //     },
//               //     // {
//               //     //   ...itemProps,
//               //     //   id: 'col-2',
//               //     //   type: 'col',
//               //     //   name: 'Col 2',
//               //     //   props: {},
//               //     //   children: [
//               //     //     {
//               //     //       ...itemProps,
//               //     //       id: 'headline-12',
//               //     //       type: 'text',
//               //     //       name: 'Headline 2',
//               //     //       props: {
//               //     //         html: 'MY Second Headline',
//               //     //       },
//               //     //     },
//               //     //   ],
//               //     // },
//               //     // {
//               //     //   ...itemProps,
//               //     //   id: 'col-3',
//               //     //   type: 'col',
//               //     //   name: 'Col 3',
//               //     //   props: {},
//               //     //   children: [
//               //     //     {
//               //     //       ...itemProps,
//               //     //       id: 'headline-12',
//               //     //       type: 'text',
//               //     //       name: 'Headline 3',
//               //     //       props: {
//               //     //         html: 'MY Third Headline',
//               //     //       },
//               //     //     },
//               //     //   ],
//               //     // },
//               //   ],
//               // },
//               // {
//               //   ...itemProps,
//               //   id: 'row-2',
//               //   type: 'row',
//               //   name: 'Row 2',
//               //   props: {},
//               //   children: [],
//               // },
//               // {
//               //   id: 'headline-4',
//               //   type: 'text',
//               //   name: 'Headline 4',
//               //   props: {
//               //     html: 'My third headline',
//               //   },
//               // },
//             ],
//           },
//         ],
//       },
//       // {
//       //   id: 'footer',
//       //   type: 'footer',
//       //   children: [],
//       // },
//     ],
//   }
// }

// export default pageV2
