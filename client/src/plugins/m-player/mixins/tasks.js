const parseTaskName = (task) => {
  if (typeof task === 'number' || (typeof task === 'string' && !isNaN(task))) {
    task = `time_${task}`
  }
  return task
}

export default {
  data() {
    return {
      _repeatTasks: {},
      _singleTasks: {},
    }
  },

  methods: {
    remove(task, func) {
      task = parseTaskName(task)

      let index = -1
      if (this._repeatTasks[task]) {
        index = this._repeatTasks[task].indexOf(func)
        if (index > -1) this._repeatTasks[task].splice(index, 1)
      }

      if (this._singleTasks[task]) {
        index = this._singleTasks[task].indexOf(func)
        if (index > -1) this._singleTasks[task].splice(index, 1)
      }
    },

    once(task, func) {
      this.on(task, func, true)
    },

    on(task, func, once = false) {
      task = parseTaskName(task)

      const key = once ? '_singleTasks' : '_repeatTasks'

      if (!this[key][task]) this[key][task] = [func]
      else this[key][task].push(func)
    },

    call(task, val = null) {
      if (this._repeatTasks[task]) {
        this._repeatTasks[task].forEach((func) => {
          func(val)
        })
      }

      if (this._singleTasks[task]) {
        this._singleTasks[task].forEach((func) => {
          func(val)
        })
        delete this._singleTasks[task]
      }
    },
  },
}
