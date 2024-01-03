<?php

namespace App\Http\Controllers;

use App\Models\Variant_type;
use App\Models\Variant_prop;
use Illuminate\Http\Request;

class VariantTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllVariant()
    {

        $varTypes = Variant_type::with('toVariantProp.toPivotVariantProducts.toVariantPropFromPivotProduct')->get();
       
        return   $varTypes;
        
    
        return $result;
    }

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
       
    ];
    
  
    $data =  Variant_type::create($request_data);
    
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
    public function show(Variant_type $variant_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Variant_type $variant_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Variant_type $variant_type)
    {

    //     typeID: varType.id,
    // propID: varProp.id,
    // varTypeTr: typeName.tr,
    // varTypeEn: typeName.en,
    // varPropTr: propName.tr,
    // varPropEn: propName.en

       
        $request->validate([
            'typeID' => 'required|numeric',
            'propID' => 'required|numeric',
            'varTypeTr' => 'required|string',
            'varTypeEn' => 'required|string',
            'varPropTr' => 'required|string',
            'varPropEn' => 'required|string',
        ]);
        

        $translationsType = [
            'en' => $request->input('varTypeEn'),
            'tr' => $request->input('varTypeTr'),
        ];
        $varType = Variant_type::find($request->typeID)->update([
            'name' => json_encode($translationsType), 
        ]);

        $translationsProp = [
            'en' => $request->input('varPropEn'),
            'tr' => $request->input('varPropTr'),
        ];
        $varProp = Variant_prop::find($request->propID)->update([
            'name' => json_encode($translationsProp), 
            
        ]);
        return response()->json(['type' => $varType,'prop' => $varProp, ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Variant_type $variant_type)
    {
        //
    }
}
