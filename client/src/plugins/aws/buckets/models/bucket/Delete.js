import { DeleteBucketCommand, DeleteObjectCommand } from '@aws-sdk/client-s3'

const deleteObject = async function (Key) {
  const command = new DeleteObjectCommand({
    Bucket: this.name,
    Key,
  })

  try {
    await this.s3Client.send(command)

    return true
  } catch (err) {
    return this.errorResponse(err)
  }
}

const forceDestroy = async function () {
  await this.listObjects()

  if (this.objects.length) {
    const items = this.objects.map((a) => a.Key)
    await this.deleteObjects(items)
  }

  return this.destroy()
}

const destroy = async function () {
  const command = new DeleteBucketCommand({
    Bucket: this.name,
  })

  try {
    await this.s3Client.send(command)

    return true
  } catch (err) {
    return this.errorResponse(err)
  }
}

export { deleteObject, destroy, forceDestroy }
