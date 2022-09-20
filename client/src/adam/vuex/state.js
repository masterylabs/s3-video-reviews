const state = {
  refreshPages: false,
  panel: [null],
  page: null,
  parent: null,
  pageStr: '',
  savedSlug: '',
  bucket: null,

  removed: {
    parentId: '',
    item: null,
  },

  // set during load as action: setupNewPanelIndex
  newPanelIndex: 0,

  appendPanels: [
    {
      text: 'Footer',
      value: 'footer',
    },
    {
      text: 'Design',
      value: 'theme',
    },
    {
      text: 'Background',
      value: 'bg',
    },
    {
      text: 'SEO & Meta',
      value: 'seo',
    },
    {
      text: 'Advanced',
      value: 'advanced',
    },
  ],

  bgPreview: false,
}

export default state
