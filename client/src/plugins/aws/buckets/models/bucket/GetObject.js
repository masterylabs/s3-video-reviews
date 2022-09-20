import { GetObjectCommand, ListObjectsCommand } from '@aws-sdk/client-s3'
import { streamToString } from '../../helpers'

const getObject = async function (Key) {
  //
  const args = {
    Bucket: this.name,
    Key,
  }

  try {
    return await this.s3Client.send(new GetObjectCommand(args))
  } catch {
    return false
  }
}

const getObjectBody = async function (Key) {
  try {
    const data = await this.getObject(Key)

    //
    //
    const value = await streamToString(data.Body)

    return {
      contentType: data.ContentType,
      value,
    }
  } catch (err) {
    return this.errorResponse(err)
  }
}

const getObjectListFormat = async function (Key) {
  const req = await this.s3Client.send(
    new ListObjectsCommand({
      MaxKeys: 1,
      Bucket: this.name,
      Prefix: Key,
    })
  )

  if (req.Contents && req.Contents.length) {
    return req.Contents[0]
  }

  return false
}

export { getObject, getObjectListFormat, getObjectBody }
