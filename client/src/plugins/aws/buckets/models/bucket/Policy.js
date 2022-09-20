import {
  GetBucketPolicyCommand,
  PutBucketPolicyCommand,
  DeleteBucketPolicyCommand,
} from '@aws-sdk/client-s3'

const getPolicy = async function () {
  const command = new GetBucketPolicyCommand({
    Bucket: this.name,
  })
  try {
    const res = await this.s3Client.send(command)
    return JSON.parse(res.Policy)
  } catch (err) {
    this.error = err
    return false
  }
}

const putPolicy = async function (policyObject) {
  const command = new PutBucketPolicyCommand({
    Bucket: this.name,
    Policy: JSON.stringify(policyObject),
  })

  try {
    await this.s3Client.send(command)
    return policyObject
  } catch (err) {
    this.error = err
    return false
  }
}
const deletePolicy = async function () {
  const command = new DeleteBucketPolicyCommand({
    Bucket: this.name,
  })

  try {
    await this.s3Client.send(command)
    return true
  } catch (err) {
    this.error = err
    return false
  }
}

export {
  //
  getPolicy,
  putPolicy,
  deletePolicy,
}
