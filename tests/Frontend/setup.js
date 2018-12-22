import Vue from 'vue'

import VueI18n from 'vue-i18n'
Vue.use(VueI18n)

import VeeValidate from 'vee-validate'
Vue.use(VeeValidate, { fieldsBagName: 'veeFields' })

window.Vue = Vue

import "bootstrap.js"

window.Datatables(window, $)

import MockAdapter from 'axios-mock-adapter';
window.mockedAxios = new MockAdapter(window.axios);
window.Vue.prototype.$axios = window.axios;

import { defer } from 'lodash'

window.defer = function () {
  return new Promise(function(resolve, reject) {
    defer(resolve)
  })
}
