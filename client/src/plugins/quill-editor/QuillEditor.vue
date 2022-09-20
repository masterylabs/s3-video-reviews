<template>
  <div>
    <!-- <div id="announcementEditorToolbar">
      <span class="ql-formats">
        <select class="ql-size">
          <option selected>Default</option>
          <option value="24px">Small</option>
          <option value="48px">Medium</option>
          <option value="100px">Large</option>
          <option value="200px">Huge</option>
        </select>
      </span>
    </div> -->

    <div ref="editor"></div>
  </div>
</template>
<script>
  // https://quilljs.com/docs/api/#deletetext
  // https://quilljs.com/docs/modules/toolbar/

  // window.Quill
  // var fontSizeStyle = window.Quill.import('attributors/style/size')
  // fontSizeStyle.whitelist = ['24px', '48px', '100px', '200px']

  const toolbar = [
    // [{ header: 1 }, { header: 2 }],
    // [{ content : 'Toolbar NAME' }],
    [{ size: ['small', false, 'large', 'huge'] }], // custom dropdown
    // [{ size: ['24px', '48px', '100px', '200px'] }],
    // [{ font: [] }],
    ['bold', 'italic', 'underline', 'strike'], // toggled buttons
    ['link'],
    [{ color: [] }, { background: [] }], // dropdown with defaults from theme
    // ['blockquote', 'code-block'],

    // [{ header: 1 }, { header: 2 }], // custom button values
    // [{ direction: 'rtl' }], // text direction

    // [{ header: [1, 2, 3, 4, 5, 6, false] }],

    [{ align: [] }],
    [
      { list: 'ordered' },
      { list: 'bullet' },
      { indent: '-1' },
      { indent: '+1' },
    ],
    // [{ script: 'sub' }, { script: 'super' }], // superscript/subscript
    // [{ indent: '-1' }, { indent: '+1' }], // outdent/indent

    // ['image'], // 'video'
    ['clean'], // remove formatting button
  ]

  export default {
    props: {
      value: {
        type: String,
        default: '',
      },
      label: {
        type: String,
        default: 'Content',
      },
      autofocus: Boolean,
    },

    data() {
      return {
        ready: false,
        content: 'Starting...',
        editor: null,
      }
    },

    methods: {
      onTextChange() {
        if (!this.ready) return
        // const content = this.$refs.editor.firstChild.innerHTML
        this.$emit('input', this.$refs.editor.firstChild.innerHTML)
      },
      // onSelectionChange(e) {
      //   if (e) {
      //     this.lastIndex = e.index
      //     this.lastLength = e.length
      //   }
      // },
      addCustomValue(value) {
        var range = this.editor.getSelection()

        if (range && range.length) {
          this.editor.deleteText(range.index, range.length)
        }
        const index = range ? range.index : 0
        this.editor.insertText(index, value, 'bold', true)
      },
    },

    mounted() {
      const quill = new window.Quill(this.$refs.editor, {
        theme: 'snow',
        modules: {
          toolbar,
        },
        placeholder: this.label,
        autofocus: true,
      })

      quill.on('text-change', this.onTextChange)

      if (this.value) quill.root.innerHTML = this.value

      this.editor = quill

      this.ready = true

      if (this.autofocus) {
        setTimeout(() => {
          quill.root.focus()
        }, 250)
      }
    },
  }
</script>
