# Login Form Example

This repository contains Laraform's [Login example](https://laraform.io/examples#login) code.

## Installation

This example relies on **Bootstrap 4** so if your project does not include it install it with:

```
npm install bootstrap
```

#### 1) Copy assets

First merge the contents of `resources` directory with you app's `resources` directory.

If you **don't have a fresh Laravel** install make sure you merge `app.js` & `app.scss` manually. 

#### 2) Change Theme

Open `config/laraform.php` and change `theme` to `bs4`:

``` php
/*
|--------------------------------------------------------------------------
| Theme
|--------------------------------------------------------------------------
|
| Default theme.
|
*/
'theme' => 'bs4',
```

#### 3) Set up route

Add the following to your `routes/web.php`:

``` php
Route::get('/login-form', function () {
  return view('login', [
    'login' => app('App\Forms\LoginForm')
  ]);
});
```

#### 4) Copy `LoginForm.php`

Create an `app/Forms` folder in your project and copy `LoginForm.php` from `app/Forms` to yours.

#### 5) Compile and run

Now you should have everything set up, so just run:

``` bash
npm run dev
```

Once assets are compiled you can launch your site for example with:

``` bash
php artisan serve
```

Visit `localhost:8000/login-form` to see the live example.