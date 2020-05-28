# Shopify Checkout Form Example

This repository contains Laraform's [Shopify example](https://laraform.io/examples#shopify) code.

## Installation

This example relies on **Bootstrap 4** so if your project does not include it install it with:

```
npm install bootstrap
```

#### 1) Copy assets

First merge the contents of `resources` directory with you app's `resources` directory.

If you **don't have a fresh Laravel** install make sure you merge `app.js` and `app.scss` manually. 

#### 2) Set up route

Add the following to your `routes/web.php`:

``` php
Route::get('/shopify', function () {
  return view('shopify', [
    'checkout' => app('App\Forms\ShopifyCheckoutForm')
  ]);
});
```

#### 3) Copy `ShopifyCheckoutForm.php`

Create an `app/Forms` folder in your project and copy `ShopifyCheckoutForm.php` from `app/Forms` to yours.

#### 4) Compile and run

Now you should have everything set up, so just run:

``` bash
npm run dev
```

Once assets are compiled you can launch your site for example with:

``` bash
php artisan serve
```

Visit `localhost:8000/shopify` to see the live example.

*Please note that this example requires a full [Laraform license](https://laraform.io/pricing).*