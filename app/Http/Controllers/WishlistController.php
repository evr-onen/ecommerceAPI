<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
      return   $wishProducts =Wishlist::where('user_id', $request->user_id)->with('products.toVariantProducts.toPivotProps.toVariantPropFromPivotProduct', 'products.productImages','products.comments' )->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);
        $wishlist = Wishlist::create([
            'user_id' => $request->input('user_id'),
            'product_id' => $request->input('product_id'),
            
        ]);
      
        return Wishlist::where('id', $wishlist->id)->with('products.toVariantProducts.toPivotProps.toVariantPropFromPivotProduct', 'products.productImages')->first();
       

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
       
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);
        
        $user_id = $request->user_id;
        $product_id = $request->product_id;

        $wishlist = Wishlist::where('user_id',$user_id)->where('product_id', $product_id)->first();
        
        return Wishlist::destroy($wishlist->id);
        
        
    }
}
