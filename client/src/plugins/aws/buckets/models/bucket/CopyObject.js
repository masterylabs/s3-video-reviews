import { CopyObjectCommand } from '@aws-sdk/client-s3'

const copyObject = async function (sourceKey, newKey) {
  const CopySource = `${this.name}/${sourceKey}`
  const command = new CopyObjectCommand({
    Bucket: this.name,
    Key: newKey,
    CopySource,
    //CacheControl
    //Optional ContentType
  })

  try {
    await this.s3Client.send(command)

    return true
  } catch (err) {
    return this.errorResponse(err)
  }
}

export { copyObject }
