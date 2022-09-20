import {
  GetBucketWebsiteCommand,
  PutBucketWebsiteCommand,
  DeleteBucketWebsiteCommand,
  // PutBucketWebsiteRequest
} from '@aws-sdk/client-s3'

/**
 * 
 * @returns 
    // 404 if no website set: returns false 

 */
export default {
  async deleteWebsite() {
    const command = new DeleteBucketWebsiteCommand({
      Bucket: this.name,
    })

    try {
      const res = await this.s3Client.send(command)

      // delete res.$metadata
      return res
    } catch (err) {
      return this.errorResponse(err)
    }
  },

  async getWebsite() {
    const command = new GetBucketWebsiteCommand({
      Bucket: this.name,
    })

    try {
      const res = await this.s3Client.send(command)
      delete res.$metadata
      return res
    } catch (err) {
      return this.errorResponse(err)
    }
  },

  async putWebsite(WebsiteConfiguration) {
    const command = new PutBucketWebsiteCommand({
      Bucket: this.name,
      WebsiteConfiguration,
    })

    try {
      await this.s3Client.send(command)
      return true
    } catch (err) {
      return this.errorResponse(err)
    }
  },
}
