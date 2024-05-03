<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function makePayment(Request $request)
    {
        $user_id = auth("sanctum")->user()->id;

        $carts = Cart::whereIn("product_id",$request->input("productsIds"))
            ->where("user_id",$user_id)->get();
        $lineItems = [];
        $orderitems = [];
        foreach ($carts as $cart) {
            $priceInCents = $cart->product->current_price * 100; // price in cents
            $lineItems[] = [
               "price_data" => [
                   "currency" => "usd",
                   "unit_amount" => $priceInCents,
                   "product_data" => [
                       "name" => $cart->product->product_name,
                       "description" => $cart->product->short_description,
                   ]
               ],
                "quantity" => $cart->product_qty,
            ];
            $orderitems[] = [
              "product_id" => $cart->product_id,
              "qty" => $cart->product_qty,
              "price" => $cart->product->current_price,
              "size"  => $cart->product_size
            ];
        }

        Stripe::setApiKey(config("stripe.secret_key"));
        $session = Session::create([
           "payment_method_types" => ["card","cashapp","us_bank_account"],
            "line_items" => $lineItems,
            "mode" => "payment",
            "success_url" => config("stripe.success_url"),
            "cancel_url" => config("stripe.cancel_url"),
        ]);
        //create order
        $order = Order::create([
            "user_id" => $user_id,
            "firstname" => $request->input("first_name"),
            "lastname" => $request->input("last_name"),
            "phone" => $request->input("phone"),
            "email" => $request->input("email"),
            "address" => $request->input("address"),
            "city" => $request->input("city"),
            "state" => $request->input("state"),
            "zipcode" => $request->input("zipcode"),
            "payment_id" => Str::random(30),
            "payment_mode" => "STRIPE",
        ]);
        $order->orderitems()->createMany($orderitems);
        Cart::destroy($carts);


        return response()->json([
            "url" => $session->url,
        ]);
    }
}
