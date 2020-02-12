import utils from '@laraform/laraform/src/utils'
import bs4 from '@laraform/laraform/src/themes/bs4'

export default utils.extendTheme(bs4, {
  classes: {
    form: 'laraform-shopify',
    formWizardStep: 'shopify-wizard-step',
  }
})