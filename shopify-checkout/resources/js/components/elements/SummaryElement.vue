<template>
  <div class="summary" v-if="visible">

    <div class="item" v-if="items.indexOf('contact') !== -1">
      <label>Contact</label>
      <span>{{ contact }}</span>
      <a href="" @click.prevent="goTo('customer_information')">Change</a>
    </div>

    <div class="item" v-if="items.indexOf('ship_to') !== -1">
      <label>Ship to</label>
      <span>{{ ship_to }}</span>
      <a href="" @click.prevent="goTo('customer_information')">Change</a>
    </div>

    <div class="item" v-if="items.indexOf('method') !== -1">
      <label>Method</label>
      <span>{{ method }}</span>
      <a href="" @click.prevent="goTo('shipping_method')">Change</a>
    </div>
    
  </div>
</template>

<script>
  import StaticElement from '@laraform/laraform/src/components/elements/StaticElement'

  export default {
    mixins: [StaticElement],
    computed: {
      items() {
        return this.schema.items
      },
      contact() {
        let el = this.form$.elements$.contact_information
        
        if (!el) {
          return null
        }

        return this.form$.el$('contact_information.email').value
      },
      ship_to() {
        let el = this.form$.elements$.shipping_address

        if (!el) {
          return null
        }

        let parts = ['address', ',', 'address2', ',', 'city', 'state', 'zip_code', ',', 'country']

        return parts.map((part, key) => {
          if (part === ',') {
            return this.form$.el$(`shipping_address.${parts[(key-1)]}`).value ? part : ''
          }

          let value = part == 'country'
            ? this.form$.el$(`shipping_address.${part}`).textValue
            : this.form$.el$(`shipping_address.${part}`).value

          return value && key > 0 ? ' ' + value : value
        }).join('')
      },
      method() {
        let el = this.form$.elements$.shipping_method

        if (!el) {
          return null
        }

        let shippingMethod = this.form$.el$('shipping_method')
        let item = shippingMethod.items[shippingMethod.value]

        if (!item) {
          return ''
        }

        return item.carrier + ' ' + item.price
      }
    },
    methods: {
      goTo(step) {
        this.form$.wizard$.goTo(step)
      }
    }
  }
</script>>