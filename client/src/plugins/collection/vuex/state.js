export default {
  ready: false,
  loading: false,
  refreshing: false,
  search: '',
  endpoint: '',
  title: '',
  query: {
    page: 1,
    limit: 24,
    q: '',
    order: 'desc',
    orderby: 'id',
    archived: 0,
  },
  data: [],
  pagin: {},
}
