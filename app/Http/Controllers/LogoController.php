<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use Illuminate\Http\Request;

class LogoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logo = Logo::find(1);
        return response()->json([
            "logo"  => $logo,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->image){
            $destinationPath = 'uploads/logo';
            $myimage = $request->image->getClientOriginalName();
            $request->image->move(public_path($destinationPath), $myimage);
        }

        $logo = Logo::find(1);
        $logo->update([
            "logo" => url("uploads/logo/".$myimage) ?? "",
        ]);

        return response()->json([
            "success"  => "Logo Updated Successfully",
            "logo" => url("uploads/logo/".$myimage) ?? "",
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Logo $logo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Logo $logo)
    {

       //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Logo $logo)
    {
        //
    }
}
