<?php

namespace App\Forms;

class ShopifyCheckoutForm extends \Laraform
{
  // Choosing theme
  public $theme = 'shopify';

  // Assign Vue component
  public $component = 'shopify-checkout-form';

  // Hiding labels by default
  public $labels = false;

  // Hiding form error collector
  public $formErrors = false;

  // Defining default column sizes
  public $columns = [
    'element' => 12,
    'label' => 12,
    'field' => 12
  ];

  // Defining form steps
  public $wizard = [

    // 1st step - 'Customer information'
    'customer_information' => [
      'label' => 'Customer information',
      'elements' => ['contact_information', 'shipping_address'],
      'labels' => [
        'previous' => ' ',
        'next' => 'Continue to shipping method'
      ]
    ],

    // 2nd step - 'Shipping method'
    'shipping_method' => [
      'label' => 'Shipping method',
      'elements' => ['shipping_summary', 'shipping_method'],
      'labels' => [
        'previous' => '< Return to customer information',
        'next' => 'Continue to payment method'
      ]
    ],

    // 3rd step - 'Payment method'
    'payment_method' => [
      'label' => 'Payment method',
      'elements' => ['payment_summary', 'payment_method', 'billing_address', 'remember_me', 'terms'],
      'labels' => [
        'previous' => '< Return to shipping method',
        'finish' => 'Complete order'
      ]
    ],
  ];

  // Defining form elements
  public function schema() {
    return [

      // 'Contact information' (email)
      'contact_information' => [
        'type' => 'group',
        'label' => 'Contact information',
        'schema' => [
          'email' => [
            'type' => 'text',
            'placeholder' => 'Email',
            'floating' => 'Email',
            'rules' => 'required|email:debounce=300',
          ],
          'updates' => [
            'type' => 'checkbox',
            'text' => 'Keep me up to date on news and exclusive offers',
          ],
        ]
      ],

      // 'Shipping address' (name, company, address fields, phone)
      'shipping_address' => [
        'type' => 'group',
        'label' => 'Shipping address',
        'schema' => [
          'firstname' => [
            'type' => 'text',
            'placeholder' => 'First name (optional)',
            'floating' => 'First name (optional)',
            'columns' => 6
          ],
          'lastname' => [
            'type' => 'text',
            'placeholder' => 'Last name',
            'floating' => 'Last name',
            'rules' => 'required',
            'columns' => 6
          ],
          'company' => [
            'type' => 'text',
            'floating' => 'Company (optional)',
            'placeholder' => 'Company (optional)',
          ],
          'address' => [
            'type' => 'text',
            'floating' => 'Address',
            'placeholder' => 'Address',
            'rules' => 'required'
          ],
          'address2' => [
            'type' => 'text',
            'floating' => 'Apartment, suite, etc. (optional)',
            'placeholder' => 'Apartment, suite, etc. (optional)',
          ],
          'city' => [
            'type' => 'text',
            'floating' => 'City',
            'placeholder' => 'City',
            'rules' => 'required'
          ],
          'country' => [
            'type' => 'select',
            'floating' => 'Country',
            'placeholder' => 'Country',
            'rules' => 'required',
            'items' => [
              'de' => 'Germany',
                'us' => 'United States',
            ],
            'columns' => 8,
          ],
          'state' => [
            'type' => 'select',
            'floating' => 'State',
            'placeholder' => 'State',
            'columns' => 4,
            'items' => self::$states,
            'rules' => 'required',
            'conditions' => [
              ['shipping_address.country', 'us']
            ],
          ],
          'zip_code' => [
            'type' => 'text',
            'floating' => 'ZIP Code',
            'placeholder' => 'ZIP Code',
            'rules' => 'required',
            'columns' => 4
          ],
          'phone' => [
            'type' => 'text',
            'floating' => 'Phone',
            'placeholder' => 'Phone',
            'rules' => 'required',
          ],
        ]
      ],

      // Shipping summary block with custom SummaryElement imported at app.js
      'shipping_summary' => [
        'type' => 'static',
        'component' => 'SummaryElement',
        'items' => ['contact', 'ship_to']
      ],

      // 'Shipping method' - using custom template for checkboxes
      'shipping_method' => [
        'type' => 'radiogroup',
        'label' => 'Shipping method',
        'before' => '<span class="group-description">Please Note - Orders will be ship the next business day. Please add one shipping day to all estimates.</span>',
        'items' => [],
        'rules' => 'required',
      ],

      // Payment summary block with custom SummaryElement imported at app.js      
      'payment_summary' => [
        'type' => 'static',
        'component' => 'SummaryElement',
        'items' => ['contact', 'ship_to', 'method']
      ],

      // 'Payment method' block
      'payment_method' => [
        'type' => 'group',
        'label' => 'Payment method',
        'class' => 'payment-method',
        'before' => '<span class="group-description">All transactions are secure and encrypted.</span>',
        'schema' => [

          // 'Credit card' option
          'credit_card' => [
            'type' => 'radio',
            'text' => 'Credit card',
            'fieldName' =>  'payment_method',
            'after' => '<span class="card-logos"></span>',
            'rules' => [
              [
                'required' => ['payment_method.paypal', null]
              ]
            ],
            'messages' => [
              'required' => 'One payment method must be choosen.'
            ]
          ],

          // Credit card details (if selected)
          'credit_card_details' => [
            'type' => 'group',
            'class' => 'credit-card-details',
            'conditions' => [
              ['payment_method.credit_card', 1]
            ],
            'schema' => [
              'card_number' => [
                'type' => 'text',
                'floating' => 'Card number',
                'placeholder' => 'Card number (do not provide actual card number)',
              ],
              'cardholder_name' => [
                'type' => 'text',
                'floating' => 'Cardholder name',
                'placeholder' => 'Cardholder name',
                'columns' => 6
              ],
              'expiration' => [
                'type' => 'text',
                'floating' => 'MM / YY',
                'placeholder' => 'MM / YY',
                'columns' => 3
              ],
              'cvv' => [
                'type' => 'text',
                'floating' => 'CVV',
                'placeholder' => 'CVV',
                'columns' => 3
              ],
            ]
          ],

          // 'Paypal' option
          'paypal' => [
            'type' => 'radio',
            'text' => ' ',
            'class' => 'paypal-payment',
            'fieldName' => 'payment_method',
            'after' => '<span class="card-logos only-3"></span>',
            'rules' => [
              [
                'required' => ['payment_method.credit_card', null]
              ]
            ],
            'messages' => [
              'required' => 'One payment method must be choosen.'
            ]
          ],

          // Paypal info window (if selected)
          'paypal_payment' => [
            'type' => 'static',
            'component' => 'PaymentElement',
            'text' => 'After clicking "Complete order", you will be redirected to PayPal to complete your purchase securely.',
            'conditions' => [
              ['payment_method.paypal', 1]
            ],
          ],
        ],
      ],

      // 'Billing address' block
      'billing_address' => [
        'type' => 'object',
        'label' => 'Billing address',
        'class' => 'billing-address',
        'schema' => [
          'same' => [
            'type' => 'radio',
            'text' => 'Same as shipping address',
            'fieldName' => 'billing_address',
            'rules' => [
              [
                'required' => ['billing_address.different', null]
              ]
            ],
            'messages' => [
              'required' => 'One billing address option must be choosen.'
            ]
          ],
          'different' => [
            'type' => 'radio',
            'text' => 'Use a different billing address',
            'fieldName' => 'billing_address',
            'rules' => [
              [
                'required' => ['billing_address.same', null]
              ]
            ],
            'messages' => [
              'required' => 'One billing address option must be choosen.'
            ]
          ],

          // Billing info block (if 'use different is selected')
          'billing_info' => [
            'conditions' => [
              ['billing_address.different', 1]
            ],
            'type' => 'group',
            'class' => 'billing-address-fields',
            'schema' => [
              'firstname' => [
                'type' => 'text',
                'placeholder' => 'First name (optional)',
                'floating' => 'First name (optional)',
                'columns' => 6,
              ],
              'lastname' => [
                'type' => 'text',
                'placeholder' => 'Last name',
                'floating' => 'Last name',
                'columns' => 6,
                'rules' => 'required'
              ],
              'company' => [
                'type' => 'text',
                'placeholder' => 'Company (optional)',
                'floating' => 'Company (optional)',
              ],
              'address' => [
                'type' => 'text',
                'placeholder' => 'Address',
                'floating' => 'Address',
                'rules' => 'required'
              ],
              'address2' => [
                'type' => 'text',
                'placeholder' => 'Apartment, suite, etc. (optional)',
                'floating' => 'Apartment, suite, etc. (optional)',
              ],
              'city' => [
                'type' => 'text',
                'placeholder' => 'City',
                'floating' => 'City',
                'rules' => 'required'
              ],
              'country' => [
                'type' => 'select',
                'floating' => 'Country',
                'placeholder' => 'Country',
                'items' => [
                  'de' => 'Germany',
                  'us' => 'United States',
                ],
                'columns' => 8,
                'rules' => 'required',
              ],
              'state' => [
                'type' => 'select',
                'floating' => 'State',
                'placeholder' => 'State',
                'columns' => 4,
                'conditions' => [
                  ['billing_address.billing_info.country', 'us']
                ],
                'items' => self::$states,
                'rules' => 'required'
              ],
              'zip_code' => [
                'type' => 'text',
                'floating' => 'ZIP Code',
                'placeholder' => 'ZIP Code',
                'rules' => 'required',
                'columns' => 4
              ],
              'phone' => [
                'type' => 'text',
                'placeholder' => 'Phone',
                'floating' => 'Phone',
                'rules' => 'required'
              ],
            ]
          ]
        ],
      ],

      // 'Remember me' block
      'remember_me' => [
        'type' => 'group',
        'label' => 'Remember me',
        'class' => 'remember-me',
        'schema' => [

          // 'Remember me' checkbox
          'remember' => [
            'type' => 'checkbox',
            'text' => 'Save my information for faster checkout',
          ],

          // 'Mobile phone number' input (if 'Remember me' is checked)
          'mobile_phone_number' => [
            'type' => 'text',
            'class' => 'remember-me-number',
            'floating' => 'Mobile phone number',
            'placeholder' => 'Mobile phone number',
            'addon' => [
              'before' => '<span class="phone-icon"></span>'
            ],
            'conditions' => [
              ['remember_me.remember', true]
            ],
            'columns' => [
              'field' => 6
            ],
            'rules' => 'required'
          ],

          // Additional description for 'Mobile phone number' (if 'Remember me' is checked)
          'phone_description' => [
            'type' => 'static',
            'class' => 'phone-description',
            'content' => '<span class="field-description">Next time you check out here or other stores powered by Shopify, Shopify will send you an authorization code by SMS to securely purchase with Shopify Pay.</span>',
            'conditions' => [
              ['remember_me.remember', true]
            ]
          ]
        ]
      ],

      // 'Accept terms' checkbox (if 'Remember me' is checked)
      'terms' => [
        'type' => 'static',
        'content' => '<span class="accept-terms">By continuing, you agree to Shopify Pay’s <a href="#">Privacy Policy</a> and <a href="#">Terms of Service</a>.</span>',
        'conditions' => [
          ['remember_me.remember', true]
        ],
      ]
    ];
  }

  public function after() {
    // Process data here

    dd($this->data);
  }

  public static $states = [
    'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California', 'CO' => 'Colorado',
    'CT' => 'Connecticut', 'DE' => 'Delaware', 'DC' => 'District Of Columbia', 'FL' => 'Florida', 'GA' => 'Georgia',
    'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 'KY' => 'Kentucky',
    'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota',
    'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire',
    'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota',
    'OH' => 'Ohio', 'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina',
    'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia',
    'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming'
  ];
}