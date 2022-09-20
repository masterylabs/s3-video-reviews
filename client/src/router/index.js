import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Settings from '../views/Settings.vue'

import Offer from '../views/Offer'
import OfferPage from '../views/OfferPage'
import PreviewWindow from '../adam/PreviewWindow.vue'
import NewOfferRedirect from '../views/NewOfferRedirect.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
    meta: {
      menu: true,
      text: 'Offers',
      icon: 'mdi-tag-outline',
      exact: true,
      order: 10,
    },
  },
  {
    path: '/settings',
    name: 'settings',
    component: Settings,
    meta: {
      menu: true,
      text: 'SETTINGS',
      icon: 'mdi-cog',
      order: 100,
    },
  },

  {
    path: '/offers/:id',
    component: Offer,
    name: 'offer',
  },
  {
    path: '/offers/:parent_id/pages/:id',
    component: OfferPage,
    name: 'offer-page',
  },
  {
    path: '/offers/:id/new',
    component: NewOfferRedirect,
    name: 'new-offer-redirect',
  },

  {
    path: '/preview-window',
    component: PreviewWindow,
    name: 'preview-window',
    meta: {
      noContainer: true,
    },
  },
]

// import TestPage from '../views/TestPage.vue'
// routes.push({
//   name: 'test-page',
//   path: '/test',
//   component: TestPage,
//   meta: {
//     menu: true,
//     text: 'DEV',
//     icon: 'mdi-alert',
//     order: 100,
//   },
// })

const router = new VueRouter({
  routes,
})

export default router
