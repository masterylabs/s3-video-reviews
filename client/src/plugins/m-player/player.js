import computed from './computed'
import data from './data'
import events from './events'
import getters from './getters'
import loaders from './loaders'
import methods from './methods'
import mounted from './mounted'
import props from './props'
import setters from './setters'
import watch from './watch'

import mixins from './mixins'

export default {
  props,
  mixins,
  watch,
  data,
  computed,
  methods: {
    ...events,
    ...getters,
    ...loaders,
    ...methods,
    ...setters,
  },
  mounted,
}
