const setBucketWebsite = async (bucket, config = null) => {
  if (!config) {
    config = {
      ErrorDocument: {
        Key: '404.html',
      },
      IndexDocument: {
        Suffix: 'index.html',
      },
      RedirectAllRequestsTo: undefined,
      RoutingRules: undefined,
    }
  }

  return await bucket.putWebsite(config)
}

const setBucketPublic = async (bucket, access = null) => {
  if (!access) {
    access = {
      BlockPublicAcls: false, // true,
      IgnorePublicAcls: false, // true,
      BlockPublicPolicy: false,
      RestrictPublicBuckets: false,
    }
  }

  return await bucket.putPublicAccess(access)
}

const setBucketPolicy = async (bucket, policy = null) => {
  if (!policy) {
    policy = {
      Version: '2008-10-17',
      Statement: [
        {
          Sid: 'AllowPublicRead',
          Effect: 'Allow',
          Principal: {
            AWS: '*',
          },
          Action: 's3:GetObject',
          Resource: `arn:aws:s3:::${bucket.name}/*`,
          //   Resource: 'arn:aws:s3:::wp-bucket-test-3/image-one.png',
        },
      ],
    }
  }

  return await bucket.putPolicy(policy)
}

export { setBucketWebsite, setBucketPublic, setBucketPolicy }
