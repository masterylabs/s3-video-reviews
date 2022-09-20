import { ListObjectsCommand } from '@aws-sdk/client-s3'

const listObjects = async function (args = {}) {
  this.clearError()
  this.objects = []

  const getNext = async (Marker = '') => {
    try {
      // request
      const req = await this.s3Client.send(
        new ListObjectsCommand({
          MaxKeys: this.maxKeys,
          Bucket: this.name,
          Marker,
          ...args,
        })
      )

      if (req.Contents && req.Contents.length) {
        this.objects.push(...req.Contents)
        this.call('contents', req.Contents)

        // more
        if (this.maxKeys === req.Contents.length) {
          const lastKey = req.Contents[req.Contents.length - 1].Key
          return getNext(lastKey)
        }
      }

      return this.objects
    } catch (err) {
      return this.errorResponse(err)
    }
  }

  return getNext()
}

export default listObjects
