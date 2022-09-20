import { PutObjectCommand } from '@aws-sdk/client-s3'
import { getSignedUrl } from '@aws-sdk/s3-request-presigner'

import axios from 'axios'

const createFolder = async function (args) {
  //
  if (typeof args === 'string') {
    args = {
      Key: args,
      Bucket: this.name,
    }
  } else {
    args.Bucket = this.name
  }

  const command = new PutObjectCommand(args)
  const url = await getSignedUrl(this.s3Client, command, {
    expiresIn: 3600,
  })

  try {
    await axios.put(url, '')
    return true
  } catch (err) {
    this.errorResponse = err
    return false
  }
}

export default createFolder
