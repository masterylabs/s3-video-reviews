export default {
  data({ data }) {
    return data
  },
  pagin({ pagin }) {
    return pagin
  },

  loading({ loading }) {
    return loading
  },

  noData({ ready, data, query }) {
    return ready && !data.length && !query.q ? true : false
  },

  items({ data, query }) {
    if (!data.length || !query.q) {
      return data
    }
    const q = query.q.toLowerCase()
    const keys = Object.keys(data[0])

    return data.filter((item) => {
      for (let i = 0; i < keys.length; i++) {
        const k = keys[i]
        if (item[k]) {
          if (
            item[k] == q ||
            (typeof item[k] === 'string' &&
              item[k].toLowerCase().indexOf(q) > -1)
          ) {
            return true
          }
        }
      }
      return false
    })
  },
  totalItems({ pagin }) {
    return pagin.total || 0
  },

  query({ query }) {
    return query
  },
  refreshing({ refreshing }) {
    return refreshing
  },
}
