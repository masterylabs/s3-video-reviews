import getVideoId from 'get-video-id'

export const getVideo = (id, na = { service: '' }) => {
  if (!id) return na

  // no urls, ids
  if (id.indexOf('://') < 0) {
    if (!isNaN(id)) {
      return {
        service: 'vimeo',
        id,
      }
    }
    if (id.length === 11) {
      return {
        service: 'youtube',
        id,
      }
    }
  }

  const baseUrlType = id.split('?')[0].split('.').pop()

  if (baseUrlType === 'm3u8') {
    return {
      service: 'hls',
      id,
    }
  }

  const video = getVideoId(id)

  if (
    video.service &&
    video.service === 'vimeo' &&
    id.indexOf('/playback/') > -1
  ) {
    return {
      service: 'video',
      id,
    }
  }

  if (video.id) return video

  let part = id.split('/')

  if (video.service === 'vimeo') {
    part.forEach((item) => {
      if (!video.id && !isNaN(item)) {
        video.id = item
      }
    })
  } else if (video.service === 'youtube') {
    part.forEach((item) => {
      if (item.length === 11) {
        video.id = item
      }
    })
  }

  if (!video.id && id.length === 10) {
    return {
      service: 'wistia',
      id,
    }
  }

  if (!video.id && id.indexOf('://') > -1) {
    return {
      service: 'video',
      id,
    }
  }

  return video.id ? video : na
}
