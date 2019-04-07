require('./bootstrap');

import Vue from "vue";
window.Vue = Vue

import VueRouter from 'vue-router'
import VeeValidate from 'vee-validate'
import VueI18n from 'vue-i18n'

import List from './components/Feeds/List.vue'
import FormPage from './pages/Feeds/Form.vue'
import Importer from './components/Feeds/Importer.vue'

Vue.use(VueI18n)
Vue.use(VueRouter)
Vue.use(VeeValidate, { fieldsBagName: 'veeFields' })

Vue.prototype.$axios = window.axios;

import { library } from "@fortawesome/fontawesome-svg-core"
import { faLink, faPen, faEye, faSpinner, faInfoCircle } from "@fortawesome/free-solid-svg-icons"
library.add(faPen, faLink, faEye, faSpinner, faInfoCircle)

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.filter("localdatetime", date => date ? (new Date(date)).toLocaleString() : "");
Vue.filter("localdate", date => date ? (new Date(date)).toLocaleDateString() : "");

import appheader from './components/Header.vue'
import appfooter from './components/Footer.vue'

Vue.component('appheader', appheader);
Vue.component('appfooter', appfooter);

const router = new VueRouter({
  routes: [
    {
      path: '/',
      component: List,
      props: (route) => ({ type: route.query.type, tag: route.query.tag })
    },
    {
      path: '/new',
      component: FormPage
    },
    {
      path: '/import',
      component: Importer
    },
    {
      path: '/edit/:id',
      component: FormPage,
      props: true
    }
  ]
})

import messages from './Messages'
import locale from './locale'

let i18n = new VueI18n({
  messages,
  locale: locale.getCurrentLocale(),
  fallbackLocale: 'en'
})

const app = new Vue({
  router,
  i18n,
  el: '#app'
});
