import Buckets from './Buckets.vue'
import Bucket from './Bucket.vue'

const routes = [
  {
    path: '/buckets',
    name: 'aws-buckets',
    component: Buckets,
    meta: {
      menu: true,
      text: 'Buckets',
      icon: 'mdi-bucket-outline',
      exact: false,
      order: 50,
    },
  },
  {
    path: '/buckets/:id',
    name: 'aws-bucket',
    component: Bucket,
  },
]

export default routes
