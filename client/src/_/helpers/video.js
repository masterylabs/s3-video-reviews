import isUrl from './is-url'

export const prettyTime = (secs, hundreds = false, tenths = false) => {
  var hunds = 0

  if (hundreds) {
    hunds = secs - Math.floor(secs)

    if (tenths) {
      hunds = Math.round(hunds * 10)
    } else {
      hunds = Math.floor(hunds * 100)
    }
  }

  secs = Math.floor(secs)

  var hrs = 0,
    mins = 0 //, t = secs;

  if (secs >= 3600) {
    hrs = Math.floor(secs / 3600)
    secs = secs - hrs * 3600
  }

  if (secs >= 60) {
    mins = Math.floor(secs / 60)
    secs = secs - mins * 60
  }

  var display = ''

  if (hrs > 0) {
    // if (hrs < 10) {
    //   display += "0";
    // }
    display += hrs + ':'
  }

  if (mins < 10) {
    mins = '0' + mins
  }
  display += mins + ':'

  if (secs < 0) {
    secs = 0
  }

  if (secs < 10) {
    secs = '0' + secs
  }

  if (hundreds) {
    if (tenths) {
      secs += ':' + hunds
    } else {
      if (hunds < 10) {
        hunds = '0' + hunds
      }
      secs += ':' + hunds
    }
  }

  return display + secs
}

export const getVimeoId = (url, fail = false) => {
  if (!url) {
    return fail
  }

  if (!isNaN(url) && url.length > 5 && url.length < 20) {
    return url
  }

  const regex = '(https://)(www.){0,4}(vimeo.com)'
  if (!url.match(regex)) {
    return fail
  }

  const getId = url.match(/[0-9]{6,20}/)

  return getId && getId.length ? getId[0] : fail
}

export const isVimeo = (src) => {
  return !!getVimeoId(src)
}

export const getYouTubeId = (url, fail = false) => {
  if (url.length == 11 && url.indexOf(':') < 0) {
    return url
  }

  let id = ''
  url = url
    .replace(/(>|<)/gi, '')
    .split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/)
  if (url[2] !== undefined) {
    id = url[2].split(/[^0-9a-z_-]/i)
    id = id[0]
  } else {
    id = url
  }

  if (id.length != 11) {
    return fail
  }
  return id
}

export const getVideoProvider = (url = '', fail = false, file = 'file') => {
  if (!url) {
    return fail
  }

  if (
    !isNaN(url) ||
    url.indexOf('://vimeo.com') > -1 ||
    url.indexOf('://www.vimeo.com') > -1
  ) {
    return 'vimeo'
  }

  if (getYouTubeId(url, false)) {
    return 'youtube'
  }

  if (isUrl(url)) {
    return file
  }
}

export const getVideoMin = (url, validate = false) => {
  if (!url) {
    return url
  }

  if (getVimeoId(url)) {
    return getVimeoId(url)
  }

  if (getYouTubeId(url)) {
    return getYouTubeId(url)
  }

  if (validate && !isUrl(url)) return false

  return url
}

export const isValidVideo = (src) => {
  const value = getVideoMin(src, true)
  return value ? true : false
}

export const isYouTube = (src) => {
  const val = getYouTubeId(src)
  return val && val.length == 11
}
