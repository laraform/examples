require('./bootstrap');

import Vue from 'vue'
import Laraform from '@laraform/laraform/src'
import LoginForm from './components/forms/LoginForm'

Laraform.config({
  endpoints: {
    process: '/laraform/process'
  }
})

Vue.use(Laraform)

Vue.component('LoginForm', LoginForm)

const app = new Vue({
  el: '#app'
})