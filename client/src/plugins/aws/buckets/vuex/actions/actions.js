import queUpload from './QueUpload'
import DeleteObject from './DeleteObject'
import DeleteBucketByKey from './DeleteBucketByKey'
import DropFiles from './DropFiles'
import DownloadObject from './DownloadObject'
import Folder from './Folder'
import BucketAccess from './BucketAccess'
import Item from './Item'
import SaveChangedFile from './SaveChangedFile'
import DuplicateFile from './DuplicateFile'
import VideoPoster from './VideoPoster'
import UploadFile from './UploadFile'
import CreateThumb from './CreateThumb'

export default {
  ...queUpload,
  ...DeleteObject,
  ...DeleteBucketByKey,
  ...DropFiles,
  ...DownloadObject,
  ...Folder,
  ...BucketAccess,
  ...Item,
  ...SaveChangedFile,
  ...DuplicateFile,
  ...VideoPoster,
  ...UploadFile,
  ...CreateThumb,

  setPath({ commit }, path) {
    commit('SET', { path })
  },

  async refreshFiles({ dispatch, commit, state: { path, objects } }) {
    commit('SET', { objects: [], loading: true })
    await dispatch('loadBucket')

    if (path) {
      const index = objects.findIndex((obj) => obj.Key.indexOf(path) === 0)
      if (index < 0) {
        commit('SET', { path: '' })
      }
    }

    return true
  },
}
