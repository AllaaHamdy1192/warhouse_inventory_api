<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InventoryItemModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvemtoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator=Validator::make($request->all(), [
            'name'=>'required',
            'sku'=>'required|unique:inventory_items,sku',
            'price' => 'nullable|numeric'
          ]);
          if($validator->fails()) {
                   return response()->json(['status'=>false,'message'=>$validator->errors(),'data'=>[] ],400);       
           }

           $name=$request->name;
           $sku=($request->sku)??null;
           $image=($request->image)??null;
           $price=($request->price)??null;
           $inventory_item=InventoryItemModel::create(['name'=>$name,'sku'=>$sku,'image'=>$image,'price'=>$price]);
             return response()->json([
            'status'=>true,
            'message'=>'inventory item created success',
            'data'=>[ $inventory_item]],201 );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }
}
