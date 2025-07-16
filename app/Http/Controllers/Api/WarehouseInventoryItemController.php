<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InventoryStockModel;
use App\Models\WarehouseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WarehouseInventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       // $per_page=($request->per_page)??10;
        $filter_warehouse=($request->filter_warehouse_name)??'';
        $filter_inventory=($request->filter_inventory_item_name)??'';
        $warehouses=WarehouseModel::with('inventoryItems');
        if($filter_warehouse!=''){
         $warehouses=$warehouses->where('name','like','%'.$filter_warehouse.'%') ;
        }
         $cacheKey = 'warehouse_inventory' . 
 /*$inventory = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($warehouseId) {
        return InventoryItem::where('warehouse_id', $warehouseId)->get();
    });*/
        $warehouses=$warehouses->get();
         $result = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($warehouses,$filter_inventory) {
          return  $warehouses->map(function ($warehouse) use($filter_inventory) {
            if($filter_inventory!=''){
            return [
            'warehouse_id' => $warehouse->id,
            'warehouse_name' => $warehouse->name,
            'items' => $warehouse->inventoryItems->where('name',$filter_inventory)->pluck('name')->toArray(),
            ];

            }else{
              return [
            'warehouse_id' => $warehouse->id,
            'warehouse_name' => $warehouse->name,
            'items' => $warehouse->inventoryItems->pluck('name')->toArray(),
             ];
            }
       
          });
        });
       
         return response()->json([
            'status'=>true,
            'message'=>'inventory per warhouse list',
            'data'=>$result],200);                     
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
