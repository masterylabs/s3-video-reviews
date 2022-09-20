export default {
  bucketApi({ page }) {
    const data = { ...page }
    const cookiesNotice = {
      text: 'We use cookies',
      btn_text: 'OK!',
    }
    return {
      data,
      cookiesNotice,
    }
  },

  bucketName({ page, parent }) {
    if (!page || !page.page_type) {
      return ''
    }
    if (page.page_type === 'offer') {
      return page.bucket_name
    }

    return parent.bucket_name
  },

  bucketRegion({ page, parent }) {
    if (!page || !page.page_type) {
      return ''
    }
    if (page.page_type === 'offer') {
      return page.bucket_region
    }

    return parent.bucket_region
  },

  // bucketDomain({ page, parent }) {
  //   if (!page || !page.bucket_domain) {
  //     return ''
  //   }
  //   if (page.page_type === 'offer') {
  //     return page.bucket_domain
  //   }

  //   return parent.bucket_domain || ''
  // },

  bucketUrl(_, { bucketName, bucketRegion }) {
    return `http://${bucketName}.s3-website.${bucketRegion}.amazonaws.com`
  },

  bucketDomain(state) {
    if (!state.page) {
      return ''
    }

    const page = state.page.page_type === 'offer' ? state.page : state.parent

    if (!page.bucket_domain) {
      return ''
    }

    const value = page.bucket_domain

    if (value.indexOf('://') < 0) {
      return `https://${value}`
    }

    return value
  },

  customUrl({ page }, { bucketDomain }) {
    if (!bucketDomain) {
      return ''
    }

    if (page.page_type === 'offer') {
      return bucketDomain
    }

    return `${bucketDomain}/${page.slug}`
  },

  bucketAuth(_, { bucketRegion }, c, rootGetters) {
    return {
      region: bucketRegion,
      credentials: rootGetters['aws/credentials'],
    }
  },
}
