require('./bootstrap');
import VueRouter from 'vue-router'
import VeeValidate from 'vee-validate'
import VueI18n from 'vue-i18n'

import messages from './Messages'
import locale from './locale'

import List from './components/Feeds/List.vue'
import Form from './components/Feeds/Form.vue'

window.Vue = require('vue');
Vue.use(VueI18n)
Vue.use(VueRouter)
Vue.use(VeeValidate, { fieldsBagName: 'veeFields' })

import { library } from "@fortawesome/fontawesome-svg-core"
import { faLink, faPen, faEye, faSpinner, faInfoCircle } from "@fortawesome/free-solid-svg-icons"
library.add(faPen, faLink, faEye, faSpinner, faInfoCircle)

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.filter("localdatetime", date => date ? (new Date(date)).toLocaleString() : "");
Vue.filter("localdate", date => date ? (new Date(date)).toLocaleDateString() : "");

Vue.component('appheader', require('./components/Header.vue'));
Vue.component('appfooter', require('./components/Footer.vue'));

const router = new VueRouter({
  routes: [
    {
      path: '/',
      component: List,
      props: (route) => ({ type: route.query.type, tag: route.query.tag })
    },
    {
      path: '/new',
      component: Form
    },
    {
      path: '/edit/:id',
      component: Form,
      props: true
    }
  ]
})

const i18n = new VueI18n({
  messages,
  locale: locale.getCurrentLocale(),
  fallbackLocale: 'en'
})

const app = new Vue({
  router,
  i18n,
  el: '#app'
});
