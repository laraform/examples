require('./bootstrap');

import Vue from 'vue'

import Laraform from '@laraform/laraform'
// import Laraform from 'laraform' - for Community Version

import LoginForm from './components/forms/LoginForm'

Vue.use(Laraform)

Vue.component('LoginForm', LoginForm)

const app = new Vue({
  el: '#app'
})