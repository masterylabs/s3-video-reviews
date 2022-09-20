class EventsBaseClass {
  _events = {}

  call(name, payload = null) {
    if (this._events[name]) {
      this._events[name].forEach((cb) => {
        cb(payload)
      })
    }
  }

  on(name, cb) {
    if (!this._events[name]) {
      this._events[name] = []
    }
    this._events[name].push(cb)
  }
}
export default EventsBaseClass
