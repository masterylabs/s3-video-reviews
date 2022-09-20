import { GetObjectCommand } from '@aws-sdk/client-s3'
import { getSignedUrl } from '@aws-sdk/s3-request-presigner'

const getDownloadUrl = async function (Key, args = { expiresIn: 86400 }) {
  const params = {
    Key,
    Bucket: this.name,
  }
  const command = new GetObjectCommand(params)

  return await getSignedUrl(this.s3Client, command, args)
}

export { getDownloadUrl }
