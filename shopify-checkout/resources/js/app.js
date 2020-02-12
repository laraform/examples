 require('./bootstrap');

import Vue from 'vue'
import Laraform from '@laraform/laraform/src'

import ShopifyCheckoutForm from './components/forms/ShopifyCheckoutForm'
import SummaryElement from './components/elements/SummaryElement'
import PaymentElement from './components/elements/PaymentElement'
import shopifyTheme from './themes/shopify'

Laraform.theme('shopify', shopifyTheme)

Laraform.config({
  endpoints: {
    process: '/laraform/process'
  }
})

Vue.use(Laraform)

Vue.component('SummaryElement', SummaryElement)
Vue.component('PaymentElement', PaymentElement)
Vue.component('ShopifyCheckoutForm', ShopifyCheckoutForm)

const app = new Vue({
  el: '#app',
})