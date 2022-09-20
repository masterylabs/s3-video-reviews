import { DeleteObjectsCommand } from '@aws-sdk/client-s3'

const deleteObjects = async function (keysOrObjects) {
  //
  const Objects = []

  keysOrObjects.forEach((Key) => {
    if (typeof Key === 'object') {
      Key = Key.Key
    }
    Objects.push({ Key })
  })

  const args = {
    Bucket: this.name,
    Delete: { Objects },
  }

  try {
    // request
    await this.s3Client.send(new DeleteObjectsCommand(args))
    return this.successResponse()
  } catch (err) {
    return this.errorResponse(err)
  }
}

const deleteFolder = async function (Key) {
  await this.listObjects({ Prefix: Key })

  // worked ?
  if (!this.objects.length) return this.errorResponse()
  const keys = this.objects.map(({ Key }) => Key)
  return this.deleteObjects(keys)
}

export { deleteObjects, deleteFolder }
