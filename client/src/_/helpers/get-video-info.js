import YouTubePlayer from 'youtube-player'

import { createDiv, createVideo, createHiddenDiv } from './create-div'
import { getVimeoId } from './video'

export const getVideoDuration = (src) => {
  return new Promise((resolve) => {
    const playerContainer = createHiddenDiv()
    const video = createVideo()
    playerContainer.appendChild(video)

    video.src = src

    video.addEventListener('loadedmetadata', (e) => {
      const duration = e.target.duration
      playerContainer.remove()

      resolve(duration)
    })
  })
}

export const getVimeoInfo = (src, def = false) => {
  return new Promise((resolve) => {
    const videoId = getVimeoId(src)

    if (!videoId) return resolve(def)

    const playerContainer = createHiddenDiv()
    const playerDiv = createDiv()
    playerContainer.appendChild(playerDiv)

    var options = {
      id: videoId,
      width: 640,
    }

    const player = new window.Vimeo.Player(playerDiv, options)

    player.setVolume(0)

    player.on('loaded', async () => {
      const duration = await player.getDuration()
      const title = await player.getVideoTitle()

     
      player.destroy()
      playerContainer.remove()

      resolve({ videoId, duration, title })
    })

    
  })
}

export const getVideoInfo = (videoId, maxWait = 10000) => {
  return new Promise((resolve) => {
    let playerTarget = {}

    const playerContainer = createHiddenDiv()
    const playerDiv = createDiv()
    playerContainer.appendChild(playerDiv)

    const player = YouTubePlayer(playerDiv, {
      playerVars: {
        mute: 1,
        autoplay: 1,
      },
      videoId,
    })

    const wait = setTimeout(() => {
      if (playerTarget.destroy) {
        playerTarget.destroy()
      }
      playerContainer.remove()
      resolve(false)
    }, maxWait)

    player.on('ready', ({ target }) => {
      playerTarget = target
    })

    player.on('stateChange', ({ data }) => {
      if (data != 1) return

      const videoInfo = playerTarget.getVideoData()

      videoInfo.duration = playerTarget.getDuration()

      clearTimeout(wait)
      playerTarget.destroy()
      playerContainer.remove()

      resolve(videoInfo)
    })
  })
}

export default getVideoInfo
