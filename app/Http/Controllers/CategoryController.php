<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllCategories()
{
    $categories =  Category::with('products')->get();
   
    return response()->json( ['categories' => $categories]);
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
        'parent_id' => $request->input('parent_id'),
    ];
    $data =  Category::create($request_data);
    
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
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'subID' => 'required|numeric',
            'mainID' => 'required|numeric',
            'mainCatEn' => 'required|string',
            'mainCatTr' => 'required|string',
            'subCatEn' => 'required|string',
            'subCatTr' => 'required|string',
        ]);
        

        $translationsMain = [
            'en' => $request->input('mainCatEn'),
            'tr' => $request->input('mainCatTr'),
        ];
        $mainCategory = Category::find($request->mainID)->update([
            'name' => json_encode($translationsMain), 
        ]);

        $translationsSub = [
            'en' => $request->input('subCatEn'),
            'tr' => $request->input('subCatTr'),
        ];
        $subCategory = Category::find($request->subID)->update([
            'name' => json_encode($translationsSub), 
            
        ]);
        return response()->json(['main' => $mainCategory,'sub' => $subCategory, ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $category = Category::find($id)->delete();
        
        
        
       return $category;
    }
}
