export default {
  message(message) {
    this.store.dispatch('message/message', message)
  },
  success(message) {
    this.store.dispatch('message/success', message)
  },
  error(message) {
    this.store.dispatch('message/error', message)
  },
  warning(message) {
    this.store.dispatch('message/warning', message)
  },
}
