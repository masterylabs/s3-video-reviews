export default {
  loading: false,

  overwrite: false,
  path: '',
  folderMetaName: '_wp-buckets-folder-meta.json',
  // thumbKey: '_wp_buckets_thumb.jpg', // more than one location
  thumbKey: '__thumb.jpeg', // more than one location
  data: {},
  objects: [],

  filesForm: {
    showThumbs: false,
    keyword: '',
    view: {
      value: 'grid',
      options: [
        {
          text: 'Table View',
          value: 'table',
          icon: 'view-list',
          iconSize: 32,
        },
        {
          text: 'Grid View',
          value: 'grid',
          icon: 'view-grid',
        },
      ],
    },
  },

  // for edit
  bucketItem: {
    meta: {},
  },
  // folderItem: {},
  uploads: [
    // {
    //   loading: false,
    //   progress: 0,
    //   Key: 'my-new-folder/matt1-big-1024x1024.png',
    //   name: 'matt1-big-1024x1024.png',
    // },
    // {
    //   loading: false,
    //   progress: 80,
    //   Key: 'my-new-folder/matt1-small.png',
    //   name: 'matt1-small.png',
    // },
  ],
  bucket: null,
  bucketPolicy: null,
  bucketPublicAccess: null,
  bucketStatusReady: false,
  layout: {
    cardEditDialog: false,
    addBucketDialog: false,
  },
}
