import VueRouter from 'vue-router'

const setupRouter = (Vue, routes, mode = 'history') => {
  Vue.use(VueRouter)
  const router = new VueRouter({
    mode,
    routes,
  })

  return router
}

export default setupRouter
