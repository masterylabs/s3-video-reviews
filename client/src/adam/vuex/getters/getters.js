import { findParent, findItem, findItems } from '../../helpers/find'
import { isObjSame } from '../../helpers/obj'
import bucketGetters from './bucket-getters'
// import { strEndsWith } from '@/plugins/helpers'
import { getBucketFileName } from '../../helpers'

export default {
  ...bucketGetters,

  isOffer({ page }) {
    return page && page.page_type && page.page_type === 'offer'
  },
  isOfferPage({ page }) {
    return page && page.page_type && page.page_type !== 'offer'
  },

  changes({ page, pageStr }, { hasChanges, footer }) {
    // validate

    const value = {
      footer: false,
      theme: false,
      bg: false,
      advanced: false,
    }

    if (!page || !page.id || !hasChanges) {
      return value
    }

    const data = JSON.parse(pageStr)
    const dataFooter = findItem(data.body.children, 'footer', 'type')

    value.footer = !isObjSame(footer, dataFooter)
    value.theme = !isObjSame(page.theme, data.theme)
    value.bg = !isObjSame(page.bg, data.bg)
    value.advanced = !isObjSame(page.advanced, data.advanced)

    return value
  },

  bgPreview({ bgPreview, page }) {
    if (!bgPreview || !page || !page.bg || !page.bg.src) {
      return false
    }

    return page.bg
  },

  endpoint(state) {
    if (!state.page || !state.page.page_type) {
      return '/pages'
    }
    if (state.page.page_type !== 'offer' && state.parent) {
      return `/pages/${state.parent.id}/pages/${state.page.id}`
    }
    return `/pages/${state.page.id}`
  },

  slugChanged({ savedSlug, page }) {
    return page.id && page.slug !== savedSlug
  },

  fileName({ page }) {
    return getBucketFileName(page.slug)
  },

  // use to delete old files on aws that have been changed
  savedFileName({ savedSlug }) {
    return getBucketFileName(savedSlug)
  },

  pageUrl({ page }, { bucketUrl }) {
    return page.page_type === 'offer' ? bucketUrl : `${bucketUrl}/${page.slug}`
  },

  parentId({ page, parent }) {
    return page.page_type !== 'offer' && parent ? parent.id : ''
  },

  refreshPages({ refreshPages }) {
    return refreshPages
  },

  newPanelIndex({ newPanelIndex }) {
    return newPanelIndex
  },

  hasChanges({ page, pageStr }) {
    if (!page || !pageStr || !page.id) return false
    return pageStr !== JSON.stringify(page)
  },

  panels(state) {
    const main = findItem(state.page.body.children, 'main', 'type')
    return main.children
  },

  footer({ page }) {
    return page && page.body
      ? findItem(page.body.children, 'footer', 'type')
      : {}
  },

  opts({ page }) {
    return page && page.opts ? page.opts : {}
  },

  bg({ page }) {
    return page && page.bg ? page.bg : {}
  },

  theme({ page, parent }) {
    if (!page) return {}

    if (parent && (!page.opts || !page.opts.theme)) {
      return parent.theme || {}
    }

    return page.theme || {}
  },

  // v1
  page({ page }) {
    return page
  },

  pageType({ page }) {
    return page.page_type
  },

  appendPanels({ page, appendPanels }) {
    if (!page) return []

    if (page.page_type === 'offer') {
      return appendPanels
    }

    const { opts } = page

    return appendPanels.filter(({ value }) => opts[value] || value === 'seo')
  },

  pageName({ page }) {
    return !page ? '' : page.name ? page.name : page.page_type
  },

  parentName({ parent }) {
    return !parent ? '' : parent.name ? parent.name : parent.page_type
  },

  ready({ page }) {
    return !!page
  },

  slug({ page }) {
    return page ? page.slug : ''
  },

  fullSlug({ page, parent }) {
    return parent ? `${parent.slug}/${page.slug}` : page.slug
  },

  isChild({ page }) {
    return page.page_type !== 'offer'
  },

  rows({ page }) {
    const parent = findParent(page.body, 'row', 'type')
    return parent ? parent.children : []
  },

  pageId({ page }) {
    return page && page.id ? page.id : null
  },

  slugEndpoint(_, { endpoint }) {
    return `slug/${endpoint}`
  },

  videos({ page }) {
    if (!page) return []
    return findItems(page.body.children, 'video')
  },

  videoIds(_, getters) {
    return getters.videos.map((v) => v.id)
  },

  videoItems(_, getters) {
    return getters.videos.map((a, i) => {
      return {
        text: a.name !== 'Video' ? a.name : `Video ${i + 1}`, // + ` ${a.id}`,
        value: a.id,
        src: a.props.src,
        service: a.service,
        duration: a.duration,
      }
    })
  },
}
