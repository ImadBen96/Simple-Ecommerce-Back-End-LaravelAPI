<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        if (auth("sanctum")->check()) {
            $user_id = auth("sanctum")->user()->id;
            $product_id = $request->input("product_id");
            $product_qty = $request->input("product_qty");
            $product_size = $request->input("product_size");
            $productCheck = Product::where("id",$product_id)->first();
            if ($productCheck) {
                if ( Cart::where("product_id",$product_id)->where("user_id",$user_id)->exists() ) {
                    return response()->json([
                        "status" => 409,
                        "message" =>  $productCheck->name." Already Added To Cart",
                    ]);
                } else {
                    $cartitem = new Cart();
                    $cartitem->user_id = $user_id;
                    $cartitem->product_id = $product_id;
                    $cartitem->product_qty = $product_qty;
                    $cartitem->product_size = $product_size;
                    $cartitem->save();

                    return response()->json([
                        "status" => 201,
                        "message" =>  "Added To Cart",
                    ]);
                }


            } else {
                return response()->json([
                    "status" => 404,
                    "message" =>  "Product Not Found",
                ]);
            }

        }else {
            return response()->json([
                    "status" => 401,
                    "message" =>  "Login To Add To Cart",
              ]);
        }

    }
    public function viewcart()
    {
        if (auth("sanctum")->check()) {
            $user_id = auth("sanctum")->user()->id;
            $cartitems = Cart::where("user_id",$user_id)->get();

            return response()->json([
                "status" => 200,
                "cart" =>  $cartitems,
            ]);
        } else {
            return response()->json([
                "status" => 401,
                "message" =>  "Login To View Cart",
            ]);
        }
    }
    public function updateQty($cart_id,$scope)
    {
        if (auth("sanctum")->check()) {
            $user_id = auth("sanctum")->user()->id;
            $cartitems = Cart::where("id",$cart_id)->where("user_id",$user_id)->first();
            if ($scope == "inc") {
                $cartitems->product_qty +=1;
            } elseif ($scope == "dec") {
                $cartitems->product_qty -=1;
            }
            $cartitems->update();

            return response()->json([
                "status" => 200,
                "message" =>  "Qty Updated",
            ]);
        } else {
            return response()->json([
                "status" => 401,
                "message" =>  "Login To Continue",
            ]);
        }

    }
    public function deleteCartItem($cart_id)
    {
        if (auth("sanctum")->check()) {
            $user_id = auth("sanctum")->user()->id;
            $cartitems = Cart::where("id",$cart_id)->where("user_id",$user_id)->first();
            if ($cartitems) {
                $cartitems->delete();
                return response()->json([
                    "status" => 200,
                    "message" =>  "Cart Item Removed Successfully",
                ]);
            }else {
                return response()->json([
                    "status" => 404,
                    "message" =>  "Cart Item Not Found",
                ]);
            }

        } else {
            return response()->json([
                "status" => 401,
                "message" =>  "Login To Continue",
            ]);
        }

    }
}
