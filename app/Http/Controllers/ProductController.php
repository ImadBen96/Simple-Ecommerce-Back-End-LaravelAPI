<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with("category")->get();

        return response()->json([
            "products"  => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // main image
         if ($request->mainImage) {
            $destinationPath = 'uploads/mainimage';
            $myimage = $request->mainImage->getClientOriginalName();
            $request->mainImage->move(public_path($destinationPath), $myimage);
        }
        //features images
        if ($request->hasFile('files')) {
            $imagesNames = [];
            $files = $request->file('files');
            foreach ($files as $file) {
                $featureImageName = time().'.'.$file->extension();
                $imagesNames[] = url("uploads/featuresImages/".$featureImageName);
                $file->move(public_path("uploads/featuresImages"), $featureImageName);
            }
        }

        $product = Product::create([
            "product_name" => $request->input("ProductName"),
            "category_id" => $request->input("category"),
            "old_price" => $request->input("oldPrice"),
            "current_price" => $request->input("currentPrice"),
            "qty" => $request->input("qty"),
            "main_image" => url("uploads/mainimage/".$myimage) ?? "",
            "others_images" => implode(",",$imagesNames),
            "sizes" => implode(",",$request->input("sizes")),
            "colors" => implode(",",$request->input("colors")),
            "description" => $request->input("description"),
            "short_description" => $request->input("shortdescription"),
            "is_active" => $request->input("isActive"),
        ]);



        return response()->json([
            "success" => "Created With Success",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::where("id",$id)->first();

        return response()->json([
            "product" => $product,
            "id" => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json([
            "success" => "Deleted With Success",
        ]);
    }
}
