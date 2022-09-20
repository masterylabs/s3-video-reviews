import { PutObjectCommand } from '@aws-sdk/client-s3'
import { getSignedUrl } from '@aws-sdk/s3-request-presigner'
import axios from 'axios'

const uploadObject = async function ({ Key, file }) {
  const args = {
    Bucket: this.name,
    Key,
  }

  const url = await getSignedUrl(this.s3Client, new PutObjectCommand(args), {
    expiresIn: 86400,
  })

  const headers = {
    'Content-type': file.type,
  }

  try {
    await axios.put(url, file, { headers })
    return true
  } catch (err) {
    return false
  }
}

export { uploadObject }
