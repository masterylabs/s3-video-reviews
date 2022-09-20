const alertText = 'Do you really want to leave? you have unsaved changes!'
export default {
  beforeRouteLeave(to, from, next) {
    if (!this.hasChanges) return next()
    const answer = window.confirm(alertText)
    if (answer) {
      removeEventListener('beforeunload', this._hasChangesLeaveWarn, {
        capture: false,
      })
      next()
    }
  },

  methods: {
    _hasChangesLeaveWarn(event) {
      this.hideIt = true
      event.preventDefault()
      return (event.returnValue = alertText)
    },
    _addChangesWarn() {
      addEventListener('beforeunload', this._hasChangesLeaveWarn, {
        capture: false,
      })
    },
    _removeChangesWarn() {
      removeEventListener('beforeunload', this._hasChangesLeaveWarn, {
        capture: false,
      })
    },
  },

  watch: {
    hasChanges(v) {
      if (v) {
        this._addChangesWarn()
      } else {
        this._removeChangesWarn()
      }
    },
  },
}
