<?php

 return [
    "public_key" => env("STRIPE_PUBLIC_KEY"),
    "secret_key" => env("STRIPE_SECRET_KEY"),
    "success_url" => "http://localhost:3000/success",
    "cancel_url" => "http://localhost:3000/cancel",
 ];
