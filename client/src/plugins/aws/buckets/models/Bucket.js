import { S3Client } from '@aws-sdk/client-s3'
import EventsBaseClass from '@/plugins/helpers/EventsBaseClass'

import listObjects from './bucket/ListObjects'
import createFolder from './bucket/CreateFolder'
import {
  getObject,
  getObjectListFormat,
  getObjectBody,
} from './bucket/GetObject'
import { deleteObjects, deleteFolder } from './bucket/DeleteFolder'
import { getPolicy, putPolicy, deletePolicy } from './bucket/Policy'
import {
  getPublicAccess,
  putPublicAccess,
  checkCors,
} from './bucket/PublicAccess'
import { deleteObject, destroy, forceDestroy } from './bucket/Delete'
import Website from './bucket/Website'

import { copyObject } from './bucket/CopyObject'
import { uploadObject } from './bucket/UploadObject'

import { getDownloadUrl } from './bucket/Download'

class Bucket extends EventsBaseClass {
  maxKeys = 1000
  objects = []
  error = false

  listObjects = listObjects
  createFolder = createFolder
  getObject = getObject
  getObjectBody = getObjectBody
  getObjectListFormat = getObjectListFormat
  getDownloadUrl = getDownloadUrl

  deleteObject = deleteObject
  deleteObjects = deleteObjects
  copyObject = copyObject
  deleteFolder = deleteFolder
  getPolicy = getPolicy
  putPolicy = putPolicy
  checkCors = checkCors
  deletePolicy = deletePolicy
  getPublicAccess = getPublicAccess
  putPublicAccess = putPublicAccess
  destroy = destroy
  forceDestroy = forceDestroy
  getWebsite = Website.getWebsite
  putWebsite = Website.putWebsite
  deleteWebsite = Website.deleteWebsite
  uploadObject = uploadObject

  constructor(name, auth = {}) {
    super()
    this.name = name
    this.s3Client = new S3Client(auth)
  }

  clearError() {
    this.error = false
  }

  successResponse() {
    this.call('success')
    return true
  }

  errorResponse(err) {
    if (typeof err === 'object') {
      err = err.message
    }
    this.error = err
    this.call('error', err)
    return false
  }
}

export default Bucket
