<script>
  import ShoppingMethodRadioSlot from './../slots/ShoppingMethodRadioSlot'

  export default {
    mixins: [Laraform],
    data() {
      return {
        // Extending schema with frontend features
        schema: {
          shipping_method: {
            slots: {
              // Adding custom radio template for shipping method
              radio: ShoppingMethodRadioSlot,
            },
          },
          shipping_address: {
            schema: {
              phone: {
                // Defining mask for `phone` element
                mask: ['(', /[1-9]/, /\d/, /\d/, ')', ' ', /\d/, /\d/, /\d/, '-', /\d/, /\d/, /\d/, /\d/],
              }
            }
          },
          remember_me: {
            schema: {
              mobile_phone_number: {
                // Defining mask for `mobile_phone_number` element
                mask: ['(', /[1-9]/, /\d/, /\d/, ')', ' ', /\d/, /\d/, /\d/, '-', /\d/, /\d/, /\d/, /\d/],
              }
            }
          },
        },
      }
    },

    // Update colums and shipping options on country change
    watch: {
      'data.country': {
        handler(country) {
          if (!country) {
            var country = 'de'
          }

          this.el$('shipping_method').items = this.shippingOptions[country]
          this.el$('shipping_address.country').updateColumns(country == 'us' ? 5 : 8)
          this.el$('shipping_address.zip_code').updateColumns(country == 'us' ? 3 : 4)
        },
      },
      'data.billing_address.country': {
        handler(country) {
          if (!country) {
            var country = 'de'
          }

          this.el$('billing_address.billing_info.country').updateColumns(country == 'us' ? 5 : 8)
          this.el$('billing_address.billing_info.zip_code').updateColumns(country == 'us' ? 3 : 4)
        },
      },
    },

    computed: {
      shippingOptions(){
        return {
          us: {
            usps: {
              carrier: 'USPS Priority Mail Express',
              delivery_date: '1 business days',
              price: '$66.46'
            },
            fedex: {
              carrier: 'FedEx Home Delivery',
              delivery_date: '1 to 5 business days',
              price: '$66.98'
            },
            ups: {
              carrier: 'UPS Second Day Air',
              delivery_date: '2 business days',
              price: '$120.82'
            },
          },
          de: {
            eu: {
              carrier: 'Free EU Shipping',
              delivery_date: '2-3 business days',
              price: 'FREE'
            }
          }
        }
      }
    },

    mounted() {
      // Handle form success event
      this.on('success', (response) => {
        alert('Order sent!')
        
        console.log(response)
      })
    }
  }
</script>