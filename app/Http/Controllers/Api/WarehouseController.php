<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InventoryStockModel;
use App\Models\WarehouseModel;
use App\Rules\CheckWarehouseHasItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator=Validator::make($request->all(), [
            'name'=>'required',
          ]);
          if($validator->fails()) {
                   return response()->json(['status'=>false,'message'=>$validator->errors(),'data'=>[] ],400);       
           }

           $name=$request->name;
           $location=($request->location)??null;
           $email=($request->email)??null;
           $phone=($request->phone)??null;
           $warehouse=WarehouseModel::create(['name'=>$name,'location'=>$location,'phone'=>$phone,'email'=>$email]);
             return response()->json([
            'status'=>true,
            'message'=>'warhouse created success',
            'data'=>[$warehouse]],201 );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $warehouse_exists=WarehouseModel::where('id',$id)->exists();
        $per_page=(request()->per_page)??10;
        if(! $warehouse_exists){
             return response()->json([
            'status'=>false,
            'message'=>'warhouse not found',
            'data'=>[]],404);
        }
    
         $warehouses_inv_data=InventoryStockModel::with('inventory_item')->where('warehouse_id',$id)->paginate($per_page);
          return response()->json([
            'status'=>true,
            'message'=>'warehouse inventory items data',
            'data'=>$warehouses_inv_data],200); 
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
    public function store_warehouse_inventory_item(Request $request){
        $validator=Validator::make($request->all(), [
            'inventory_item_id' => ['required','exists:inventory_items,id',new CheckWarehouseHasItem],
            'warehouse_id'=>'required|exists:warehouses,id',
          ]);
          if($validator->fails()) {
                   return response()->json(['status'=>false,'message'=>$validator->errors(),'data'=>[] ],400);       
           }
           $inventory_item_id=$request->inventory_item_id;
           $warehouse_id=$request->warehouse_id;
        InventoryStockModel::create(['inventory_item_id'=>$inventory_item_id,'warehouse_id'=>$warehouse_id]);
           return response()->json([
            'status'=>true,
            'message'=>'inventory item added to warehouse successfully',
            'data'=>[]],200);
    }
}
