import {
  // getFolderName,
  isFolder,
  // toText,
  getTypeDataFromKey,
  stringEndsWith,
  isThumb,
} from '../../helpers'

export default {
  files({ objects, path, thumbKey }, { fileBaseUrl, filesForm }) {
    // const cloudfrontDomain = data.cloudfront
    if (!objects || !objects.length) {
      return []
    }
    return objects
      .filter(({ Key }) => {
        if (isFolder(Key) || !Key) return false

        if (!filesForm.showThumbs) {
          if (isThumb(Key)) {
            return false
          }
          // support version 1.0.5 can be removed in future
          if (stringEndsWith(Key, '_wp_buckets_thumb.jpg')) {
            return false
          }
        }

        const part = Key.split('/')
        const fileName = part[part.length - 1]

        // search filter
        if (filesForm.keyword) {
          const kw = filesForm.keyword.toLowerCase()
          if (fileName.toLowerCase().indexOf(kw) < 0) {
            return false
          }
        }
        return Key === `${path}${fileName}`
      })
      .map((item) => {
        const url = fileBaseUrl + '/' + encodeURI(item.Key)
        const name = item.Key.split('/').pop()
        let thumb = objects.find(
          (thumb) => thumb.Key === `${item.Key}${thumbKey}`
        )

        if (thumb) {
          thumb = {
            url: fileBaseUrl + '/' + encodeURI(thumb.Key),
            Key: thumb.Key,
          }
        }

        return {
          ...item,
          url,
          name,
          nameLower: name.toLowerCase(),
          ...getTypeDataFromKey(item.Key),
          tableKey: item.tableKey || item.Key,
          thumb,
        }
      })
  },
}
