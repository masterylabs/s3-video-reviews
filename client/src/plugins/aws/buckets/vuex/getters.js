import {
  getFolderName,
  isFolder,
  toText,
  getTypeDataFromKey,
  stringEndsWith,
  // isThumb,
} from '../helpers'

import files from './getters/files'

export default {
  ...files,
  bucketObjects({ objects }) {
    return objects
  },
  bucketObjectsCount({ objects }) {
    return objects.length
  },

  bucketName({ data }) {
    return data && data.name ? data.name : ''
  },

  path({ path }) {
    return path
  },
  layout({ layout }) {
    return layout
  },
  data({ data }) {
    return data
  },
  meta({ data }) {
    return data.meta || {}
  },

  loading({ loading }) {
    return loading
  },

  bucketStatus({ bucketPolicy, bucketPublicAccess }) {
    return {
      policy: bucketPolicy,
      publicAccess: bucketPublicAccess,
    }
  },

  isBucketPublicPolicy({ bucketPolicy, bucket }) {
    // Read Policy
    if (
      !bucketPolicy ||
      !bucketPolicy.Statement ||
      !bucketPolicy.Statement.length
    ) {
      return false
    }

    const Statement = bucketPolicy.Statement.find((item) => {
      if (item.Sid !== 'AllowPublicRead' || !item.Resource) {
        return false
      }

      const value = `arn:aws:s3:::${bucket.name}/*`
      if (typeof item.Resource === 'string') {
        return item.Resource === value
      }

      return item.Resource.findIndex((a) => a === value) > -1
    })

    return !!Statement
  },

  isBucketPublicAccess({ bucketPublicAccess }) {
    return !bucketPublicAccess ||
      bucketPublicAccess.BlockPublicPolicy ||
      bucketPublicAccess.RestrictPublicBuckets
      ? false
      : true
  },

  isBucketPublic(_, { isBucketPublicPolicy, isBucketPublicAccess }) {
    return isBucketPublicPolicy && isBucketPublicAccess ? true : false
  },

  bucketPolicy({ bucketPolicy }) {
    return bucketPolicy
  },
  bucketPublicAccess({ bucketPublicAccess }) {
    return bucketPublicAccess
  },

  bucketStatusReady({ bucketStatusReady }) {
    return bucketStatusReady
  },

  color({ data }) {
    return data.meta && data.meta.color ? data.meta.color : ''
  },

  bucketItem({ bucketItem }) {
    return bucketItem
  },

  uploads({ uploads }) {
    return uploads.map((item) => {
      return {
        loading: item.loading,
        progress: item.progress,
        Key: item.Key,
        name: item.name,
      }
    })
  },

  activeUploadsCount({ uploads }) {
    return uploads.filter((item) => item.loading).length
  },

  isCompletedUploads({ uploads }) {
    return (
      uploads.filter(({ loading, progress }) => !loading && progress === 100)
        .length > 0
    )
  },

  crumbs({ path, data }) {
    const value = [
      {
        text: data.name, // bucketName,
        value: '',
        disabled: !path,
        icon: 'bucket-outline',
        // isBucket: true,
      },
    ]
    if (!path) {
      return value
    }
    const items = path.slice(0, -1).split('/')
    let itemPath = ''

    return [
      ...value,
      ...items.map((value, i) => {
        const item = {
          text: toText(value),
          value: `${itemPath}${value}/`,
          disabled: i === items.length - 1,
          // isFolder: true,
          icon: 'folder-outline',
        }

        itemPath += `${value}/`

        return item
      }),
    ]
  },

  // use for forms, and folders getters
  bucketId({ data }) {
    return data && data.id ? data.id : ''
  },

  folderMeta({ data }) {
    return data.meta.folders || []
  },

  folders({ objects, path }, { folderMeta, filesForm }) {
    if (!objects || !objects.length) {
      return []
    }

    const filter = ({ Key }) => {
      if (!isFolder(Key)) return false

      const part = Key.split('/')
      const folderName = part[part.length - 2]

      if (filesForm.keyword) {
        const kw = filesForm.keyword.toLowerCase()
        if (folderName.toLowerCase().indexOf(kw) < 0) {
          return false
        }
      }

      return Key === `${path}${folderName}/`
    }

    const map = (item) => {
      const meta = folderMeta.find((a) => a.Key === item.Key) || {}

      // tidy up meta
      // delete meta.Key

      return {
        ...item,
        name: getFolderName(item.Key),
        prettyKey: item.Key.slice(0, -1),
        meta,
      }
    }

    return objects.filter(filter).map(map)
  },

  foldersCount(_, { folders }) {
    return folders.length
  },

  fileBaseUrl({ data }) {
    let url = data.cloudfront
      ? data.cloudfront
      : `https://${data.name}.s3.amazonaws.com`

    // support cloudfront and custom domain
    if (url.indexOf('://') < 0) {
      url = `https://${url}`
    }

    return url
  },

  thumbKey({ thumbKey }) {
    return thumbKey
  },

  thumbs({ objects, thumbKey }) {
    if (!objects || !objects.length) {
      return []
    }
    return objects.filter(({ Key }) => stringEndsWith(Key, thumbKey))
  },

  // files({ objects, path, thumbKey }, { fileBaseUrl, filesForm }) {
  //   // const cloudfrontDomain = data.cloudfront
  //   if (!objects || !objects.length) {
  //     return []
  //   }
  //   return objects
  //     .filter(({ Key }) => {
  //       if (isFolder(Key) || !Key) return false

  //       if (!filesForm.showThumbs) {
  //
  //         if (isThumb(Key)) {
  //           return false
  //         }
  //         if (stringEndsWith(Key, '_wp_buckets_thumb.jpg')) {
  //           return false
  //         }
  //       }

  //       const part = Key.split('/')
  //       const fileName = part[part.length - 1]

  //       // search filter
  //       if (filesForm.keyword) {
  //         const kw = filesForm.keyword.toLowerCase()
  //         if (fileName.toLowerCase().indexOf(kw) < 0) {
  //           return false
  //         }
  //       }
  //       return Key === `${path}${fileName}`
  //     })
  //     .map((item) => {
  //       const url = fileBaseUrl + '/' + encodeURI(item.Key)
  //       const name = item.Key.split('/').pop()
  //       let thumb = objects.find(
  //         (thumb) => thumb.Key === `${item.Key}${thumbKey}`
  //       )

  //       if (thumb) {
  //         thumb = {
  //           url: fileBaseUrl + '/' + encodeURI(thumb.Key),
  //           Key: thumb.Key,
  //         }
  //       }

  //       return {
  //         ...item,
  //         url,
  //         name,
  //         nameLower: name.toLowerCase(),
  //         ...getTypeDataFromKey(item.Key),
  //         tableKey: item.tableKey || item.Key,
  //         thumb,
  //         // thumb: objects.find(
  //         //   (thumb) => thumb.Key === `${item.Key}${thumbKey}`
  //         // ),
  //       }
  //     })
  // },

  filesCount(_, { files }) {
    return files.length
  },

  filesForm({ filesForm }) {
    return filesForm
  },

  parsedObjects({ objects }, { fileBaseUrl }) {
    return objects.map((item) => {
      const url = fileBaseUrl + '/' + encodeURI(item.Key)
      const name = item.Key.split('/').pop()

      return {
        name,
        url,
        ...item,
        ...getTypeDataFromKey(item.Key),
      }
    })
  },

  images(_, { parsedObjects }) {
    return parsedObjects.filter((item) => item.contentType === 'image')
  },
  imagesList(_, { images }) {
    return images.map((a) => {
      return {
        text: a.Key,
        value: a.url,
      }
    })
  },

  videoPosters({ data }) {
    return data && data.meta && data.meta.videoPosters
      ? data.meta.videoPosters
      : []
  },
}
