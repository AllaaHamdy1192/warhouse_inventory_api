<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InventoryStockModel;
use App\Models\InventoryTransferModel;
use App\Rules\CheckInvItemStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryItemTransferController extends Controller
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
            'from_inv_id'=>['required','exists:warehouses,id'],
            'to_inv_id'=>['required','exists:warehouses,id'],
            'inv_item_id'=>['required','exists:inventory_items,id'],
            'quantity'=>['required','gt:0',new CheckInvItemStock]
        ]);

          if($validator->fails()) {
                   return response()->json(['status'=>false,'message'=>$validator->errors(),'data'=>[] ],400);       
           }
           $item_exist_in_from_inv=InventoryStockModel::where(['warehouse_id'=>$request->from_inv_id,'inventory_item_id'=>$request->inv_item_id])->exists();
           if(!$item_exist_in_from_inv){
             return response()->json(['status'=>false,'message'=>'Item not exists in inventory','data'=>[] ],400);   
           }
            $item_exist_in_to_inv=InventoryStockModel::where(['warehouse_id'=>$request->to_inv_id,'inventory_item_id'=>$request->inv_item_id])->exists();
           if(!$item_exist_in_to_inv){
             return response()->json(['status'=>false,'message'=>'Item not exists in inventory','data'=>[] ],400);   
           }
           ///1-update inventory item stock
           $old_from_inv_qty=InventoryStockModel::where(['warehouse_id'=>$request->from_inv_id,'inventory_item_id'=>$request->inv_item_id])->first()->quantity;
           $old_to_inv_qty=InventoryStockModel::where(['warehouse_id'=>$request->to_inv_id,'inventory_item_id'=>$request->inv_item_id])->first()->quantity;
           $new_from_inv_qty=$old_from_inv_qty-$request->quantity;
           $new_to_inv_qty=$old_to_inv_qty+$request->quantity;
           InventoryStockModel::where(['warehouse_id'=>$request->from_inv_id,'inventory_item_id'=>$request->inv_item_id])->update(['quantity'=>$new_from_inv_qty]);
           InventoryStockModel::where(['warehouse_id'=>$request->to_inv_id,'inventory_item_id'=>$request->inv_item_id])->update(['quantity'=>$new_to_inv_qty]);
           ////2-add transfer in log
           InventoryTransferModel::create(['from_warehouse_id'=>$request->from_inv_id,'to_warehouse_id'=>$request->to_inv_id,'inventory_item_id'=>$request->inv_item_id]);
              return response()->json([
            'status'=>true,
            'message'=>'inventory transfer done',
            'data'=>[]],200);
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
