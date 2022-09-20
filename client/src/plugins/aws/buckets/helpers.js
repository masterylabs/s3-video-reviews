const Slugify = require('slugify')
import Compressor from 'compressorjs'
import axios from 'axios'

const getBlob = async (url) => {
  try {
    const { data } = await axios.get(url, {
      responseType: 'blob',
    })

    return data
  } catch {
    return false
  }
}

const compressImage = async (file, args = {}) => {
  return new Promise((resolve) => {
    new Compressor(file, {
      ...args,
      success: (result) => {
        resolve(result)
      },
      error() {
        resolve(false)
      },
    })
  })
}

const slugify = (str, replacement = '-', append = '') => {
  const slug = Slugify(str, {
    replacement, // replace spaces with replacement character, defaults to `-`
    lower: true, // convert to lower case, defaults to `false`
    strict: true,
  })

  return slug + append
}

const getFolderName = (key) => {
  return key.slice(0, -1).split('/').pop().replace(/-/g, ' ')
}

const appendToFileName = (fileName, append) => {
  if (fileName.indexOf('.') < 0) {
    return fileName + append
  }
  const part = fileName.split('.')
  const ext = part.pop()
  return part.join('.') + `${append}.${ext}`
}

const getUniqueKey = (Key, Keys) => {
  if (Keys.indexOf(Key) < 0) {
    return Key
  }

  let n = 2

  while (n > 0) {
    const value = appendToFileName(Key, `-${n}`)
    if (Keys.indexOf(value) < 0) {
      return value
    }

    n++

    // emergency stop
    if (n > 10000) {
      break
    }
  }
}

const isFolder = (Key) => Key && Key.charAt(Key.length - 1) === '/'
const toText = (value) => value.replace(/-/g, ' ')

function getDataTransferItems(dataTransferItems) {
  function traverseFileTreePromise(item, path = '', folder, _dirPath = '') {
    return new Promise((resolve) => {
      if (item.isFile) {
        item.file((file) => {
          // file.filepath = path || '' + file.name //save full path
          file._dirPath = _dirPath
          folder.push(file)
          resolve(file)
        })
      } else if (item.isDirectory) {
        let dirReader = item.createReader()
        dirReader.readEntries((entries) => {
          let entriesPromises = []
          let children = []
          folder.push({ name: item.name, children, _dirPath, _isDir: true })

          for (let entry of entries) {
            entriesPromises.push(
              traverseFileTreePromise(
                entry,
                path || '' + item.name + '/',
                children,
                _dirPath + item.name + '/'
              )
            )
          }

          resolve(Promise.all(entriesPromises))
        })
      }
    })
  }

  let files = []

  return new Promise((resolve) => {
    let entriesPromises = []
    for (let it of dataTransferItems)
      entriesPromises.push(
        traverseFileTreePromise(it.webkitGetAsEntry(), null, files)
      )
    Promise.all(entriesPromises).then(() => {
      resolve(files)
    })
  })
}

const streamToString = (stream) => {
  return new Promise((resolve, reject) => {
    if (stream instanceof ReadableStream === false) {
      reject('Expected stream, got ' + typeof stream)
    }
    let text = ''
    const decoder = new TextDecoder('utf-8')

    const reader = stream.getReader()
    const processRead = ({ done, value }) => {
      if (done) {
        // resolve promise with chunks

        // resolve(Buffer.concat(chunks).toString("utf8"));
        resolve(text)
        return
      }

      text += decoder.decode(value)

      // Not done, keep reading
      reader.read().then(processRead)
    }

    // start read
    reader.read().then(processRead)
  })
}

const getTypeDataFromKey = (Key) => {
  let type = Key.endsWith('/') ? 'folder' : Key.toLowerCase().split('.').pop()

  let contentType = ''

  if (['jpeg', 'jpg', 'png', 'gif', 'webp'].includes(type)) {
    contentType = 'image'
  } else if (
    [
      'html',
      'htm',
      'php',
      'js',
      'css',
      'text',
      'txt',
      'xml',
      'me',
      'svg',
    ].includes(type)
  ) {
    contentType = 'text'
  } else if (
    [
      'mp4',
      'mpeg-4',
      'mov',
      'wmv',
      'flv',
      'avi',
      'avchd',
      'webm',
      'mkv',
      'ogv',
    ].includes(type)
  ) {
    contentType = 'video'
  } else if (
    [
      'mp3',
      'mpeg-1',
      'acc',
      'ogg',
      'wav',
      'aiff',
      'dsd',
      'pcm',
      'flac',
      'alac',
    ].includes(type)
  ) {
    contentType = 'audio'
  } else {
    contentType = type
  }

  return {
    type,
    contentType,
  }
}

const isImage = (Key) => {
  const value = getTypeDataFromKey(Key)
  return value && value.contentType === 'image'
}

const stringEndsWith = (str, strEnd) => {
  const index = str.indexOf(strEnd)

  if (index < 0) {
    return false
  }
  return index === str.length - strEnd.length
}

const isThumb = (Key) => {
  return Key.split('__').pop() === 'thumb.jpeg'
}

export {
  //
  isThumb,
  isImage,
  slugify,
  getFolderName,
  getUniqueKey,
  getTypeDataFromKey,
  isFolder,
  toText,
  getDataTransferItems,
  streamToString,
  stringEndsWith,
  compressImage,
  getBlob,
}
