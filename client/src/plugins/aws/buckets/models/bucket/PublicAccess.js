import {
  GetPublicAccessBlockCommand,
  PutPublicAccessBlockCommand,
  GetBucketCorsCommand,
} from '@aws-sdk/client-s3'

const checkCors = async function () {
  const command = new GetBucketCorsCommand({
    Bucket: this.name,
  })

  try {
    const res = await this.s3Client.send(command)
    return this.successResponse(res)
  } catch (err) {
    return this.errorResponse(err)
  }

  // const access = await this.getPublicAccess()

  // if (!access) {
  //   return this.errorResponse()
  // }

  // return this.successResponse()
}

const getPublicAccess = async function () {
  this.error = false

  const command = new GetPublicAccessBlockCommand({
    Bucket: this.name,
  })
  try {
    const res = await this.s3Client.send(command)
    return res.PublicAccessBlockConfiguration
  } catch (err) {
    return this.errorResponse(err)
  }
}

const putPublicAccess = async function (obj) {
  this.error = false

  const command = new PutPublicAccessBlockCommand({
    Bucket: this.name,
    PublicAccessBlockConfiguration: obj,
  })

  try {
    await this.s3Client.send(command)
    return obj
  } catch (err) {
    return this.errorResponse(err)
  }
}

export {
  //
  getPublicAccess,
  putPublicAccess,
  checkCors,
}
