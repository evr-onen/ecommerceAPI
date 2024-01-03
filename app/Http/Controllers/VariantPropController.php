<?php

namespace App\Http\Controllers;

use App\Models\Variant_prop;
use Illuminate\Http\Request;

class VariantPropController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       //
    }

    // {
    //     $varProps = Variant_Prop::with('toVariantType')->get();
    
    //     $result = [];
    
    //     foreach ($varProps as $varProp) {
    //         $variantTypeData = $varProp->toVariantType;
            
    //         $result[] = [
    //             'variant_prop' => [
    //                 'id' => $varProp->id,
    //                 'name' => $varProp->name,
    //                 'variant_type_id' => $varProp->variant_type_id,
    //                 'created_at' => $varProp->created_at,
    //                 'updated_at' => $varProp->updated_at,
    //                 'to_variant_type' => $variantTypeData,
    //             ],
    //         ];
    //     }
    
    //     return $result;
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
   { 
   
    $translations = [
        'en' => $request->input('name.en'),
        'tr' => $request->input('name.tr'),
    ];
    
    $request_data = [
        'name' => json_encode($translations), 
        'variant_type_id' => $request->input('variant_type_id'),
    ];
    
  
    $data =  Variant_prop::create($request_data);
    
    return response()->json(['data' => $data]);
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
    public function show(Variant_prop $variant_prop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Variant_prop $variant_prop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Variant_prop $variant_prop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $category = Variant_prop::find($id)->delete();
    }
}
