<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Pivot_variant_product;
use App\Models\Product_image;
use App\Models\Variant_product;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('toVariantProducts.toPivotProps.toVariantPropFromPivotProduct', 'productImages', 'comments.user')->get();
        return $products;
    }
    public function getSingleProduct(Request $request)
    {
      
        $product = Product::with(['toVariantProducts.toPivotProps.toVariantPropFromPivotProduct', 'productImages', 'Comments.user'])->find($request->id);
        return $product;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $isVariant=$request->isVariant; 
        
          $request->validate([
            'name' => 'required|string',
            'price' => !$isVariant ?  'required|numeric' : 'nullable',
            'discount_flat' => 'nullable|numeric',
            'discount_percent' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'stock' => !$isVariant ?  'required|integer' : 'nullable',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slider_.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            'variants.*.stock' => $isVariant ?  'required|numeric' : 'nullable',
            'variants.*.price' => $isVariant ?  'required|numeric' : 'nullable',
            'variants.*.variantPropertise' => $isVariant ?'required|array' : 'nullable|array',
        ]);
       
        try {
            
            $descJson= [
                'en' => $request->input('descriptionEN'),
                'tr' => $request->input('descriptionTR'),
            ];

           $shortDescJson= [
                'en' => $request->input('shortDescriptionEN'),
                'tr' => $request->input('shortDescriptionTR'),
            ];
            
            $product = Product::create([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'discount_flat' => $request->input('discount_flat'),
                'discount_percent' => $request->input('discount_percent'),
                'category_id' => $request->input('category_id'),
                'stock' => $request->input('stock'),
                'description' => json_encode($request->input('description')),
                'short_description' => json_encode($request->input('short_description')),
            ]);

            if( $request->isVariant !=='false'){
                
                $variants = json_decode($request->input('variants'), true);
                foreach ($variants as $variant) {
                    
                    $variantProduct = Variant_product::create([
                        'product_id' => $product->id,
                        'price' => $variant['price'],
                        'discount_flat' => $variant['discountFlat'],
                        'discount_percent' => $variant['discountPercent'],
                        'stock' => $variant['stock'],
                    ]);

                    $variantsOfProduct = $variant['variantPropertise'];
                    
                    foreach ($variantsOfProduct as $var) {
                       
                      $Pivot_variant_product= Pivot_variant_product::create([
                        'variant_product_id' => $variantProduct->id,
                        'variant_prop_id' => $var['id'],
                    ]);

                    }

                }
            }
            if ($request->hasFile('thumbnail')) {
                $new_name = rand() . '.' . $request->file('thumbnail')->getClientOriginalExtension();
                // $thumbnailPath = $request->file('thumbnail')->store('product_images');
                $image= $request->file('thumbnail');
                $image->move(public_path('/uploads/product_images'), $new_name);
    
                $img = new Product_image();
                $img->name =  $new_name;
                $img->path =  "/uploads/product_images/" . $new_name;
                $img->priority = 0;
                $img->product_id =  $product->id;
               
                $img->save();
            } 

            for ($i = 0; $i <= 5; $i++) {
                $sliderKey = "slider_$i";
                $image= $request->file( $sliderKey);
                if ($request->hasFile($sliderKey)) {
                
                    $new_name = rand() . '.' . $request->file( $sliderKey)->getClientOriginalExtension();
                 // $thumbnailPath = $request->file($sliderKey)->store('product_images');

                    $image->move(public_path('/uploads/product_images'), $new_name);
    
                $img = new Product_image();
                $img->name =  $new_name;
                $img->path =  "/uploads/product_images/" . $new_name;
                $img->priority = $i + 1;
                $img->product_id =  $product->id;
               
                $img->save();
                }
            }
            return response()->json(['message' => 'success']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $isVariant=$request->isVariant; 
        
        $request->validate([
          'name' => 'required|string',
          'price' => !$isVariant ?  'required|numeric' : 'nullable',
          'discount_flat' => 'nullable|numeric',
          'discount_percent' => 'nullable|numeric',
          'category_id' => 'required|exists:categories,id',
          'stock' => !$isVariant ?  'required|integer' : 'nullable',
          'description' => 'nullable|string',
          'short_description' => 'nullable|string',
          'thumbnail' =>$request->hasFile('thumbnail') ? 'required|image|mimes:jpeg,png,jpg,gif|max:2048|' : 'nullable',
          'slider_.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
          
          'variants.*.stock' => $isVariant ?  'required|numeric' : 'nullable',
          'variants.*.price' => $isVariant ?  'required|numeric' : 'nullable',
          'variants.*.variantPropertise' => $isVariant ?'required|array' : 'nullable|array',
      ]);
      try {
        $product_id = $request->input('id');
        $product = Product::with('toVariantProducts.toPivotProps', 'productImages')->find($product_id);
           
          if ($product) {
              $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->discount_flat = $request->input('discount_flat');
            $product->discount_percent = $request->input('discount_percent');
            $product->category_id = $request->input('category_id');
            $product->stock = $request->input('stock');
            $product->description = json_encode($request->input('description'));
            $product->short_description = json_encode($request->input('short_description'));
            
            $product->save();
            
          if( $request->isVariant !=='false'){
              
            $req_vars = $product->toVariantProducts->pluck('id');                // db deki data
            $variants = json_decode($request->input('variants'), true);        // requestteki data
            
               
            // frontend den daha aktif edilmedi
            foreach ($req_vars->diff(collect($variants)->pluck('id')) as $delProuctID ) {
                Variant_product::destroy($delProuctID);
            }

            foreach ($variants as $index =>   $variant) {
                if (!array_key_exists('id', $variant)) {
                  
                    // create

                    $variantProduct = Variant_product::create([
                        'product_id' => $product->id,
                        'price' => $variant['price'],
                        'discount_flat' => $variant['discountFlat'],
                        'discount_percent' => $variant['discountPercent'],
                        'stock' => $variant['stock'],
                    ]);

                    $variantsOfProduct = $variant['variantPropertise'];
                    
                    foreach ($variantsOfProduct as $var) {
                       
                      $Pivot_variant_product= Pivot_variant_product::create([
                        'variant_product_id' => $variantProduct->id,
                        'variant_prop_id' => $var['id'],
                    ]);

                    }

                }else{
                    // update
                    
                    $variantProduct = Variant_product::where('id', $variant['id'])->update([
                        'price' => $variant['price'],
                        'stock' => $variant['stock'],
                        'discount_flat' => $variant['discountFlat'],
                        'discount_percent' => $variant['discountPercent'],
                    ]);
                    
                    // variant_props islemleri
                    $db_propsIds = $product->toVariantProducts[$index]->toPivotProps->pluck('variant_prop_id');
                   

                
                $req_props  = collect($variant['variantPropertise'])->pluck('id'); 
                    

                foreach ($req_props->diff($db_propsIds)->values() as $createPropID) {
                    
                    // create prop
                    Pivot_variant_product::create([
                        'variant_prop_id' => $createPropID,
                        'variant_product_id' => $variant['id'],
                    ]);         
                    
                }
             
                
                foreach ($db_propsIds->diff($req_props)->values() as $deletePropID) {
                    // delete prop
                    
                    $pivotID= $product->toVariantProducts[$index]->toPivotProps->where('variant_prop_id', $deletePropID)->values()[0]->id;
                    Pivot_variant_product::destroy($pivotID);
                }
                
                
            }
        }
       
        
        // Notlar:
        // collect($variants[0]['variantPropertise'])->pluck('id');
        // collect($var_ids[0]->props)->pluck('variant_prop_id');
            // collect($var_ids[0]->props)->pluck('variant_prop_id')->diff(collect($variants[0]['variantPropertise'])->pluck('id')) ;
            // soldakine gore A\B gibi islem yapiyor. Boylece A\B ile craete, B\A yaparak da silinecek olani buluyoruz.. sagdakilerin hepsi soldakinde var eger [] ise 
            // collect($var_ids[0]->props)->pluck('variant_prop_id')->intersect(collect($variants[0]['variantPropertise'])->pluck('id'))->values()
            // bunla da kesisimini bulup update edilecekleri bulabiliriz
            // array_key_exists('id', $variant), property_exists($variant, 'id')
            
        }else{
            if(count($product->toVariantProducts) !== 0){
                
                foreach ($product->toVariantProducts as $var_index => $delProduct ) {
                    $req_pivotIds = $product->toVariantProducts[$var_index]->toPivotProps->pluck('id'); 
                    Pivot_variant_product::destroy($req_pivotIds);
                    Variant_product::destroy($delProduct->id);
                } 
            }
           
        }

          if ($request->hasFile('thumbnail')) {
              $lastImageId= $product->productImages->where('priority', 0)->first()->id;
             
            
            Product_image::destroy($lastImageId);

              $new_name = rand() . '.' . $request->file('thumbnail')->getClientOriginalExtension();
             
              $image= $request->file('thumbnail');
              $image->move(public_path('/uploads/product_images'), $new_name);
  
              $img = new Product_image();
              $img->name =  $new_name;
              $img->path =  "/uploads/product_images/" . $new_name;
              $img->priority = 0;
              $img->product_id =  $product->id;
             
              $img->save();
          } 


        $imgOrders = json_decode($request->input('imageOrders'), true); 
          return $imgOrders;
          for ($i=0; $i < 5 ; $i++) { 

           $itemImg = collect($imgOrders)->where('order', $i+1);
          
       
         if(!empty($itemImg)){
            
            if(isset($itemImg->values()[0]['priority']) && isset($itemImg->values()[0]['order'])  ){
                
               
                if( $itemImg->values()[0]['priority'] !== $itemImg->values()[0]['order'] ){

                  
                    Product_image::where('priority', $i+1)->update([
                        'name' => $itemImg->values()[0]['name'],
                        'path' => $itemImg->values()[0]['path'],
                        'priority' => $itemImg->values()[0]['order'],
                    ]);
                }else{
                    
                }
                
            }else if( !isset($itemImg->values()[0]['priority']) && isset($itemImg->values()[0]['order'])){
                $delImg= $product->productImages->where('priority', $i+1)->first();
                if(isset($delImg->id)){

                    Product_image::destroy($delImg->id);
                }
                $sliderKey = "slider_$i"; 
               
             if ($request->hasFile($sliderKey)) {
                                       
                 $image= $request->file( $sliderKey);
                  $new_name = rand() . '.' . $request->file( $sliderKey)->getClientOriginalExtension();
                  $image->move(public_path('/uploads/product_images'), $new_name);
                   $img = new Product_image();
                  $img->name =  $new_name;
                    $img->path =  "/uploads/product_images/" . $new_name;
                  $img->priority = $i + 1;
                 $img->product_id =  $product->id;
                                        
                   $img->save();
                }
            }else{
                $deleteProduct = Product_image::where('product_id', $product->id)->where('priority', $i+1)->first();
               
                if(!empty($deleteProduct)){
                   
                    $deleteId= $deleteProduct->id;
                    Product_image::destroy($deleteId);
                }
            }
        }else{
            $imageId= $product->productImages->where('product_id', $product->id)->where('priority', $i+1  )->values()[0]->id;
            Product_image::destroy($imageId);
        }
    

    if(empty($imgOrders)){
        $imageIds= $product->productImages->where('product_id', $product->id)->where('priority', '!=', '0' )->values()->pluck('id');
        Product_image::destroy($imageIds);
                    }

          }
        }
          return response()->json(['message' => 'success']);
      } catch (\Exception $e) {
          Log::error($e);
          return response()->json(['error' => $e->getMessage()], 500);
      }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function deletePoduct(Request $request)
    {
        $id = $request->id;
        $product = Product::find($id);
        
        $product->productImages()->each(function ($productImages) {
            $productImages->delete();
        });
            
        $product->toVariantProducts()->each(function ($variantProduct) {
            $variantProduct->toPivotProps()->each(function($pivot){
                $pivot->delete();
            });
            $variantProduct->delete();
            
        });
        
       return $product->delete();
   
    }
}
