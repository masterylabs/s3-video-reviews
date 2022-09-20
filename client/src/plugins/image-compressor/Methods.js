import axios from 'axios'
import Compressor from 'compressorjs'

const newFileNameExtension = (name, type) => {
  const part = name.split('.')
  part.pop()

  let ext = type.split('/').pop()
  // if (ext === 'jpeg') ext = 'jpg'
  return part.join('.') + `.${ext}`
}

export default {
  changeFormat() {
    const newFileName = newFileNameExtension(this.fileName, this.format)

    this.source.file = new File([this.source.blob], newFileName, {
      type: this.format,
    })

    this.compress()
  },
  async loadImage() {
    try {
      const { data } = await axios.get(this.url, {
        responseType: 'blob',
      })

      // first time match
      //   if (!this.format) {
      this.originalFormat = data.type
      this.format = data.type
      //   }

      const file = new File([data], this.fileName, { type: this.format })

      this.source.blob = data
      this.source.file = file
      this.source.size = file.size
      this.source.type = file.type
      this.compress()
    } catch {
      this.$app.error('Unable to load image')
      this.$emit('failed')
    }
  },

  compress() {
    this.compressor = new Compressor(this.source.file, {
      ...this.form,
      success: (result) => {
        // set size and URL
        this.image.size = result.size
        this.image.url = URL.createObjectURL(result)

        const formatChanged = this.format !== this.originalFormat

        if (!this.isReady) {
          this.isReady = true

          // only emit if has changes
          if (this.sizeImprovement) {
            this.$emit('input', {
              file: result,
              format: this.format,
              formatChanged,
              improvement: this.sizeImprovement,
            })
          }
        }
        // always post change
        else {
          this.$emit('input', {
            file: result,
            format: this.format,
            formatChanged,
          })
        }
      },
      error() {
        this.$app.error('Unable to generate image compression')
      },
    })
  },
}
