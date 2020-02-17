<?php

namespace App\Forms;

use Auth;

class LoginForm extends \Laraform
{
  // Assigning Vue component
  public $component = "login-form";

  // Adding class
  public $class = "login-form";

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

  public function schema() {
    return [
      "title" => [
        "type" => "static",
        "content" => "<h5>Log in to your account</h5>"
      ],
      "email" => [
        "type" => "text",
        "placeholder" => "Email address",
        "floating" => "Email address",
        "rules" => "email"
      ],
      "password" => [
        "type" => "password",
        "placeholder" => "Password",
        "floating" => "Password"
      ],
      "remember" => [
        "type" => "toggle", // change to "checkbox" if you are using Community Edition
        "text" => "Remember me"
      ]
    ];
  }

  public function buttons() {
    return [[
      "label" => "Login",
      "class" => "btn-primary w-100"
    ]];
  }

  public function after () {
    if (Auth::attempt($this->data, $this->data["remember"])) {
      return $this->success("You are authenticated!");
    }
    
    return $this->fail("Authentication failed");
  }
}